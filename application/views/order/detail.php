<style>
	#biz>a {display:block;overflow:hidden;}
		#biz>a>* {float:left;display:inline-block;}

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

	<section id=status>
		<ul>
			<li><?php echo $item['status'] ?></li>
		</ul>
	</section>

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
		<a title="<?php echo $item['biz_name'] ?>" href="<?php echo base_url('biz/detail?id='. $item['biz_id']) ?>">
			<img title="<?php echo $item['biz_name'] ?>" src="<?php echo MEDIA_URL.'biz/'. $item['biz_url_logo'] ?>">
			<?php echo $item['biz_name'] ?>
		</a>
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

		<?php if ($item['status'] !== '待付款'): ?>

			<?php if ( !empty($item['credit_payed'] ) ): ?>
			<li>积分支付 -￥<?php echo $item['credit_payed'] ?></li>
			<?php endif ?>

			<?php if ( $item['total_payed'] !== '0.00' ): ?>
			<li id=total_payed>已支付 ￥<?php echo $item['total_payed'] ?></li>
			<li>支付方式 ￥<?php echo $item['payment_type'] ?></li>
			<li>支付流水号 ￥<?php echo $item['payment_id'] ?></li>
			<?php endif ?>

			<?php if ( $item['refund_status'] !== '未申请' ): ?>
			<li>退款/售后状态 <?php echo $item['refund_status'] ?></li>
			<li>已退款 ￥<?php echo $item['total_refund'] ?></li>
			<?php endif ?>

			<?php if ( $item['invoice_status'] !== '未申请' ): ?>
			<li>发票状态 <?php echo $item['invoice_status'] ?></li>
			<?php endif ?>

		<?php endif ?>
	</dl>

	<dl id=list-record class=dl-horizontal>
		<dt>订单号</dt>
		<dd><?php echo $item['order_id'] ?></dd>
		<dt>下单时间</dt>
		<dd><?php echo date('Y-m-d H:i:s', $item['time_create']) ?></dd>

		<?php if ($item['status'] !== '待付款'): ?>
			<dt>取消时间</dt>
			<dd><?php echo $item['time_cancel'] ?></dd>
			<dt>自动过期时间</dt>
			<dd><?php echo $item['time_expire'] ?></dd>
			<dt>用户付款时间</dt>
			<dd><?php echo $item['time_pay'] ?></dd>
			<dt>商家拒绝时间</dt>
			<dd><?php echo $item['time_refuse'] ?></dd>
			<dt>商家接单时间</dt>
			<dd><?php echo $item['time_accept'] ?></dd>
			<dt>商家发货时间</dt>
			<dd><?php echo $item['time_deliver'] ?></dd>
			<dt>用户确认时间</dt>
			<dd><?php echo $item['time_confirm'] ?></dd>
			<dt>系统确认时间</dt>
			<dd><?php echo $item['time_confirm_auto'] ?></dd>
			<dt>用户评价时间</dt>
			<dd><?php echo $item['time_comment'] ?></dd>
			<dt>商家退款时间</dt>
			<dd><?php echo $item['time_refund'] ?></dd>
			
			<?php if ( ! empty($item['time_delete']) ): ?>
			<dt>用户删除时间</dt>
			<dd><?php echo $item['time_delete'] ?></dd>
			<?php endif ?>

		<?php endif ?>
	</dl>
</div>

<nav id=nav-main>
	<ul>
		
		<li>
			<a id=order-create class="btn btn-primary btn-lg btn-block" title="立即购买" href="<?php echo base_url('order/pay?id='.$item[$this->id_name]) ?>">
				去付款
			</a>
		</li>
	</ul>
</nav>