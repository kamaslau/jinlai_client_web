<style>
    .vote-option {width:100%;float:none;}
        .vote-option:nth-of-type(2n+0) {margin-left:0;}

        .option-figure {width:105px;height:105px;margin-top:0;border-radius:12px;overflow:hidden;float:left;}
            .option-figure figure {width:105px;height:105px;}
        .option-brief {margin-left:105px;}
            .option-rank {color:#fde101;font-size:24px;float:right;}

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

<div id=content>
	<?php if ( empty($item) ): ?>
	<p><?php echo $error ?></p>

	<?php else: ?>
    <!-- 背景音乐 -->
    <?php if ( ! empty($item['url_audio'])): ?>
    <audio id=vote-audio class=hide autoplay loop alt="背景音乐" src="<?php echo $item['url_audio'] ?>">您的浏览器不支持音频播放</audio>
    <div id=audio-control><i class="far fa-pause"></i></div>
    <?php endif ?>

    <!-- 投票活动信息 -->
    <div id=vote-info>
        <?php if ( empty($item['url_image']) ): ?>
        <h1 id=vote-name><?php echo $item['name'] ?></h1>
        <?php else: ?>
        <figure id=vote-url_image class=vote-figure>
            <img alt="<?php echo $item['name'] ?>形象图" src="<?php echo $item['url_image'] ?>">
        </figure>
        <?php endif ?>

        <div id=vote-brief>

            <div id=counter-container class=vote-time_end>
                <?php
                    // 根据当前时间判断以活动开始时间还是活动结束时间作为倒计时目标时间
                    $time_countdown_ends = (time() >= $item['time_start'])? $item['time_end']: $item['time_start'];
                    $countdown_text = (time() >= $item['time_start'])? '活动结束': '活动开始';
                ?>
                <p>距离<?php echo $countdown_text ?></p>
                <ul id=down-counter class=countdown>
                    <li>
                        <span class="days">00</span>
                        <p class="days_ref">天</p>
                    </li>
                    <li class="seperator">天</li>
                    <li>
                        <span class="hours">00</span>
                        <p class="hours_ref">小时</p>
                    </li>
                    <li class="seperator">:</li>
                    <li>
                        <span class="minutes">00</span>
                        <p class="minutes_ref">分钟</p>
                    </li>
                    <li class="seperator">:</li>
                    <li>
                        <span class="seconds">00</span>
                        <p class="seconds_ref">秒</p>
                    </li>
                </ul>
            </div>

            <script>
                $(function(){
                    $('#down-counter').downCount({
                        date: '<?php echo date('m/d/Y H:i:s', $time_countdown_ends) ?>',
                        offset: +8
                    }, function(){
                        alert('倒计时已结束，请刷新页面');
                    });
                });
            </script>
        </div>
    </div>

    <?php if ( ! empty($options)): ?>
    <div id=result-panel class=container>
        <h1>投票结果</h1>
        <ul id=vote-options>
            <?php
                // 候选项默认占位图
                $default_option_image = $item['url_default_option_image'];

                // 先显示前10名
                for ($i=0; $i<10; $i++):
                    $option = $options[$i];
            ?>
            <li class=vote-option>

                <a class=option-figure href="<?php echo base_url('vote_option/detail?id='.$option['option_id']) ?>">
                    <figure>
                        <img
                                class=lazyload
                                src="<?php echo $default_option_image ?>"
                                data-original="<?php echo !empty($option['url_image'])? MEDIA_URL.'vote_option/'.$option['url_image']: $default_option_image ?>"
                        >
                    </figure>
                </a>
                <div class=option-brief>
                    <div class=option-rank>第 <?php echo $i + 1 ?> 名</div>
                    <div class=option-id># <?php echo $option['option_id'] ?></div>
                    <h2 class=option-name><?php echo $option['name'] ?></h2>
                    <div class=ballot-count><?php echo $option['ballot_overall'] ?> 票</div>
                </div>

            </li>
            <?php endfor ?>
        </ul>
    </div>
    <?php endif ?>

    <?php endif ?>
</div>

<script defer src="<?php echo CDN_URL ?>jquery/jquery.downCount.js"></script>

<link rel=stylesheet media=all href="<?php echo CDN_URL ?>jquery/swiper.min.css">
<script defer src="<?php echo CDN_URL ?>jquery/swiper.min.js"></script>