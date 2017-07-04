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

<nav id=nav-main class=container>
	<ul class="list-horizontal row">
		<li class="col-sm-3"><a <?php if ($class === 'home') echo 'class=active' ?> title="首页" href="<?php echo base_url('home') ?>">首页</a></li>
		<li class="col-sm-3"><a <?php if ($class === 'explore') echo 'class=active' ?> title="发现" href="<?php echo base_url('explore') ?>">发现</a></li>
		<li class="col-sm-3"><a <?php if ($class === 'cart') echo 'class=active' ?> title="购物车" href="<?php echo base_url('cart') ?>">购物车</a></li>
		<li class="col-sm-3"><a <?php if ($class === 'account mine') echo 'class=active' ?> title="我的" href="<?php echo base_url('mine') ?>">我的</a></li>
	</ul>
</nav>