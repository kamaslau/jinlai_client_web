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

<div id=breadcrumb>
	<ol class="breadcrumb container">
		<li><a href="<?php echo base_url() ?>">首页</a></li>
		<li class=active><?php echo $this->class_name_cn ?></li>
	</ol>
</div>

<div id=content class=container>
	<div class=btn-group role=group>
		<a class="btn btn-primary" title="所有<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>"><i class="fa fa-list fa-fw" aria-hidden=true></i> 所有<?php echo $this->class_name_cn ?></a>
	</div>

	<?php if ( empty($items) ): ?>
	<blockquote>
		<p>没有符合条件的数据</p>
	</blockquote>

	<?php else: ?>

		<ul id=item-list class=row>
			<?php foreach ($items as $item): ?>
			<li class="item col-xs-6 col-sm-3 col-md-4">
				<a href="<?php echo base_url($this->class_name. '/detail?id='.$item[$this->id_name]) ?>">
					<?php echo $item['title'] ?>
					<?php echo $item['excerpt'] ?>
				</a>
			</li>
			<?php endforeach ?>
		</ul>
	<?php endif ?>
</div>