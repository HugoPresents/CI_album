$(function() {
	//快捷引用功能
	$(".exp_link").mouseover(function() {
		if($(this).next(".exp_link_text").is(":hidden")) {
			$(".exp_link_text").hide();
			$(this).siblings().removeClass("text-selected");
			$(this).next(".exp_link_text").show();
			$(this).addClass("text-selected");
		}
	});
	$(".exp_link_text").click(function() {
		$(this).select();
	});
	//缩放功能
	$("#image_area").click(function() {
		img = $(this).children("img").attr('src');
		str = '<div id="zoom-image"><img src="' + img + '"></div>';
		$("body").prepend('<div id="photo-zoom"></div>');
		$('#photo-zoom').after(str);
		$("#photo-zoom, #zoom-image").click(function() {
			$("#zoom-image, #photo-zoom").remove();
		})
	})
	//删除图片确认
	$(".delete_link").click(function() {
		if(confirm("将删除与之相关的所有尺寸的图片以及数据，该操作没有后悔药，确认删除？")) {
			return true;
		}else {
			return false;
		}
	});
	
	//编辑图片信息
	$("#image_title").click(function() {
		title = $(this).text();
		id = $(this).attr('pid');
		$(this).hide();
		str = '<input type="text" name="title" value="' + title + '">';
		$(this).before(str);
		$("input[name='title']").focus();
		$("input[name='title']").blur(function() {
			changed = $(this).val();
			if(changed != title && changed != '') {
				$.post(SITE_URL + 'photo/update', {
					id: id,
					title: changed
				}, function(data) {
					if(data == '1') {
						$("input[name='title']").remove();
						$("#image_title").text(changed).show();
					} else {
						alert('修改失败');
						$("input[name='title']").remove();
						$("#image_title").show();
					}
				});
			} else {
				$("input[name='title']").remove();
				$("#image_title").show();
			}
		});
	});
	
	$("#input[name='title']").keydown(function(e) {
		if(e.which == 13 || e.which == 10) {
            $(this).blur();
        }
    });
	
	$("#image_desc").click(function() {
		desc = $(this).text();
		id = $(this).attr('pid');
		$(this).hide();
		str = '<textarea name="desc">' + desc + '</textarea>';
		$(this).before(str);
		$("textarea[name='desc']").focus();
		$("textarea[name='desc']").blur(function() {
			changed = $(this).val();
			if(changed != desc && changed != '') {
				$.post(SITE_URL + 'photo/update', {
					id: id,
					desc: changed
				}, function(data) {
					if(data == '1') {
						$("textarea[name='desc']").remove();
						$("#image_desc").text(changed).show();
					} else {
						alert('修改失败');
						$("textarea[name='desc']").remove();
						$("#image_desc").show();
					}
				});
			} else {
				$("textarea[name='desc']").remove();
				$("#image_desc").show();
			}
		});
	});
	
	$("#textarea[name='desc']").keydown(function(e) {
		if(e.which == 13 || e.which == 10) {
            $(this).blur();
        }
    });
});