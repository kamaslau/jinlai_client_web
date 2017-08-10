<style>
	#address-list>li {border-bottom:1px solid #aaa;margin-bottom:2rem;}

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

<div id=content class=container>
	<nav id=nav-main>
		<ul class=row>
			<li class="col-xs-12">
				<a class="btn btn-primary btn-lg btn-block" title="创建<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name.'/create') ?>"><i class="fa fa-plus" aria-hidden=true></i> 添加新<?php echo $this->class_name_cn ?></a>
			</li>
		</ul>
	</nav>

	<?php if ( empty($items) ): ?>
	<blockquote>
		<p>这里空空如也，快点添加<?php echo $this->class_name_cn ?>吧</p>
	</blockquote>

	<?php else: ?>
	<ul id=address-list class=row>

		<?php foreach ($items as $item): ?>
		<li class=col-xs-12>
			<ul class=row>
				<?php if ( strpos(DEVELOPER_MOBILES, ','.$this->session->mobile.',') !== FALSE ): ?>
				<li class=col-xs-12>ID <?php echo $item['address_id'] ?></li>
				<?php endif ?>
				
				<?php if ( !empty($item['brief']) ): ?>
				<li class=col-xs-12><em><?php echo $item['brief'] ?></em></li>
				<?php endif ?>
				
				<li class=col-xs-12>
					<?php echo $item['fullname'] ?>
					<span class="pull-right text-right"><?php echo $item['mobile'] ?></span>
				</li>
				<li class=col-xs-12>
					<?php echo $item['province']. $item['city']. $item['county']. '<br>'.$item['street'] ?>
				</li>
				<li class=col-xs-12>
					<ul class="row">
						<?php var_dump($item['address_id']) ?>
						<?php var_dump($this->session->address_id) ?>

						<?php if ($item['address_id'] == $this->session->address_id): ?>
						<li class="col-xs-6"><i class="fa fa-fw fa-check-circle" aria-hidden=true></i> 默认地址</li>
						<?php else: ?>
						<li class="col-xs-6"><a title="设为默认" href="<?php echo base_url($this->view_root.'/default_this?id='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-fw fa-circle-o"></i> 设为默认</a></li>
						<?php endif ?>

						<li class="col-xs-3"><a title="修改" href="<?php echo base_url($this->class_name.'/edit?id='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-fw fa-edit"></i> 修改</a></li>
						
						<?php if ($item['address_id'] != $this->session->address_id): ?>
						<li class="col-xs-3"><a title="删除" href="<?php echo base_url($this->class_name.'/delete?ids='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-fw fa-trash"></i> 删除</a></li>
						<?php endif ?>
					</ul>
				</li>
			</ul>
		</li>
		<?php endforeach ?>

	</ul>
	<?php endif ?>
</div>