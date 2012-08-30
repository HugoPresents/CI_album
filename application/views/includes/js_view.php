<? if(isset($js)): ?>
	<? if(is_array($js)): ?>
		<? foreach($js as $value): ?>
			<script type="text/javascript" src="<?=site_url('source/js/' . $value) ?>"></script>
		<? endforeach; ?>
	<? endif; ?>
	<script type="text/javascript" src="<?=site_url('source/js/' . $js) ?>"></script>
<? endif; ?>
</head>
<body>