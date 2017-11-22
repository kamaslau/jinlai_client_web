<style>
    <?php if ( !empty($item['ornament']['main_figure_url']) ): ?>
    body{
        background:#f2f2f3 url(<?php echo MEDIA_URL.'ornament_biz/'.$item['ornament']['main_figure_url'] ?>) no-repeat center top;
        background-size: contain;
    }
    <?php endif ?>

    <?php if ( !empty($item['ornament']['member_figure_url']) ): ?>
    .vipcard {background:url(<?php echo MEDIA_URL.'ornament_biz/'.$item['ornament']['member_figure_url'] ?>) no-repeat center center;padding: 0px;height: 3.9rem;overflow: hidden;position: relative;}
    .vipcard p{
    	position: absolute;
    	width: 100%;
    	height: 1.2rem;
    	background: rgba(0,0,0,.2);
    	bottom: 0px;
    	padding-left: .4rem;
    	font-size: .2rem;
    	    line-height: 1.2rem;
    }
     .vipcard p span{
     	    width: .86rem;
		    height: .26rem;
		    line-height: .26rem;
		    font-size: .18rem;
		    display: inline-block;
     }
    <?php endif ?>

    <?php if ( !empty($item['ornament']['vi_color_first']) ): ?>
    .vipcard {background-color:#<?php echo $item['ornament']['vi_color_first'] ?>;background-size: contain;padding: 0px;height: 3.9rem;}
    .vipcard p span{color:#<?php echo $item['ornament']['vi_color_first'] ?>;}
    .equity i:before {color:#<?php echo $item['ornament']['vi_color_first'] ?>;}
    <?php endif ?>
    .vipcard{position: relative;overflow: hidden;padding: 0px;height: 3.9rem;}
    .ui-loader {display:none;}
	.vipcard p{margin-top: 0px;width: 100%;position: absolute;left:0px;height: 1.2rem;padding-left: .4rem;background: rgba(0,0,0,.2);bottom: 0px;}
    .enterstorebtn a {color:#fff;}
</style>

<?php
    // 若未指定会员卡LOGO，使用商家LOGO
    $logo_url = MEDIA_URL. (!empty($item['ornament']['member_logo_url'])? 'ornament_biz/'. $item['ornament']['member_logo_url']: 'biz/'. $item['url_logo']);
?>
	<div style="text-align: center;">
    <div class="storemainlogo">
		 <a href="<?php echo base_url('biz/detail?id='.$item['biz_id']) ?>" target="_self">
             <img src="<?php echo $logo_url ?>">
        </a>
	</div>
	</div>
	<div class="enterstorebtn">
        <a href="<?php echo base_url('biz/detail?id='.$item['biz_id']) ?>" target="_self">进入店铺</a>
	</div>

	<div class="vipcard wid670 auto">
		<!--<div class="storelogo fl">
            <img src="<?php echo $logo_url ?>">
		</div>
		<div class="rule fr">
            <?php echo $item['brief_name'] ?>
		</div>
		<div class="viptext">VIP<?php echo $member_biz['level'] ?></div>-->
		<p>
			Hi，<?php echo $this->session->nickname ?>
			<span>
				<!--VIP<?php echo $member_biz['level'] ?>-->
				普通会员
			</span>
		</p>
	</div>

	<div class=equity>
		<h2>
            我的特权
            <span>当前等级 普通会员</span>
            <span class="fr">解绑会员卡</span>
        </h2>
		
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
	<script>
// 		//$('.member_wrap').remove();
// 		// debugger;
// 		// function reurl(){ 
// 		// url = location.href; //把当前页面的地址赋给变量url 
// 		// var times = url.split('?'); //分切变量url分隔符号为“？” 
// 		// if(times[1]!= 1){//如果？后的值不等于1表示没有刷新
// 		// url +="？1"; //把变量url的值加入？1 
// 		// self.location.replace(url); //刷新页面
// } 
// } 

// reurl(); //执行这个函数
		
	</script>