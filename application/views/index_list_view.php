<div id="index_list">
	<? foreach($list->result() as $row): ?>
		<div class="photo_area">
			<div class="image"><a href="<?=site_url('photo/id/' . $row->id) ?>"><img src="<?=$row->preview ?>"></a></div>
			<div class="photo_name">
				<?=$row->title ?>
			</div>
		</div>
	<? endforeach ?>
</div>
<p style="
    padding: 10px 0;
    border-bottom: 1px dotted #DDD;
"></p>
<div id="pagination">
	<?=$pagination ?>
</div>