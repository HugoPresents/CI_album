<script type="text/javascript">
	$("input[name='upload']").click(function() {
			if($("input[name='file']").val() == '') {
				alert('请选择图片文件');
				return false;
			} else {
				return true;
			}
		});
</script>
<div id="upload">
	<h2>上传图片</h2>
	<?=form_open_multipart('upload/do_upload/') ?>
	<p><?=form_upload('file') ?>
	<?=form_submit('upload', '上传') ?></p>
</div>