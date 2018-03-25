<style>
    h1 {color:#e9c387;font-size:58px;text-align:center;}
        h1>span {display:block;font-size:26px;}

    #result-panel {margin-top:36px;overflow:hidden;}
        #result-panel>* {background-color:#a42535;border:1px solid #b12839;border-radius:15px;box-shadow:0 0 8px 0 #81131c;}
        #other-options {margin-top:20px;}

    .vote-option {color:#fff;background-color:transparent;font-size:28px;width:100%;padding:20px 0;border:0;border-bottom:1px solid #901824;border-radius:0;box-shadow:none;float:none;}
    .vote-option:last-child {border:0;}
    .vote-option:nth-of-type(2n+0) {margin-left:0;}
    #ace-options .vote-option:first-child {background:url('/media/images/vote/ranking_1.png') no-repeat right 36px;background-size:40px 50px;}
    #ace-options .vote-option:nth-child(2) {background:url('/media/images/vote/ranking_2.png') no-repeat right 36px;background-size:40px 50px;}
    #ace-options .vote-option:nth-child(3) {background:url('/media/images/vote/ranking_3.png') no-repeat right 36px;background-size:40px 50px;}

    .option-figure {width:105px;height:105px;margin-top:0;border-radius:12px;overflow:hidden;float:left;}
    .option-figure figure {width:100%;height:100%;}
    .option-brief {font-size:24px;margin-left:102px;padding-top:8px;position:relative;}
    #other-options .option-brief {margin-left:0;}
    .option-brief>.ballot-count {margin-bottom:0;}
    .option-brief>.option-name {height:24px;margin-bottom:20px;}
    .option-rank {color:#fde101;position:absolute;right:0;top:8px;}

    /* 宽度在750像素以上的设备 */
    @media only screen and (min-width:751px)
    {
        body {width:100%;padding:52px 2.4% 58px;}

        #counter-container {width:562px;margin:36px auto 0;}

        #result-panel {border:1px solid #b12839;border-radius:15px;box-shadow:0 0 8px 0 #81131c;padding:0;}
            #result-panel>* {display:inline-block;border:0;border-radius:0;box-shadow:none;}
            #ace-options {width:72%;float:left;overflow:hidden;margin-bottom:48px;border-right:1px solid #cb495a;padding:68px 96px 20px;
                -webkit-column-count:2;
                -moz-column-count:2;
                column-count:2;
                -webkit-column-gap:75px;
                -moz-column-gap:75px;
                column-gap:75px;}
            #other-options {background-color:#941f2e;width:28%;float:right;height:748px;overflow-y:scroll;margin-top:0;padding:68px 72px;}
                #other-options .vote-option {margin-bottom:0;}
                #other-options h1 {display:none;}

                .vote-option {border:0;padding:0;}

                    .option-figure {width:84px;height:84px;}
    }
</style>

<base href="<?php echo $this->media_root ?>">

<div id=content>
    <?php if ( empty($item) ): ?>
        <p><?php echo $error ?></p>

    <?php else: ?>
        <!-- 投票活动信息 -->
        <div id=vote-info>
            <?php if ($this->user_agent['is_desktop']): ?>
                <h1>投票结果<span>VOTING RESULTS</span></h1>
            <?php else: ?>
                <figure id=vote-url_image class=vote-figure>
                    <img alt="<?php echo $item['name'] ?>形象图" src="<?php echo $item['url_image'] ?>">
                </figure>
            <?php endif ?>

            <div id=vote-brief>
                <?php if (time() < $item['time_end']): ?>
                    <div id=counter-container class="vote-time_end center_x">
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
                                window.location.reload()
                            });
                        });
                    </script>
                <?php endif ?>
            </div>
        </div>

        <?php
        if ( ! empty($options)):
            // 候选项默认占位图
            $default_option_image = $item['url_default_option_image'];
            ?>
            <div id=result-panel class=container>
                <ul id=ace-options>
                    <?php
                    // 突出显示前10名之内
                    $ace_counts = (count($options) >= 10)? 10: count($options);

                    for ($i=0; $i<$ace_counts; $i++):
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
                                <h2 class=option-name><?php echo $option['name'] ?></h2>
                                <div class=ballot-count><?php echo $option['ballot_overall'] ?> 票</div>
                                <div class=option-rank>第 <?php echo $i + 1 ?> 名</div>
                            </div>

                        </li>
                    <?php endfor ?>
                </ul>

                <?php if (count($options) > $ace_counts): ?>
                    <div id=other-options class=swiper-container>
                        <h1>TOP11 - 100</h1>
                        <ul class=swiper-wrapper>
                            <?php
                            for ($i=$ace_counts; $i<count($options); $i++):
                                $option = $options[$i];
                                ?>
                                <li class="vote-option swiper-slide">

                                    <div class=option-brief>
                                        <h2 class=option-name><?php echo $option['name'] ?></h2>
                                        <div class=ballot-count><?php echo $option['ballot_overall'] ?>票</div>
                                        <div class=option-rank>第<?php echo $i + 1 ?>名</div>
                                    </div>

                                </li>
                            <?php endfor ?>
                        </ul>
                    </div>
                <?php endif ?>
            </div>
        <?php endif ?>

    <?php endif ?>
</div>

<?php if (time() < $item['time_end']): ?>
    <script defer src="<?php echo CDN_URL ?>jquery/jquery.downCount.js"></script>

<?php elseif ($this->user_agent['is_desktop']): ?>
    <link rel=stylesheet media=all href="<?php echo CDN_URL ?>jquery/swiper.min.css">
    <script defer src="<?php echo CDN_URL ?>jquery/swiper.min.js"></script>
    <script>
        window.onload = function() {
            var swiper = new Swiper('.swiper-container', {
                //loop: true,
                direction: 'vertical',
                slidesPerView: 6,
                slidesPerGroup: 3,
                autoHeight: true, //enable auto height
                autoplay: {
                    delay: 4500,
                    disableOnInteraction: true,
                }
            });
        }
    </script>
<?php endif ?>