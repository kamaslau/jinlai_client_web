<style>
    <?php if ( !empty($item['ornament']['main_figure_url']) ): ?>
    body{
        background:#f2f2f3 url(<?php echo MEDIA_URL.'ornament_biz/'.$item['ornament']['main_figure_url'] ?>) no-repeat center top;
        background-size: contain;
    }
    <?php endif ?>

    <?php if ( !empty($item['ornament']['vi_color_first']) ): ?>
    .vipcard {background-color:#<?php echo $item['ornament']['vi_color_first'] ?>;}
    .equity i:before {color:#<?php echo $item['ornament']['vi_color_first'] ?>;}
    <?php endif ?>

    .ui-loader {display:none;}

    .enterstorebtn a {color:#fff;}
</style>

	<div class="storemainlogo">
        <img src="<?php echo MEDIA_URL.'biz/'. $item['url_logo'] ?>">
	</div>
	<div class="enterstorebtn">
        <a href="<?php echo base_url('biz/detail?id='.$item['biz_id']) ?>">进入店铺</a>
	</div>
	<div class="vipcard wid670 auto">
		<div class="storelogo fl">
            <img src="<?php echo MEDIA_URL.'biz/'. $item['url_logo'] ?>">
		</div>
		<div class="rule fr">
			查看条款  <i class=" icon-Arrow"></i>
		</div>
		<h2>申请成为<?php echo $item['brief_name'] ?>会员</h2>
		<div class="clearfix">
            <input name=mobile type=tel value="<?php echo $this->input->post('mobile')? set_value('mobile'): $this->input->cookie('mobile') ?>" size=11 pattern="\d{11}" placeholder="请输入您的常用手机号" required>
			<a href="<?php echo base_url('member_biz/joined?id='.$item['biz_id']) ?>">加入会员</a>
		</div>
		<p>
			* 若老会员绑定，需和线下会员预留手机号与姓名保持一致
			* 我已经阅读并了解此品牌基本网站条款条件,隐私政策及会员卡绑定协议,并且同意接受所有条款
		</p>
	</div>

	<div class="equity">
		<h2>成为会员可享权益</h2>
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