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

<base href="<?php echo base_url('uploads/') ?>">

<div id=breadcrumb>
	<ol class="breadcrumb container">
		<li><a href="<?php echo base_url() ?>">首页</a></li>
		<li><a href="<?php echo base_url($this->class_name) ?>"><?php echo $this->class_name_cn ?></a></li>
		<li class=active><?php echo $title ?></li>
	</ol>
</div>

<div id=content class=container>
	<div id=item-figure classs="col-xs-12 col-sm-6">
		<div class=row>
			<figure id=image_main class="col-xs-12 col-sm-6 col-md-4">
				<img title="<?php echo $item['name'] ?>" src="<?php echo $item['url_image_main'] ?>">
			</figure>
		</div>

		<?php if ( !empty($item['figure_image_urls']) ): ?>
		<ul id=figure-images class=row>
			<?php
				$figure_image_urls = explode(',', $item['figure_image_urls']);
				foreach($figure_image_urls as $url):
			?>
			<li class="col-xs-3">
				<img src="<?php echo $url ?>">
			</li>
			<?php endforeach ?>
		</ul>
		<?php endif ?>
		
		<!--
		<?php if ( !empty($item['figure_video_urls']) ): ?>
		<ul id=figure-videos class=row>
			<?php
				$figure_video_urls = explode(',', $item['figure_video_urls']);
				foreach($figure_video_urls as $url):
			?>
			<li class="col-xs-6 col-sm-4 col-md-3">
				<video src="<?php echo $url ?>" controls="controls">您的浏览器不支持视频播放</video>
			</li>
			<?php endforeach ?>
		</ul>
		<?php endif ?>
		-->
	</div>
	
	<div id=item-bried class="col-xs-12 col-sm-6">
		<h2 id=item-name><?php echo $item['name'] ?></h2>
		<ul class=row>
			<?php echo !empty($item['slogan'])? '<li>'.$item['slogan'].'</li>': NULL ?>

			<?php $unit_name = !empty($item['unit_name'])? $item['unit_name']: '份' ?>
			<li id=stocks>
				库存 <?php echo $item['stocks'].' '. $unit_name ?>
				<?php echo $item['quantity_min'] > 1? ' '.$item['quantity_min'].$unit_name. '起售': NULL; ?>
				<?php echo !empty($item['quantity_max'])? ' 限购 '.$item['quantity_max'].$unit_name: NULL ?>
			</li>

			<li id=prices>
				<strong>￥ <?php echo $item['price'] ?></strong>
				<?php echo ($item['tag_price'] !== '0.00')? ' <del>￥'. $item['tag_price']. '</del>': NULL ?>
			</li>
		</ul>
	</div>

	<dl id=list-info class=dl-horizontal>
		<dt>商品ID</dt>
		<dd><?php echo $item['item_id'] ?></dd>
		<dt>系统分类</dt>
		<dd><?php echo $category['name'] ?></dd>

		<dt>品牌</dt>
		<dd><?php echo !empty($item['brand_id'])? $brand['name']: '未设置'; ?></dd>

		<?php if ( !empty($item['code_biz']) ): ?>
		<dt>商家自定义货号</dt>
		<dd><?php echo $item['code_biz'] ?></dd>
		<?php endif ?>

		<dt>是否可用优惠券</dt>
		<dd><?php echo ($item['coupon_allowed'] === '1')? '是': '否'; ?></dd>
		<dt>积分抵扣率</dt>
		<dd><?php echo $item['discount_credit'] * 100 ?>%</dd>

		<?php if ( ! empty($item['time_suspend']) ): ?>
		<dt>预定上架时间</dt>
		<dd><?php echo !empty($item['time_to_publish'])? date('Y-m-d H:i:s', $item['time_to_publish']). '开售': NULL ?></dd>
		<?php endif ?>

		<?php if ( ! empty($item['time_publish']) ): ?>
		<dt>预定下架时间</dt>
		<dd><?php echo empty($item['time_to_suspend'])? '未设置': date('Y-m-d H:i:s', $item['time_to_suspend']); ?></dd>
		<?php endif ?>

		<dt>运费</dt>
		<dd>
			<?php
				// 预算运费
				if ( empty($item['freight_template_id']) ):
			?>
			包邮
			<?php
				else:
					echo $freight_template['name'];
				endif;
			?>

			<p class=help-block>以下3项择一填写即可；若填写多项，将按毛重、净重、体积重的顺序取首个有效值计算运费。</p>
			<ul class="list-horizontal row">
				<li class="col-xs-12 col-sm-4">毛重 <?php echo ($item['weight_gross'] !== '0.00')? $item['weight_gross']: '-'; ?> KG</li>
				<li class="col-xs-12 col-sm-4">净重 <?php echo ($item['weight_net'] !== '0.00')? $item['weight_net']: '-'; ?> KG</li>
				<li class="col-xs-12 col-sm-4">体积重 <?php echo ($item['weight_volume'] !== '0.00')? $item['weight_volume']: '-'; ?> KG</li>
			</ul>
		</dd>

		<dt>店内活动</dt>
		<dd>
			<?php if ( ! empty($item['promotion_id']) ): ?>
			<strong><?php echo $promotion['name'] ?></strong>
			<?php endif ?>
		</dd>
	</dl>

	<?php if ( !empty($skus) ): ?>
	<section id=skus>
		
		<ul class=row>
			<?php foreach ($skus as $sku): ?>
			<li class="col-xs-6 col-sm-4 col-md-3">
				<a href="<?php echo base_url('sku/detail?id='.$sku['sku_id']) ?>">
					<h3><?php echo $sku['name_first'].$sku['name_second'].$sku['name_third'] ?></h3>
					<small>￥<?php echo $sku['price'] ?> / 库存<?php echo $sku['stocks'] ?></small>
					<?php if ( !empty($sku['url_image']) ): ?>
					<figure>
						<img src="<?php echo $sku['url_image'] ?>">
					</figure>
					<?php endif ?>
				</a>
			</li>
			<?php endforeach ?>
		</ul>

	</section>
	<?php endif ?>

	<section id=description class=row>
		<h2>商品描述</h2>
		<?php if ( !empty($item['description']) ): ?>
		<div id=description-content>
			<h3>商家内容</h3>
			<?php echo $item['description'] ?>
		</div>
		<?php endif ?>
		
		<div id=common-content>
			<h3>平台统一内容</h3>
		</div>
	</section>
</div>

<nav id=nav-main>
	<ul class=row>
		<li class="col-xs-2"><a title="客服" href="<?php echo base_url('dialog/detail?biz_id='.$item['biz_id']) ?>">客服</a></li>
		<li class="col-xs-2"><a title="发现" href="<?php echo base_url('biz/detail?id='.$item['biz_id']) ?>">店铺</a></li>
		<li class="col-xs-2"><a title="收藏" href="<?php echo base_url('fav_item/create?item_id='.$item['item_id']) ?>">收藏</a></li>
		<li class="col-xs-3"><a title="加入购物车" href="<?php echo base_url('cart/create?item_id='.$item['item_id']) ?>">加入购物车</a></li>
		<li class="col-xs-3"><a title="立即购买" href="<?php echo base_url('order?item_id='.$item['item_id']) ?>">立即购买</a></li>
	</ul>
</nav>