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

<nav id=nav-main>
	<ul class="horizontal">
		<li><a <?php if ($class === 'home') echo 'class=active' ?> title="首页" href="<?php echo base_url('home') ?>">首页</a></li>
		<li><a <?php if ($class === 'explore') echo 'class=active' ?> title="发现" href="<?php echo base_url('explore') ?>">发现</a></li>
		<li><a <?php if ($class === 'cart') echo 'class=active' ?> title="购物车" href="<?php echo base_url('cart') ?>">购物车</a></li>
		<li><a <?php if ($class === 'account mine') echo 'class=active' ?> title="我的" href="<?php echo base_url('mine') ?>">我的</a></li>
	</ul>
</nav>