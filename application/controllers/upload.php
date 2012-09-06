<?php
	class Upload extends CI_Controller {
		function __construct() {
			parent::__construct();
			$this->load->model('Photo_model');
		}
		
		function index() {
			$data['title'] = '上传图片';
			$data['main_content'] = 'upload_view';
			$data['css'] = 'upload_view.css';
			$this->load->view('includes/template_view', $data);
		}
		
		function do_upload() {
			$id = $this->Photo_model->upload();
			/*
			if($id) {
				static_view('上传成功', '上传成功！现在你有两条路选择：' . anchor('photo/id/' . $id, '查看已上传图片') . '&nbsp;或者&nbsp;'.  anchor('upload', '继续上传'));
				//redirect('photo/model');
			} else {
				static_view('上传失败', '图片上传失败', site_url('upload'));
			}
			 * 
			 */
		}
	}