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
		<!--
		<dt>限定系统分类ID</dt>
		<dd><?php echo $item['category_id'] ?></dd>
		<dt>所属/限定商家ID</dt>
		<dd><?php echo $item['biz_id'] ?></dd>
		<dt>限定商家分类ID</dt>
		<dd><?php echo $item['category_biz_id'] ?></dd>
		<dt>限定商品ID</dt>
		<dd><?php echo $item['item_id'] ?></dd>
		-->
		<dt>名称</dt>
		<dd><?php echo $item['name'] ?></dd>
		<dt>说明</dt>
		<dd><?php echo $item['description'] ?></dd>
		<dt>面额（元）</dt>
		<dd>￥ <?php echo $item['amount'] ?></dd>
		<dt>起用金额（元）</dt>
		<dd>￥ <?php echo $item['min_subtotal'] ?></dd>
		<dt>有效期</dt>
		<dd><?php echo date('Y-m-d H:i:s', $item['time_start']) ?> - <?php echo date('Y-m-d H:i:s', $item['time_end']) ?></dd>

		<dt>失效时间</dt>
		<dd><?php echo $item['time_expire'] ?></dd>
		<dt>所属订单ID</dt>
		<dd><?php echo $item['order_id'] ?></dd>
		<dt>使用时间</dt>
		<dd><?php echo $item['time_used'] ?></dd>
		<dt>状态</dt>
		<dd><?php echo $item['status'] ?></dd>
	</dl>
</div>