<?php
	//新建配置项
	function insert_options($array) {
		$CI =& get_instance();
		$CI->db->insert('options', $array);
	}
	//读取配置项
	function get_options($name = '') {
		$CI =& get_instance();
		$CI->db->where('name', $name);
		$result = $CI->db->get('options');
		if($result->num_rows > 0) {
			return $result->row()->value;
		} else {
			return FALSE;
		}
	}
	
	//修改配置项
	function update_options($array = array()) {
		$CI =& get_instance();
		//print_vars($array);
		foreach($array as $name => $value) {
			if(get_options($name)) {
				$CI->db->where('name', $name)->update('options', array('value' => $value));
			} else {
				insert_options(array('name'=>$name, 'value'=>$value));
			}
		}
	}
	//分割文件名为文件名和后缀
	function explode_name($name, $prev = TRUE) {
		if($prev) {
			return substr($name, 0, strrpos($name, '.'));
		} else {
			return substr($name, strrpos($name, '.'));
		}
	}
	//加载静视图辅助函数
	function static_view($title = '', $message = '', $back_url = '') {
		$CI =& get_instance();
		$data['title'] = $title;
		$data['message'] = $message;
		$data['back_url'] = $back_url;
		$data['main_content'] = 'static_view';
		$CI->load->view('includes/template_view', $data);
	}
	//加载跳转视图辅助函数
	function jump_view($title = '', $message = '', $jump_url = '') {
		$CI =& get_instance();
		$data['title'] = $title;
		$data['message'] = $message;
		$data['jump_url'] = site_url($jump_url);
		$data['main_content'] = 'jump_view';
		$CI->load->view('includes/template_view', $data);
	}
	
	//统计数据库表行数
	function count_table($table = '') {
		if($table) {
			$CI =& get_instance();
			return $CI->db->count_all($table);
		} else {
			return FALSE;
		}
	}
	if(! function_exists('print_var')) {
		function print_vars() {
			$vars = func_get_args();
			echo '<pre>';
			foreach ($vars as $var) {
				var_dump($var);
			}
			echo '</pre>';
		}
	}
	if(! function_exists('mkdirs')) {
		function mkdirs($dir) {  
			if(!is_dir($dir)) {  
				if(!mkdirs(dirname($dir))){  
					return false;  
				}  
				if(!mkdir($dir,0755)) {  
					return false;  
				}  
			}
			return true;  
		}
	}
	if(! function_exists('thumb_url')) {
		function thumb_url($filename, $thumb = '100') {
			$CI = &get_instance();
			$thumb_url = $CI->config->item('album_path') . $thumb . '/' . $filename;
			//print_vars($filename, $thumb, $thumb_url);
			if(file_exists($thumb_url)) {
				return site_url($thumb_url);
			} elseif ($thumb != 'original') {
				$original_path = $CI->config->item('album_path') . 'original/' . $filename;
				//print_vars($original_path);
				$CI->load->library('image_lib');
				$thumb = array(
					'source_image' => $original_path,
					'create_thumb' => TRUE,
					'maintain_ratio' => TRUE,
					'thumb_marker' => '',
					'quality' => 100,
					'new_image' => $CI->config->item('album_path') . $thumb .'/',
					'width' => 100,
					'height' => 100
				);
				mkdirs($thumb['new_image']);
				$CI->image_lib->initialize($thumb);
				$CI->image_lib->resize();
				return $thumb_url;
			}
			return FALSE;
		}
	}
