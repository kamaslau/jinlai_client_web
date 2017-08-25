<style>
	#cart-header {background:#efefef url('/media/cart/top_bg@3x.png') center -44px no-repeat;background-size:100% auto;height:128px;}

	section {background-color:#fff;margin:20px;border-radius:30px;}
		section h2 {padding:30px 10px;}
		section li {border-top:1px solid #dcdddd;}
			section a {color:#3e3a39;font-size:26px;}
	
	.biz-name {overflow:hidden;padding:10px 20px;}
		.biz-name>* {float:left;}
		.biz-name img {width:60px;height:60px;margin-left:20px;margin-right:10px;overflow:hidden;display:inline-block;}

	.item {padding:20px 36px 20px 20px;overflow:hidden;}
		.item>* {float:left;height:190px;}
		.item-image-main {width:190px;margin-left:20px;margin-right:30px;overflow:hidden;}
		.item-info {font-size:28px;width:374px;}
			.price {color:#f39800;margin:20px 0;}
			.count {color:#3e3a39;width:92px;}

	.cart-items>li {background-color:#fff;margin-bottom:10px;padding:0.5em;}
		.cart-items>li>* {padding-right:0;}

	.actions {border-top:1px solid #9ed99d;padding:0;margin:0;margin-top:0.5em;overflow:hidden;}
		.actions>li {height:44px;line-height:44px;padding:0;}
			.actions>li:first-of-type {border-right:1px solid #9ed99d;}
			.actions>li a {font-size:20px;text-align:center;display:block;width:100%;height:100%;}
			a.add {color:#fff;background-color:#9ed99d;}
			a.reduce {color:rgba(0, 0, 0, 0.3);}
	
	#cart-actions {background-color:#fff;position:fixed;left:0;right:0;bottom:96px;height:88px;padding:24px 0 24px 20px;border-top:1px solid #e1e1e1;overflow:hidden;}
	#cart-actions>* {float:left;display:inline;}
	#create-order {color:#fff;background-color:#ff5353;font-size:30px;font-weight:600;text-align:center;width:215px;height:88px;line-height:88px;position:absolute;right:0;bottom:0;}
</style>

<base href="<?php echo $this->media_root ?>">

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
			var is_confirm = confirm('确定要删除这个宝贝吗');
			
			if (is_confirm == false)
			{
				return false;
			}
		});
	});
</script>

<?php if ($this->session->mobile === '17664073966') var_dump($this->session->cart) ?>

<header id=cart-header>

</header>

<div id=content class=container>
	<?php if ( !empty($content) ) echo '<p class="bg-info text-info text-center">'.$content.'</p>'; ?>

<?php if ( empty($this->session->cart) ): ?>
	<p>购物车竟然是空的</p>
	<p>再忙，也要记得买点什么犒赏自己~</p>

<?php else: ?>
	<?php foreach ($cart_data['bizs'] as $biz): ?>
	<section class=biz data-biz-id="<?php echo $biz['biz_id'] ?>">
		<h2 class=biz-name>
			<a title="<?php echo $biz['name'] ?>" href="<?php echo base_url('biz/detail?id='.$biz['biz_id']) ?>">
				<img alt="<?php echo $biz['name'] ?>" src="<?php echo MEDIA_URL.'/biz/'.$biz['url_logo'] ?>">
				<span><?php echo $biz['name'] ?> &gt;</span>
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
			if ( empty($item['time_publish']) ):
				$is_valid = FALSE;

			else:
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

			<div class=item-image-main>
				<a href="<?php echo base_url('item/detail?id='.$item['item_id']) ?>">
					<img alt="<?php echo $item['name'] ?>" src="<?php echo $item['url_image_main'] ?>">
				</a>
			</div>

			<div class=item-info>
				<h2 class=item-name>
					<a title="<?php echo $item['name'] ?>" href="<?php echo base_url('item/detail?id='.$item['item_id']) ?>">
						<?php if ($is_valid === FALSE): ?>
							<span class="label label-danger">已失效</span>
						<?php else: ?>
							<?php if ($is_enough === FALSE): ?>
							<span class="label label-warning">库存不足</span>
							<?php endif ?>
						<?php endif ?>

						<?php echo $item['name'] ?>
					</a>
				</h2>
				<div class=price>￥ <?php echo $item['price'] ?></div>

				<!-- 数量调整 -->
				<?php if ($is_valid === TRUE): ?>
				<ul class="actions row">
					<?php if ($can_reduce === TRUE): ?>
					<li class=reduce>
						<a href="<?php echo base_url('cart/reduce'.$url_param) ?>"><i class="fa fa-minus-circle" aria-hidden=true></i></a>
					</li>
					<?php endif ?>
				
					<li class=count>
						<?php echo $item['count'] ?>
					</li>

					<li class=remove>
						<a href="<?php echo base_url('cart/remove'.$url_param) ?>"><i class="fa fa-trash" aria-hidden=true></i></a>
					</li>

					<?php if ($can_add === TRUE): ?>
					<li class=add>
						<a href="<?php echo base_url('cart/add'.$url_param) ?>"><i class="fa fa-plus-circle" aria-hidden=true></i></a>
					</li>
					<?php endif ?>
				</ul>
				<?php endif ?>
			</div>

		</li>
		<?php endforeach ?>
	</ul>

	<div id=cart-actions>
		<a id=clear-cart title="清空购物车" href="<?php echo base_url('cart/clear') ?>">清空</a>
		<a id=create-order title="创建订单" href="<?php echo base_url('order/create') ?>">去下单</a>
	</div>

<?php endif ?>
</div>
