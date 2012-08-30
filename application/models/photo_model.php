<?php
	class Photo_model extends  CI_Model {
		public $storage;
		public $domain;
		public $original_url;
		public $small_url;
		public $medium_url;
		public $big_url;
		function __construct() {
			parent::__construct();
			$this->domain = get_options('domain');
			$this->storage = new SaeStorage();
		}
		
		function get_list($limit = '8', $offset = 0) {
			$this->db->from('photos')->order_by('id', 'DESC')->limit($limit, $offset);
			$result = $this->db->get();
			if($result->num_rows > 0) {
				return $result;
			} else {
				return FALSE;
			}
		}
		
		function upload() {
			if (($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/vnd.microsoft.icon")) {
				$title = explode_name($_FILES["file"]["name"], TRUE);
				$name = md5(time()) . explode_name($_FILES["file"]["name"], FALSE);
				$type = $_FILES["file"]["type"];
				$size = ceil($_FILES["file"]["size"] / 1024);
				$author = $this->session->userdata('user')->id;
				$time = date("Y-m-d H:i");
				$this->storage->upload($this->domain, 'original/' . $name, $_FILES['file']['tmp_name']);
				//调试
				//echo $this->storage->errno();
				//echo $this->storage->errmsg();
				if($this->storage->errno() == 0) {
					//从storage读取文件让saeimage读取出文件信息
					$original_image = new SaeImage();
					$original_image->setData($this->storage->read($this->domain, 'original/' . $name));
					$original_imageinfo = $original_image->getImageAttr();
					$width = $original_imageinfo[0];
					$height = $original_imageinfo[1];
					$preview = '';
					//根据图片大小将生成三种缩略图
					if($width > 150) {
						$preview = $this->thumb_url($name, 150);
						if($width > 300) {
							$this->thumb_url($name, 300);
							if($width > 500) {
								$this->thumb_url($name, 500);
							}
						}
					} else {
						$preview = $this->storage->getUrl($this->domain, 'original/' . $name);
					}
					$image_info = array(
						'name' => $name,
						'title' => $title,
						'type' => $type,
						'time' => $time,
						'size' => $size,
						'preview' => $preview,
						'width' => $width,
						'height' => $height,
						'author' => $author,
						'storage' => $this->domain
					);
					//将图片信息插入数据库
					return($this->insert_photo($image_info));
				} else {
					return FALSE;
				}
			}
		}
		//根据id获取图片信息
		function id($id = '') {
			$this->db->where('id', $id);
			$result = $this->db->get('photos');
			if($result->num_rows == 0) {
				return FALSE;
			} else {
				$image_info = $result->row();
				//echo $image_info->name;
				$this->original_url = $this->storage->getUrl($this->domain, 'original' . '/' . $image_info->name);
				if($image_info->width > 150) {
					$this->small_url =  $this->thumb_url($image_info->name, 150);
					if($image_info->width > 300) {
						$this->medium_url = $this->thumb_url($image_info->name, 300);
						if($image_info->width > 500) {
							$this->big_url = $this->thumb_url($image_info->name, 500);
						}
					}
				}
				return $this->to_array($image_info);
			}
		}
		
		//根据相册获取图片信息
		function album() {
			
		}
		//将视图需要的数据以数组的形式返回给控制器
		function to_array($image_info) {
			return array(
				'image_info' => $image_info,
				'small_url' => $this->small_url,
				'medium_url' => $this->medium_url,
				'big_url' => $this->big_url,
				'original_url' => $this->original_url
			);
		}
		//获取指定大小的缩略图url，如果没有则生成缩略图
		function thumb_url($filename, $size = '150') {
			//如果缩略图不存在则创建缩略图
			if(!$this->storage->fileExists($this->domain, $size . '/' . $filename)) {
				$image = new SaeImage();
				$image->setData($this->storage->read($this->domain, 'original/' . $filename));
				$image->resize($size);
				$this->storage->write($this->domain, $size . '/' . $filename, $image->exec());
			}
				return $this->storage->getUrl($this->domain, $size . '/' . $filename);
		}
		
		function insert_photo($image_info = '') {
			$this->db->insert('photos', $image_info);
			return $this->db->insert_id();
		}
		//删除图片方法
		function delete_photo($id) {
			$this->db->where('id', $id);
			$result = $this->db->get('photos');
			if($result->num_rows == 0) {
				return FALSE;
			} else {
				$photo = $result->row();
				$name = $photo->name;
				//删除所有尺寸的图片
				if($this->storage->fileExists($this->domain, '150/' . $name))
					$this->storage->delete($this->domain, '150/' . $name);
				if($this->storage->fileExists($this->domain, '300/' . $name))
					$this->storage->delete($this->domain, '300/' . $name);
				if($this->storage->fileExists($this->domain, '500/' . $name))
					$this->storage->delete($this->domain, '500/' . $name);
				if($this->storage->fileExists($this->domain, 'original/' . $name))
					$this->storage->delete($this->domain, 'original/' . $name);
				$this->db->where('id', $id);
				$this->db->delete('photos');
				return TRUE;
			}
		}
		//修改图片信息
		function update_photo($id, $array = '') {
			$this->db->where('id', $id);
			if($this->db->update('photos', $array)) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
		
		//获取下一张图片
		function next_photo($id = '') {
			if($id) {
				$this->db->where('id <', $id)->order_by('id', 'DESC')->limit(1);
				$result = $this->db->get('photos');
				if($result->num_rows == 1) {
					return $result->row();
				} else {
					return FALSE;
				}
			} else {
				return FALSE;
			}
		}
		
		//获取上一张图片
		function prev_photo($id = '') {
			if($id) {
				$this->db->where('id >', $id)->order_by('id', 'ASC')->limit(1);
				$result = $this->db->get('photos');
				if($result->num_rows == 1) {
					return $result->row();
				} else {
					return FALSE;
				}
			} else {
				return FALSE;
			}
		}
	}