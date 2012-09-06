<?php
	class Photo_model extends CI_Model {
		
		function __construct() {
			parent::__construct();
			$this->load->library('upload');
		}
		
		/**
		 * 上传方法
		 */
		private function upload() {
			$title = explode_name($_FILES["file"]["name"], TRUE);
			$filename = md5(time()) . explode_name($_FILES["file"]["name"], FALSE);
			$config = array(
		  		'allowed_types' =>$this->config->item('allow_types'),
		  		'upload_path' => $this->config->item('album_path') . 'original/',
		  		'max_size' => $this->config->item('max_size'),
		  		'overwrite' => FALSE,
		  		'file_name'	=> $filename
			);
			mkdirs($config['upload_path']);
			print_vars($config, $title);
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('file')) {
				//$this->upload->display_errors();
				return FALSE;
			}
			$upload_data = $this->upload->data();
			print_vars($upload_data, $_POST);
			if($upload_data['image_width'] > 100) {
				$this->load->library('image_lib');
				$thumb = array(
					'source_image' => $upload_data['full_path'],
					'create_thumb' => TRUE,
					'maintain_ratio' => TRUE,
					'thumb_marker' => '',
					'quality' => 100,
					'new_image' => $this->config->item('album_path') . '100/',
					'width' => 100,
					'height' => 100
				);
				mkdirs($thumb['new_image']);
				$this->image_lib->initialize($thumb);
				$this->image_lib->resize();
				// 依据图片宽度，判断是否生成缩略图
				if($upload_data['image_width'] > $this->config->item('thumb_size')) {
					$this->load->library('image_lib');
					$thumb = array(
						'source_image' => $upload_data['full_path'],
						'create_thumb' => TRUE,
						'maintain_ratio' => TRUE,
						'thumb_marker' => '',
						'quality' => 100,
						'new_image' => $this->config->item('album_path') . '500/',
						'width' => 500,
						'height' => 500
					);
					mkdirs($thumb['new_image']);
					$this->image_lib->initialize($thumb);
					$this->image_lib->resize();
				}
			}
			$data = array(
				'title' => $title, 
				'name' => $upload_data['file_name'],
				'title' =>$title,
				'width' => $upload_data['image_width'],
				'height' => $upload_data['image_height'],
				'size' => ceil($upload_data['file_size'])
			);
			return $data;
		}
		
		/**
		 * 插入照片
		 */
		function insert() {
			if($photo = $this->upload()) {
				$photo['user_id'] = $this->session->userdata('id');
				$photo['time'] = time();
				$this->db->insert('photos', $photo);
				return $this->db->insert_id();
			} else {
				return FALSE;
			}
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