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
	<div class=btn-group role=group>
		<a class="btn btn-primary" title="所有<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>"><i class="fa fa-list fa-fw" aria-hidden=true></i> 所有<?php echo $this->class_name_cn ?></a>
	</div>

	<?php if ( empty($items) ): ?>
	<blockquote>
		<p>一大波商家正在排队入驻中……</p>
	</blockquote>

	<?php else: ?>

	<ul id=item-list class=row>
		<?php foreach ($items as $item): ?>
		<li class="item col-xs-12">
			<a title="<?php echo $item['name'] ?>" href="<?php echo base_url($this->class_name. '/detail?id='.$item[$this->id_name]) ?>">
				<figure class="image-main col-xs-12 col-sm-6 col-md-3">
					<img title="<?php echo $item['name'] ?>" src="<?php echo $item['url_logo'] ?>">
					<figcaption>
						<ul class=row>
							<li class="col-xs-6"><a title="收藏" href="<?php echo base_url('fav_biz/create?biz_id='.$item['biz_id']) ?>" target=_blank><i class="fa fa-heart-o"></i> 收藏</a></li>
						</ul>
					</figcaption>
				</figure>

				<section class="col-xs-12 col-sm-6 col-md-3">
					<h2 class=biz-name><?php echo $item['name'] ?></h2>
				</section>
			</a>
		</li>
		<?php endforeach ?>
	</ul>

	<?php endif ?>
</div>