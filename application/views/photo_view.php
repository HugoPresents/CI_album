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
		<img src="<?=$image['original_url'] ?>" width="450">
	</div>
	<div id="extend">
		<p><a class="image_attr">图片名称: </a>
		<? if($this->session->userdata('is_login')): ?>
		<a id="image_title" pid="<?=$image['image_info']->id ?>"><?=$image['image_info']->title ?></a></p>
		<? else: ?>
		<?=$image['image_info']->title ?></p>
		<? endif ?>
		<p><a class="image_attr">图片尺寸: </a><?=$image['image_info']->width . ' × ' . $image['image_info']->height ?></p>
		<p><a class="image_attr">图片大小: </a><?=$image['image_info']->size ?> KB</p>
		<p><a class="image_attr">上传时间: </a><?=$image['image_info']->time ?></p>
		<? if($this->session->userdata('is_login')): ?>
		<p class="operate"><a class="image_attr">操作: </a><?=anchor('photo/delete/' . $image['image_info']->id, '删除', 'class="delete_link"') ?></p>
		<? endif ?>
		<p><a class="image_attr">图片描述: </a>
		<? if($this->session->userdata('is_login')): ?>	
		<a id="image_desc" pid="<?=$image['image_info']->id ?>"><?=($image['image_info']->description == '' ? '点击添加描述' : $image['image_info']->description) ?></a></p>
		<? else: ?>
		<?$image['image_info']->description ?> </p>
		<? endif ?>
		<p><a class="image_attr">社交操作: </a><g:plusone size="medium"></g:plusone></p>
		<p><a class="image_attr">切换图片: </a>
		<div id="photo-scroll">
			<? if($prev): ?>
			<!--上一张图片 -->
			<div class="scroll-photo-preview">
			<a class="change-photo" href="<?=site_url('photo/id/' . $prev->id) ?>" title="<?=$prev->title ?>"><img src="<?=$prev->preview ?>" width="80"></a>
			</div>
			<? endif ?>
			<!--当前图片 -->
			<div class="scroll-photo-preview">
			<a class="cur-photo" title="<?=$image['image_info']->title ?>"><img src="<?=$image['image_info']->preview ?>" width="80"></a>
			</div>
			<? if($next): ?>
			<!--下一张张图片 -->
			<div class="scroll-photo-preview">
			<a class="change-photo" href="<?=site_url('photo/id/' . $next->id) ?>" title="<?=$next->title ?>"><img src="<?=$next->preview ?>" width="80"></a>
			</div>
			<? endif ?>
		</div>
		<p><a class="image_attr">快捷引用：</a>
		<? if(isset($image['small_url'])): ?>
		<a class="exp_link" href="<?=$image['small_url'] ?>" target="_blank">150</a>
		
		<textarea readonly="readonly" class="exp_link_text"><a href="<?=site_url('photo/id/' . $image['image_info']->id) ?>" title="<?=$image['image_info']->title ?>"><img src="<?=$image['small_url'] ?>" alt="<?=$image['image_info']->title ?>"></a></textarea>
		
		<? endif ?>
		<? if(isset($image['medium_url'])): ?>
		<a class="exp_link" href="<?=$image['medium_url'] ?>" target="_blank">300</a>
		
		<textarea readonly="readonly" class="exp_link_text"><a href="<?=site_url('photo/id/' . $image['image_info']->id) ?>" title="<?=$image['image_info']->title ?>"><img src="<?=$image['medium_url'] ?>" alt="<?=$image['image_info']->title ?>"></a></textarea>
		
		<? endif ?>
		<? if(isset($image['big_url'])): ?>
		<a class="exp_link" href="<?=$image['big_url'] ?>" target="_blank">500</a>
		
		<textarea readonly="readonly" class="exp_link_text"><a href="<?=site_url('photo/id/' . $image['image_info']->id) ?>" title="<?=$image['image_info']->title ?>"><img src="<?=$image['big_url'] ?>" alt="<?=$image['image_info']->title ?>"></a></textarea>
		
		<? endif ?>
		<? if(isset($image['original_url'])): ?>
		<a class="exp_link" href="<?=$image['original_url'] ?>" target="_blank">原始</a>
		
		<textarea readonly="readonly" class="exp_link_text"><a href="<?=site_url('photo/id/' . $image['image_info']->id) ?>" title="<?=$image['image_info']->title ?>"><img src="<?=$image['original_url'] ?>" alt="<?=$image['image_info']->title ?>"></a></textarea>
		
		<? endif ?>
		</p>
	</div>
</div>
<div id="photo_nav">
	<? if($prev): ?>
		<?=anchor('photo/id/' . $prev->id, '<<', 'id="prev_photo" title="上一张图片"') ?>
	<? endif ?>
	<? if($next): ?>
		<?=anchor('photo/id/' . $next->id, '>>', 'id="next_photo" title="下一张图片"') ?>
	<? endif ?>
</div>