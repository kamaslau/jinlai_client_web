<style>
	#item-list>li {border-bottom:1px solid #aaa;margin-bottom:2rem;}

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
		<li class=active><?php echo $this->class_name_cn ?></li>
	</ol>
</div>

<div id=content class=container>

	<?php if ( empty($items) ): ?>
	<blockquote>
		<p>没有符合条件的数据</p>
	</blockquote>

	<?php else: ?>
	<ul id=item-list class=row>

		<?php foreach ($items as $item): ?>
		<li class=col-xs-12>

			<ul class=row>
			<?php if ( strpos(DEVELOPER_MOBILES, ','.$this->session->mobile.',') !== FALSE ): ?>
			<li class=col-xs-12>ID <?php echo $item[$this->id_name] ?></li>
			<?php endif ?>

			<?php
				$tr = array_keys($data_to_display);
				foreach ($tr as $td):
					echo '<li>' .$item[$td]. '</li>';
				endforeach;
			?>

		</li>
		<?php endforeach ?>

	</ul>
	<?php endif ?>
</div>