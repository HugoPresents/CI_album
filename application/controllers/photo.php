<?php
	class Photo extends CI_Controller {
		function __construct() {
			parent::__construct();
			$this->load->model('Photo_model');
		}
		
		function index() {
			$list = $this->Photo_model->get_list();
			if($list) {
				$data['list'] = $list;
				$data['title'] = '首页';
			} else {
				$data['message'] = '你还没有上传照片' . anchor('upload', '点此上传');
				$data['title'] = '首页';
				$data['main_content'] = 'static_view';
				$this->load->view('includes/template_view', $data);
			}
		}
		//根据id查看图片
		function id($id = '') {
			$data['image'] = $this->Photo_model->id($id);
			if($data['image']) {
				$data['next'] = $this->Photo_model->next_photo($id);
				$data['prev'] = $this->Photo_model->prev_photo($id);
				$data['title'] = $data['image']['image_info']->title . '|' . get_options('album_name');
				$data['main_content'] = 'photo_view';
				$data['css'] = 'photo_view.css';
				$data['js'] = 'photo_view.js';
				$this->load->view('includes/template_view', $data);
			} else {
				static_view('图片不存在', '你要查看的图片不存在');
			}
		}
		
		function album() {
			
		}
		
		function delete($id = '') {
			if($id != '') {
				if($this->Photo_model->delete_photo($id)) {
					redirect(isset($_SERVER['HTTP_REFERER']) ? ($_SERVER['HTTP_REFERER']) : site_url());
				} else {
					static_view('删除失败', '删除图片失败,返回查看该图片', site_url('photo/id/' . $id));
				}
			} else {
				static_view('删除失败', '删除图片失败,要删除的图片不存在');
			}
		}
		/***************************************ajax function start********************************************/
		// 修改图片信息方法
		function update() {
			$id = $this->input->post('id');
			$array = array();
			if($this->input->post('title') != '') {
				$array['title'] = $this->input->post('title');
			}
			
			if($this->input->post('desc') != '') {
				$array['description'] = $this->input->post('desc');
			}
			if($this->Photo_model->update_photo($id, $array)) {
				echo '1';
			} else {
				echo '0';
			}
		}
		
		
		/***************************************ajax function end********************************************/
	}
