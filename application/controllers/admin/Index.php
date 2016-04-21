<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Admin_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	//初始化页面
	public function index()
	{
		$this->load->config('menu_admin');
		$this->resData['menu'] = $this->config->item('menu');

		$this->load->view($this->getTemplateFile(), $this->resData);
	}

	//默认页面
	public function main()
	{
		$start_time = getTodayStartTime();
		$end_time = now();
		
		$where_offers = array('atime > ' => $start_time, 'atime < ' => $end_time);
		//查询提现
		$this->load->model('offers_model');
		//店铺提现
		$where = $where_offers;
		$where['sid >'] = 0;
		$field = 'COUNT(sid) AS number,COUNT(DISTINCT sid) AS times,SUM(money) AS total';
		$offer_store = $this->offers_model->getTableCount($field, $where);
		if(is_null($offer_store['total'])){
			$offer_store['total'] = 0;
		}
		$this->resData['offer_store'] = $offer_store;
		//代理/推广员提现
		$where = $where_offers;
		$where['aid >'] = 0;
		$field = 'COUNT(aid) AS number,COUNT(DISTINCT aid) AS times,SUM(money) AS total';
		$offer_agent = $this->offers_model->getTableCount($field, $where);
		if(is_null($offer_agent['total'])){
			$offer_agent['total'] = 0;
		}
		$this->resData['offer_agent'] = $offer_agent;
		// var_export($offer_store);var_export($offer_agent);exit();

		//查询店铺
		$this->load->model('store_model');
		//店铺总数
		$field = 'COUNT(id) AS number';
		$this->resData['store_total'] = $this->store_model->getTableCount($field);
		//店铺数
		$this->resData['store_yes'] = 0;
		$this->resData['store_check'] = 0;
		$where = $where_offers;
		// $where['status'] = $this->store_model->status_yes;
		$field = 'status, COUNT(id) AS number';
		$store_status = $this->store_model->getTableCount($field, $where, 'status', false);
		// var_export($store_status);
		if($store_status){
			foreach($store_status as $item){
				if($item['status'] == $this->store_model->status_yes){
					$this->resData['store_yes'] = $item['number'];
				}elseif($item['status'] == $this->store_model->status_null){
					$this->resData['store_check'] = $item['number'];
				}
			}
		}

		//查询交易
		$this->load->model('order_model');
		$where = $where_offers;
		$field = 'COUNT(order_id) AS number,SUM(money) AS total';
		$order = $this->order_model->getTableCount($field, $where);
		if(is_null($order['total'])){
			$order['total'] = 0;
		}
		$this->resData['order'] = $order;

		echo $this->load->view($this->getTemplateFile(), $this->resData, TRUE);
	}

	public function map()
	{
		// sleep(5);
		$base = array(
			'type' => 'map',
			'mapType' => 'china',
			'label' => array('normal' => array('show' => true), 'emphasis' => array('show' => true))
		);
		$res = array();
		$this->load->config('region');
		$regions = $this->config->item('region');
		$region = $regions[1];//默认中国区
		
		//查询代理
		$agent_data = array();
		$this->load->model('agent_promoter_model');
		$field = "region_1,COUNT(id) AS number";
		$where = array('parent_id' => 0);
		$agent = $this->agent_promoter_model->getTableCount($field, $where, 'region_1', false);
		// var_export($agent);exit();
		if($agent){
			foreach($agent as $item){
				$agent_data[] = array('name' => $region[$item['region_1']], 'value' => $item['number']);
			}
		}
		$key = count($res);
		$res[$key] = $base;
		$res[$key]['name'] = '代理';
		$res[$key]['data'] = $agent_data;

		//查询推广员
		$promoter_data = array();
		$field = "region_1,COUNT(id) AS number";
		$where = array('parent_id >' => 0);
		$promoter = $this->agent_promoter_model->getTableCount($field, $where, 'region_1', false);
		if($promoter){
			foreach($promoter as $item){
				$promoter_data[] = array('name' => $region[$item['region_1']], 'value' => $item['number']);
			}
		}
		$key = count($res);
		$res[$key] = $base;
		$res[$key]['name'] = '推广员';
		$res[$key]['data'] = $promoter_data;

		//查询店铺
		$store_data = array();
		$this->load->model('store_model');
		$field = "region_1,COUNT(id) AS number";
		$where = array();
		$store = $this->store_model->getTableCount($field, $where, 'region_1', false);
		if($store){
			foreach($store as $item){
				$store_data[] = array('name' => $region[$item['region_1']], 'value' => $item['number']);
			}
		}
		$key = count($res);
		$res[$key] = $base;
		$res[$key]['name'] = '店铺';
		$res[$key]['data'] = $store_data;

		$this->setSuccessResponse($res);
		echo $this->getResponse();
	}

	//站点Logo
	public function do_upload()
	{
        $this->upload_file();
        echo $this->getResponse();
	}

	public function chang_account()
	{
		$this->load->helper('array');
		$data = elements(
			array('account', 'email', 'usericon', 'new_password', 'password'),
			$this->input->post()
		);
		
		foreach($data as $key=>$item){
			if(is_null($item) || empty($item)){
				unset($data[$key]);
			}
		}

		if(! isset($data['password'])){
			$this->setFailResponse("编辑个人信息异常！");
			echo $this->getResponse();
			exit();
		}
		
		$this->load->model('admin_model');
		if($this->admin_model->setAdminPassword($data['password']) != $this->aSession['data']['password']){
			$this->setFailResponse("当前密码不正确！");
			echo $this->getResponse();
			exit();
		}
		if(isset($data['usericon']) && $data['usericon'] != $this->aSession['data']['header']){
			$data['header'] = $data['usericon'];
			unset($data['usericon']);
			if($this->aSession['data']['header'] && file_exists(FCPATH.'uploads/'.$this->aSession['data']['header'])){
				unlink(FCPATH.'uploads/'.$this->aSession['data']['header']);
			}
		}
		unset($data['password']);
		if(isset($data['new_password'])){
			$data['password'] = $this->admin_model->setAdminPassword($data['new_password']);
			unset($data['new_password']);
		}
		// var_export($data);exit();
		if($this->admin_model->updateTable($data, array('id' => $this->aSession['data']['id']))){
			$this->setSuccessResponse();
		}else{
			$this->setFailResponse("更新个人信息失败！");
		}

		echo $this->getResponse();
	}
}
