<div id="setting">
	<h2>创建用户</h2>
	<div id="setting_bar">
	</div>
	<div id="change_pass" class="hide">
		<?=form_open('index/create_user') ?>
		<p>
			<label class="input-s">用户名：</label><?=form_input('name', $name) ?>
			<span><?=$name_error ?></span>
		</p>
		<p>
			<label class="input-s">密码：</label><?=form_password('pass', $pass) ?>
			<span><?=$pass_error ?></span>
		</p>
		<p>
			<label class="input-s">确认新密码：</label><?=form_password('pass_check', $pass_check) ?>
			<span><?=$pass_check_error ?></span>
		</p>
		<p><?=form_submit('submit', '提交') ?></p>
		<?=form_close() ?>
	</div>
</div>