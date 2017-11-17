<style>
    <?php if ( !empty($item['ornament']['main_figure_url']) ): ?>
    body{
        background:#f2f2f3 url(<?php echo MEDIA_URL.'ornament_biz/'.$item['ornament']['main_figure_url'] ?>) no-repeat center top;
        background-size: contain;
    }
    <?php endif ?>

    <?php if ( !empty($item['ornament']['member_figure_url']) ): ?>
    .vipcard {background:url(<?php echo MEDIA_URL.'ornament_biz/'.$item['ornament']['member_figure_url'] ?>) no-repeat center center;}
    <?php endif ?>

    <?php if ( !empty($item['ornament']['vi_color_first']) ): ?>
    .vipcard {background-color:#<?php echo $item['ornament']['vi_color_first'] ?>;background-size: contain;}
    .equity i:before {color:#<?php echo $item['ornament']['vi_color_first'] ?>;}
    <?php endif ?>

    .ui-loader {display:none;}
	.vipcard p{margin-top: 0px;}
    .enterstorebtn a {color:#fff;}
</style>

	<div class="storemainlogo">
		 <a href="<?php echo base_url('biz/detail?id='.$item['biz_id']) ?>" target="_self">
        	<img src="<?php echo MEDIA_URL.'biz/'. $item['url_logo'] ?>">
        </a>
	</div>
	<div class="enterstorebtn">
        <a href="<?php echo base_url('biz/detail?id='.$item['biz_id']) ?>" target="_self">进入店铺</a>
	</div>
	<div class="vipcard wid670 auto" style="background:url(<?php echo MEDIA_URL.'ornament_biz/'.$item['ornament']['member_figure_url'] ?>) no-repeate center center">
		<div class="storelogo fl">
            <img src="<?php echo MEDIA_URL.'biz/'. $item['url_logo'] ?>">
		</div>
		<div class="rule fr">
            <?php echo $item['brief_name'] ?>
		</div>
		<div class="viptext">VIP</div>
		<p>
			Hi，<?php echo $this->session->nickname ?>
			<span>普通会员</span>
		</p>
	</div>
	<div class="equity">
		<h2>我的特权<span>当前等级普通会员</span><span class="fr">解绑会员卡</span></h2>
		
	    <ul>
			<li>
				<a>
					<i class="icon-xiaoxi"></i>
				</a>
				<span>活动提前通知</span>
			</li>
			<li>
				<a>
					<i class="icon-xinpin"></i>
				</a>
				<span>95折享新品</span>
			</li>
			<li>
				<a>
					<i class="icon-jifen2"></i>
				</a>
				<span>入会送积分</span>
			</li>
			<li>
				<a>
					<i class="icon-gouwu"></i>
				</a>
				<span>购物送积分</span>
			</li>
		</ul>
	</div>