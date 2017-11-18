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
    </style>
	<!--头部title区域开始-->
	<div class="member_title" style="display:none">
		<i class="icon-back fl"></i>
		会员
		<i class="icon-huiyuan fr"></i>
		
	</div>
    <?php
        foreach ($items as $item):
            $inline_style = '';
            if ( !empty($item['vi_color_first']) )
                $inline_style .= 'background-color:#'.$item['vi_color_first'].';';
            if ( !empty($item['member_thumb_url']) )
                $inline_style .= 'background: url('. MEDIA_URL.'ornament_biz/'.$item['member_thumb_url']. ') no-repeat center center;';
    ?>

    <a class="entermember_wrap" href="<?php echo base_url('member_biz/detail?id='.$item['biz_id']) ?>" target="_self">
        <div class="member_list wid710 auto border20" style="<?php echo $inline_style ?>">
            <div class="memberlistpic">
                <img src="<?php echo MEDIA_URL.'biz/'. $item['url_logo'] ?>">
            </div>
            <h1><?php echo $item['brief_name'] ?></h1>
            <span class="entermember">加入会员</span>
            <div class="memberdescription">
                会员享特权,多重优惠抢不停!
            </div>
        </div>
	</a>

    <?php endforeach ?>