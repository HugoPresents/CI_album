<?php
	class Photo extends MY_Controller {
		function __construct() {
			parent::__construct();
			$this->load->model('Photo_model');
		}
		
		function index($id = '') {
			$data['image'] = $this->Photo_model->fetch_one($id);
			if($data['image']) {
				$data['next'] = $this->Photo_model->next_photo($id);
				$data['prev'] = $this->Photo_model->prev_photo($id);
				$data['title'] = $data['image']->title;
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
				if($this->Photo_model->delete($id)) {
					redirect();
				} else {
					static_view('删除失败', '删除图片失败,返回查看该图片', site_url('photo/' . $id));
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
			if($this->Photo_model->update($id, $array)) {
				echo '1';
			} else {
				echo '0';
			}
		}
		
		
		/***************************************ajax function end********************************************/
	}
