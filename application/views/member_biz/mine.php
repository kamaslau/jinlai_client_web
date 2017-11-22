	<style>
        body {background:#efefef;}
        .member_list {
        height:2.6rem;
            background-color:orange;
        /* background:url(<?php echo CDN_URL ?>media/member/tu1@3x.png); */
        position:relative;
        margin-bottom:.2rem;
	    background-size:contain;
        overflow:hidden;}
        .ui-loader {display:none;}

		.entermember {color:#9fa0a0;}
    </style>

    <?php
        foreach ($items as $item):
            // 若未指定会员卡LOGO，使用商家LOGO
            $logo_url = MEDIA_URL. (!empty($item['member_logo_url'])? 'ornament_biz/'. $item['member_logo_url']: 'biz/'. $item['url_logo']);

            $inline_style = ''; // 根据商家店铺装修方案设置样式
            if ( !empty($item['vi_color_first']) )
                $inline_style .= 'background-color:#'.$item['vi_color_first'].';';
            if ( !empty($item['member_thumb_url']) )
                $inline_style .= 'background: url('. MEDIA_URL.'ornament_biz/'.$item['member_thumb_url']. ') no-repeat center center;';
    ?>

    <a class="entermember_wrap" href="<?php echo base_url('member_biz/detail?biz_id='.$item['biz_id']) ?>" target="_self">
        <div class="member_list wid710 auto border20" style="<?php echo $inline_style ?>">
            <div class="memberlistpic"<?php if (!empty($item['member_logo_url']) && !empty($item['vi_color_second'])) echo ' style="background-color:#'.$item['vi_color_second'].'"' ?>>
                <img src="<?php echo $logo_url ?>">
            </div>
            <h1><?php echo $item['brief_name'] ?></h1>
            <span class="entermember">我是会员</span>
            <div class="memberdescription">
                会员享特权,多重优惠抢不停!
            </div>
        </div>
	</a>

    <?php endforeach ?>