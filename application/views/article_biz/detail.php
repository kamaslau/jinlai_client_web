<base href="<?php echo $this->media_root ?>">


<?php if ( !empty($item['excerpt']) ): ?>
<div class="wid670 auto mt20 abstracts">
	<p><?php echo $item['excerpt'] ?></p>
</div>
<?php endif ?>

<!--内容区域-->
<div class="articletext wid710 auto">
	<h1><?php echo $item['title'] ?></h1>
	<time><?php echo $item['time_create'] ?></time>

    <?php echo $item['content'] ?>
</div>
<script>
	$(".articletext p img").attr({
		'width':'auto',
		'height' : 'auto'
	});
</script>