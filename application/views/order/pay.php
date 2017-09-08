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
	<?php if ( isset($error) ) echo '<div class="alert alert-warning" role=alert>'.$error.'</div>'; ?>

	<section id=address>
		<ul>
			<li>
				<?php echo $item['fullname'] ?>
				<span class="pull-right text-right"><?php echo $item['mobile'] ?></span>
			</li>
			<li>
				<?php echo $item['province']. $item['city']. $item['county']. '<br>'.$item['street'] ?>
			</li>
		</ul>
	</section>

	<section id=note_user>
		<h3>留言</h3>
		<p><?php echo $item['note_user'] ?></p>
	</section>

	<section id=biz>
		<li>商户ID <?php echo $item['biz_id'] ?></li>
	</section>

	<dl id=list-info class=dl-horizontal>
		<li>小计 ￥<?php echo $item['subtotal'] ?></li>
		<li>运费 ￥<?php echo $item['freight'] ?></li>

		<?php if ( $item['discount_coupon'] !== '0.00' ): ?>
		<li>营销活动折抵 -￥<?php echo $item['discount_promotion'] ?></li>
		<?php endif ?>

		<?php if ( $item['discount_coupon'] !== '0.00' ): ?>
		<li>优惠券折抵 -￥<?php echo $item['discount_coupon'] ?></li>
		<?php endif ?>

		<?php if ( $item['discount_reprice'] !== '0.00' ): ?>
		<li>改价折抵 -￥<?php echo $item['discount_reprice'] ?></li>
		<?php endif ?>

		<li id=total>应支付 ￥<?php echo $item['total'] ?></li>
	</dl>

	<dl id=list-record class=dl-horizontal>
		<dt>订单号</dt>
		<dd><?php echo $item['order_id'] ?></dd>
		<dt>下单时间</dt>
		<dd><?php echo date('Y-m-d H:i:s', $item['time_create']) ?></dd>
	</dl>
</div>

<nav id=nav-main>
	<ul>
		<li>
			<?php
			// 测试者/开发者每笔订单仅需支付0.01元
			if ( strpos(DEVELOPER_MOBILES, ','.$this->session->mobile.',') !== FALSE ) $item['total'] = 0.01;

			// 生成支付信息
			$payment_string = 'type=order&order_id='.$item['order_id']. '&total_fee='.$item['total']. '&body='.urlencode(SITE_NAME.'商品订单 编号').$item['order_id'];
			?>
			<a id=order-create class="btn btn-primary btn-lg btn-block" title="立即购买" href="<?php echo WEPAY_URL_JSAPI.$payment_string ?>">
				去付款
			</a>
		</li>
	</ul>
</nav>