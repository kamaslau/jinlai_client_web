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
	<?php if ( isset($content) ) echo '<div class="alert alert-warning" role=alert>'.$content.'</div>'; ?>
	
	<?php if ( empty($items) ): ?>
	<blockquote>
		<p>您未收藏任何商品</p>
	</blockquote>

	<?php else: ?>
	<ul id=item-list class=row>

		<?php foreach ($items as $item): ?>
		<li class="item col-xs-6 col-sm-4 col-md-3" data-item-id="<?php echo $item[$this->id_name] ?>">
			<?php if ( strpos(DEVELOPER_MOBILES, ','.$this->session->mobile.',') !== FALSE ): ?>
			<span>ID <?php echo $item['record_id'] ?></span>
			<?php endif ?>

			<a title="<?php echo $item['name'] ?>" href="<?php echo base_url('item/detail?id='.$item['item_id']) ?>">
				<figure class=image-main class="col-xs-12 col-sm-6 col-md-4">
					<img title="<?php echo $item['name'] ?>" src="<?php echo $item['url_image_main'] ?>">
				</figure>

				<h2 class=item-name>
					<?php echo $item['name'] ?>
				</h2>

				<div class=digits>
					<span>￥</span><strong><?php echo substr($item['price'], 0, -3).'<small>'.substr($item['price'], -3).'</small>' ?></strong>
					<?php echo ($item['tag_price'] !== '0.00')? ' <del>￥'. $item['tag_price']. '</del>': NULL ?>
				</div>

				<?php if ( !empty($skus) ): ?>
				<section class=skus>

					<ul class=row>
						<?php foreach ($skus as $sku): ?>
						<li class="col-xs-6 col-sm-4 col-md-3">
							<?php if ( !empty($sku['url_image']) ): ?>
							<figure>
								<img src="<?php echo $sku['url_image'] ?>">
							</figure>
							<?php endif ?>
						</li>
						<?php endforeach ?>
					</ul>

				</section>
				<?php endif ?>
			</a>

			<ul class=row>
				<li class="col-xs-6">
					<a class=delete data-op-class=<?php echo $this->class_name ?> data-op-name=delete data-id="<?php echo $item[$this->id_name] ?>"  title="删除" href="<?php echo base_url($this->class_name.'/delete?ids='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-trash"></i> 删除</a>
				</li>
			</ul>
			
		</li>
		<?php endforeach ?>

	</ul>
	<?php endif ?>
</div>