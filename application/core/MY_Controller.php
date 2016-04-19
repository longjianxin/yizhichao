<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	public $cur_page = 0;//当前页
	public $per_page = 25;//每页显示条数
	public $offset = 0;

	public $res = array('code' => -1, 'msg' => '未知返回信息', 'data' => array());
	public function __construct()
	{
		parent::__construct();
		$cur_page = (int)$this->input->get_post('cur_page');
		$offset = (int)$this->input->get_post('offset');
		$per_page = (int)$this->input->get_post('per_page');
		if($cur_page < 1){
			$cur_page = 1;
		}
		$this->cur_page = $cur_page;
		$this->per_page = $per_page ? $per_page : $this->per_page;
		$this->offset = $offset ? $offset : ($this->cur_page - 1) * $this->per_page;
	}

	public function getTemplateFile($views = '')
	{
		return empty($views) ? $this->router->directory.$this->router->class.'_'.$this->router->method : $views;
	}

	public function getSiteUrl($method = '', $class = '', $directory = '')
	{
		$directory = empty($directory) ? $this->router->directory : $directory;
		$class = empty($class) ? $this->router->class : $class;
		$method = empty($method) ? $this->router->method : $method;
		return site_url(array($directory, $class, $method));
	}

	public function setSuccessResponse($data = array())
	{
		$this->res['code'] = 0;
		$this->res['msg'] = '操作成功！';
		$this->res['data'] = $data;
	}

	public function setFailResponse($msg = '', $code = 1)
	{
		log_message('error', current_url().var_export($this->input->get(), true).var_export($this->input->post(), 
true));
		$this->res['code'] = $code;
		$this->res['msg'] = $msg;
		log_message('error', $code.'->'.$msg.'->'.var_export($this->getResponse(), true));
	}

	public function getResponse()
	{
		return json_encode($this->res);
	}

	public function getAppSign($seller_id, $sid, $shopowner, $time, $token)
	{
		$param = array(
			'seller_id' => (int)$seller_id,
			'sid' => (int)$sid,
			'shopowner' => (int)$shopowner,
			'time' => (int)$time,
			'token' => $token,
			'key' => $this->config->item('encryption_key')
		);
		// var_export($param);
		return md5(serialize($param));
	}

	public function getToken()
	{
		return md5(microtime());
	}

	public function upload_file()
	{
		$this->load->library('upload');

		$base_dir = $this->input->post('base_dir');
		if(is_null($base_dir)){
			$base_dir = $this->router->directory;
		}
		$this->upload->set_upload_path($this->upload->upload_path.$base_dir);

        if(! $this->upload->validate_upload_path()){
        	if(! is_dir($this->upload->upload_path)){
        		mkdir($this->upload->upload_path, 0777);
        	}
        }

        if(! $this->upload->do_upload('Filedata')){//$_FILES['Filedata']['tmp_name']
        	$this->setFailResponse($this->upload->display_errors());
        }else{
        	$data = $this->upload->data();
        	$file_name = $base_dir.$data['file_name'];
        	$res = array('file_name' => $file_name, 'site_url' => base_url('uploads/'.$file_name));
        	$this->setSuccessResponse($res);
        }        
	}

	public function file_download($file)
	{
		$this->load->helper('download');
		force_download($file, null);
	}

	public function getSystemAccountPwd($password)
	{
		$key = '14937c3a0f1ba660e03c6e4b4ee34944';
		return md5($key.$password);
	}
}

class MY_Admin_Controller extends MY_Controller {
	public $resData = array();
	public $aSession = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$aSession = $this->session->userdata($this->router->directory);
		if(is_null($aSession) || $aSession['is_login'] != 1){
			redirect(site_url(array($this->router->directory, 'login', 'index')));
		}
		$this->aSession = $aSession;
		
		$this->load->config('system');
		$system = $this->config->item('system');
		$this->resData['system'] = $system;
		if($this->router->class == 'main' && $this->router->method == 'index'){
			
		}else{			
			$stop = (! isset($system['site_satus']) || $system['site_satus'] == 0);//TRUE FALSE
			if($stop && (! isset($this->aSession['is_system_admin']) || $this->aSession['is_system_admin'] != 1)){
				set_status_header(405);
				echo isset($system['reson']) ? $system['reson'] : '平台维护升级关闭操作';
				exit();
			}
		}

		if($this->input->method(TRUE) == 'GET'){//get请求
			$this->resData['listHeader'] = array('location' => array(), 'actions' => array());
			$selected_menu = $this->input->get('data_num');
			$top = 0;//默认顶部导航
			if(! is_null($selected_menu) && $selected_menu != '-1'){
				$aLocation = array();
				if(strpos($selected_menu, '-') === FALSE){
					array_push($aLocation, $selected_menu);
				}else{
					list($top, $first, $second) = explode('-', $selected_menu);
					array_push($aLocation, $first);
					array_push($aLocation, $second);
				}
				if($aLocation){
					switch($this->router->directory){
						case 'agent/':
							$this->load->config('menu_agent');
							break;
						case 'admin/':
							$this->load->config('menu_admin');
							break;
						default:
							break;
					}
					
					$menu = $this->config->item('menu');
					$level = -1;
					foreach($aLocation as $key){//支持二级菜单
						if($level == -1){
							$level = $key;
							$this->resData['listHeader']['location'][] = array('name' => $menu[$top]['list'][$key]['name'], 'url' => '');
						}else{
							if(isset($menu[$top]['list'][$level]['list'][$key])){//修复左侧导航只有一级菜单(默认导航为top-left1-left2)
								$this->resData['listHeader']['location'][] = array('name' => $menu[$top]['list'][$level]['list'][$key]['name'], 'url' => '');
							}
						}						
					}
				}				
			}
		}

		$this->load->database();
	}

	/**
	 * 封装异步翻页
	 * @ $url 请求接口地址
	 * @ $total_rows 总记录数
	 * @ $per_page 每页显示条数
	 * @ $num_links 页码导航显示数
	 */
	public function pagination($url, $total_rows, $per_page = 0, $num_links = 5)
	{
		$per_page = $per_page == 0 ? $this->per_page : $per_page;
		$this->load->library('pagination');
		$config['base_url'] = $url;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;

		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';

		$config['first_link'] = '&lsaquo; 首页';
		$config['last_link'] = '末页 &rsaquo;';

		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = '»';
		$config['prev_link'] = '«';

		$config['prev_tag_open'] = '<li>';//<a href="#" aria-label="Previous"><span aria-hidden="true">
		$config['prev_tag_close'] = '</li>';

		$config['next_tag_open'] = '<li>';//<a href="#" aria-label="Next"><span aria-hidden="true">
		$config['next_tag_close'] = '</li>';//</span></a>

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
		$config['cur_tag_close'] = '</a></li>';

		$total_page = ceil($total_rows / $per_page);
		$config['num_links'] = $num_links > $total_page ? $total_page : $num_links;
		$this->pagination->initialize($config);

		$this->pagination->cur_page = $this->cur_page;
		return $this->pagination->create_links(TRUE);
	}
}

class MY_Agent_Controller extends MY_Admin_Controller {
	public function __construct()
	{
		parent::__construct();
	}
}

class MY_App_Controller extends MY_Controller {
	public $seller_id;//店员id
	public $time;
	public $sign;
	public $sid;//店铺id
	public $shopowner;//店长标识
	private $app_token_day = 7;
	public function __construct()
	{		
		parent::__construct();
		$this->checkAppSign();
	}

	private function checkAppSign()
	{
		$sid = $this->input->get_post('sid');
		$seller_id = $this->input->get_post('seller_id');
		$shopowner = $this->input->get_post('shopowner');
		$time = $this->input->get_post('time');
		$sign = $this->input->get_post('sign');

		if(is_null($sign)){
			$this->setFailResponse("签名参数为空！", -2);
			echo $this->getResponse();
			exit();
		}else{
			if(is_null($seller_id) || is_null($time) || is_null($sid) || is_null($shopowner)){
				$this->setFailResponse("缺少请求参数！", -2);
				echo $this->getResponse();
				exit();
			}else{
				$this->load->database();
				$this->load->model('app_token_model');
				$where = array('seller_id' => $seller_id, 'sid' => $sid);
				$row = $this->app_token_model->getTableOne($where);
				if(! $row){
					$this->setFailResponse("请先登录账号！", -2);
					echo $this->getResponse();
					exit();
				}

				$this->load->config('system');
				$system = $this->config->item('system');
				if(isset($system['app_token_day']) || $system['app_token_day'] = $this->app_token_day){//令牌授权过期，重新登录
					if(empty($system['app_token_day'])){
						$system['app_token_day'] = $this->app_token_day;
					}
					$appTime = $time + $system['app_token_day'] * 86400;//3600 * 24
					if($appTime < now()){
						$this->setFailResponse("令牌授权过期，重新登录！", -2);
						echo $this->getResponse();
						exit();
					}
				}

				if($time != $row['time']){
					$this->setFailResponse("授权令牌时间戳不正确！", -2);
					echo $this->getResponse();
					exit();
				}
				
				$this->sign = $this->getAppSign($seller_id, $sid, $shopowner, $time, $row['token']);
				if($this->sign != $sign){
					$this->setFailResponse("签名校验失败！", -2);
					echo $this->getResponse();
					exit();
				}

				if(mdate("%Y%m%d", $time) != mdate("%Y%m%d")){//非今天则更新令牌
					$ttime = now();
					$token = $this->getToken();
					if($this->app_token_model->updateTable(array('time' => $ttime, 'token' => $token), $where)){
						$time = $ttime;
						$sign = $this->getAppSign($seller_id, $sid, $shopowner, $time, $token);
					}
				}

				$this->seller_id = $seller_id;
				$this->sid = $sid;
				$this->shopowner = $shopowner;
				$this->time = $time;
				$this->sign = $sign;
			}
		}
	}

	public function setAppResponse($param = array())
	{
		$data = array(
			'com' => array(
				'seller_id' => $this->seller_id,
				'sid' => $this->sid,
				'shopowner' => $this->shopowner,
				'time' => $this->time,
				'sign' => $this->sign,
			),
			'param' => $param
		);
		$this->setSuccessResponse($data);
	}

	public function upload_base64_file($dir, $base64_image_content)
	{
		if(! empty($base64_image_content) && preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
			$type = $result[2];
			$new_file = makeStorePID().".{$type}";
			if(file_put_contents($dir.$new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
				return $new_file;
			}
		}else{
			return '';
		}
	}
}


class MY_Cron_Controller extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		if(! is_cli()){
			exit();
		}
	}
}

class MY_Normal_Controller extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 设置登录成功
	 * @ $is_system_admin 超级标识，停服可继续管理系统
	 * @ $account_type 账号类型【1平台2代理/推广员】
	 * @ $account 登录账号
	 */
	public function login_work_success($is_system_admin, $account_type, $account, $data = array())
	{
		$param = array(
				$this->router->directory => array(
						'is_login' => 1,
						'is_system_admin' => $is_system_admin,
						'account_type' => $account_type,
						'account' => $account,
						'data' => $data
				)
		);
		$this->session->set_userdata($param);
	}
	
	public function login_work_out($redirect_url)
	{
		$this->session->sess_destroy();
		redirect($redirect_url);
	}
}