<div id="login">
	<h2>用户登陆</h2>
	<?=form_open('index/do_login') ?>
	<p><label class="input-s">用户名：</label><?=form_input('name'); ?></p>
	<p><label class="input-s">密码：</label><?=form_password('pass') ?></p>
	<div style="width:280px;height:30px">
	<div class="form-left"><?=form_checkbox('remember_status', '1') ?>记住登录状态？</div><div class="form-right"><?=form_submit('submit', '登录'); ?></div>
	</div>
	<?=form_close() ?>
</div>