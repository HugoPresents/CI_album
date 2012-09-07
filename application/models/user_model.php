<?php
 	class User_model extends CI_Model {
 		function __construct() {
 			parent::__construct();
 		}
		
		function insert($array, $table = 'users') {
			if($this->db->insert($table, $array)) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
		
		function delete_user() {
			
		}
		
		function login($name = '', $pass = '', $use_cookie = FALSE) {
			$remember = $this->input->post('remember_status');
			$this->db->where('name', $name);
			$result = $this->db->get('users');
			if($result->num_rows > 0) {
				$user = $result->row();
				if($pass == $user->pass) {
					$this->session->set_userdata(array(
						'id' => $user->id,
						'user' => $user,
						'is_login' => TRUE
					));
					//在不是用cookie登陆的情况下勾选了记住登录，就会写入cookie到浏览器
					if($remember == 1 && !$use_cookie) {
						$cookie = array(
							'name'   => 'name',
							'value'  => $user->name,
							'expire' => '86500'
						);
						$this->input->set_cookie($cookie);
						$cookie = array(
							'name'   => 'pass',
							'value'  => $user->pass,
							'expire' => '86500'
						);
						$this->input->set_cookie($cookie);
					}
					return 2;
				} else {
					return 1;
				}
			} else {
				return 0;
			}
		}
		//使用cookie登录方法
		function cookie_login() {
			$name = $this->input->cookie('name');
			$pass = $this->input->cookie('pass');
			return $this->login($name, $pass, TRUE);
		}
		//修改密码
		function change_pass() {
			$original_pass = $this->input->post('original_pass');
			$new_pass = $this->input->post('new_pass');
			$new_pass_check = $this->input->post('new_pass_check');
			if($new_pass != $new_pass_check) {
				return 0;
			} else {
				$name = $this->session->userdata('user')->name;
				$this->db->where('name', $name);
				$result = $this->db->get('users');
				$user = $result->row();
				if($user->pass != md5($original_pass)) {
					return 1;
				} else {
					$this->db->update('users', array('pass' => md5($new_pass)));
					return 2;
				}
			}
		}
 	}
