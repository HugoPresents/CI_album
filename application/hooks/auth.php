<?php
	class Auth {
		private $CI;
		private $is_login;
		function __construct() {
			$this->CI = &get_instance();
			$this->CI->load->library('session'); 
			$this->CI->load->helper('url');
			$this->is_login = isset($this->CI->session->userdata['is_login']) ? $this->CI->session->userdata['is_login'] : '' ;
		}
		//控制器限制
		function controller_auth() {
			//先尝试用cookie登录
			$this->CI->User_model->cookie_login();
			$array = array(
				'setting',
				'upload',
			);
			if(in_array($this->CI->uri->segment(1), $array) && !$this->is_login) {
					//echo '控制器钩子检测到';
				redirect('index/error');
			} else {
				$this->function_auth();
			}
		}
		
		function function_auth() {
			$array = array(
				'update',
				'delete'
			);
			if(in_array($this->CI->uri->segment(2), $array) && !$this->is_login) {
				//echo '方法钩子检测到';
				redirect('index/error');
			}
		}
	}