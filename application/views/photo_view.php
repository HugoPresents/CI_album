<script type="text/javascript">
  window.___gcfg = {lang: 'zh-CN'};

  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<div id="photo_details">
	<div id="image_area">
		<img src="<?=thumb_url($image->name, 'original') ?>" width="450">
	</div>
	<div id="extend">
		<p><a class="image_attr">图片名称: </a>
		<? if($this->session->userdata('is_login')): ?>
		<a id="image_title" pid="<?=$image->id ?>"><?=$image->title ?></a></p>
		<? else: ?>
		<?=$image->title ?></p>
		<? endif ?>
		<p><a class="image_attr">图片尺寸: </a><?=$image->width . ' × ' . $image->height ?></p>
		<p><a class="image_attr">图片大小: </a><?=$image->size ?> KB</p>
		<p><a class="image_attr">上传时间: </a><?=date('Y年m月d日 H:i:s', $image->time) ?></p>
		<? if($this->session->userdata('is_login')): ?>
		<p class="operate"><a class="image_attr">操作: </a><?=anchor('photo/delete/' . $image->id, '删除', 'class="delete_link"') ?></p>
		<? endif ?>
		<p><a class="image_attr">图片描述: </a>
		<? if($this->session->userdata('is_login')): ?>	
		<a id="image_desc" pid="<?=$image->id ?>"><?=($image->description == '' ? '点击添加描述' : $image->description) ?></a></p>
		<? else: ?>
		<?$image->description ?> </p>
		<? endif ?>
		<p><a class="image_attr">社交操作: </a><g:plusone size="medium"></g:plusone></p>
		<p><a class="image_attr">切换图片: </a>
		<div id="photo-scroll">
			<? if($prev): ?>
			<!--上一张图片 -->
			<div class="scroll-photo-preview">
			<a class="change-photo" href="<?=site_url('photo/' . $prev->id) ?>" title="<?=$prev->title ?>"><img src="<?=thumb_url($prev->name, '100') ?>" width="80"></a>
			</div>
			<? endif ?>
			<!--当前图片 -->
			<div class="scroll-photo-preview">
			<a class="cur-photo" title="<?=$image->title ?>"><img src="<?=thumb_url($image->name, '100') ?>" width="80"></a>
			</div>
			<? if($next): ?>
			<!--下一张张图片 -->
			<div class="scroll-photo-preview">
			<a class="change-photo" href="<?=site_url('photo/' . $next->id) ?>" title="<?=$next->title ?>"><img src="<?=thumb_url($next->name, '100') ?>" width="80"></a>
			</div>
			<? endif ?>
		</div>
		<p><a class="image_attr">快捷引用：</a>
		<? if($thumb_url = thumb_url($image->name, '150')): ?>
			<a class="exp_link" href="<?=$thumb_url ?>" target="_blank">150</a>
			
			<textarea readonly="readonly" class="exp_link_text"><a href="<?=site_url('photo/' . $image->id) ?>" title="<?=$image->title ?>"><img src="<?=$thumb_url ?>" alt="<?=$image->title ?>"></a></textarea>
		<? endif ?>
		<? if($thumb_url = thumb_url($image->name, '500')): ?>
			<a class="exp_link" href="<?=$thumb_url ?>" target="_blank">500</a>
			
			<textarea readonly="readonly" class="exp_link_text"><a href="<?=site_url('photo/' . $image->id) ?>" title="<?=$image->title ?>"><img src="<?=$thumb_url ?>" alt="<?=$image->title ?>"></a></textarea>
		<? endif ?>
		<? if($original_url = thumb_url($image->name, 'original')): ?>
			<a class="exp_link" href="<?=$original_url ?>" target="_blank">原始</a>
			
			<textarea readonly="readonly" class="exp_link_text"><a href="<?=site_url('photo/' . $image->id) ?>" title="<?=$image->title ?>"><img src="<?=$original_url ?>" alt="<?=$image->title ?>"></a></textarea>
		<? endif ?>
		</p>
	</div>
</div>
<div id="photo_nav">
	<? if($prev): ?>
		<?=anchor('photo/' . $prev->id, '<<', 'id="prev_photo" title="上一张图片"') ?>
	<? endif ?>
	<? if($next): ?>
		<?=anchor('photo/' . $next->id, '>>', 'id="next_photo" title="下一张图片"') ?>
	<? endif ?>
</div>