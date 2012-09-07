<?php
	class Index extends CI_Controller{
		public $limit;
		function __construct() {
			parent::__construct();
			$this->load->model('Photo_model');
			$this->load->library('pagination');
			$this->limit = get_options('per_page');
		}
		
		function index() {
			$this->page(1);
		}
		
		function page($page = 1) {
			if($page == 1 && $this->uri->segment(2) == 'page') {
				redirect(site_url());
			}
			$list = $this->Photo_model->get_list($this->limit, ($page - 1) * $this->limit);
			if($list) {
				$config = array(
					'per_page' => $this->limit,
					'base_url' => site_url('index/page/'),
					'total_rows' => count_table('photos'),
					'uri_segment' => 3,
				);
				$this->pagination->initialize($config);
				$data['pagination'] = $this->pagination->create_links();
				$data['list'] = $list;
				$data['title'] = '首页';
				if($page > 1) {
					$data['title'] = 'page' . $page;
				}
				$data['css'] = 'index_list_view.css';
				$data['main_content'] = 'index_list_view';
				$this->load->view('includes/template_view', $data);
			} else {
				static_view('首页', '你还没有上传图片,' . anchor('upload', '点此上传'));
			}
		}
		
		function login() {
			if($this->session->userdata('is_login')) {
				redirect(site_url());
			} else {
				delete_cookie('name');
				delete_cookie('pass');
				$data['main_content'] = 'login_view';
				$data['title'] = '管理员登陆';
				$data['css'] = 'login_view.css';
				$data['js'] = 'login_view.js';
				$this->load->view('includes/template_view', $data);
			}
		}
		
		function do_login() {
			$name = $this->input->post('name');
			$pass = md5($this->input->post('pass'));
			$login_code = $this->User_model->login($name, $pass);
			if($login_code == 2) {
				redirect(site_url());
			} elseif($login_code == 1) {
				static_view('登陆失败', '密码不正确，返回重新登录', site_url('index/login'));
			} else {
				static_view('登陆失败', '用户名不存在，返回重新登录', site_url('index/login'));
			}
		}
		
		function logout() {
			$this->session->sess_destroy();
			delete_cookie('name');
			delete_cookie('pass');
			redirect(site_url());
		}
		
		function error() {
			static_view('无权限操作', '亲，你不要干哈事，如果你是管理员，请先' . anchor('index/login', '登录') . '好吧');
		}
	}