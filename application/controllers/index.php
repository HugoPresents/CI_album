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
				redirect();
			} else {
				delete_cookie('name');
				delete_cookie('pass');
				$data['name'] = '';
				$data['pass'] = '';
				$data['name_error'] = '';
				$data['pass_error'] = '';
				$data['remember_status'] = 0;
				if($this->input->post('submit')) {
					$data['name'] = trim($this->input->post('name'));
					$data['pass'] = $this->input->post('pass');
					$data['remember_status'] = $this->input->post('remember_status');
					if(!$data['name']) {
						$data['name_error'] = '用户名不能为空';
					} elseif(!$data['pass']) {
						$data['pass_error'] = '密码不能为空';
					} else {
						$login_code = $this->User_model->login($data['name'], md5($data['pass']));
						if($login_code == 2) {
							redirect();
						} elseif($login_code == 1) {
							$data['pass_error'] = '密码错误';
						} else {
							$data['name_error'] = '用户名不存在';
						}
					}
				}
				$data['main_content'] = 'login_view';
				$data['title'] = '管理员登录';
				$data['css'] = 'login_view.css';
				$this->load->view('includes/template_view', $data);
			}
		}
		
		function create_user() {
			$user = $this->db->get('users');
			if($user->num_rows < 1 || $this->session->userdata('is_login')){
				$data['name'] = '';
				$data['pass'] = '';
				$data['pass_check'] = '';
				$data['name_error'] = '';
				$data['pass_error'] = '';
				$data['pass_check_error'] = '';
				if($this->input->post('submit')) {
					$data['name'] = trim($this->input->post('name'));
					$data['pass'] = $this->input->post('pass');
					$data['pass_check'] = $this->input->post('pass_check');
					if(!$data['name']) {
						$data['name_error'] = '用户名不能为空';
					} elseif(!$data['pass']) {
						$data['pass_error'] = '密码不能为空';
					} elseif($data['pass'] != $data['pass_check']) {
						$data['pass_check_error'] = '密码不一致';
					} else {
						$user = array(
							'name' => $data['name'],
							'pass' => md5($data['pass'])
						);
						$this->User_model->insert($user);
						jump_view('创建用户', '创建用户成功，请自行登录', 'index/login');
						return;
					}
				}
				$data['title'] = '创建用户';
				$data['main_content'] = 'regist_view';
				$data['css'] = 'setting_vies.css';
				$this->load->view('includes/template_view', $data);
			} else {
				redirect('index/error');
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