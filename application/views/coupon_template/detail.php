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
		<dt>说明</dt>
		<dd><?php echo $item['description'] ?></dd>
		<dt>面值</dt>
		<dd>￥ <?php echo $item['amount'] ?></dd>
		<dt>起用金额</dt>
		<dd>￥ <?php echo $item['min_subtotal'] ?></dd>

		<dt>总限量</dt>
		<dd>
			<?php echo empty($item['max_amount'])? '无': $item['max_amount'].'份'; ?>
		</dd>
		<dt>单个用户限量</dt>
		<dd><?php echo empty($item['max_amount_user'])? '无': $item['max_amount_user'].'份'; ?></dd>

		<dt>限用系统分类</dt>
		<dd><?php echo empty($item['category_id'])? '不限': $category['name']; ?></dd>
		<dt>限用店内分类</dt>
		<dd><?php echo empty($item['category_biz_id'])? '不限': $category_biz['name']; ?></dd>
		<dt>限用商品</dt>
		<dd><?php echo empty($item['item_id'])? '不限': $item['item_id']; ?></dd>

		<?php
			$options = array(
				'1小时' => '3600',
				'2小时' => '7200',
				'3小时' => '10800',
				'4小时' => '14400',
				'6小时' => '21600',
				'8小时' => '28800',
				'12小时' => '43200',
				'24小时/1天' => '86400',
				'2天' => '172800',
				'3天' => '259200',
				'7天' => '604800',
				'10天' => '864000',
				'14天' => '1209600',
				'30天' => '2592000',
				'45天' => '3888000',
				'90天' => '7776000',
				'120天' => '10368000',
				'180天/半年' => '15552000',
				'366天/1年' => '31622400',
			);
			$options = array_flip($options);
		?>
		<dt>有效时间</dt>
		<dd>
			<?php echo empty($item['time_start'])? date('Y-m-d H:i:s'): date('Y-m-d H:i:s', $item['time_start']); ?> <?php echo empty($item['time_end'])? '起 '.$options[ $item['period'] ].'内': '至 '.date('Y-m-d H:i:s', $item['time_end']); ?>
		</dd>
	</dl>

</div>