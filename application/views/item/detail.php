<style>
	#header, #breadcrumb {display:none;}
	
	#content {width:100%;}
	
	#item-figure {padding:0;}

	#item-name {color:#000;font-size:16px;font-weight:700;line-height:1;padding-bottom:.2em;}

	/* SKU */
	#skus li {line-height:28px;padding:1px;margin-bottom:4px;margin-right:4px;}
		#skus a {height:38px;line-height:38px;border:1px solid #b8b7bd;text-align:center;overflow:hidden;}
			#skus a>* {float:left;display:inline;}
			#skus figure {width:28px;height:28px;}
			#skus h3 {font-size:12px;max-width:97px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-indent: 0;padding-left:1px;}

	#description p, #description img {line-height:1;}

	/* 宽度在750像素以上的设备 */
	@media only screen and (min-width:751px)
	{
		#header, #breadcrumb {display:block;}
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
		<li><a href="<?php echo base_url('item?category_id='.$item['category_id']) ?>"><?php echo $category['name'] ?></a></li>
		<li class=active><?php echo $title ?></li>
	</ol>
</div>

<div id=content class=container>
	<div id=item-figure class="col-xs-12 col-sm-6 swiper-container">
		<?php
			// 判断是否有形象图，若有，则将形象图与主图拼装为轮播内容进行显示
			if ( empty($item['figure_image_urls']) ):
		?>
		<div class=row>
			<figure id=image_main class="col-xs-12 col-sm-6 col-md-4">
				<img title="<?php echo $item['name'] ?>" src="<?php echo $item['url_image_main'] ?>">
			</figure>
		</div>

		<?php else: ?>
		<ul id=figure-images class="swiper-wrapper">
			<li class="swiper-slide">
				<img alt="<?php echo $item['name'] ?>" src="<?php echo $item['url_image_main'] ?>">
			</li>

			<?php
				$figure_image_urls = explode(',', $item['figure_image_urls']);
				foreach($figure_image_urls as $url):
			?>
			<li class="swiper-slide">
				<img alt="<?php echo $item['name'] ?>" src="<?php echo $url ?>">
			</li>
			<?php endforeach ?>
		</ul>
		<!-- 页码提示 -->
	    <div class="swiper-pagination"></div>
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.2/css/swiper.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.2/js/swiper.jquery.min.js"></script>
		<script>
			var swiper = new Swiper('.swiper-container',{
	            pagination: '.swiper-pagination'
	        });
	    </script>
		<?php endif ?>
	</div>

	<!--
	<div id=item-figure classs="col-xs-12 col-sm-6">
		<div class=row>
			<figure id=image_main class="col-xs-12 col-sm-6 col-md-4">
				<img title="<?php echo $item['name'] ?>" src="<?php echo $item['url_image_main'] ?>">
			</figure>
		</div>

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
	</div>
	-->

	<div id=item-bried class="col-xs-12 col-sm-6">
		<h2 id=item-name><?php echo $item['name'] ?></h2>
		<ul class=row>
			<?php echo !empty($item['slogan'])? '<li class=slogan>'.$item['slogan'].'</li>': NULL ?>
			
			<li id=prices>
				<strong>￥ <?php echo substr($item['price'], 0, -3).'<small>'.substr($item['price'], -3).'</small>' ?></strong>
				<?php echo ($item['tag_price'] !== '0.00')? ' <del>￥'. $item['tag_price']. '</del>': NULL ?>
			</li>

			<?php $unit_name = !empty($item['unit_name'])? $item['unit_name']: '份' ?>
			<li id=stocks>
				库存 <?php echo $item['stocks']. $unit_name ?>
				<?php echo $item['quantity_min'] > 1? ' '.$item['quantity_min'].$unit_name. '起售': NULL; ?>
				<?php echo $item['quantity_max'] > 0? ' 限购 '.$item['quantity_max'].$unit_name: NULL ?>
			</li>
		</ul>
	</div>

	<dl id=list-info class=dl-horizontal>
		<?php if ( isset($brand) ): ?>
		<dt>品牌</dt>
		<dd><?php echo !empty($item['brand_id'])? $brand['name']: '未设置'; ?></dd>
		<?php endif ?>

		<?php if ( !empty($item['code_biz']) ): ?>
		<dt>货号</dt>
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

		<ul class="horizontal">
			<?php foreach ($skus as $sku): ?>
			<li>
				<a data-item-id="<?php echo $item['item_id'] ?>" data-sku-id="<?php echo $sku['sku_id'] ?>" data-stocks="<?php echo $sku['stocks'] ?>" href="<?php echo base_url('sku/detail?id='.$sku['sku_id']) ?>">
					<?php if ( !empty($sku['url_image']) ): ?>
					<figure>
						<img src="<?php echo MEDIA_URL.'/sku/'.$sku['url_image'] ?>">
					</figure>
					<?php endif ?>
					<h3><?php echo $sku['name_first'].$sku['name_second'].$sku['name_third'] ?></h3>
				</a>
			</li>
			<?php endforeach ?>
		</ul>

	</section>
	<?php endif ?>

	<section id=biz-info class=row>
		<a title="<?php echo $biz['name'] ?>" href="<?php echo base_url('biz/detail?id='.$item['biz_id']) ?>">
			<?php echo $biz['name'] ?>
		</a>
	</section>

	<section id=description class=row>
		<h2>商品描述</h2>
		<?php if ( !empty($item['description']) ): ?>
		<div id=description-content>
			<h3>商家内容</h3>
			<?php //echo $item['description'] ?>
		</div>
		<?php endif ?>

		<div id=common-content>
			<h3>平台统一内容</h3>
		</div>
	</section>
</div>

<nav id=nav-main>
	<ul class=row>
		<?php // TODO 显示客服按钮前检查当前店铺客服工作状态，决定留言或即时通讯 ?>
		<li class="col-xs-2">
			<a title="客服" href="<?php echo base_url('dialog/detail?biz_id='.$item['biz_id']) ?>">
				<i class="fa fa-comments" aria-hidden="true"></i>
				客服
			</a>
		</li>

		<?php // TODO 显示店铺按钮前检查商家经营状态 ?>
		<li class="col-xs-2">
			<a title="店铺" href="<?php echo base_url('biz/detail?id='.$item['biz_id']) ?>">
				<i class="fa fa-home" aria-hidden="true"></i>
				店铺
			</a>
		</li>

		<?php // TODO 显示收藏、加入购物车、立即购买按钮前检查是否可售性（是否在售、库存是否足够、每单最高限量等） ?>
		<li class="col-xs-2">
			<a class=fav-add-item data-item-id="<?php echo $item['item_id'] ?>" title="收藏" href="<?php echo base_url('fav_item/create?item_id='.$item['item_id']) ?>">
				<i class="fa fa-star-o" aria-hidden="true"></i>
				收藏
			</a>
		</li>

		<?php
			// TODO 根据每单最高及最低限量做相关处理
			if ( !empty($in_cart) ):
				//var_dump($in_cart);
			endif;
		?>
		<li class="col-xs-3">
			<a id=cart-add class="btn btn-info btn-lg btn-block" title="加入购物车" href="<?php echo base_url('cart/add?biz_id='.$item['biz_id'].'&item_id='.$item['item_id']) ?>">
				加入<wbr>购物车
			</a>
		</li>

		<li class="col-xs-3">
			<a id=order-create class="btn btn-primary btn-lg btn-block" title="立即购买" href="<?php echo base_url('order/create?item_id='.$item['item_id']) ?>">
				立即购买
			</a>
		</li>
	</ul>
</nav>

<script>
	// 点击SKU时获取SKU信息
	$('#skus a').click(function(){
		item_id = $(this).attr('data-item-id');
		sku_id = $(this).attr('data-sku-id');
		stocks = $(this).attr('data-stocks');
		
		if (stocks == 0)
		{
			alert('卖光了');
		}
		else
		{
			alert(item_id + ':' + sku_id + '库存 ' + stocks);
		}

		return false;
	});
	
	// 商品信息
	var item = <?php echo $item_in_json ?>
</script>