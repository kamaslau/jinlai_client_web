<style>
	// 基本的响应式网页内嵌样式
	// 作为一个PHP开发框架，Basic只提供一个基本的前端页面示例
	// 当然这不妨碍我借着这个机会推广一下移动优先的响应式开发思路 lol

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

	<section id=list-biz>
		<?php if ( empty($bizs) ): ?>
		<blockquote>
			<p>一大波商家正在排队入驻中……</p>
		</blockquote>

		<?php else: ?>
		<ul class=row>
			<?php foreach ($bizs as $biz): ?>
			<li class="item col-xs-12">
				<a title="<?php echo $biz['name'] ?>" href="<?php echo base_url('biz/detail?id='.$biz['biz_id']) ?>">
					<figure class="image-main col-xs-12 col-sm-6 col-md-3">
						<img title="<?php echo $biz['name'] ?>" src="<?php echo $biz['url_logo'] ?>">
						<figcaption>
							<ul class=row>
								<li class="col-xs-6">
									<a title="收藏" href="<?php echo base_url('fav_biz/create?biz_id='.$biz['biz_id']) ?>" target=_blank><i class="fa fa-heart-o"></i> 收藏</a>
								</li>
							</ul>
						</figcaption>
					</figure>

					<section class="col-xs-12 col-sm-6 col-md-3">
						<h2 class=biz-name><?php echo $biz['name'] ?></h2>
					</section>
				</a>
			</li>
			<?php endforeach ?>
		</ul>

		<?php endif ?>
	</section>

</div>