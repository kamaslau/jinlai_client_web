<style>
	#header, #breadcrumb {display:none;}

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

<script src="/js/jquery.qrcode.min.js"></script>

<base href="<?php echo $this->media_root ?>">

<div id=breadcrumb>
	<ol class="breadcrumb container">
		<li><a href="<?php echo base_url() ?>">首页</a></li>
		<li><a href="<?php echo base_url($this->class_name) ?>"><?php echo $this->class_name_cn ?></a></li>
		<li class=active><?php echo $title ?></li>
	</ol>
</div>

<div id=content class=container>
	<?php if ( empty($item) ): ?>
	<p><?php echo $error ?></p>

	<?php else: ?>
	<div class="jumbotron row">
		<dl id=core-info class=dl-horizontal>
			<dt>商家全称</dt>
			<dd>
				<h2 class=biz-name><?php echo $item['name'] ?></h2>
			</dd>
			<dt>简称</dt>
			<dd><?php echo $item['brief_name'] ?></dd>
			<dt>客服电话</dt>
			<dd><?php echo $item['tel_public'] ?></dd>
		</dl>
	</div>

	<dl id=list-info class=dl-horizontal>
		<dt>LOGO</dt>
		<dd>
			<?php if ( ! empty($item['url_logo']) ): ?>
			<figure class=row>
				<img class="col-xs-12 col-sm-6 col-md-3" src="<?php echo $item['url_logo'] ?>">
			</figure>
			<?php endif ?>
		</dd>

		<dt>宣传语</dt>
		<dd><?php echo empty($item['slogan'])? '未填写': $item['slogan'] ?></dd>
		<dt>简介</dt>
		<dd><?php echo empty($item['description'])? '未填写': $item['description'] ?></dd>
		<dt>店铺公告</dt>
		<dd><?php echo empty($item['notification'])? '未填写': $item['notification'] ?></dd>
		<!--
		<dt>官方网站</dt>
		<dd><?php echo empty($item['url_web'])? '未填写': $item['url_web'] ?></dd>
		<dt>官方微博</dt>
		<dd><?php echo empty($item['url_weibo'])? '未填写': $item['url_weibo'] ?></dd>

		<dt>微信二维码</dt>
		<dd>
			<?php if ( !empty($item['url_wechat']) ): ?>
			<figure id=qrcode class="col-xs-12 col-sm-6 col-md-3"></figure>
			<script>
			$(function(){
				// 创建二维码并转换为图片格式，以使微信能识别该二维码
				$('#qrcode').qrcode("<?php echo $item['url_wechat'] ?>");
				
				// 将canvas转换为Base64格式的图片内容
				function convertCanvasToImage(canvas)
				{
					// 新Image对象，可以理解为DOM 
					var image = new Image();
					// canvas.toDataURL 返回的是一串Base64编码的URL，当然,浏览器自己肯定支持 
					// 指定格式 PNG 
					image.src = canvas.toDataURL("image/png"); 
					return image; 
				} 

				//获取网页中的canvas对象 
				var mycanvas = document.getElementsByTagName('canvas')[0];

				//将转换后的img标签插入到html中 
				var img = convertCanvasToImage(mycanvas); 
				$('#qrcode').append(img);
				$('#qrcode canvas').remove(); // 移除canvas格式的二维码
			})
			</script>
			<?php endif ?>
		</dd>

		<dt>产品</dt>
		<dd>
			<?php if ( !empty($item['url_image_product']) ): ?>
			<ul class=row>
				<?php
					$figure_image_urls = explode(',', $item['url_image_product']);
					foreach($figure_image_urls as $url):
				?>
				<li class="col-xs-6 col-sm-4 col-md-3">
					<img src="<?php echo $url ?>">
				</li>
				<?php endforeach ?>
			</ul>

			<?php else: ?>
			未上传
			<?php endif ?>
		</dd>

		<dt>工厂/产地</dt>
		<dd>
			<?php if ( !empty($item['url_image_produce']) ): ?>
			<ul class=row>
				<?php
					$figure_image_urls = explode(',', $item['url_image_produce']);
					foreach($figure_image_urls as $url):
				?>
				<li class="col-xs-6 col-sm-4 col-md-3">
					<img src="<?php echo $url ?>">
				</li>
				<?php endforeach ?>
			</ul>

			<?php else: ?>
			未上传
			<?php endif ?>
		</dd>

		<dt>门店/柜台</dt>
		<dd>
			<?php if ( !empty($item['url_image_retail']) ): ?>
			<ul class=row>
				<?php
					$figure_image_urls = explode(',', $item['url_image_retail']);
					foreach($figure_image_urls as $url):
				?>
				<li class="col-xs-6 col-sm-4 col-md-3">
					<img src="<?php echo $url ?>">
				</li>
				<?php endforeach ?>
			</ul>

			<?php else: ?>
			未上传
			<?php endif ?>
		</dd>
	</dl>

	<h2>资质信息</h2>
	<dl class=dl-horizontal>
		<dt>工商注册号</dt>
		<dd><?php echo $item['code_license'] ?></dd>

		<dt>营业执照</dt>
		<dd>
			<?php if ( ! empty($item['url_image_license']) ): ?>
			<figure class=row>
				<img class="col-xs-12 col-sm-6 col-md-4" src="<?php echo $item['url_image_license'] ?>">
			</figure>
			<?php endif ?>
		</dd>
	</dl>

	<dl class=dl-horizontal>
		<dt>地址</dt>
		<dd>
			<p>
				<?php echo $item['nation'] ?> <?php echo $item['province'] ?>省 <?php echo $item['city'] ?>市 <?php echo $item['county'] ?>区/县<br>
				<?php echo $item['street'] ?>
			</p>
		</dd>
	</dl>
	-->
	
	<?php if ( empty($items) ): ?>
	<blockquote class=row>
		<p>商家正在备货，敬请期待！</p>
	</blockquote>

	<?php else: ?>
	<ul id=item-list class=row>
		<?php foreach ($items as $item): ?>
		<li class="item col-xs-6 col-sm-3 col-md-4">
			<a href="<?php echo base_url('item/detail?id='.$item['item_id']) ?>">

				<figure class=image-main class="col-xs-12 col-sm-6 col-md-4">
					<img title="<?php echo $item['name'] ?>" src="<?php echo MEDIA_URL. 'item/'.$item['url_image_main'] ?>">
				</figure>

				<h2 class=item-name><?php echo $item['name'] ?></h2>

				<div class=digits>
					<span>￥</span><strong><?php echo substr($item['price'], 0, -3).'<small>'.substr($item['price'], -3).'</small>' ?></strong>
					<?php echo ($item['tag_price'] !== '0.00')? '<del>￥'. $item['tag_price']. '</del>': NULL ?>
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
					<a class=fav-add-item data-item-id="<?php echo $item['item_id'] ?>" title="收藏" href="<?php echo base_url('fav_item/create?item_id='.$item['item_id']) ?>" target=_blank>
						<i class="fa fa-star-o" aria-hidden="true"></i>收藏
					</a>
				</li>
			</ul>
		</li>
		<?php endforeach ?>
	</ul>

	<?php endif ?>
	
	<nav id=nav-main>
		<ul class=row>
			<li class="col-xs-2">
				<a title="客服" href="<?php echo base_url('dialog/detail?biz_id='.$item['biz_id']) ?>">
					<i class="fa fa-comments" aria-hidden="true"></i>客服
				</a>
			</li>
			<!--<li class="col-xs-2"><a title="发现" href="<?php echo base_url('biz/detail?id='.$item['biz_id']) ?>">店铺</a></li>-->
			<li class="col-xs-2">
				<a class=fav-add-biz data-biz-id="<?php echo $item['biz_id'] ?>" title="关注" href="<?php echo base_url('fav_biz/create?biz_id='.$item['biz_id']) ?>">
					<i class="fa fa-heart-o" aria-hidden="true"></i>关注
				</a>
			</li>
			<!--
			<li class="col-xs-3"><a title="加入购物车" href="<?php echo base_url('cart/create?item_id='.$item['item_id']) ?>">加入购物车</a></li>
			<li class="col-xs-3"><a title="立即购买" href="<?php echo base_url('order?item_id='.$item['item_id']) ?>">立即购买</a></li>
			-->
		</ul>
	</nav>
	
	<?php endif ?>
</div>