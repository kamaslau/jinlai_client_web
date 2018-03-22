<style>

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

            <div id=vote-description>
                <?php echo $item['description'] ?>
            </div>

            <div id=info-actions>
                <a id=vote-article href="#vote-article-content" style="text-indent:-0.5em /*调整由于书名号引起的视觉上未居中问题*/">《匠心计划》助力政策</a>
                <a id=media-board href="#media-list">媒体矩阵</a>
            </div>
        </div>

        <?php if ( ! empty($item['url_video']) ): ?>
        <figure id=url_video class=vote-figure>
            <video controls alt="<?php echo $item['name'] ?>形象视频" poster="<?php echo $item['url_video_thumb'] ?>" src="<?php echo $item['url_video'] ?>">您的浏览器不支持视频播放</video>
        </figure>
        <?php endif ?>

        <div id=vote-extra>
            <section>
                <p>【参选对象】 青岛市范围内的优质商家</p>
                <p>【参评方式】 全网投放，线上线下征集商家，全民投票评选。</p>
                <p>【公开颁奖】 3月27日「进来」平台商家运营峰会，共同见证揭晓结果（15:00投票通道关闭），盛大仪式隆重颁奖。</p>
                <p>【投票规则】 <?php echo ($item['max_user_total'] == 0)? NULL: '总共可投'.$item['max_user_total'].'票，' ?>每人每天<?php echo $item['max_user_daily'] ?>张选票，同一商家每天限投<?php echo $item['max_user_daily_each'] ?>票。</p>
            </section>

            <p class=strong>消费者可以根据参评商家的品牌、品质、服务、口碑、匠心、稀缺性等6个维度进行综合评选。</p>
        </div>
    </div>

    <?php if ( ! empty($options)): ?>
    <!-- 投票候选项搜索 -->
    <div id=vote-searcher class=container>
        <div id=search-button>
            <i class="fal fa-search" aria-hidden=true></i>
        </div>
        <input name=content type=search placeholder="可根据候选项名称或序号进行搜索">
    </div>

        <?php if ( ! empty($tags)): ?>
        <!-- 投票候选项导航 -->
        <div id=options-naver class=container>
            <ul class=horizontal>
                <li><a href="#" data-tag_id=all>全部</a></li>

                <?php foreach ($tags as $tag): ?>
                <li><a href="#" data-tag_id="<?php echo $tag['tag_id'] ?>"><?php echo $tag['name'] ?></a></li>
                <?php endforeach ?>
            </ul>
        </div>
        <?php endif ?>

    <ul id=vote-options class=container>
        <?php
            // 候选项默认占位图
            $default_option_image = $item['url_default_option_image'];

            foreach ($options as $option):
        ?>
        <li
            class=vote-option
            data-tag_id="<?php echo $option['tag_id'] ?>"
            data-option_id="<?php echo $option['option_id'] ?>"
            data-option_name="<?php echo $option['name'] ?>"
        >

            <div class=option-brief>
                <div class=option-id># <?php echo $option['option_id'] ?></div>
                <h2 class=option-name><?php echo $option['name'] ?></h2>
                <div class=ballot-count><span><?php echo $option['ballot_overall'] ?></span> 票</div>
            </div>
            <a class=option-figure href="<?php echo base_url('vote_option/detail?id='.$option['option_id']) ?>">
                <figure>
                    <img
                        class=lazyload
                        src="<?php echo $default_option_image ?>"
                        data-original="<?php echo !empty($option['url_image'])? MEDIA_URL.'vote_option/'.$option['url_image']: $default_option_image ?>"
                    >
                </figure>
            </a>

        </li>
        <?php endforeach ?>
    </ul>
    <?php endif ?>

    <?php endif ?>
</div>

<ul id=naver-inpage>
    <li>
        <a id=tosearch href="#vote-searcher" data-target_dom_id=vote-searcher>
            <i class="fal fa-search" aria-hidden=true></i>
        </a>
    </li>
    <li>
        <a id=totop href="#main-container" data-target_dom_id=maincontainer>
            <i class="fal fa-arrow-to-top" aria-hidden=true></i>
        </a>
    </li>
</ul>

<script defer src="<?php echo CDN_URL ?>jquery/jquery.downCount.js"></script>
<script>
    $(function(){
        // 页面内跳转
        $('#naver-inpage a').click(function()
        {
            var target_id = $(this).attr('data-target_dom_id');

            scroll_to_dom(target_id, 'id', 20)

            // 若导航到的是搜索框，则将焦点移入搜索框
            if (target_id === 'vote-searcher'){
                $('#vote-searcher [type=search]').focus();
            }

            return false;
        });
    });
</script>