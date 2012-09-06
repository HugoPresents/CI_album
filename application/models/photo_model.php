<?php
	class Photo_model extends CI_Model {
		
		function __construct() {
			parent::__construct();
			$this->load->library('upload');
			$this->load->library('image_lib');
		}
		
		/**
		 * 上传方法
		 */
		private function upload() {
			$title = explode_name($_FILES["file"]["name"], TRUE);
			$filename = md5(time()) . explode_name($_FILES["file"]["name"], FALSE);
			$config = array(
		  		'allowed_types' =>$this->config->item('allow_types'),
		  		'upload_path' => $this->config->item('album_path'),
		  		'max_size' => $this->config->item('max_size'),
		  		'overwrite' => FALSE,
		  		'file_name'	=> $filename
			);
			$this->upload->initialize($config);
			$this->upload->do_upload();
			$upload_data = $this->upload->data();
			
			$thumb = array(
				
			);
		}
		
		/**
		 * 插入照片
		 */
		function insert() {
			
			
		}
		
		/**
		 * 删除照片
		 */
		function delete($id) {
			
		}
		
		/**
		 * 更新照片信息
		 */
		function update($id, $param = array()) {
			
		}
		/**
		 * 获取图片列表
		 */
		function get_list($limit = '8', $offset = 0) {
			$this->db->from('photos')->order_by('id', 'DESC')->limit($limit, $offset);
			$result = $this->db->get();
			if($result->num_rows > 0) {
				return $result;
			} else {
				return FALSE;
			}
		}
	}