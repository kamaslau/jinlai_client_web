<style>


	/* 宽度在750像素以上的设备 */
	@media only screen and (min-width:751px)
	{
		
	}
	
	/* 宽度在960像素以上的设备 */
	@media only screen and (min-width:961px)
	{

	}

	/* 宽度在1280像素以上的设备 */
	@media only screen and (min-width:1281px)
	{

	}
</style>

<base href="<?php echo $this->media_root ?>">

<div id=breadcrumb>
	<ol class="breadcrumb container">
		<li><a href="<?php echo base_url() ?>">首页</a></li>
		<li><a href="<?php echo base_url($this->class_name) ?>"><?php echo $this->class_name_cn ?></a></li>
		<li class=active><?php echo $title ?></li>
	</ol>
</div>

<div id=content class=container>

	<?php
		if ( !empty($error) ):
			echo '<div class="alert alert-warning" role=alert>'.$error.'</div>';

		else:
	?>
	
	<header>
		<h2><?php echo $item['title'] ?></h2>
		<ul class="list-horizontal row">
			<li class="col-xs-12 col-sm-6 col-md-3"><?php echo $item['time_edit'] ?></li>
		</ul>
		<div class="excerpt well"><?php echo $item['excerpt'] ?></div>
	</header>

	<section id=article-content><?php echo $item['content'] ?></section>

	<dl id=list-info class=dl-horizontal>
		<!--
		<dt>分类</dt>
		<dd><?php echo $item['category_id'] ?></dd>
		-->
		<?php if ( !empty($item['url_images']) ): ?>
		<dt>形象图</dt>
		<dd>
			<ul class=row>
				<?php
					$figure_image_urls = explode(',', $item['url_images']);
					foreach($figure_image_urls as $url):
				?>
				<li class="col-xs-6 col-sm-4 col-md-3">
					<img src="<?php echo $url ?>">
				</li>
				<?php endforeach ?>
			</ul>
		</dd>
		<?php endif ?>
	</dl>

	<?php endif ?>
</div>