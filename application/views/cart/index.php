<style>
	#header {display:none;}

	#list-cart {}

	.cart-items>li {background-color:#fff;margin-bottom:10px;padding:0.5em;}
		.cart-items>li>* {padding-right:0;}

	.main-images {padding:0;}
		.main-images img {display:block;height:100%;}

	.price>* {font-size:18px;text-align:right;}
		.price strong {color:#1aad19;}

	.actions {border-top:1px solid #9ed99d;padding:0;margin:0;margin-top:0.5em;overflow:hidden;}
		.actions>li {width:50%;height:36px;line-height:36px;padding:0;}
			.actions>li:first-of-type {border-right:1px solid #9ed99d;}
			.actions>li a {text-align:center;display:block;width:100%;height:100%;}
			a.add {color:#fff;font-size:20px;background-color:#9ed99d;}
			a.remove {color:rgba(0, 0, 0, 0.3);font-size:18px;}
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
	});
</script>

<?php if ($this->session->mobile === '17664073966') var_dump($this->session->cart) ?>

<div id=content class=container>
	<?php if ( !empty($content) ) echo '<p class="bg-info text-info text-center">'.$content.'</p>'; ?>

<?php if ( empty($this->session->cart) ): ?>
	<p>购物车竟然是空的</p>
	<p>再忙，也要记得买点什么犒赏自己~</p>

<?php else: ?>
	<?php foreach ($bizs as $biz): ?>
	<section style="border:2px solid red" class=biz data-biz-id="<?php echo $biz['biz_id'] ?>">
		<h2>
			<a title="<?php echo $biz['name'] ?>" href="<?php echo base_url('biz/detail?id='.$biz['biz_id']) ?>">
				<?php echo $biz['name'] ?>
			</a>
		</h2>
	</section>
	<?php endforeach ?>
	
	<ul id=list-cart>
	<?php
		foreach ($items as $item):

		// 生成操作参数
		$url_param = '?';
		// 初始化有效性
		$is_valid = TRUE;
		
		// TODO 判断店铺状态是否正产，若正常则获取biz_id
		if ( TRUE ):
			$url_param .= 'biz_id='.$item['biz_id'];
		else:
			$is_valid = FALSE;
		endif;

		// 判断商品是否在售，库存是否足够，若正常则获取item_id
		if ( $item['time_publish'] !== NULL && $item['stocks'] > $item['count'] ):
			$url_param .= '&item_id='.$item['item_id'];
		else:
			$is_valid = FALSE;
		endif;

		// 判断是否存在SKU
		if ( isset($item['sku']) ):
			// 判断SKU库存是否足够，若正常则获取sku_id
			if ( $item['sku']['stocks'] > $item['count'] ):
				$url_param .= '&sku_id='.$item['sku']['sku_id'];
			else:
				$is_valid = FALSE;
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
				<?php if ($is_valid === TRUE): ?>
				<h2 class=item-name>
					<a href="<?php echo base_url('item/detail?id='.$item['item_id']) ?>">
						<?php echo $item['name'] ?>
					</a>
				</h2>
				<?php else: ?>
				<h2>
					<span class="label label-default">已失效</span> <?php echo $item['name'] ?>
				</h2>
				<?php endif ?>
			</section>

			<!-- 价格相关 -->
			<ul class="price list-unstyled col-xs-4">
				<li><strong>￥ <?php echo $item['price'] ?></strong> &times; <?php echo $item['count'] ?></li>
			</ul>

			<!-- 数量调整 -->
			<?php if ($is_valid === TRUE): ?>
			<ul class="actions list-unstyled list-inline col-xs-12 row">
				<li class="col-xs-6">
					<a class=remove href="<?php echo base_url('cart/remove'.$url_param) ?>"><i class="fa fa-minus-circle" aria-hidden=true></i></a>
				</li>

				<li class="col-xs-6">
					<a class=add href="<?php echo base_url('cart/add'.$url_param) ?>"><i class="fa fa-plus-circle" aria-hidden=true></i></a>
				</li>
			</ul>
			<?php endif ?>
		</li>

		<?php endforeach ?>
	</ul>

	<ul id=cart-actions class=row>
		<li class="col-xs-12 col-sm-offset-2 col-sm-2">
			<a class="btn btn-primary btn-lg btn-block" title="创建订单" href="<?php echo base_url('order/create') ?>">去下单</a>
	    </li>
	    <li class="col-xs-12 col-sm-offset-2 col-sm-2">
			<a class="btn btn-warning btn-lg btn-block" title="清空购物车" href="<?php echo base_url('cart/clear') ?>">清空</a>
	    </li>
	</ul>

<?php endif ?>
</div>
