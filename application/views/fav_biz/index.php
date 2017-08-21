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
		<li class=active><?php echo $this->class_name_cn ?></li>
	</ol>
</div>

<div id=content class=container>
	<?php if ( empty($items) ): ?>
	<blockquote>
		<p>您未关注任何商家</p>
	</blockquote>

	<?php else: ?>

	<?php if ( isset($content) ) echo '<div class="alert alert-warning" role=alert>'.$content.'</div>'; ?>
	<ul id=item-list class=row>

		<?php foreach ($items as $item): ?>
		<li class="col-xs-6 col-sm-4 col-md-6" data-item-id="<?php echo $item['record_id'] ?>">
			<ul class=row>
				<?php if ( strpos(DEVELOPER_MOBILES, ','.$this->session->mobile.',') !== FALSE ): ?>
				<li class=col-xs-12>ID <?php echo $item['record_id'] ?></li>
				<?php endif ?>

				<li class=col-xs-12>
					<ul class="row">
						<li class="col-xs-3"><a class=delete data-op-class=<?php echo $this->class_name ?> data-op-name=delete data-id="<?php echo $item[$this->id_name] ?>" title="删除" href="<?php echo base_url($this->class_name.'/delete?ids='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-fw fa-trash"></i> 删除</a></li>
					</ul>
				</li>
			</ul>
		</li>
		<?php endforeach ?>

	</ul>
	<?php endif ?>
</div>