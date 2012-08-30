$(function() {
	//切换设置选项
	$("a[target=album_setting]").click(function() {
		$("#change_pass").hide();
		$("#album_setting").show();
		$('#setting_bar a').removeClass('setting_selected');
		$(this).addClass('setting_selected');
	});
	$("a[target=change_pass]").click(function() {
		$("#album_setting").hide();
		$("#change_pass").show();
		$('#setting_bar a').removeClass('setting_selected');
		$(this).addClass('setting_selected');
	});
	
	//验证密码
	$("#change_pass input[name='submit']").click(function() {
		if(original_password_check() && new_password_check() && password_check()) {
			return true;
		} else if(!original_password_check()) {
			alert('原密码不能为空');
			return false;
		} else if(!new_password_check()) {
			alert('新密码不能为空');
			return false;
		} else if(!password_check()) {
			alert('确认密码不一致');
			return false;
		} else {
			alert('验证异常');
			return false;
		}
	});
	
	function original_password_check() {
		if($("#change_pass input[name='original_pass']").val() == '') {
			return false;
		} else {
			return true;
		}
	}
	
	function new_password_check() {
		if($("#change_pass input[name='new_pass']").val() == '') {
			return false;
		} else {
			return true;
		}
	}
	
	function password_check() {
		if($("#change_pass input[name='new_pass_check']").val() == $("#change_pass input[name='new_pass']").val()) {
			return true;
		} else {
			return false;
		}
	}

});
