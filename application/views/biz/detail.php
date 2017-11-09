<base href="<?php echo $this->media_root ?>">

	<!--店铺首页商家信息开始-->
	<?php
	// 检查当前设备信息
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$is_wechat = strpos($user_agent, 'MicroMessenger')? TRUE: FALSE;
	$is_ios = ($this->input->get('device_platform') === 'ios' || strpos($user_agent, 'iPhone') || strpos($user_agent, 'iPad'))? TRUE: FALSE;
	$is_android = strpos($user_agent, 'Android')? TRUE: FALSE;
	if (($is_ios === FALSE && $is_android === FALSE) || $is_wechat === TRUE):
?>
		<div class="shopinfo wid710 auto clearfix">
			<div class="shoppic fl">
				<img src="<?php echo CDN_URL ?>media/home/banner@3x.png">
			</div>
			<!--商家名字等信息-->
			<div class="shopname fl">
				<span class="fl"><?php echo $item['brief_name'] ?></span>
				<a href="#" class="fl">入驻商家</a>
			</div>
			<div class="gnwrap fr">
				<a href="#" class="pay">充值</a>
				<a href="#" class="focus">+关注</a>
			</div>
		</div>
		<!--tab切换区域开始-->
		<div class="shopIndextabtitle wid710 auto">
			<ul class="clearfix">
				<li class="current">
					首页
				</li>
				<li>
					<span>商品</span>
					<span>(99)</span>
				</li>
				<li>
					最新上架
				</li>
				<li style="border-right:0">
					活动商品
				</li>
			</ul>
			
		</div>
			<!--底部导航区域-->
				<div class="fiex footerbar clearfix">
					<div class="textbar fl">
						<ul>
							<li>
								<span>宝贝分类</span>
								<p class="line"></p>
							</li>
							<li>
								<span>宝贝分类</span>
								<p class="line"></p>
							</li>
							<li>
								<span>宝贝分类</span>
								<p class="line"></p>
							</li>
						</ul>
					</div>
					<div class="wechat">
						<i></i>
						<span>客服</span>
					</div>
					
				</div>
		<?php endif ?>
		
	<!--头部banner区域开始-->
		<div class="bannerWrap auto">
			<div class="swiper-container">
	        <div class="swiper-wrapper">
	            <div class="swiper-slide">
	            	<img src="<?php echo CDN_URL ?>media/slider1-2.png" />
	            </div>
	            <div class="swiper-slide">
	            	<img src="<?php echo CDN_URL ?>media/slider1-1.png" />
	            </div>
	            <div class="swiper-slide">
	            	<img src="<?php echo CDN_URL ?>media/slider1-2.png" />
	            </div>
	            <div class="swiper-slide">
	            	<img src="<?php echo CDN_URL ?>media/slider1-1.png" />
	            </div>
	        </div>
	        <!-- Add Pagination -->
	        <div class="swiper-pagination"></div>
	    </div>
	</div>
	<!--商品分类-->
	<div class="threecol clearfix none">
	<ul>
		<li>
			<a href="https://www.517ybang.com/item/detail?id=3" target="_self">
			<div class="pic shopIndexpic">
				<img src="<?php echo CDN_URL ?>media/home/jianhuo_putao@3x.png">
			</div>
			</a>
		</li>
		<li>
			<div class="pic shopIndexpic">
				<img src="<?php echo CDN_URL ?>media/home/jianhuo_putao@3x.png">
			</div>
		</li>
		<li style="margin-right:0">
			<div class="pic shopIndexpic">
				<img src="<?php echo CDN_URL ?>media/home/banner1@3x.png">
			</div>
		</li>
	</ul>
</div>
	<!--卡片式导航分类区域-->
	<div class="shopIndexcard clearfix auto mt10 wid710">
		<div class="pictitle wid710 border20">
			<img src="<?php echo CDN_URL ?>media/home/linebar.png" />
		</div>
		<div class="pic mt10">
			<a href="<?php echo base_url('item/detail?id='.$item['m1ace_id']) ?>">
				<img src="<?php echo $this->media_root.$item['m1figure_url'] ?>">
			</a>
		</div>
		<!--卡片式导航商品内容区域-->
		<div class="cardnavcontent clearfix wid710 auto mt14">
			<ul>
				<?php foreach ($item['m1_items'] as $item): ?>
				<li>
					<a href="<?php echo base_url('item/detail?id='.$item['item_id']) ?>">
						<div class=pic>
							<img src="<?php echo MEDIA_URL. 'item/'.$item['url_image_main'] ?>">
						</div>
					
						<h1><?php echo $item['name'] ?></h1>
						<h2><?php echo $item['slogan'] ?></h2>
						<h3>￥ <?php echo $item['price'] ?></h3>
					</a>
				</li>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
	<!--卡片式导航分类区域-->
	<div class="shopIndexcard clearfix auto mt10 wid710">
		<div class="pictitle wid710 border20">
			<img src="<?php echo CDN_URL ?>media/home/linebar.png" />
		</div>
		<div class="pic mt10">
			<img src="<?php echo CDN_URL ?>media/home/banner1@3x.png" />
		</div>
		<!--卡片式导航商品内容区域-->
		<div class="cardnavcontent clearfix wid710 auto mt14">
			<ul>
				<li>
					<a href="https://www.517ybang.com/item/detail?id=3" target="_self">
					<div class="pic">
						<img src="<?php echo CDN_URL ?>media/home/xinpinshangxin/xpsx160/160x160_0.jpg" />
					</div>
					</a>
						<h1>NIKE男子休闲鞋子</h1>
						<h2>AIR PERSON</h2>
						<h3>¥3444.00</h3>
				</li>
				<li>
					<a href="https://www.517ybang.com/item/detail?id=3" target="_self">
					<div class="pic">
						<img src="<?php echo CDN_URL ?>media/home/xinpinshangxin/xpsx160/160x160_1.jpg" />
					</div>
					</a>
						<h1>NIKE男子休闲鞋子</h1>
						<h2>AIR PERSON</h2>
						<h3>¥3444.00</h3>
				</li>
				<li style="margin-right: 0;">
					<a href="https://www.517ybang.com/item/detail?id=3" target="_self">
					<div class="pic">
						<img src="<?php echo CDN_URL ?>media/home/xinpinshangxin/xpsx160/160x160_2.jpg" />
					</div>
					</a>
						<h1>NIKE男子休闲鞋子</h1>
						<h2>AIR PERSON</h2>
						<h3>¥3444.00</h3>
				</li>
			
			</ul>
		</div>
	</div>
	<!--卡片式导航分类区域-->
	<div class="shopIndexcard clearfix auto mt10 wid710">
		<div class="pictitle wid710 border20">
			<img src="<?php echo CDN_URL ?>media/home/linebar.png" />
		</div>
		<div class="pic mt10">
			<img src="<?php echo CDN_URL ?>media/home/banner1@3x.png" />
		</div>
		<!--卡片式导航商品内容区域-->
		<div class="cardnavcontent clearfix wid710 auto mt14">
			<ul>
				<li>
					<a href="https://www.517ybang.com/item/detail?id=3" target="_self">
					<div class="pic">
						<img src="<?php echo CDN_URL ?>media/home/yundongjiankang/160x160_0.jpg" />
					</div>
					</a>
						<h1>NIKE男子休闲鞋子</h1>
						<h2>AIR PERSON</h2>
						<h3>¥3444.00</h3>
				</li>
				<li>
					<a href="https://www.517ybang.com/item/detail?id=3" target="_self">
					<div class="pic">
						<img src="<?php echo CDN_URL ?>media/home/yundongjiankang/160x160_1.jpg" />
					</div>
					</a>
						<h1>NIKE男子休闲鞋子</h1>
						<h2>AIR PERSON</h2>
						<h3>¥3444.00</h3>
				</li>
				<li style="margin-right: 0;">
					<a href="https://www.517ybang.com/item/detail?id=3" target="_self">
					<div class="pic">
						<img src="<?php echo CDN_URL ?>media/home/yundongjiankang/160x160_2.jpg" />
					</div>
					</a>
						<h1>NIKE男子休闲鞋子</h1>
						<h2>AIR PERSON</h2>
						<h3>¥3444.00</h3>
				</li>
			
			</ul>
		</div>
	</div>
	<div class="wid718 auto bgfff border20 exercise clearfix">
					<img src="<?php echo CDN_URL ?>media/home/cainixihuan/cainixihuan@3x.png">
	</div>
	<div class="like wid718 auto clearfix mt10">
					<ul>
						
						<li>
							<a href="https://www.517ybang.com/item/detail?id=3" target="_self">
							<img src="<?php echo CDN_URL ?>media/home/cainixihuan/cnxh/210x210_0.jpg">
							<h1>JUSTE UN CLOU 手镯</h1>
							<h2>8K玫瑰金</h2>
							<h3>¥5100</h3>
							</a>
						</li>
						<li>
							<a href="https://www.517ybang.com/item/detail?id=3" target="_self">
							<img src="<?php echo CDN_URL ?>media/home/cainixihuan/cnxh/210x210_1.jpg">
							<h1>JUSTE UN CLOU 手镯</h1>
							<h2>8K玫瑰金</h2>
							<h3>¥5100</h3>
							</a>
						</li>
						<li class="mr0">
							<a href="https://www.517ybang.com/item/detail?id=3" target="_self">
							<img src="<?php echo CDN_URL ?>media/home/cainixihuan/cnxh/210x210_2.jpg">
							<h1>JUSTE UN CLOU 手镯</h1>
							<h2>8K玫瑰金</h2>
							<h3>¥5100</h3>
							</a>
						</li>
						<li>
							<a href="https://www.517ybang.com/item/detail?id=3" target="_self">
							<img src="<?php echo CDN_URL ?>media/home/cainixihuan/cnxh/210x210_3.jpg">
							<h1>JUSTE UN CLOU 手镯</h1>
							<h2>8K玫瑰金</h2>
							<h3>¥5100</h3>
							</a>
						</li>
						<li>
							<a href="https://www.517ybang.com/item/detail?id=3" target="_self">
							<img src="<?php echo CDN_URL ?>media/home/cainixihuan/cnxh/210x210_2.jpg">
							<h1>JUSTE UN CLOU 手镯</h1>
							<h2>8K玫瑰金</h2>
							<h3>¥5100</h3>
							</a>
						</li>
						<li class="mr0">
							<a href="https://www.517ybang.com/item/detail?id=3" target="_self">
							<img src="<?php echo CDN_URL ?>media/home/cainixihuan/cnxh/210x210_1.jpg">
							<h1>JUSTE UN CLOU 手镯</h1>
							<h2>8K玫瑰金</h2>
							<h3>¥5100</h3>
							</a>
						</li>
					</ul>
				</div>
<script>
	// <?php echo $this->class_name_cn ?>数据
	var item = <?php echo json_encode($item) ?>
</script>