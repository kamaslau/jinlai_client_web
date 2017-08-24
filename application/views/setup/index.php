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
		<li class=active><?php echo $this->class_name_cn ?></li>
	</ol>
</div>

<div id=content class=container>

	<ul id=item-list class=row>
		<li class="col-xs-12 col-sm-4 col-md-3"><a title="修改密码" href="<?php echo base_url('password_change') ?>">修改密码</a></li>
		<li class="col-xs-12 col-sm-4 col-md-3"><a title="退出账户" id=logout class="btn btn-block btn-danger" href="<?php echo base_url('logout') ?>">退出</a></li>
	</ul>

</div>