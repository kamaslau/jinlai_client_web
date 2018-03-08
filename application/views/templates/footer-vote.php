		</main>
<!-- End #maincontainer -->

        <div class=full-screen id=follow-guide>
            <div class=full-screen-container>
                <div class="full-screen-content">
                    <p>关注"进来商城"微信公众号即可参与投票</p>
                    <img alt="进来商城微信公众号" src="<?php echo base_url('/media/images/vote/qrcode_wechat_jinlai_client.png') ?>">

                    <a style="color:#333" href="<?php echo 'https://'. $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] ?>">我已关注</a>
                </div>
            </div>
        </div>

        <div class=full-screen id=signup-succeed>
            <div class=full-screen-container>
                <div class=full-screen-close>
                    <i class="far fa-times" aria-hidden=true></i>
                </div>

                <div class="full-screen-content">
                    <h3 class="full-screen-title">报名成功</h3>
                    <p>主办方将对被提名候选项进行审核，通过后该候选项即可参选</p>
                </div>
            </div>
        </div>

        <div class=full-screen id=vote-succeed>
            <div class=full-screen-container>
                <div class=full-screen-close>
                    <i class="far fa-times" aria-hidden=true></i>
                </div>

                <div class="full-screen-content">
                    <h3 class="full-screen-title">选TA成功</h3>
                    <p>选TA成功<br>点击右上角菜单分享本页面可以推荐TA</p>
                </div>
            </div>
        </div>

        <div class=full-screen id=share-guide>
            <div class=full-screen-container>
                <div class=full-screen-close>
                    <i class="far fa-times" aria-hidden=true></i>
                </div>

                <div class="full-screen-content">
                    <h3 class="full-screen-title">推荐TA</h3>
                    <p>点击右上角菜单分享本页面即可</p>
                </div>
            </div>
        </div>

        <div class=full-screen id=form-signup>
            <div class=full-screen-container>
                <div class=full-screen-close>
                    <i class="far fa-times" aria-hidden=true></i>
                </div>

                <div class=full-screen-content>
                    <h3 class=full-screen-title>参选报名</h3>

                    <?php
                    $attributes = array('class' => 'form-'.$this->class_name.'-create full-screen-form', 'role' => 'form');
                    echo form_open_multipart('vote_option/create?vote_id='.$item['vote_id'], $attributes);
                    ?>
                        <fieldset>
                            <div class=input-group>
                                <label for=name>候选项名称</label>
                                <div>
                                    <input name=name type=text placeholder="最多30个字" required value="<?php set_value('name') ?>">
                                </div>
                            </div>

                            <?php if ( ! empty($tags)): ?>
                            <div class=input-group>
                                <label for=tag_id>参选分类</label>
                                <div>
                                    <select name=tag_id required>
                                    <?php foreach($tags as $tag): ?>
                                        <option value="<?php echo $tag['tag_id'] ?>"><?php echo $tag['name'] ?></option>
                                    <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <?php endif ?>

                            <div class=input-group>
                                <label for=url_image>形象图</label>
                                <div>
                                    <?php
                                    require_once(APPPATH. 'views/templates/file-uploader.php');
                                    $name_to_upload = 'url_image';
                                    generate_html($name_to_upload, 'vote_option', FALSE);
                                    ?>
                                </div>
                            </div>

                            <div class=input-group>
                                <label for=description>描述</label>
                                <div>
                                    <textarea name=description rows=3 placeholder="最多100个字"><?php set_value('description') ?></textarea>
                                </div>
                            </div>
                        </fieldset>

                        <button type=submit>报名</button>
                    </form>

                    <!--
                    <hr>
                    <p class=form-hint>报名后主办方会对被提名的候选项进行审核，审核通过后该候选项即可参选；每位用户仅可提名1个候选项，投票期间若不再关注相关公众号则视为弃权，已提名候选项及所有选票将立即失效、永久销毁。</p>
                    -->
                </div>
            </div>
        </div>

        <div class=full-screen id=vote-article-content>
            <div class=full-screen-container>
                <div class=full-screen-close>
                    <i class="far fa-times" aria-hidden=true></i>
                </div>

                <div class=full-screen-content>
                    <p>【〈匠心计划〉助力政策】<br>
                        免费入住【进来】平台，Top10商家可免【进来】审核流程</p>
                    <h3>Top10资金助力：（同时可享资源助力）</h3>
                    <p>Top1：  88888元匠心助力金<br>
                    Top2：  38888元匠心助力金<br>
                    Top3：  18888元匠心助力金<br>
                    Top4- Top10：  8888元匠心助力金<br>
                    【进来】商家ToP10助力金申提规则（完成入驻流程、专款专用）：<br>
                    1. 用于助力企业品质、服务的建设与提升；<br>
                        2. 用于助力企业营销、运营。</p>

                    <h3>Top11- Top100资源助力：（完成入驻流程，仅限入选商家）</h3>
                    <p>1. 【进来】拥有用户15万+及自有媒介渠道粉丝10万+，可为入选商家提供品牌宣传、售卖及精准引流；<br>
                    2. 为入围商家深度品牌包装、策划、专属定制运营服务（含摄影、品牌价值深度挖掘、【进来】个性化店铺展示设计、活动策划、差异化营销）；<br>
                    3. 【进来】各类峰会、论坛优先为其提供品宣机会。旗下栏目《十二言》可为Top10商家做品牌深度价值专访、曝光及推广， Top11-Top100可在进来旗下栏目《十二言》进行曝光及推广；<br>
                    4. 可携手商家共享进来线下战略合作资源体系（海信地产27个高端社区及多个物业社区，银海教育系统，海信广场双立人、菲仕乐等高端品牌战略合作）；<br>
                        5. 【进来】的战略合作伙伴中国银联、平安银行等金融机构为【进来】商家定制专属金融服务。
                    </p>
                </div>
            </div>
        </div>

		<script>
			$(function(){
				// 回到页首按钮
				$('a#totop').click(function()
				{
					$('body,html').stop(false, false).animate({scrollTop:0}, 800);
					return false;
				});
			});
		</script>
	</body>
</html>