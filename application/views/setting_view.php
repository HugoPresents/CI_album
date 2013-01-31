<div id="setting">
	<h2>站点设置</h2>
	<div id="setting_bar">
		<ul>
			<li><a target="album_setting" class="setting_selected">相册设置</a>| </li>
			<li><a target="change_pass">修改密码</a></li>
		</ul>
	</div>
	<div id="album_setting">
		<?=form_open('setting/album') ?>
		<p><label class="input-s">相册名称：</label><?=form_input('album_name', get_options('album_name')) ?></p>
		<p><label class="input-s">相册描述：</label><?=form_input('description', get_options('description')) ?></p>
		<p><label class="input-s">每页显示数量：</label><?=form_input('per_page', get_options('per_page')) ?></p>
		<p><label class="input-s">Cookie 过期时间(秒)：</label><?=form_input('cookie_expire', get_options('cookie_expire')) ?></p>
		<p><?=form_submit('submit', '更新设置') ?></p>
		<?=form_close() ?>
	</div>
	<div id="change_pass" class="hide">
		<?=form_open('setting/change_pass') ?>
		<p><label class="input-s">原密码：</label><?=form_password('original_pass') ?></p>
		<p><label class="input-s">新密码：</label><?=form_password('new_pass') ?></p>
		<p><label class="input-s">确认新密码：</label><?=form_password('new_pass_check') ?></p>
		<p><?=form_submit('submit', '修改密码') ?></p>
		<?=form_close() ?>
	</div>
</div>