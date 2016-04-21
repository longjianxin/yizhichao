<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Normal_Controller {

	public function __construct()
	{		
		parent::__construct();
	}

	public function index()
	{
		$this->load->view($this->getTemplateFile());
	}

	//登录
	public function login_in()
	{
		$this->load->library('session');
		$account_type = $this->input->post('account_type');
		$account = $this->input->post('account');
		$password = $this->input->post('password');
		
		if($account == SYSTEM_ADMIN_ACCOUNT && $this->getSystemAccountPwd($password) == SYSTEM_ADMIN_PASSWORD){
			$this->login_work_success(1, $account_type, SYSTEM_ADMIN_ACCOUNT, array('email' => '', 'header' => '', 'account' => SYSTEM_ADMIN_ACCOUNT, 'name' => SYSTEM_ADMIN_ACCOUNT));
			$this->setSuccessResponse(array('url' => site_url(array($this->router->directory, 'index', 'index'))));
		}else{
			$this->load->model('admin_model');
			$row = $this->admin_model->getTableOne(array('account' => $account));
			if(! $row){
				$this->setFailResponse("登录账号不存在！");
				echo $this->getResponse();
				exit();
			}

			if($row['password'] != $this->admin_model->setAdminPassword($password)){
				$this->setFailResponse("登录密码不正确！");
			}else{
				$this->login_work_success(0, $account_type, $row['account'], $row);
				$this->admin_model->updateTable(array('num' => $row['num'] + 1, 'last_time' => $row['login_time'], 'login_time' => now()), array('id' => $row['id']));
				$this->setSuccessResponse(array('url' => site_url(array($this->router->directory, 'index', 'index'))));
			}
		}

		echo $this->getResponse();
	}

	//登出
	public function login_out()
	{
		$this->load->library('session');
		$this->login_work_out(site_url(array($this->router->directory, $this->router->class, 'index')));
	}
}
