<div id="sliderbar">
	<ul>
		<li><?=anchor(site_url(), '首页') ?></li>
		<? if($this->session->userdata('is_login') == 1): ?>
		<!--
		<li><?=anchor('album', '所有图片') ?></li>
		-->
		<li><?=anchor('upload', '上传图片') ?></li>
		<li><?=anchor('setting', '站点设置') ?></li>
		<li><?=anchor('index/logout', '退出登录') ?></li>
		<? else: ?>
		<li><?=anchor('index/login', '管理员登录') ?></li>
		<? endif; ?>
	</ul>
</div>