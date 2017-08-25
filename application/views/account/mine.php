<style>
	body {background:#efefef url('/media/account/mine/beijing@3x.png') center -44px no-repeat;background-size:100% 388px;}

	#content li {text-align:center;}
		#content li img {display:block;margin:0 auto;}

	#user-info {color:#fff;padding:60px 20px 30px 45px;border-bottom:1px dashed #eee;}
		#user-info a {color:#fff;display:block;overflow:hidden;}
			#user-info a>* {float:left;}
			.avatar {margin-right:20px;}
				.avatar img {width:130px;height:130px;}
			#user-info h2 {color:#fff;}

	#user-records {height:125px;padding:16px 0 26px;}
		#user-records a {color:#fff;font-size:26px;}
		#user-records img {width:45px;height:45px;margin-bottom:14px;}

	section {background-color:#fff;margin:20px 10px 0;border-radius:30px;}
		section h2 {padding:30px 10px;}
		section li {border-top:1px solid #dcdddd;}
			section a {color:#3e3a39;font-size:26px;}

	#order-nav {}
		#to-all {color:#898989;}
		#order-nav li {height:142px;padding:25px 0 30px;width:20%;}
			#order-nav img {width:48px;height:48px;margin-bottom:14px;}

	#misc {margin-bottom:-1px;}
		#misc li {height:152px;padding:30px 0;}
			#misc img {width:54px;height:54px;margin-bottom:12px;}
</style>

<div id=content class=container>
	<?php
		// 常用数据
		$username = $user['nickname'];
		$url_avatar = empty($user['avatar'])? DEFAULT_IMAGE: $user['avatar'];
	?>

	<div id=user-info>
		<a title="我的用户资料" href="<?php echo base_url('user/mine') ?>">
			<figure class="avatar">
				<img class=img-circle alt="<?php echo $username ?>" src="<?php echo $this->media_root. $user['avatar'] ?>">
			</figure>

			<h2><?php echo $username ?></h2>
		</a>
	</div>

	<nav id=user-records>
		<ul class=row>
			<li class=col-xs-4>
				<a title="关注店铺" href="<?php echo base_url('fav_biz') ?>">
					<img src="/media/account/mine/guanzhu@3x.png">
					关注店铺
				</a>
			</li>
			<li class=col-xs-4>
				<a title="收藏宝贝" href="<?php echo base_url('fav_item') ?>">
					<img src="/media/account/mine/shoucang@3x.png">
					收藏宝贝
				</a>
			</li>
			<li class=col-xs-4>
				<a title="卡券" href="<?php echo base_url('coupon') ?>">
					<img src="/media/account/mine/kabao@3x.png">
					卡券
				</a>
			</li>
		</ul>
	</nav>

	<section id=order-nav>
		<h2>
			我的订单
			<a id=to-all class="pull-right" title="全部订单" href="<?php echo base_url('order') ?>">全部 &gt;</a>
		</h2>
		<ul id=list-order class="row">
			<li class=col-xs-2>
				<img src="/media/account/mine/daifukuan@3x.png">
				<a title="待付款订单" href="<?php echo base_url('order?status=待付款') ?>">待付款</a>
			</li>
			<li class=col-xs-2>
				<img src="/media/account/mine/daifahuo@3x.png">
				<a title="待发货订单" href="<?php echo base_url('order?status=待发货') ?>">待发货</a>
			</li>
			<li class=col-xs-2>
				<img src="/media/account/mine/daishouhuo@3x.png">
				<a title="待收货订单" href="<?php echo base_url('order?status=待收货') ?>">待收货</a>
			</li>
			<li class=col-xs-2>
				<img src="/media/account/mine/daipingjia@3x.png">
				<a title="待评价订单" href="<?php echo base_url('order?status=待评价') ?>">待评价</a>
			</li>
			<li id=order-refund class=col-xs-2>
				<img src="/media/account/mine/shouhou@3x.png">
				<a title="退款/售后" href="<?php echo base_url('refund') ?>">退款/售后</a>
			</li>
		</ul>
	</section>

	<section id=misc>
		<h2>
			我的服务
		</h2>
		<ul class="row">
			<li class=col-xs-4>
				<a title="我的钱包" href="<?php echo base_url('balance') ?>"><img src="/media/account/mine/yue@3x.png">钱包</a>
			</li>
			<li class=col-xs-4>
				<a title="我的积分" href="<?php echo base_url('credit') ?>"><img src="/media/account/mine/jifen@3x.png">积分</a>
			</li>
			<li class=col-xs-4>
				<a title="我的卡券" href="<?php echo base_url('coupon') ?>"><img src="/media/account/mine/kabao2@3x.png">卡券</a>
			</li>
			<li class=col-xs-4>
				<a title="邀请好友" href="<?php echo base_url('invite') ?>"><img src="/media/account/mine/yaoqinghaoyou@3x.png">邀请好友</a>
			</li>
			<li class=col-xs-4>
				<a title="商家合作" href="<?php echo BIZ_URL.'biz/create' ?>"><img src="/media/account/mine/shangjiahezuo@3x.png">商家合作</a>
			</li>
			<li class=col-xs-4>
				<a title="进来红卡" href="<?php echo base_url('biz/create') ?>"><img src="/media/account/mine/hongka@3x.png">进来红卡</a>
			</li>
			<li class=col-xs-4>
				<a title="我的地址" href="<?php echo base_url('address') ?>"><img src="/media/account/mine/dizhi@3x.png">地址</a>
			</li>
			<li class=col-xs-4>
				<a title="系统设置" href="<?php echo base_url('setup') ?>"><img src="/media/account/mine/shezhi@3x.png">设置</a>
			</li>
			<li class=col-xs-4>
				<a title="关于我们" href="<?php echo base_url('article/about-us') ?>"><img src="/media/account/mine/guanyuwomen@3x.png">关于我们</a>
			</li>
			<li class=col-xs-4>
				<a title="APP下载" href="<?php echo base_url('download/app?type=client') ?>"><i class="fa fa-download"></i>APP下载</a>
			</li>
			<!--
			<li class=col-xs-4>
				<a title="安全中心" href="<?php echo base_url('safty') ?>">安全中心</a>
			</li>
			-->
		</ul>
	</section>

</div>