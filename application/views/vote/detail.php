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

<script defer src="/js/vote.js"></script>
<script defer src="/js/jquery.downCount.js"></script>

<base href="<?php echo $this->media_root ?>">

<div id=content>
	<?php if ( empty($item) ): ?>
	<p><?php echo $error ?></p>

	<?php else: ?>

    <!-- 背景音乐 -->
    <?php if ( ! empty($item['url_audio'])): ?>
    <audio id=vote-audio class=hide autoplay loop alt="背景音乐" src="<?php echo $item['url_audio'] ?>">您的浏览器不支持音频播放</audio>
    <div id=audio-control>
        <i class="fa fa-pause"></i>
    </div>
    <?php endif ?>

    <div id=vote-info>
        <?php if ( empty($item['url_image']) ): ?>
        <h1 id=vote-name><?php echo $item['name'] ?></h1>
        <?php else: ?>
        <figure id=vote-url_image class=vote-figure>
            <img alt="<?php echo $item['name'] ?>形象图" src="<?php echo $item['url_image'] ?>">
        </figure>
        <?php endif ?>

        <div id=vote-brief>
            <?php if ($item['signup_allowed'] === '是'): ?>
            <a id=vote-signup href="<?php echo base_url('vote_option/create?vote_id='.$item['vote_id']) ?>">我要报名</a>
            <?php endif ?>

            <div id=counter-container class=vote-time_end>
                <p>距离投票结束<!--（<?php echo date('Y-m-d H:i:s', $item['time_end']) ?>）--></p>
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
                        date: '<?php echo date('m/d/Y H:i:s', $item['time_end']) ?>',
                        offset: +8
                    }, function(){
                        alert('活动已结束');
                    });
                });
            </script>

            <div id=vote-description>
                <?php echo $item['description'] ?>
                <p><?php echo ($item['max_user_total'] == 0)? NULL: '总共可投'.$item['max_user_total'].'票 / ' ?>每日<?php echo $item['max_user_daily'] ?>票（每选项限投<?php echo $item['max_user_daily_each'] ?>票）</p>
            </div>

            <a id=vote-article href="#vote-article-content" style="text-indent:-0.5em /*调整由于书名号引起的视觉上未居中问题*/">《匠心计划》助力政策</a>
        </div>

        <?php if ( ! empty($item['url_video']) ): ?>
        <figure id=url_video class=vote-figure>
            <video controls alt="<?php echo $item['name'] ?>形象视频" poster="<?php echo $item['url_video_thumb'] ?>" src="<?php echo $item['url_video'] ?>">您的浏览器不支持视频播放</video>
        </figure>
        <?php endif ?>

        <div id=vote-extra>
            <section>
                <p>【主办单位】 进来平台</p>
                <p>【参选对象】 青岛市范围内的优质商家</p>
                <p>【参评方式】 全网投放，线上线下征集商家，全民投票评选。</p>
                <p>【公开颁奖】 3月31日「进来」平台招商运营峰会，共同见证揭晓结果（15:00投票通道关闭），盛大仪式隆重颁奖。</p>
                <p>【投票规则】 每人每天10张选票，其中同一商家每天限投1次。</p>
            </section>

            <p class=strong>消费者可以根据参评商家的品牌、品质、服务、口碑、匠心、稀缺性等6个维度进行综合评选。</p>
        </div>
    </div>

    <div id=vote-searcher class=container>
        <i id=search-button class="fa fa-search" aria-hidden=true></i>
        <input name=content type=search placeholder="可根据商家名称或序号进行搜索" required>
    </div>

    <ul id=vote-options class=container>
        <?php foreach ($options as $option): ?>
        <li class=vote-option data-option_id="<?php echo $option['option_id'] ?>" data-option_name="<?php echo $option['name'] ?>">

            <div class=option-brief>
                <div class=option-id># <?php echo $option['option_id'] ?></div>
                <h2 class=option-name><?php echo $option['name'] ?></h2>
                <div class=ballot-count><span><?php echo $option['ballot_count'] ?></span> 票</div>
            </div>
            <a class=option-figure href="<?php echo base_url('vote_option/detail?id='.$option['option_id']) ?>">
                <figure>
                    <img src="<?php echo $option['url_image'] ?>">
                </figure>
            </a>
            <div class=option-actions>
                <?php
                    // 通用字符串
                    $common_params = 'vote_id='.$item['vote_id'].'&';
                    $common_attrs = 'data-vote_id='.$item['vote_id'].' data-option_id='.$option['option_id'];
                ?>
                <a <?php echo $common_attrs ?> href="<?php echo base_url('vote_option/detail?'.$common_params.'id='.$option['option_id']) ?>">拉票</a>
                <a <?php echo $common_attrs ?> href="<?php echo base_url('vote_ballot/create?'.$common_params.'option_id='.$option['option_id']) ?>">投票</a>
            </div>

        </li>
        <?php endforeach ?>
    </ul>

    <!--
        <div id=loader>
        <i class="fa fa-spin fa-refresh" aria-hidden=true></i>
    </div>
    -->
    <?php endif ?>
</div>