<style>
	#content {width:100%;}
		#content>* {color:#898989;background-color:#fff;}
		#content>section {padding:30px 20px;border-radius:20px;margin:20px;}

	#item-figure {border-radius:0 0 20px 20px;}

	#item-name {color:#3e3a39;font-size:30px;line-height:1;margin-bottom:10px;}
	#slogan {color:#9fa0a0;font-size:24px;margin-bottom:30px;}

	#service-promise li {background:url('/media/item/detail/quan@3x.png') no-repeat left center;background-size:24px 24px;padding-left:34px;}

	#prices {font-size:24px;}
		#prices strong {color:#ff3649;font-size:44px;font-weight:600;}
		#prices small {font-size:32px;}

	/* SKU */
	#skus li {line-height:28px;padding:1px;margin-bottom:4px;margin-right:4px;}
		#skus a {height:38px;line-height:38px;border:1px solid #b8b7bd;text-align:center;overflow:hidden;}
			#skus a>* {float:left;display:inline;}
			#skus figure {width:28px;height:28px;}
			#skus h3 {font-size:12px;max-width:97px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-indent: 0;padding-left:1px;}

	#general-seperater {font-size:24px;background-color:transparent;text-align:center;margin:50px 0;}

	#description p, #description img {line-height:1;}
</style>

<script>
wx.ready(function(){
	// 分享到朋友圈
	wx.onMenuShareTimeline({
	    title: '<?php echo $title.'【'.SITE_NAME.'】' ?>', // 分享标题
	    link: '<?php echo base_url('item/detail?id='.$item['item_id']) ?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
	    imgUrl: '<?php echo $this->media_root.$item['url_image_main'] ?>', // 分享图标
	    success: function () {
	        // 用户确认分享后执行的回调函数
			alert('分享成功');
	    },
	    cancel: function () {
	        // 用户取消分享后执行的回调函数
			alert('未完成分享');
	    }
	});

	// 分享给朋友
	wx.onMenuShareAppMessage({
	    desc: '<?php echo $description ?>', // 分享描述
	    title: '<?php echo $title.'【'.SITE_NAME.'】' ?>', // 分享标题
	    link: '<?php echo base_url('item/detail?id='.$item['item_id']) ?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
	    imgUrl: '<?php echo $this->media_root.$item['url_image_main'] ?>', // 分享图标
	    type: 'link', // 分享类型,music、video或link，不填默认为link
	    success: function () {
	        // 用户确认分享后执行的回调函数
			alert('分享成功');
	    },
	    cancel: function () {
	        // 用户取消分享后执行的回调函数
			alert('您未完成分享');
	    }
	});
});
</script>

<base href="<?php echo $this->media_root ?>">

<div id=breadcrumb>
	<ol class="breadcrumb container">
		<li><a href="<?php echo base_url() ?>">首页</a></li>
		<li><a href="<?php echo base_url('item?category_id='.$item['category_id']) ?>"><?php echo $category['name'] ?></a></li>
		<li class=active><?php echo $title ?></li>
	</ol>
</div>

<div id=content class=container>
	<div id=item-figure class="swiper-container row">
		<?php
			// 判断是否有形象图，若有，则将形象图与主图拼装为轮播内容进行显示
			if ( empty($item['figure_image_urls']) ):
		?>
		<figure id=image_main>
			<img title="<?php echo $item['name'] ?>" src="<?php echo $item['url_image_main'] ?>">
		</figure>

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
		
		<link rel="stylesheet" href="<?php echo CDN_URL ?>css/swiper.min.css">
		<script src="<?php echo CDN_URL ?>js/swiper.jquery.min.js"></script>
		<script>
			var swiper = new Swiper('.swiper-container',{
	            pagination: '.swiper-pagination'
	        });
	    </script>
		<?php endif ?>
	</div>

	<section id=item-brief>
		<h2 id=item-name><?php echo $item['name'] ?></h2>

		<?php echo !empty($item['slogan'])? '<h3 id=slogan>'.$item['slogan'].'</h3>': NULL ?>

		<ul class=row>
			<li id=prices>
				<strong>
					<small>￥</small><?php echo substr($item['price'], 0, -3).'<small>'.substr($item['price'], -3).'</small>' ?>
				</strong>
				<?php echo ($item['tag_price'] !== '0.00')? ' <del>￥'. $item['tag_price']. '</del>': NULL ?>
			</li>

			<?php $unit_name = !empty($item['unit_name'])? $item['unit_name']: '份' ?>
			<li id=stocks>
				库存 <?php echo $item['stocks']. $unit_name ?>
				<?php echo $item['quantity_min'] > 1? ' '.$item['quantity_min'].$unit_name. '起售': NULL; ?>
				<?php echo $item['quantity_max'] > 0? ' 限购 '.$item['quantity_max'].$unit_name: NULL ?>
			</li>
		</ul>
	</section>
	
	<section id=service-promise>
		<ul class=row>
			<li class=col-xs-4>上门处理投诉</li>
			<li class=col-xs-4>满58元包邮</li>
			<li class=col-xs-4>3小时送达</li>
		</ul>
	</section>

	<?php if ( !empty($skus) ): ?>
	<section id=skus>
		<ul class=horizontal>
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

	<p id=general-seperater>继续拖动，查看图文详情</p>

	<div id=description class=row>
		<?php if ( !empty($item['description']) ): ?>
		<div id=description-content>
			<?php echo $item['description'] ?>
		</div>
		<?php endif ?>

		<div id=common-content>
			<h3>平台统一内容</h3>
		</div>
	</div>
</div>

<style>
	#nav-main {padding:14px 20px 14px 40px;border-top:1px solid #ddd;border-radius:20px 20px 0 0;}
		#nav-main .btn {width:194px;height:64px;line-height:64px;margin-top:3px;border-radius:10px;}
		#nav-main li.vice-button {margin-right:54px;}
			#nav-main li.vice-button a {font-size:24px;line-height:1;text-align:center;}
		#nav-main li:nth-of-type(3) {margin-right:40px;}
		#nav-main li:last-of-type {margin-left:10px;}
		#nav-main img {width:36px;height:36px;margin:0 auto 10px;}
</style>

<nav id=nav-main>
	<ul>
		<?php // TODO 显示客服按钮前检查当前店铺客服工作状态，决定留言或即时通讯 ?>
		<li class=vice-button>
			<a title="客服" href="<?php echo base_url('dialog/detail?biz_id='.$item['biz_id']) ?>">
				<img src="<?php echo base_url('/media/item/detail/kafu_icon@3x.png') ?>">
				客服
			</a>
		</li>

		<?php // TODO 显示店铺按钮前检查商家经营状态 ?>
		<li class=vice-button>
			<a title="店铺" href="<?php echo base_url('biz/detail?id='.$item['biz_id']) ?>">
				<img src="<?php echo base_url('/media/item/detail/dianpu_icon@3x.png') ?>">
				店铺
			</a>
		</li>

		<?php // TODO 显示收藏、加入购物车、立即购买按钮前检查是否可售性（是否在售、库存是否足够、每单最高限量等） ?>
		<li class=vice-button>
			<a class=create data-op-class=fav_item data-op-name=create data-id="<?php echo $item['item_id'] ?>" title="收藏" href="<?php echo base_url('fav_item/create?id='.$item['item_id']) ?>">
				<img data-src-success="<?php echo base_url('/media/item/detail/shoucang-_xuanzhong@3x.png') ?>" src="<?php echo base_url('/media/item/detail/shoucang-@3x.png') ?>">
				收藏
			</a>
		</li>

		<?php
			// TODO 根据每单最高及最低限量做相关处理
			if ( !empty($in_cart) ):
				//var_dump($in_cart);
			endif;
		?>
		<li>
			<a id=cart-add class="btn btn-info btn-lg btn-block" title="加入购物车" href="<?php echo base_url('cart/add?biz_id='.$item['biz_id'].'&item_id='.$item['item_id']) ?>">
				加入<wbr>购物车
			</a>
		</li>

		<li>
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