		</main>
<!-- End #maincontainer -->

        <div class=full-screen id=follow-guide>
            <div class=full-screen-container>
                <div class="full-screen-content">
                    <p>关注"进来商城"微信公众号即可参与投票</p>
                    <img alt="进来商城微信公众号" src="<?php echo base_url('/media/images/vote/qrcode_wechat_jinlai_client.jpg') ?>">
                </div>
            </div>
        </div>

        <div class=full-screen id=vote-succeed>
            <div class=full-screen-container>
                <i class="full-screen-close fa fa-times" aria-hidden=true></i>

                <div class="full-screen-content">
                    <h3 class="full-screen-title">投票成功</h3>
                    <p>投票成功<br>点击右上角菜单分享本页面可以为我拉票</p>
                </div>
            </div>
        </div>

        <div class=full-screen id=share-guide>
            <div class=full-screen-container>
                <i class="full-screen-close fa fa-times" aria-hidden=true></i>

                <div class="full-screen-content">
                    <h3 class="full-screen-title">为我拉票</h3>
                    <p>点击右上角菜单分享本页面</p>
                </div>
            </div>
        </div>

        <div class=full-screen id=form-signup>
            <div class=full-screen-container>
                <i class="full-screen-close fa fa-times" aria-hidden=true></i>

                <div class=full-screen-content>
                    <h3 class=full-screen-title>报名参选</h3>
                    <?php
                    $attributes = array('class' => 'form-'.$this->class_name.'-create full-screen-form', 'role' => 'form');
                    echo form_open_multipart('vote_option/create?vote_id='.$item['vote_id'], $attributes);
                    ?>
                        <fieldset>
                            <div class=form-group>
                                <label for=url_image>形象图</label>
                                <?php
                                require_once(APPPATH. 'views/templates/file-uploader.php');
                                $name_to_upload = 'url_image';
                                generate_html($name_to_upload, $this->class_name, FALSE);
                                ?>
                            </div>

                            <div class=form-group>
                                <label for=name>候选项名称</label>
                                <input name=name type=text placeholder="最多30个字符" required value="<?php set_value('name') ?>">
                            </div>

                            <div class=form-group>
                                <label for=description>描述</label>
                                <textarea name=description rows=3 placeholder="最多100个字符"><?php set_value('description') ?></textarea>
                            </div>
                        </fieldset>

                        <button type=submit>报名</button>
                    </form>
                </div>
            </div>
        </div>

        <div class=full-screen id=vote-article-content>
            <div class=full-screen-container>
                <i class="full-screen-close fa fa-times" aria-hidden=true></i>

                <div class="full-screen-content">
                    <p>【〈匠心计划〉助力政策】<br>
    免费入住【进来】平台，Top10商家可免【进来】审核流程<br>
    Top10资金助力：（同时可享资源助力）<br>
    Top1：  88888元匠心助力金<br>
    Top2：  38888元匠心助力金<br>
    Top3：  18888元匠心助力金<br>
    Top4- Top10：  8888元匠心助力金<br>
    【进来】商家ToP10助力金申提规则（完成入驻流程、专款专用）：<br>
    1. 用于助力企业品质、服务的建设与提升；<br>
    2. 用于助力企业营销、运营。<br>

    Top11- Top100资源助力：（完成入驻流程，仅限入选商家）<br>
    1. 【进来】拥有用户15万+及自有媒介渠道粉丝10万+，可为入选商家提供品牌宣传、售卖及精准引流；<br>
    2. 为入围商家深度品牌包装、策划、专属定制运营服务（含摄影、品牌价值深度挖掘、【进来】个性化店铺展示设计、活动策划、差异化营销）；<br>
    3. 【进来】各类峰会、论坛优先为其提供品宣机会。旗下栏目《十二言》可为Top10商家做品牌深度价值专访、曝光及推广， Top11-Top100可在进来旗下栏目《十二言》进行曝光及推广；<br>
    4. 可携手商家共享进来线下战略合作资源体系（海信地产27个高端社区及多个物业社区，银海教育系统，海信广场双立人、菲仕乐等高端品牌战略合作）。
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