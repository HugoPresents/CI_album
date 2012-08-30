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
		foreach($array as $name => $value) {
			$CI->db->where('name', $name);
			$CI->db->update('options', array('value' => $value));
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
		$data['title'] = $title. '|' . get_options('album_name');
		$data['message'] = $message;
		$data['back_url'] = $back_url;
		$data['main_content'] = 'static_view';
		$CI->load->view('includes/template_view', $data);
	}
	//加载跳转视图辅助函数
	function jump_view($title = '', $message = '', $jump_url = '') {
		$CI =& get_instance();
		$data['title'] = $title. '|' . get_options('album_name');
		$data['message'] = $message;
		$data['jump_url'] = $jump_url;
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
