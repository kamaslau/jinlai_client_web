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
	<div class=btn-group role=group>
		<a class="btn btn-default" title="所有<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>"><i class="fa fa-list fa-fw" aria-hidden=true></i> 所有<?php echo $this->class_name_cn ?></a>
	  	<a class="btn btn-default" title="<?php echo $this->class_name_cn ?>回收站" href="<?php echo base_url($this->class_name.'/trash') ?>"><i class="fa fa-trash fa-fw" aria-hidden=true></i> 回收站</a>
	</div>
	<?php endif ?>

	<dl id=list-info class=dl-horizontal>
		<dt>订单号</dt>
		<dd><?php echo $item['order_id'] ?></dd>
		<dt>商户ID</dt>
		<dd><?php echo $item['biz_id'] ?></dd>
		<dt>小计（元）</dt>
		<dd><?php echo $item['subtotal'] ?></dd>
		<dt>营销活动折抵金额（元）</dt>
		<dd><?php echo $item['discount_promotion'] ?></dd>
		<dt>优惠券折抵金额（元）</dt>
		<dd><?php echo $item['discount_coupon'] ?></dd>
		<dt>积分折抵金额（元）</dt>
		<dd><?php echo $item['discount_credit'] ?></dd>
		<dt>运费（元）</dt>
		<dd><?php echo $item['freight'] ?></dd>
		<dt>改价折抵金额（元）</dt>
		<dd><?php echo $item['discount_reprice'] ?></dd>
		<dt>应支付金额（元）</dt>
		<dd><?php echo $item['total'] ?></dd>
		<dt>实际支付金额（元）</dt>
		<dd><?php echo $item['total_payed'] ?></dd>
		<dt>实际退款金额（元）</dt>
		<dd><?php echo $item['total_refund'] ?></dd>
		<dt>收件人全名</dt>
		<dd><?php echo $item['fullname'] ?></dd>
		<dt>收件人手机号</dt>
		<dd><?php echo $item['mobile'] ?></dd>
		<?php echo $item['province']. $item['city']. $item['county']. '<br>'.$item['street'] ?>
		<dt>付款方式</dt>
		<dd><?php echo $item['payment_type'] ?></dd>
		<dt>付款账号</dt>
		<dd><?php echo $item['payment_account'] ?></dd>
		<dt>付款流水号</dt>
		<dd><?php echo $item['payment_id'] ?></dd>
		<dt>用户留言</dt>
		<dd><?php echo $item['note_user'] ?></dd>
		<dt>订单状态</dt>
		<dd><?php echo $item['status'] ?></dd>
		<dt>退款状态</dt>
		<dd><?php echo $item['refund_status'] ?></dd>
		<dt>发票状态</dt>
		<dd><?php echo $item['invoice_status'] ?></dd>
	</dl>

	<dl id=list-record class=dl-horizontal>
		<dt>用户下单时间</dt>
		<dd><?php echo $item['time_create'] ?></dd>
		<dt>用户取消时间</dt>
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
	</dl>
</div>