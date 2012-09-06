<?php
	class Setting extends CI_Controller {
		function __construct() {
			parent::__construct();
		}
		
		function index() {
			$data['title'] = '站点设置';
			$data['css'] = 'setting_view.css';
			$data['js'] = 'setting_view.js';
			$data['main_content'] = 'setting_view';
			$this->load->view('includes/template_view', $data);
		}
		
		function album() {
			$album_name = $this->input->post('album_name');
			$description = $this->input->post('description');
			$per_page = $this->input->post('per_page');
			$options = array();
			if($album_name != '') {
				$options = array_merge($options, array('album_name' => $album_name));
			}
			if($description != '') {
				$options = array_merge($options, array('description' => $description));
			}
			if($per_page != '') {
				$options = array_merge($options, array('per_page' => $per_page));
			}
			//print_r($options);
			update_options($options);
			redirect('setting');
		}
		
		function change_pass() {
			$return_code = $this->User_model->change_pass();
			switch($return_code) {
				case 0:
					static_view('修改密码失败', '两次输入新密码不一致，请返回重试', site_url('setting'));
					break;
				case 1:
					static_view('修改密码失败', '原密码错误，请返回重试', site_url('setting'));
					break;
				case 2:
					$this->session->sess_destroy();
					delete_cookie('name');
					delete_cookie('pass');
					jump_view('修改密码成功', '修改密码成功，需要重新登录，即将跳转到登录页面', site_url('index/login'));
					break;
			}
		}
	}
