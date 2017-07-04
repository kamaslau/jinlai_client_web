<style>


	/* 宽度在640像素以上的设备 */
	@media only screen and (min-width:641px)
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

<div id=content class=container>
	<section id=user-info>
		<?php $username = !empty($this->session->nickname)? $this->session->nickname: $this->session->mobile; ?>
		<h2><?php echo $username ?></h2>
	</section>
	
	<section id=record-info>
		<ul id=list-record class="row list">
			<li class=col-xs-3>
				<a title="商品收藏" href="<?php echo base_url('label_item') ?>">
					<span><?php echo $count['label_item'] ?></span>
					收藏夹
				</a>
			</li>
			<li class=col-xs-3>
				<a title="商家收藏" href="<?php echo base_url('label_biz') ?>">
					<span><?php echo $count['label_biz'] ?></span>
					关注商家
				</a>
			</li>
			<li class=col-xs-3>
				<a title="优惠券" href="<?php echo base_url('coupon') ?>">
					<span><?php echo $count['coupon'] ?></span>
					优惠券
				</a>
			</li>
			<li class=col-xs-3>
				<a title="浏览记录" href="<?php echo base_url('footprint') ?>">
					<span><?php echo $count['footprint'] ?></span>
					浏览记录
				</a>
			</li>
		</ul>
	</section>
	
	<section id=order-info>
		<header>
			<h2>我的订单</h2>
			<a id=order-all title="全部订单" href="<?php echo base_url('order') ?>">更多 <i class="fa fa-angle-right" aria-hidden="true"></i></a>
		</header>
		<ul id=list-order class="row list">
			<li class=col-xs-3>
				<i class="fa fa-credit-card-alt" aria-hidden="true"></i>
				<a title="待付款订单" href="<?php echo base_url('order?status=create') ?>">待付款</a>
			</li>
			<li class=col-xs-3>
				<i class="fa fa-archive" aria-hidden="true"></i>
				<a title="待发货订单" href="<?php echo base_url('order?status=pay') ?>">待发货</a>
			</li>
			<li class=col-xs-3>
				<i class="fa fa-truck" aria-hidden="true"></i>
				<a title="待收货订单" href="<?php echo base_url('order?status=deliver') ?>">待收货</a>
			</li>
			<li class=col-xs-3>
				<i class="fa fa-thumbs-up" aria-hidden="true"></i>
				<a title="待评价订单" href="<?php echo base_url('order?status=finish') ?>">待评价</a>
			</li>
			<li>
				<i class="fa fa-undo" aria-hidden="true"></i>
				<a title="退款订单" href="<?php echo base_url('order?status=refund') ?>">退款/售后</a>
			</li>
		</ul>
	</section>
	
	<a title="设置" class="btn btn-block btn-default" href="<?php echo base_url('setup') ?>">设置</a>
	
	<a title="退出账户" class="btn btn-block btn-danger" href="<?php echo base_url('logout') ?>">退出账户</a>
</div>