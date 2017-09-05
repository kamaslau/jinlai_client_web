<style>
	#address-list>li {border:2px solid gray;cursor:pointer;}
		#address-list>li.active {border-color:red;}

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

<script>
	$(function(){
		// 标注默认地址为选中状态
		$('#address-list>li[data-id=<?php echo $this->session->address_id ?>]').addClass('active');

		// 点击地址项时获取并填充相应字段值
		$('#address-list>li').click(function(){
			var address_id = $(this).attr('data-id');
			console.log(address_id);
			$('[name=address_id]').val(address_id);

			// 标注为选中状态
			$('#address-list>li.active').removeClass('active');
			$(this).addClass('active');
		});
	});
</script>

<base href="<?php echo $this->media_root ?>">

<div id=breadcrumb>
	<ol class="breadcrumb container">
		<li><a href="<?php echo base_url() ?>">首页</a></li>
		<li><a href="<?php echo base_url($this->class_name) ?>"><?php echo $this->class_name_cn ?></a></li>
		<li class=active><?php echo $title ?></li>
	</ol>
</div>

<div id=content class=container>
	<?php if ( isset($item) ): ?>
	<div id=order-single>
		<h2>单品订单</h2>
		<section id=order-item>
			<?php echo '商品名称 '.$item['name'] ?>
			<?php echo '商家名称 '.$biz['name'] ?>
		</section>
	</div>

	<?php else: ?>
	<script>
		$(function(){
			// 将所有购物车项以商家为单位进行显示
			$('.biz').each(function(){
				// 获取当前biz_id
				var biz_id = $(this).attr('data-biz-id');
			
				// 将所有该biz_id对应的购物车项装入同一容器
				$('.item[data-biz-id='+ biz_id +']').wrapAll('ul.cart-items').appendTo('section[data-biz-id='+ biz_id +']');

			});

			// 移除购物车项前要求用户确定
			$('a.remove').click(function(){
				var is_confirm = confirm('确定删除这个宝贝吗');
			
				if (is_confirm == false)
				{
					return false;
				}
			});
		});
	</script>

	<div id=order-multiple>
		<h2>购物车订单</h2>

		<?php foreach ($cart_data['bizs'] as $biz): ?>
		<section style="border:2px solid red" class=biz data-biz-id="<?php echo $biz['biz_id'] ?>">
			<h2 class=biz-name>
				<a title="<?php echo $biz['name'] ?>" href="<?php echo base_url('biz/detail?id='.$biz['biz_id']) ?>">
					<i class="fa fa-home" aria-hidden="true"></i> <?php echo $biz['name'] ?>
				</a>
			</h2>
		</section>
		<?php endforeach ?>

		<ul>
		<?php
			foreach ($cart_data['items'] as $item):

			// 生成操作URL参数
			$url_param = '?';
			// 初始化有效性、库存充足度、可减量、可加量性
			$is_valid = $is_enough = $can_add = $can_reduce = TRUE;

			// TODO 判断店铺状态是否正常，若正常则获取biz_id
			if ( TRUE ):
				$url_param .= 'biz_id='.$item['biz_id'];
			else:
				$is_valid = FALSE;
			endif;

			// 判断商品是否在售，若正常则获取item_id
			if ( !empty($item['time_publish']) ):
				$url_param .= '&item_id='.$item['item_id'];

				// 判断库存是否充足
				if ( $item['stocks'] < $item['count'] ):
					$is_enough = FALSE;
				endif;

				// 判断是否可减量
				if ( $item['quantity_min'] >= $item['count'] ):
					$can_reduce = FALSE;
				endif;

				// 判断是否可加量
				if ( $item['stocks'] == $item['count'] || $item['quantity_max'] <= $item['count']):
					$can_add = FALSE;
				endif;

			else:
				$is_valid = FALSE;
			endif;

			// 判断是否存在SKU
			if ( isset($item['sku']) ):
				// 判断SKU库存是否足够，若正常则获取sku_id
				if ( $item['sku']['stocks'] >= $item['count'] ):
					$url_param .= '&sku_id='.$item['sku']['sku_id'];

					// 判断是否可加量
					if ( $item['sku']['stocks'] == $item['count']):
						$can_add = FALSE;
					endif;
				else:
					$is_enough = FALSE;
				endif;

			endif;
		?>
			<li class="item row" data-biz-id="<?php echo $item['biz_id'] ?>">
				<div class="main-images col-xs-2">
					<a href="<?php echo base_url('item/detail?id='.$item['item_id']) ?>">
						<img alt="<?php echo $item['name'] ?>" src="<?php echo $item['url_image_main'] ?>">
					</a>
				</div>

				<section class="col-xs-6">
					<h2 class=item-name>
						<a title="<?php echo $item['name'] ?>" href="<?php echo base_url('item/detail?id='.$item['item_id']) ?>">
							<?php if ($is_valid === FALSE): ?>
								<span class="label label-danger">已失效，下单时将忽略</span>
							<?php else: ?>
								<?php if ($is_enough === FALSE): ?>
								<span class="label label-warning">库存不足，下单时将忽略</span>
								<?php endif ?>
							<?php endif ?>

							<?php echo $item['name'] ?>
						</a>
					</h2>
				</section>

				<!-- 价格相关 -->
				<ul class="price list-unstyled col-xs-4">
					<li><strong>￥ <?php echo $item['price'] ?></strong> &times; <?php echo $item['count'] ?></li>
				</ul>

				<!-- 数量调整 -->
				<?php if ($is_valid === TRUE): ?>
				<ul class="actions col-xs-12 row">
					<?php if ($can_reduce === TRUE): ?>
					<li class="col-xs-4">
						<a class=reduce href="<?php echo base_url('cart/reduce'.$url_param) ?>"><i class="fa fa-minus-circle" aria-hidden=true></i></a>
					</li>
					<?php endif ?>

					<li class="col-xs-4">
						<a class=remove href="<?php echo base_url('cart/remove'.$url_param) ?>"><i class="fa fa-trash" aria-hidden=true></i></a>
					</li>

					<?php if ($can_add === TRUE): ?>
					<li class="col-xs-4">
						<a class=add href="<?php echo base_url('cart/add'.$url_param) ?>"><i class="fa fa-plus-circle" aria-hidden=true></i></a>
					</li>
					<?php endif ?>
				</ul>
				<?php endif ?>
			</li>

			<?php endforeach ?>
		</ul>

	</div>

	<?php endif ?>

	<?php
		if ( !empty($error) ) echo '<div class="alert alert-warning" role=alert>'.$error.'</div>';
		$attributes = array('class' => 'form-'.$this->class_name.'-create form-horizontal', 'role' => 'form');
		echo form_open_multipart($this->class_name.'/create', $attributes);
	?>
		<fieldset>
			<?php if ( isset($item) ): ?>
			<input name=item_id type=hidden value="<?php echo $item['item_id'] ?>">
			<?php endif ?>

			<div class=form-group>
				<label for=note_user class="col-sm-2 control-label">收货地址</label>
				<div class=col-sm-10>
					<input name=address_id type=hidden value="<?php echo $this->session->address_id ?>">

					<?php
						// 生成回调跳转URL
						$url_to_return = urlencode('https://'. $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);

						// 若未设置收货地址，提示用户创建新收货地址
						if ( empty($addresses) ):
					?>
					<p class=help-block>您目前没有可用的收货地址</p>

					<a class="btn btn-primary btn-lg" href="<?php echo base_url('address/create?return_to='.$url_to_return) ?>">添加地址</a>

					<?php else: ?>
					<ul id=address-list class=row>

						<?php foreach ($addresses as $item): ?>
						<li class="col-xs-12 col-sm-6 col-md-4" data-id="<?php echo $item['address_id'] ?>">
							<ul class=row>
								<li class=col-xs-12>
									<?php if ( !empty($item['brief']) ): ?>
									<em>「<?php echo $item['brief'] ?>」</em>
									<?php endif ?>

									<?php echo $item['fullname'] ?>
									<span class="pull-right text-right"><?php echo $item['mobile'] ?></span>
								</li>
								<li class=col-xs-12>
									<?php echo $item['province']. $item['city']. $item['county']. '<br>'.$item['street'] ?>
								</li>
							</ul>
						</li>
						<?php endforeach ?>

					</ul>
					<a class="btn btn-default btn-lg" href="<?php echo base_url('address/create?return_to='.$url_to_return) ?>">添加地址</a>

					<?php endif ?>
				</div>
			</div>
		</fieldset>

		<fieldset>
			<div class=form-group>
				<label for=note_user class="col-sm-2 control-label">留言</label>
				<div class=col-sm-10>
					<textarea name=note_user class=form-control placeholder="如有特殊要求，请留言说明，最多255个字符"><?php echo set_value('note_user') ?></textarea>
				</div>
			</div>
		</fieldset>

		<div class=form-group>
		    <div class="col-xs-12 col-sm-offset-2 col-sm-2">
				<button class="btn btn-primary btn-lg btn-block" type=submit>确定</button>
		    </div>
		</div>
	</form>

</div>