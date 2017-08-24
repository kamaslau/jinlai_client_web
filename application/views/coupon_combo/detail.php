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

	<dl id=list-info class=dl-horizontal>
		<dt>名称</dt>
		<dd><?php echo $item['name'] ?></dd>
		<dt>所含优惠券</dt>
		<dd><?php echo $item['template_ids'] ?></dd>
		<dt>总限量</dt>
		<dd>
			<?php echo empty($item['max_amount'])? '否': $item['max_amount'].'份'; ?>
		</dd>
		<dt>开放领取时间</dt>
		<dd>
			<?php echo empty($item['time_start'])? '自即日起': date('Y-m-d H:i:s', $item['time_start']); ?> <?php echo empty($item['time_end'])? '始终开放': '至 '.date('Y-m-d H:i:s', $item['time_end']); ?>
		</dd>
	</dl>

</div>