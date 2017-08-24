<style>
	#content h2 {font-size:20px;}
	#content li {text-align:center;}
		#content li i {display:block;}
		
		.avatar img {width:120px;height:120px;}
	
		#general-actions li {text-align:left;}

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

<div id=content class=container>
	<?php
		// 常用数据
		$username = $user['nickname'];
		$url_avatar = empty($user['avatar'])? DEFAULT_IMAGE: $user['avatar'];
	?>

	<div id=user-info>
		<a title="我的用户资料" href="<?php echo base_url('user/mine') ?>">
			<figure class=avatar>
				<img class=img-circle alt="<?php echo $username ?>" src="<?php echo $user['avatar'] ?>">
			</figure>

			<h2><?php echo $username ?></h2>
		</a>
	</div>

	<section id=user-records>
		<ul class=row>
			<li class=col-xs-4>
				<a title="关注店铺" href="<?php echo base_url('fav_biz') ?>">
					<i class="fa fa-heart" aria-hidden="true"></i>
					关注店铺
				</a>
			</li>
			<li class=col-xs-4>
				<a title="收藏宝贝" href="<?php echo base_url('fav_item') ?>">
					<i class="fa fa-star" aria-hidden="true"></i>
					收藏宝贝
				</a>
			</li>
			<li class=col-xs-4>
				<a title="卡券" href="<?php echo base_url('coupon') ?>">
					<i class="fa fa-ticket" aria-hidden="true"></i>
					卡券
				</a>
			</li>
		</ul>
	</section>

	<section id=order-nav>
		<h2>
			我的订单
			<a class="pull-right" title="全部订单" href="<?php echo base_url('order') ?>">全部 &gt;</a>
		</h2>
		<ul id=list-order class="row">
			<li class=col-xs-2>
				<i class="fa fa-credit-card-alt" aria-hidden="true"></i>
				<a title="待付款订单" href="<?php echo base_url('order?status=待付款') ?>">待付款</a>
			</li>
			<li class=col-xs-2>
				<i class="fa fa-archive" aria-hidden="true"></i>
				<a title="待发货订单" href="<?php echo base_url('order?status=待发货') ?>">待发货</a>
			</li>
			<li class=col-xs-2>
				<i class="fa fa-truck" aria-hidden="true"></i>
				<a title="待收货订单" href="<?php echo base_url('order?status=待收货') ?>">待收货</a>
			</li>
			<li class=col-xs-2>
				<i class="fa fa-thumbs-up" aria-hidden="true"></i>
				<a title="待评价订单" href="<?php echo base_url('order?status=待评价') ?>">待评价</a>
			</li>
			<li id=order-refund class=col-xs-2>
				<i class="fa fa-undo" aria-hidden="true"></i>
				<a title="退款/售后" href="<?php echo base_url('refund') ?>">退款/售后</a>
			</li>
		</ul>
	</section>

	<section id=misc>
		<ul class="row">
			<li class=col-xs-4><a title="我的钱包" href="<?php echo base_url('balance') ?>">钱包</a></li>
			<li class=col-xs-4><a title="我的积分" href="<?php echo base_url('credit') ?>">积分</a></li>
			<li class=col-xs-4>
				<a title="卡券" href="<?php echo base_url('coupon') ?>">
					<i class="fa fa-ticket" aria-hidden="true"></i>卡券
				</a>
			</li>
			<li class=col-xs-4><a title="我的地址" href="<?php echo base_url('address') ?>">地址</a></li>
			<li class=col-xs-4><a title="系统设置" href="<?php echo base_url('setup') ?>">设置</a></li>
			<li class=col-xs-4><a title="安全中心" href="<?php echo base_url('safty') ?>">安全中心</a></li>
			<li class=col-xs-4><a title="商家合作" href="<?php echo base_url('biz/create') ?>">商家合作</a></li>
			<li class=col-xs-4><a title="关于我们" href="<?php echo base_url('article/about-us') ?>">关于我们</a></li>
			<li class=col-xs-4><a title="APP下载" href="<?php echo base_url('download/app?type=client') ?>">APP下载</a></li>
			<!--
			<li class=col-xs-4><a title="邀请好友" href="<?php echo base_url('invite') ?>">邀请好友</a></li>
			-->
			<li class=col-xs-4><a title="退出账户" id=logout class="btn btn-block btn-danger" href="<?php echo base_url('logout') ?>">退出</a></li>
		</ul>
	</section>

</div>