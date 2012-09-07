<?php
	class MY_Controller extends CI_Controller {
		function __construct() {
			parent::__construct();
		}
		
		function _remap($method, $params = array()) {
			if (method_exists($this, $method)){
				return call_user_func_array(array($this, $method), $params);
			} else {
				array_unshift($params, $method);
				return call_user_func_array(array($this, 'index'), $params);
			}
		}
	}