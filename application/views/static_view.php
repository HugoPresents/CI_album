<div id="static">
	<p><?=$message ?></p>
	<? if($back_url != ''): ?>
	<p><?=anchor($back_url, '返回') ?></p>
	<? endif ?>
</div>