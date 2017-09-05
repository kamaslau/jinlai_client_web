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
	<div class=btn-group role=group>
		<a class="btn btn-primary" title="所有<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>"><i class="fa fa-list fa-fw" aria-hidden=true></i> 所有<?php echo $this->class_name_cn ?></a>
	  	<a class="btn btn-default" title="<?php echo $this->class_name_cn ?>回收站" href="<?php echo base_url($this->class_name.'/trash') ?>"><i class="fa fa-trash fa-fw" aria-hidden=true></i> 回收站</a>
	</div>
	
	<?php if ( isset($error) ) echo '<div class="alert alert-warning" role=alert>'.$error.'</div>'; ?>

	<?php if ( empty($items) ): ?>
	<blockquote>
		<p>这里空空如也，快去挑选你喜欢的宝贝吧</p>
	</blockquote>

	<?php else: ?>
	<form method=get target=_blank>
		<fieldset>
			<div class=btn-group role=group>
				<button formaction="<?php echo base_url($this->class_name.'/delete') ?>" type=submit class="btn btn-default">删除</button>
			</div>
		</fieldset>

		<table>
			<tbody>
			<?php foreach ($items as $item): ?>
				<? //var_dump($item) ?>
				<tr>
					<td>
						<input name=ids[] class=form-control type=checkbox value="<?php echo $item[$this->id_name] ?>">
					</td>
					<td>
						<section class=biz>
							<a title="<?php echo $item['biz_name'] ?>" href="<?php echo base_url('biz/detail?id='. $item['biz_id']) ?>">
								<img title="<?php echo $item['biz_name'] ?>" src="<?php echo MEDIA_URL.'biz/'. $item['biz_url_logo'] ?>">
								<?php echo $item['biz_name'] ?>
							</a>
						</section>

						<section class=order-items>
							<a href="<?php echo base_url($this->class_name. '/detail?id='.$item[$this->id_name]) ?>">
							<ul>
								<?php //foreach (): ?>
								
								
								
								<?php //endforeach ?>
							</ul>
							</a>
						</section>

						<nav class=order-actions>
							<ul class=horizontal>
								<li><a title="查看" href="<?php echo base_url($this->view_root.'/detail?id='.$item[$this->id_name]) ?>">查看</a></li>

								<?php if ($item['status'] === '待付款'): ?>
								<li><a title="去付款" href="<?php echo base_url('order/pay?id='.$item[$this->id_name]) ?>">去付款</a></li>
								<?php endif ?>

								<?php
									$status_can_delete = array('已完成', '已取消', '已拒绝', '已关闭');
									if ( in_array($item['status'], $status_can_delete) ):
								?>
								<li><a title="删除" href="<?php echo base_url($this->class_name.'/delete?ids='.$item[$this->id_name]) ?>">删除</a></li>
								<?php endif ?>
							</ul>
						</nav>
					</td>
				</tr>

			<?php endforeach ?>
			</tbody>
		</table>

	</form>
	<?php endif ?>
</div>