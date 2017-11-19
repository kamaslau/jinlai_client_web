	<style>
		body{
			background: #eaeaea;
		}
		span,div,p,li,a,i,b{
			 -webkit-touch-callout:none;  /*系统默认菜单被禁用*/     
    -webkit-user-select:none; /*webkit浏览器*/     
    -khtml-user-select:none; /*早期浏览器*/     
    -moz-user-select:none;/*火狐*/     
    -ms-user-select:none; /*IE10*/     
    user-select:none;  
		}
		input[type="checkbox"]{-webkit-appearance:none;outline: none;border:none}
input.check{
	background:url(<?php echo CDN_URL ?>media/cart/icon/icon_radio3.png) no-repeat center left;  
	 background-size: cover;
    position: absolute;
    top: 50%;
    left: 10px;
    margin-top: -.21rem;
    width: .42rem;
    height: .42rem;
 }
.ui-loader{
display: none;}
input.check:checked{
	background:url(<?php echo CDN_URL ?>media/cart/icon/icon_radio4.png) no-repeat center left;
	background-size:20px 20px;
	}
input.goodsCheck:checked{
	background:url(<?php echo CDN_URL ?>media/cart/icon/icon_radio4.png) no-repeat center left;
	background-size:20px 20px;
	}
input.check:checked{
	background:url(<?php echo CDN_URL ?>media/cart/icon/icon_radio4.png) no-repeat center left;    
	background-size: cover;
    position: absolute;
    top: 50%;
    left: 10px;
    margin-top: -.21rem;
    width: .42rem;
    height: .42rem;
    }
.checked{
	background:url(<?php echo CDN_URL ?>media/cart/icon/icon_radio4.png) no-repeat left center;
	background-size:20px 20px;
	position:absolute;
	top:50%;
	left:15px;
	margin-top:-18px;
	width:20px;
	height:35px;
	}
.usercenter{
	background-size:cover ;
	height: 3.5rem;
	background:url(<?php echo CDN_URL ?>media/account/mine/beijing@3x.png) no-repeat center left ;
	    border-bottom-left-radius: .35rem;
    border-bottom-right-radius: .35rem;
    overflow: hidden;
}
	</style>
<!--tab切换content区域-->
		<div class="tabcontent" id="list">
			<div class="item" style="display: block;">
				<!--菜单区域开始-->
				<div class="menuOuter">
				<div class="swiper-container">
				<div class="swiper-wrapper">
					<div class="menuWrap auto clearfix swiper-slide">
					<ul class="clearfix">
						<li>
                            <a href="<?php echo base_url('page/detail?id=2') ?>" target=_self>
                                <!--图标-->
                                <div class="iconWrap">
                                    <img data-src="<?php echo CDN_URL ?>media/home/shengxianchaoshi@3x.png">
                                </div>
                                <!--文字-->
                                <span class="text">生鲜超市</span>
                            </a>
						</li>
						<li>
                            <a href="<?php echo base_url('page/detail?id=4') ?>" target=_self>
                                <!--图标-->
                                <div class="iconWrap2">
                                    <img data-src="<?php echo CDN_URL ?>media/home/jiankangjiaoyu@3x.png">
                                </div>
                                <!--文字-->
                                <span class="text">健康教育</span>
                            </a>
						</li>
						<li>
                            <a href="<?php echo base_url('page/detail?id=3') ?>" target=_self>
                                <!--图标-->
                                <div class="iconWrap3">
                                    <img data-src="<?php echo CDN_URL ?>media/home/gesemeishi@3x.png">
                                </div>
                                <!--文字-->
                                <span class="text">各色美食</span>
                            </a>
						</li>
						<li>
                            <a href="<?php echo base_url('page/detail?id=5') ?>" target=_self>
                                <!--图标-->
                                <div class="iconWrap4">
                                    <img data-src="<?php echo CDN_URL ?>media/home/shishangyule@3x.png">
                                </div>
                                <!--文字-->
                                <span class="text">时尚娱乐</span>
                            </a>
						</li>
						<li style="margin-right:0">
                            <a href="<?php echo base_url('page/detail?id=2') ?>" target=_self>
                                <!--图标-->
                                <div class="iconWrap5">
                                    <img data-src="<?php echo CDN_URL ?>media/home/zhinengjiaju@3x.png">
                                </div>
                                <!--文字-->
                                <span class="text">智能家居</span>
                            </a>
						</li>
						<li>
							<!--图标-->
							<a href="https://www.517ybang.com/coupon_template/index" target="_self">
                                <div class="iconWrap6">
                                    <img data-src="<?php echo CDN_URL ?>media/home/lingquanzhongxin@3x.png">
                                </div>

                                <!--文字-->
                                <span class="text">领券中心</span>
                            </a>
						</li>
						<li>
							<!--图标-->
							<div class="iconWrap7">
								<img data-src="<?php echo CDN_URL ?>media/home/yaoqinghaoyou@3x.png">
							</div>
							<!--文字-->
							<span class="text">邀请好友</span>
						</li>
						<li>
							<!--图标-->
							<a href="https://biz.517ybang.com/biz/create" target="_self">
								<div class="iconWrap8">
									<img data-src="<?php echo CDN_URL ?>media/home/woyaoruzhu@3x.png">
								</div>
							</a>
							<!--文字-->
							<span class="text">我要入驻</span>
						</li>
						<li>
							<!--图标-->
							<div class="iconWrap9">
								<img data-src="<?php echo CDN_URL ?>media/home/zaixianpintuantime@3x.png">
							</div>
							<!--文字-->
							<span class="text">在线拼团</span>
						</li>
						<li style="margin-right:0">
							<!--图标-->
							<div class="iconWrap10">
							<img data-src="<?php echo CDN_URL ?>media/home/chakangengduo@3x.png">
							</div>
							<!--文字-->
							<span class="text">查看更多</span>
						</li>
					</ul>
				</div>
				<div class="menuWrap auto clearfix swiper-slide">
					<ul class="clearfix">
						<li>
                            <a href="<?php echo base_url('page/detail?id=2') ?>">
                                <!--图标-->
                                <div class="iconWrap">
                                    <div class="menuicon bg1">
                                        <i class="icon iconfont icon-putao"></i>
                                    </div>
                                </div>
                                <!--文字-->
                                <span class="text">进来生鲜</span>
                            </a>
						</li>
						<li>
							<!--图标-->
							<div class="iconWrap2">
								<div class="menuicon2 bg2">
									<i class="icon iconfont icon-putao"></i>
								</div>
							</div>
							<!--文字-->
							<span class="text">进来生鲜</span>
						</li>
						<li>
							<!--图标-->
							<div class="iconWrap3">
								<div class="menuicon3 bg3">
									<i class="icon iconfont icon-iconcopy"></i>
								</div>
							</div>
							<!--文字-->
							<span class="text">进来生鲜</span>
						</li>
						<li>
							<!--图标-->
							<div class="iconWrap4">
								<div class="menuicon4 bg4">
									<i class="icon iconfont icon-ruanxiangjiao"></i>
								</div>
							</div>
							<!--文字-->
							<span class="text">进来生鲜</span>
						</li>
						<li style="margin-right:0">
							<!--图标-->
							<div class="iconWrap5">
								<div class="menuicon5 bg5">
									<i class="icon iconfont icon-ruanxiangjiao"></i>
								</div>
							</div>
							<!--文字-->
							<span class="text">进来生鲜</span>
						</li>
						<li>
							<!--图标-->
							<div class="iconWrap6">
								<div class="menuicon6 bg6">
									<i class="icon iconfont icon-ruanxiangjiao"></i>
								</div>
							</div>
							<!--文字-->
							<span class="text">进来生鲜</span>
						</li>
						<li>
							<!--图标-->
							<div class="iconWrap7">
								<div class="menuicon7 bg7">
									<i class="icon iconfont icon-ruanxiangjiao"></i>
								</div>
							</div>
							<!--文字-->
							<span class="text">进来生鲜</span>
						</li>
						<li>
							<!--图标-->
							<div class="iconWrap8">
								<div class="menuicon8 bg8">
									<i class="icon iconfont icon-putao"></i>
								</div>
							</div>
							<!--文字-->
							<span class="text">进来生鲜</span>
						</li>
						<li>
							<!--图标-->
							<div class="iconWrap9">
								<div class="menuicon9 bg9">
									<i class="icon iconfont icon-ruanxiangjiao"></i>
								</div>
							</div>
							<!--文字-->
							<span class="text">进来生鲜</span>
						</li>
						<li style="margin-right:0">
							<!--图标-->
							<div class="iconWrap10">
								<div class="menuicon10 bg10">
									<i class="icon iconfont icon-ruanxiangjiao"></i>
								</div>
							</div>
							<!--文字-->
							<span class="text">进来生鲜</span>
						</li>
					</ul>
				</div>
			</div>
			<!-- Add Pagination -->
	      <div class="swiper-pagination"></div>
			</div>
			</div>
				<!--广告图区域-->
				<div class="addpic auto">
					<a href="https://www.517ybang.com/biz/detail?id=13" target="_self">
					<img data-src="<?php echo CDN_URL ?>media/home/banner@3x.png" />
					</a>
				</div>
				<!--公告文字区域开始-->
				<div class="announcement auto">
					<!--左边图片区域-->
					<div class="pic">
						<img src="<?php echo CDN_URL ?>media/home/title.png" />
					</div>
					<div class="line"></div>
					<!--右边文字部分-->
					<div class="text" id="news">
						<ul class="clearfix">
							<li>
								<a href="###">
								<span class="cir"></span><span class="listr">注册送188新人礼包,绑定红卡惊喜不断</span>
								</a>
							</li>
							<li>
								<a href="###">
								<span class="cir"></span><span class="listr">路易威登成功入进来</span>
								</a>
							</li>
							<li>
								<a href="###">
								<span class="cir"></span>
								<span class="listr">中共十九大</span>
								</a>
							</li>
							<li>
								<a href="###">
								<span class="cir"></span>
								<span class="listr">积极促进一带一路</span>
								</a>
							</li>
							<li>
								<a href="###">
								<span class="cir"></span><span class="listr">进来,上新</span>
								</a>
							</li>
							<li>
								<a href="###">
								<span class="cir"></span><span class="listr">进来成功在纳斯达克上市</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<!--水果图片区域开始-->
				<div class="fruidWrap clearfix auto">
					<ul>
						<li>
							<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
							<img data-src="<?php echo CDN_URL ?>media/home/jianhuo@3x.png" />
							</a>
						</li>
						<li>
							<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
							<img data-src="<?php echo CDN_URL ?>media/home/jianhuo_putao@3x.png" />
							</a>
						</li>
						<li style="margin-right:0">
							<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
							<img data-src="<?php echo CDN_URL ?>media/home/jianhuo_mangguo@3x.png" />
							</a>
						</li>
					</ul>
				</div>
				<!--新品上新图片-->
				<div class="newgoodspic auto">
					<img data-src="<?php echo CDN_URL ?>media/home/xinpinshangxin/xinpinshangxin@3x.png" />
				</div>
				<!--新品上新商品区域开始-->
				<div class="newgoodslist auto clearfix">
					<div class="twocol clearfix">
						<div class="goodsleft">
							<ul class="clearfix">
								<li>
									<a href="https://www.517ybang.com/item/detail?id=2" target="_self">
									<div class="pic">
										
										<img data-src="<?php echo CDN_URL ?>media/home/xinpinshangxin/xpsx156/156x156.jpg" />
										
									</div>
									</a>
									<p>IPhone7红色版</p>
									<span>¥3,900</span>
								</li>
								<li style="margin-left: .3rem;">
									<a href="https://www.517ybang.com/item/detail?id=2" target="_self">
									<div class="pic">
										<img data-src="<?php echo CDN_URL ?>media/home/xinpinshangxin/xpsx156/156x156_1.jpg" />
									</div>
										</a>
									<p>IPhone7红色版</p>
									<span>¥3,900</span>
								</li>
							</ul>
						</div>
						<div class="goodsleft" style="margin-left:.1rem">
							<ul class="clearfix">
								<li>
									<a href="https://www.517ybang.com/item/detail?id=2" target="_self">
									<div class="pic">
										
										<img data-src="<?php echo CDN_URL ?>media/home/xinpinshangxin/xpsx156/156x156_2.jpg" />
									</div>
									</a>
									<p>IPhone7红色版</p>
									<span>¥3,900</span>
								</li>
								<li style="margin-left: .3rem;">
									<a href="https://www.517ybang.com/item/detail?id=2" target="_self">
									<div class="pic">
										<img data-src="<?php echo CDN_URL ?>media/home/xinpinshangxin/xpsx156/156x156_3.jpg" />
									</div>
									</a>
									<p>IPhone7红色版</p>
									<span>¥3,900</span>
								</li>
							</ul>
						</div>
					</div>
					<div class="threecol">
						<ul>
							<li>
								<a href="https://www.517ybang.com/item/detail?id=2" target="_self">
								<div class="pic">
									<img data-src="<?php echo CDN_URL ?>media/home/xinpinshangxin/xpsx160/160x160_0.jpg" />
								</div>
								</a>
								<p>IPhone8</p>
								<span>¥9985</span>
							</li>
							<li>
								<a href="https://www.517ybang.com/item/detail?id=2" target="_self">
								<div class="pic">
									<img data-src="<?php echo CDN_URL ?>media/home/xinpinshangxin/xpsx160/160x160_1.jpg" />
								</div>
								</a>
								<p>IPhone8</p>
								<span>¥9985</span>
							</li>
							<li style="margin-right:0">
								<a href="https://www.517ybang.com/item/detail?id=2" target="_self">
								<div class="pic">
									<img data-src="<?php echo CDN_URL ?>media/home/xinpinshangxin/xpsx160/160x160_2.jpg" />
								</div>
								</a>
								<p>IPhone8</p>
								<span>¥9985</span>
							</li>
						</ul>
					</div>
				</div>
				<!--在线拼团区域开始-->
				<div class="onlinegroup clearfix">
					<div class="newgoodspic auto">
						<img data-src="<?php echo CDN_URL ?>media/home/zaixianpintuan/zaixianpintuan@3x.png">
					</div>
					<!--在线拼团商品详情区域-->
					<div class="onlinegroupcontent wid718 auto mt10">
						<div class="onlinegoodsleft">
							<!--倒计时区域-->
							<div class="time"></div>
							<a href="https://www.517ybang.com/item/detail?id=2" target="_self">
							<div class="pic">
								<img data-src="<?php echo CDN_URL ?>media/home/zaixianpintuan/240x240.jpg"/>
							</div>
							</a>
							<h1>OMG超霸系列</h1>
							<h2>同轴设计时腕表</h2>
							<p>
								<span class="fl">¥4587</span>
								<span class="fr">¥17,988</span>
							</p>
						</div>
						<div class="onlinegoodsright fr">
							<div class="onlinegoodstop">
								<ul>
									<li>
										<a href="https://www.517ybang.com/item/detail?id=2" target="_self">
										<div class="pic">
											<img data-src="<?php echo CDN_URL ?>media/home/zaixianpintuan/zxpt/140x140_0.jpg"/>
										</div>
										</a>
										<h1>日本阳光红富士</h1>
										<h2>¥9.9/斤</h2>
									</li>
									<li>
										<a href="https://www.517ybang.com/item/detail?id=2" target="_self">
										<div class="pic">
											<img data-src="<?php echo CDN_URL ?>media/home/zaixianpintuan/zxpt/140x140_1.jpg"/>
										</div>
										</a>
										<h1>里吉塔蓝莓</h1>
										<h2>¥4.9/斤</h2>
									</li>
								</ul>
							</div>
							<div class="onlinegoodstop" style="margin-top:.1rem">
								<ul>
									<li>
										<a href="https://www.517ybang.com/item/detail?id=2" target="_self">
										<div class="pic">
											<img data-src="<?php echo CDN_URL ?>media/home/zaixianpintuan/zxpt/140x140_2.jpg"/>
										</div>
										</a>
										<h1>i7 1071组装机</h1>
										<h2>¥7500/斤</h2>
									</li>
									<li>
										<a href="https://www.517ybang.com/item/detail?id=2" target="_self">
										<div class="pic">
											<img data-src="<?php echo CDN_URL ?>media/home/zaixianpintuan/zxpt/140x140_3.jpg"/>
										</div>
										</a>
										<h1>VITA红茶整箱</h1>
										<h2>¥31.95/斤</h2>
									</li>
								</ul>
								
							</div>
						</div>
					</div>
				</div>
				<!--商家搜罗-->
				<div class="onlinegroup clearfix">
					<div class="newgoodspic auto">
						<img data-src="<?php echo CDN_URL ?>media/home/shangjiasouluo/shangjiasouluo@3x.png">
					</div>
			</div>
			<!--颜色叠加公用部分-->
			<div class="coloroverlay">
				<div class="coloroverlaywrap activecoverplay" id="activecoverplay">
					<div class="zbottom">
						<b>时尚</b>
						<a style="display: none;">Shishang</a>
						<i style="display: none;">时尚</i>
						
					</div>
					<div class="zbottom zfirst">
						<b>丽人</b>
						<a style="display: none;">Liren</a>
						<i style="display: none;">丽人</i>
						
					</div>
					<div class="zbottom zsecond">
						<b>娱乐</b>
						<a style="display: none;">Yule</a>
						<i style="display: none;">娱乐</i>
						
					</div>
					<div class="zbottom zthree coverCur">
						<b>美食</b>
						<a style="display: none;">Delatious</a>
						<span class="r">美食</span>
						<i style="display: none;">美食</i>
						
					</div>
					
				</div>
				<div class="fr squarecube" id="more">
					<img src="<?php echo CDN_URL ?>media/home/list.png" class="block auto" />
				</div>
			</div>
			<!--颜色叠加区域内容-->
			<div class="coloroverlaycontent clearfix" id="morelist">
				<!--时尚内容-->
				<div class="colorovertab clearfix" style="display:block">
				<div class="left fl refreshcontent">
					<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
						<div class="bgefefef">
						<img data-src="<?php echo CDN_URL ?>media/home/shangjiasouluo/top1.png" />
						</div>
						<h1>The Diner  啤酒配披萨</h1>
					</a>
				</div>
				<div class="right fr refreshcontent">
					<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
						<div class="bgefefef">
						<img data-src="<?php echo CDN_URL ?>media/home/shangjiasouluo/top2.png" />
						</div>
						<h1>遇见你很高兴  小资多彩</h1>
					</a>
				</div>
				<div class="mid fl" style="margin-top:.1rem">
					<div class="midleft refreshcontent">
						<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
							<img class="h150" data-src="<?php echo CDN_URL ?>media/home/shangjiasouluo/410x150.jpg" />
							<h1>麦乐面包达人</h1>
							<h2>面包也可以带有亲情</h2>
						</a>
					</div>
					<div class="midright fr refreshcontent">
						<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
							<img class="h150" data-src="<?php echo CDN_URL ?>media/home/shangjiasouluo/260x150.jpg" />
							<h1>主推新品</h1>
							<h2>甜品也可以甜而不腻</h2>
						</a>
					</div>
				</div>
				</div>
				<!--丽人内容-->
				<div class="colorovertab clearfix">
				<div class="left fl refreshcontent">
					<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
						<div class="bgefefef">
						<img data-src="<?php echo CDN_URL ?>media/home/jianhuo_mangguo@3x.png" />
						</div>
						<h1>The Diner  啤酒配披萨</h1>
					</a>
				</div>
				<div class="right fr refreshcontent">
					<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
						<div class="bgefefef">
						<img data-src="<?php echo CDN_URL ?>media/home/jianhuo_mangguo@3x.png" />
						</div>
						<h1>The Diner  啤酒配披萨</h1>
					</a>
				</div>
				<div class="mid fl" style="margin-top:.1rem">
					<div class="midleft refreshcontent">
						<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
							<div class="bgefefef">
							<img data-src="<?php echo CDN_URL ?>media/home/banner@3x.png" />
							</div>
							<h1>买了面包大面包也可以带有亲情人</h1>
							<h2>面包也可以带有亲情面包也可以带有亲情面包也可以带有亲情</h2>
						</a>
					</div>
					<div class="midright fr refreshcontent">
						<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
							<div class="bgefefef">
							<img data-src="<?php echo CDN_URL ?>media/home/banner@3x.png" />
							</div>
							<h1>买了面包大面包也可以带有亲情人</h1>
							<h2>面包也可以带有亲情面包也可以带有亲情面包也可以带有亲情</h2>
						</a>
					</div>
				</div>
				</div>
				<!--娱乐内容-->
				<div class="colorovertab clearfix">
				<div class="left fl refreshcontent">
					<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
						<div class="bgefefef">
						<img data-src="<?php echo CDN_URL ?>media/home/banner@3x.png">
							</div>
						<h1>The Diner  啤酒配披萨</h1>
					</a>
				</div>
				<div class="right fr refreshcontent">
					<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
						<div class="bgefefef">
						<img data-src="<?php echo CDN_URL ?>media/home/banner@3x.png">
							</div>
						<h1>The Diner  啤酒配披萨</h1>
					</a>
				</div>
				<div class="mid fl" style="margin-top:.1rem">
					<div class="midleft refreshcontent">
						<a href="https://www.517ybang.com/biz/detail?id=2">
							<div class="bgefefef">
							<img data-src="<?php echo CDN_URL ?>media/home/banner@3x.png">
								</div>
							<h1>买了面包大面包也可以带有亲情人</h1>
							<h2>面包也可以带有亲情面包也可以带有亲情面包也可以带有亲情</h2>
						</a>
					</div>
					<div class="midright fr refreshcontent">
						<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
							<div class="bgefefef">
							<img data-src="<?php echo CDN_URL ?>media/home/banner@3x.png">
								</div>
							<h1>买了面包大面包也可以带有亲情人</h1>
							<h2>面包也可以带有亲情面包也可以带有亲情面包也可以带有亲情</h2>
						</a>
					</div>
				</div>
				</div>
				<!--美食tab内容-->
					<div class="colorovertab clearfix">
					<div class="left fl refreshcontent">
						<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
							<div class="bgefefef">
							<img data-src="<?php echo CDN_URL ?>media/home/banner@3x.png">
								</div>
							<h1>The Diner  啤酒配披萨</h1>
						</a>
					</div>
					<div class="right fr refreshcontent">
						<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
							<div class="bgefefef">
							<img data-src="<?php echo CDN_URL ?>media/home/banner@3x.png">
								</div>
							<h1>遇见你 很高兴  啤酒配披萨</h1>
						</a>
					</div>
					<div class="mid fl" style="margin-top:.1rem">
						<div class="midleft refreshcontent">
							<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
								<div class="bgefefef">
								<img data-src="<?php echo CDN_URL ?>media/home/banner@3x.png">
									</div>
								<h1>买了面包大面包也可以带有亲情人</h1>
								<h2>面包也可以带有亲情面包也可以带有亲情面包也可以带有亲情</h2>
							</a>
						</div>
						<div class="midright fr refreshcontent">
							<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
								<div class="bgefefef">
								<img data-src="<?php echo CDN_URL ?>media/home/banner@3x.png">
									</div>
								<h1>买了面包大面包也可以带有亲情人</h1>
								<h2>面包也可以带有亲情面包也可以带有亲情面包也可以带有亲情</h2>
							</a>
						</div>
					</div>
				</div>
				<div class="botWrap auto wid718 border20 fl mt10 clearfix">
					<div class="dotcontent clearfix bgfff border20">
						<ul>
							<li>
								<a href="https://www.517ybang.com/item/detail?id=2" target="_self">
									<img data-src="<?php echo CDN_URL ?>media/home/shangjiasouluo/sjss/160x160_0.jpg" class="auto block">
									<h1>蘑菇火腿炒饭</h1>
									<h2>¥38.28</h2>
								</a>
							</li>
							<li>
								<a href="https://www.517ybang.com/item/detail?id=2" target="_self">
									<img data-src="<?php echo CDN_URL ?>media/home/shangjiasouluo/sjss/160x160_1.jpg" class="auto block">
									<h1>韩式海鲜汤</h1>
									<h2>¥22.25</h2>
								</a>
							</li>
							<li>
								<a href="https://www.517ybang.com/item/detail?id=2" target="_self">
									<img data-src="<?php echo CDN_URL ?>media/home/shangjiasouluo/sjss/160x160_2.jpg" class="auto block">
									<h1>新西兰精品牛排</h1>
									<h2>¥68.00</h2>
								</a>
							</li>
							<li>
								<a href="https://www.517ybang.com/item/detail?id=2" target="_self">
									<img data-src="<?php echo CDN_URL ?>media/home/shangjiasouluo/sjss/160x160_3.jpg" class="auto block">
									<h1>狮子头意面</h1>
									<h2>¥28.00</h2>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<!--运动健康区域-->
				<div class="wid718 auto bgfff border20 exercise fl">
					<img data-src="<?php echo CDN_URL ?>media/home/yundongjiankang/yundongjiankang@3x.png" />
				</div>
				<div class="coloroverlay mt14 fl">
				<div class="coloroverlaywrap">
					<div class="zbottom zbottomaction">
					</div>
					<div class="zbottom zfirst zfirstaction">
					</div>
					
					<div class="zbottom zthree action">
						Come in Recommend
						<span class="r">进来推荐</span>
					</div>
					
				</div>
				<div class="fr square">
					<img data-src="<?php echo CDN_URL ?>media/home/icon_2@3x.png" class="block auto" />
				</div>
			</div>
				<div class="coloroverlaycontent clearfix fl">
				
				<!--运动装备区域-->
				<div class="mid fl">
					<div class="midleft fl mt0">
						<div class="bgefefef">
							<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
						<img src="https://cdn-remote.517ybang.com/media/home/yundongjiankang/left.png" class="success">
						</a>
						</div>
						<h1>挑战极限 边界由你定</h1>
						
					</div>
					<div class="midright fr mt0">
						<div class="bgefefef">
							<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
						<img src="https://cdn-remote.517ybang.com/media/home/yundongjiankang/right.png" class="success">
							</a>
						</div>
						<h1>美女运动装备</h1>
						
					</div>
				</div>
				</div>
				
			</div>
			<!--进来推荐区域内容-->
			<div class="coloroverlaycontent clearfix" style="margin-top:.1rem">
				
				<!-- <div class="left fr">
					<img data-src="<?php echo CDN_URL ?>media/home/yundongjiankang/260x150.jpg">
					<h1>美女运动装备</h1>
				</div>
				<div class="right fl">
					<img data-src="<?php echo CDN_URL ?>media/home/yundongjiankang/410x150.jpg">
					<h1>挑战极限   边界由你定</h1>
				</div> -->
				<div class="mid fl">
					<div class="midleft fr">
						<div class="bgefefef">
							<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
						<img data-src="<?php echo CDN_URL ?>media/home/yundongjiankang/left.png">
							</a>
						</div>
						<h1>DIOS</h1>
						<h2>DIOS精准标靶装备</h2>
					</div>
					<div class="midright fl">
						<div class="bgefefef">
							<a href="https://www.517ybang.com/biz/detail?id=2" target="_self">
						<img data-src="<?php echo CDN_URL ?>media/home/yundongjiankang/right.png">
							</a>
						</div>
						<h1>极限装备</h1>
						<h2>极限运动装备</h2>
					</div>
				</div>
				
				<div class="botWrap auto wid718 border20 fl mt10 clearfix">
					<div class="dotcontent clearfix bgfff border20">
						<ul>
							<li>
								<img data-src="<?php echo CDN_URL ?>media/home/yundongjiankang/160x160_0.jpg" class="auto block">
								<h1>NIKE飞线跑步鞋</h1>
								<h2>¥799.00</h2>
							</li>
							<li>
								<img data-src="<?php echo CDN_URL ?>media/home/yundongjiankang/160x160_1.jpg" class="auto block">
								<h1>NIKE速干衣</h1>
								<h2>¥219.00</h2>
							</li>
							<li>
								<img data-src="<?php echo CDN_URL ?>media/home/yundongjiankang/160x160_2.jpg" class="auto block">
								<h1>NIKE耐克polo衫</h1>
								<h2>¥288.00</h2>
							</li>
							<li>
								<img data-src="<?php echo CDN_URL ?>media/home/yundongjiankang/160x160_3.jpg" class="auto block">
								<h1>NIKE球衣</h1>
								<h2>¥383.28</h2>
							</li>
						</ul>
					</div>
				</div>
				<!--运动健康区域-->
				<!-- <div class="wid718 auto bgfff border20 exercise fl">
					<img data-src="<?php echo CDN_URL ?>media/home/cainixihuan@3x.png">
				</div> -->
			<!-- 	<div class="coloroverlay mt14 fl">
				<div class="coloroverlaywrap">
					<div class="zbottom zbottomaction">
					</div>
					<div class="zbottom zfirst zfirstaction">
					</div>
					
					<div class="zbottom zthree action">
						Come in Recommend
						<span class="r">进来推荐</span>
					</div>
					
				</div>
				<div class="fr square">
					<img data-src="<?php echo CDN_URL ?>media/home/icon_2@3x.png" class="block auto">
				</div>
			</div> -->
			</div>
			
				
				<!--电子产品-->
				<div class="wid718 auto bgfff border20 exercise clearfix">
					<div class="bgefefef">
					<img data-src="<?php echo CDN_URL ?>media/home/dianzichanpin/dianzichanpin@3x.png">
					</div
				</div>
				<div class="coloroverlay mt14">
				<div class="coloroverlaywrap">
					<div class="zbottom zbottomaction pinkaction">
					</div>
					<div class="zbottom zfirst zfirstaction zfirstpinkaction">
					</div>
					
					<div class="zbottom zthree action">
						Come in Recommend
						<span class="r">进来推荐</span>
					</div>
					
				</div>
				<div class="fr square">
					<img data-src="<?php echo CDN_URL ?>media/home/icon_1@3x.png" class="block auto" style="height:.42rem">
				</div>
			</div>
			<div class="coloroverlaycontent clearfix" style="margin-top:.14rem">
				
				<!--运动装备区域-->
				<div class="mid fl">
					<div class="midleft fr mt0">
						<div class="bgefefef">
						<img data-src="<?php echo CDN_URL ?>media/home/dianzichanpin/right.png">
						</div>
						<h1>镜头再长一点 再长一点</h1>
						
					</div>
					<div class="midright fl mt0">
						<div class="bgefefef">
						<img data-src="<?php echo CDN_URL ?>media/home/dianzichanpin/left.png">
						</div>
						<h1>我的镜头 我的世界</h1>
						
					</div>
				</div>
				</div>
				<div class="coloroverlaycontent clearfix" style="margin-top:.10rem">
				
				
				
				<div class="mid fl">
					<div class="midleft fl">
						<img src="https://cdn-remote.517ybang.com/media/home/dianzichanpin/410x150.jpg" class="success">
						<h1>我的mac</h1>
						<h2>1309 我的MAC</h2>
					</div>
					<div class="midright fr">
						<img src="https://cdn-remote.517ybang.com/media/home/dianzichanpin/260x150.jpg" class="success">
						<h1>IPHONE</h1>
						<h2>爱疯 爱疯 疯</h2>
					</div>
				</div>
				
			</div>
				<div class="botWrap auto wid718 border20 mt10 clearfix">
					<div class="dotcontent clearfix bgfff border20">
						<ul>
							<li>
								
								<img src="<?php echo CDN_URL ?>media/home/dianzichanpin/dzcp/160x160_0.jpg" class="auto block">
								<h1>IPHONE7P</h1>
								<h2>¥5199.00</h2>
							</li>
							<li>
								<img src="<?php echo CDN_URL ?>media/home/dianzichanpin/dzcp/160x160_1.jpg" class="auto block">
								<h1>APPLE Ipad 平板</h1>
								<h2>¥383.2</h2>
							</li>
							<li>
								<img src="<?php echo CDN_URL ?>media/home/dianzichanpin/dzcp/160x160_2.jpg" class="auto block">
								<h1>苹果SLO</h1>
								<h2>¥383.22</h2>
							</li>
							<li>
								<img src="<?php echo CDN_URL ?>media/home/dianzichanpin/dzcp/160x160_3.jpg" class="auto block">
								<h1>iWatch</h1>
								<h2>¥1388.00</h2>
							</li>
						</ul>
					</div>
				</div>
				<!--猜你喜欢-->
				<div class="wid718 auto bgfff border20 exercise clearfix">
					<img data-src="<?php echo CDN_URL ?>media/home/cainixihuan/cainixihuan@3x.png">
				</div>
				<!--猜你喜欢内容区域开始-->
				<div class="like wid718 auto clearfix mt10">
					<ul>
						<li>
							<img data-src="<?php echo CDN_URL ?>media/home/cainixihuan/cnxh/210x210_0.jpg"/>
							<h1>JUSTE UN CLOU 手镯</h1>
							<h2>8K玫瑰金</h2>
							<h3>¥10555.00</h3>
						</li>
						<li>
							<img data-src="<?php echo CDN_URL ?>media/home/cainixihuan/cnxh/210x210_1.jpg"/>
							<h1>栖霞红富士</h1>
							<h2>18k玫瑰金,手带表</h2>
							<h3>¥1045.00</h3>
						</li>
						<li class="mr0">
							<img data-src="<?php echo CDN_URL ?>media/home/cainixihuan/cnxh/210x210_2.jpg"/>
							<h1>DRIVER ONE 手表</h1>
							<h2>8K玫瑰金</h2>
							<h3>¥5100</h3>
						</li>
						<li>
							<img data-src="<?php echo CDN_URL ?>media/home/cainixihuan/cnxh/210x210_3.jpg"/>
							<h1>JUSTE UN CLOU 手镯</h1>
							<h2>8K玫瑰金</h2>
							<h3>¥5100</h3>
						</li>
						<li>
							<img data-src="<?php echo CDN_URL ?>media/home/cainixihuan/cnxh/210x210_0.jpg"/>
							<h1>JUSTE UN CLOU 手镯</h1>
							<h2>8K玫瑰金</h2>
							<h3>¥5100</h3>
						</li>
						<li class="mr0">
							<img data-src="<?php echo CDN_URL ?>media/home/cainixihuan/cnxh/210x210_2.jpg"/>
							<h1>JUSTE UN CLOU 手镯</h1>
							<h2>8K玫瑰金</h2>
							<h3>¥5100</h3>
						</li>
					</ul>
				</div>
			</div>
		
			
			
			</div>
				<div class="item">分类</div>
			<div class="item">
					<!--头部banner区域开始-->
		<div class="bannerWrap auto">
			<div class="swiper-container">
	        <div class="swiper-wrapper">
	            <div class="swiper-slide">
	            	<img src="<?php echo CDN_URL ?>media/slider1-2.png" />
	            </div>
	            <!--<div class="swiper-slide">
	            	<img src="<?php echo CDN_URL ?>media/slider1-2.png" />
	            </div>
	            <div class="swiper-slide">
	            	<img src="<?php echo CDN_URL ?>media/slider1-1.png" />
	            </div>
	            <div class="swiper-slide">
	            	<img src="<?php echo CDN_URL ?>media/slider1-2.png" />
	            </div>-->
	        </div>
	        <!-- Add Pagination -->
	        <div class="swiper-pagination"></div>
	    </div>
	</div>
	<!--培训分类区域开始-->
	<div class="classification auto">
		<div class="swiper-container5">
        <div class="swiper-wrapper">
			<div class="swiper-slide">
				<p class="colorarea colorareaRed">
				</p>
				<div class="move">
					<span class="titletext">外语培训</span>
					<span class="smalltitle smallcolor_one">FRESH FRUIT</span>
				</div>
				<img src="<?php echo CDN_URL ?>media/slider1-1.png" />
				<div class="downarrow"></div>
			</div>
			<div class="swiper-slide">
				<p class="colorarea colorareaYellow">
				</p>
				<div class="move">
				<span class="titletext">音乐培训</span>
				<span class="smalltitle smallcolor_two">APPLE</span>
				</div>
				<img src="<?php echo CDN_URL ?>media/slider1-2.png" />
				<div class="downarrow arrYellow"></div>
			</div>
			<div class="swiper-slide">
				<p class="colorarea colorareaBlue">
				</p>
				<div class="move">
				<span class="titletext">美术培训</span>
				<span class="smalltitle smallcolor_three">FRESH FRUIT</span>
				</div>
				<img src="<?php echo CDN_URL ?>media/slider1-1.png" />
				<div class="downarrow arrBlue"></div>
			</div>
			<div class="swiper-slide">
				<p class="colorarea colorareaRed">
				</p>
				<div class="move">
					<span class="titletext">外语培训</span>
					<span class="smalltitle smallcolor_one">FRESH FRUIT</span>
				</div>
				<img src="<?php echo CDN_URL ?>media/slider1-1.png" />
				<div class="downarrow"></div>
			</div>
			<div class="swiper-slide">
				<p class="colorarea colorareaPink"></p>
				<div class="move">
				<span class="titletext">升学培训</span>
				<span class="smalltitle smallcolor_four">GRUNT</span>
				</div>
				<img src="<?php echo CDN_URL ?>media/slider1-1.png" />
				<div class="downarrow arrPink"></div>
			</div>
			<div class="swiper-slide">
				<p class="colorarea colorareaRed">
				</p>
				<div class="move">
					<span class="titletext">外语培训</span>
					<span class="smalltitle smallcolor_one">FRESH FRUIT</span>
				</div>
				<img src="<?php echo CDN_URL ?>media/slider1-1.png" />
				<div class="downarrow"></div>
			</div>
			<div class="swiper-slide" style="margin-right: 0;">
				<p class="colorarea colorareaGreen">
				</p>
				<div class="move">
				<span class="titletext">生活兴趣</span>
				<span class="smalltitle smallcolor_five">DRINK</span>
				</div>
				<img src="<?php echo CDN_URL ?>media/slider1-2.png" />
				<div class="downarrow arrGreen"></div>
			</div>
		 <div class="swiper-scrollbar"></div>
		</div>
	</div>
	</div>
	<!--立即体验区域开始-->
	<div class="experience wid710 auto">
		<div class="experience_one fl">
			<div class="title">
				<img src="<?php echo CDN_URL ?>media/home/title.png" class="fl"/>
			</div>
			<div class="goodpic auto">
				<img src="<?php echo CDN_URL ?>media/slider1-2.png"/>
			</div>
			<h1>芝麻街英语芝麻街英语芝麻街英语</h1>
			<h2>英语的领导品牌</h2>
			<a href="###" class="atonce">立即体验</a>
		</div>
		<div class="experience_two fr">
			<div class="card_one">
				<img src="<?php echo CDN_URL ?>media/slider1-2.png" class="fl"/>
				<h1 class="mt10">沃尔德国际英语</h1>
				<h2>英语的领导品牌</h2>
				<a href="###" class="atonce atonce_r">立即体验</a>
			</div>
			<div class="card_one mt10">
				<img src="<?php echo CDN_URL ?>media/slider1-2.png" class="fl"/>
				<h1 class="mt10">沃尔德国际英语</h1>
				<h2>英语的领导品牌</h2>
				<a href="###" class="atonce atonce_r">立即体验</a>
			</div>
		</div>
	</div>
	<!--tab切换区域开始-->
	
	<div class="tab">
		<a class="active" href="javascript:;">全部</a>
		<a href="javascript:;">人气优先</a>
		<a href="javascript:;">距离优先</a>
	</div>
	<div class="swiper-container6">
		<div class="swiper-wrapper w">
			<div class="swiper-slide d">
				<div class="init-loading list-group-item text-center" style="display: none;">下拉可以刷新</div>
				<div class="swiper-container7">
				<div class="swiper-wrapper">
					<div class="swiper-slide list-group">
						<div class="list-group-item">
							<div class="list">
			            		<img src="<?php echo CDN_URL ?>media/slider1-2.png" class="fl">
			            		<div class="listtext fr">
		            			<!--显示距离-->
		            			<span class="area">0.3km</span>
		            			<h1>韦博英语韦博英语韦博英语韦博英语韦博英语(麦岛分路店)</h1>
		            			<!--五星区域-->
		            			<div class="star">
		            				<ul>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            				</ul>
            				</div>
            			<div class="tag">
            				麦岛路沿线   英语
            			</div>
            			<div class="allbuy">
            				<span class="tuan">团</span>
            				<span>99元 单人体验一次</span>
            			</div>
            		</div>
            	</div>
            	<div class="list">
			            		<img src="<?php echo CDN_URL ?>media/slider1-2.png" class="fl">
			            		<div class="listtext fr">
		            			<!--显示距离-->
		            			<span class="area">0.3km</span>
		            			<h1>韦博英语韦博英语韦博英语韦博英语韦博英语(麦岛分路店)</h1>
		            			<!--五星区域-->
		            			<div class="star">
		            				<ul>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            				</ul>
            				</div>
            			<div class="tag">
            				麦岛路沿线   英语
            			</div>
            			<div class="allbuy">
            				<span class="tuan">团</span>
            				<span>99元 单人体验一次</span>
            			</div>
            		</div>
            	</div>
						</div>
						
					</div>
					<div class="swiper-slide list-group">
						<div class="list-group-item">
							<div class="list">
			            		<img src="<?php echo CDN_URL ?>media/slider1-2.png" class="fl">
			            		<div class="listtext fr">
		            			<!--显示距离-->
		            			<span class="area">0.3km</span>
		            			<h1>韦博英语韦博英语韦博英语韦博英语韦博英语(麦岛分路店)</h1>
		            			<!--五星区域-->
		            			<div class="star">
		            				<ul>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            				</ul>
            				</div>
            			<div class="tag">
            				麦岛路沿线   英语
            			</div>
            			<div class="allbuy">
            				<span class="tuan">团</span>
            				<span>99元 单人体验一次</span>
            			</div>
            		</div>
            	</div>
						</div>
						
					</div>
					<div class="swiper-slide list-group">
						<div class="list-group-item">
							<div class="list">
			            		<img src="<?php echo CDN_URL ?>media/slider1-2.png" class="fl">
			            		<div class="listtext fr">
		            			<!--显示距离-->
		            			<span class="area">0.3km</span>
		            			<h1>韦博英语韦博英语韦博英语韦博英语韦博英语(麦岛分路店)</h1>
		            			<!--五星区域-->
		            			<div class="star">
		            				<ul>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            				</ul>
            				</div>
            			<div class="tag">
            				麦岛路沿线   英语
            			</div>
            			<div class="allbuy">
            				<span class="tuan">团</span>
            				<span>99元 单人体验一次</span>
            			</div>
            		</div>
            	</div>
						</div>
						<div class="list-group-item">
							<div class="list">
			            		<img src="<?php echo CDN_URL ?>media/slider1-2.png" class="fl">
			            		<div class="listtext fr">
		            			<!--显示距离-->
		            			<span class="area">0.3km</span>
		            			<h1>韦博英语韦博英语韦博英语韦博英语韦博英语(麦岛分路店)</h1>
		            			<!--五星区域-->
		            			<div class="star">
		            				<ul>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            				</ul>
            				</div>
            			<div class="tag">
            				麦岛路沿线   英语
            			</div>
            			<div class="allbuy">
            				<span class="tuan">团</span>
            				<span>99元 单人体验一次</span>
            			</div>
            		</div>
            	</div>
            	<div class="list">
			            		<img src="<?php echo CDN_URL ?>media/slider1-2.png" class="fl">
			            		<div class="listtext fr">
		            			<!--显示距离-->
		            			<span class="area">0.3km</span>
		            			<h1>韦博英语韦博英语韦博英语韦博英语韦博英语(麦岛分路店)</h1>
		            			<!--五星区域-->
		            			<div class="star">
		            				<ul>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            					<li>
		            						<i class="icon iconfont icon-wuxing"></i>
		            					</li>
		            				</ul>
            				</div>
            			<div class="tag">
            				麦岛路沿线   英语
            			</div>
            			<div class="allbuy">
            				<span class="tuan">团</span>
            				<span>99元 单人体验一次</span>
            			</div>
            		</div>
            	</div>
						</div>
						
					</div>
				</div>
				</div>
			</div>
		</div>
		<!--<div class="loadtip">上拉加载更多</div>
		<div class="swiper-scrollbar"></div>-->
	</div>
			</div>
			<!--change-->
			<div class="item">
				<div class="payment-bar">
					<div class="all-checkbox"><input type="checkbox" class="check goods-check" id="AllCheck">全选</div>
					<div class="shop-total">
						<strong>合计：<span>¥</span><i class="total" id="AllTotal">0.00</i></strong>
						<p>不含运费</p>
					</div>
					<a href="#" class="settlement">结算</a>
				</div>
				<div class="my-address-list wid710 auto border20 mt20" id="my-address-list">
					<div class="shopping">
					<div class="shop-group-item">
				    <div class="touch">
				    <!--商家标题-->
					    	<div class="buycarshoptitle">
					    		<div class="shop-name clearfix">
									<input type="checkbox" class="check goods-check shopCheck">
									<h4>
										<img src="<?php echo CDN_URL ?>media/cart/jinlaitit.png" />
									</h4>
									<h3 class="fl">进来自营店
										<i class="icon-Arrow"></i>
									</h3>
								</div>
					    	</div>
					    <div class="itemlist">
						    <div class="goodslist clearfix">
							   <div class="shop-info">
								<input type="checkbox" class="check goods-check goodsCheck">
								<div class="shop-info-img"><img src="<?php echo CDN_URL ?>media/home/jianhuo@3x.png" /></div>
								<div class="shop-info-text">
									<h4>云南芒果（约400/个）</h4>
									<div class="shop-price">
										<div class="shop-pices">￥<b class="price">5.8</b>/份</div>
										<div class="shop-arithmetic">
											<a href="javascript:;" class="minus">
												<i class="icon-jian" style="font-size: .44rem;"></i>
											</a>
											<span class="num" >1</span>
											<a href="javascript:;" class="plus active">
												<i class="icon-add-add-red" style="font-size: .44rem;"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
							
				<div class="shopPrice">本店总计：￥<span class="shop-total-amount ShopTotal">0.00</span></div>
							   <!-- <div class="address-info">¥1585</div>
						    </div>
						    <a href="javascript:;" class="remove">删除</a>
					    </div>
					     <div class="itemlist">
						    <div class="goodslist clearfix">
							   <div class="shop-info">
								<input type="checkbox" class="check goods-check goodsCheck">
								<div class="shop-info-img"><img src="<?php echo CDN_URL ?>media/home/jianhuo@3x.png" /></div>
								<div class="shop-info-text">
									<h4>云南芒果（约400/个）</h4>
									<div class="shop-price">
										<div class="shop-pices">￥<b class="price">5.8</b>/份</div>
										<div class="shop-arithmetic">
											<a href="javascript:;" class="minus">-</a>
											<span class="num" >1</span>
											<a href="javascript:;" class="plus">+</a>
										</div>
									</div>
								</div>
							</div>
							
				<div class="shopPrice">本店总计：￥<span class="shop-total-amount ShopTotal">0.00</span></div>
							   <!-- <div class="address-info">¥1585</div>-->
						    </div>
						    <a href="javascript:;" class="remove">删除</a>
					    </div>
				    </div>
				    
				  
				   </div>
				   	<div class="shop-group-item">
				    <div class="touch">
				    <!--商家标题-->
					    	<div class="buycarshoptitle">
					    		<div class="shop-name clearfix">
									<input type="checkbox" class="check goods-check shopCheck">
									<h4>
										<img src="<?php echo CDN_URL ?>media/cart/akzy.png" />
									</h4>
									<h3 class="fl">爱康卓越<i class="icon-Arrow"></i></h3>
								</div>
					    	</div>
					    <div class="itemlist">
						    <div class="goodslist clearfix">
							   <div class="shop-info">
								<input type="checkbox" class="check goods-check goodsCheck">
								<div class="shop-info-img"><img src="<?php echo CDN_URL ?>media/home/jianhuo_putao@3x.png" /></div>
								<div class="shop-info-text">
									<h4>女性特色健身项目</h4>
									<div class="shop-price">
										<div class="shop-pices">￥<b class="price">98</b>/份</div>
										<div class="shop-arithmetic">
											<a href="javascript:;" class="minus">
												<i class="icon-jian" style="font-size: .44rem;"></i>
											</a>
											<span class="num" >1</span>
											<a href="javascript:;" class="plus active">
												<i class="icon-add-add-red" style="font-size: .44rem;"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
							
				<div class="shopPrice">本店总计：￥<span class="shop-total-amount ShopTotal">0.00</span></div>
							   <!-- <div class="address-info">¥1585</div>-->
						    </div>
						    <a href="javascript:;" class="remove">删除</a>
					    </div>
					     <div class="itemlist">
						    <div class="goodslist clearfix">
							   <div class="shop-info">
								<input type="checkbox" class="check goods-check goodsCheck">
								<div class="shop-info-img"><img src="<?php echo CDN_URL ?>media/home/jianhuo_mangguo@3x.png" /></div>
								<div class="shop-info-text">
									<h4>巨峰葡萄</h4>
									<div class="shop-price">
										<div class="shop-pices">￥<b class="price">3.2</b>/份</div>
										<div class="shop-arithmetic">
											<a href="javascript:;" class="minus">
													<i class="icon-jian" style="font-size: .44rem;"></i>
											</a>
											<span class="num" >1</span>
											<a href="javascript:;" class="plus active">
												<i class="icon-add-add-red" style="font-size: .44rem;"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
							
				<div class="shopPrice">本店总计：￥<span class="shop-total-amount ShopTotal">0.00</span></div>
							   <!-- <div class="address-info">¥1585</div>-->
						    </div>
						    <a href="javascript:;" class="remove">删除</a>
					    </div>
				    </div>
				    
				  
				   </div>
				  </div>
				</div>
			</div>
			<!--change-->
			<div class="item">
				<div class="usercenter clearfix">
					<!--头像区域开始-->
					<div class="userinfo clearfix">
						<div class="userpic fl">
							<img data-src="<?php echo CDN_URL ?>media/home/jianhuo@3x.png" />
						</div>
						<div class="usertext fl">
							<h1>后海小王子</h1>
							<h2>普通会员</h2>
						</div>
						<div class="usermessage fr">
							<i class="icon-chat"></i>
						</div>
					</div>
					<!--关注店铺,收藏宝贝区域-->
					<div class="mymenu">
						<ul>
							<li>
								<div class="mymenuicon">
									<i class="icon-guanzhu"></i>
								</div>
								<p>关注店铺</p>
							</li>
							<li>
								<div class="mymenuicon">
									<i class="icon-shoucang"></i>
								</div>
								<p>收藏宝贝</p>
							</li>
							<li>
								<div class="mymenuicon">
									<i class="icon-kabao"></i>
								</div>
								<p>卡包</p>
							</li>
						</ul>
					</div>

				</div>
									<!--我的订单区域-->
					<div class="myorder wid730 auto bgfff border20 mt20 clearfix">
						<!--我的订单区域-->
						<div class="myordertitle">
							<span class="fl myordertext">我的订单</span>
							<i class="icon-Arrow fr" style="position: relative;top: .009rem;"></i>
							<span class="fr allorder">全部订单</span>
							
						</div>
						<div class="myordercontent clearfix">
							<ul>
							
								<li>
									<div class="orderpic">
										<i class="icon-daifukuan"></i>
									</div>
									<h2>待付款</h2>
								</li>
								<li>
									<div class="orderpic">
										<i class="icon-daifahuo"></i>
									</div>
									<h2>待发货</h2>
								</li>
								<li>
									<div class="orderpic">
										<i class="icon-daishouhuo"></i>
									</div>
									<h2>待收货</h2>
								</li>
								<li>
									<div class="orderpic">
										<i class="icon-daipingjia"></i>
									</div>
									<h2>待评价</h2>
								</li>
									<li>
									<div class="orderpic">
										<i class="icon-daituikuan"></i>
									</div>
									<h2>退款售后</h2>
								</li>
							</ul>
						</div>
					</div>
					<!--我的服务-->
						<div class="myorder myservice wid730 auto bgfff border20 mt20 clearfix">
						<!--我的订单区域-->
						<div class="myordertitle">
							<span class="fl myordertext">我的服务</span>
						</div>
						<div class="myordercontent clearfix">
							<ul>
							
								<li>
									<div class="orderpic">
										<i class="icon-yue" style="color: #edbf3e;"></i>
									</div>
									<h2>余额</h2>
								</li>
								<li>
									<div class="orderpic">
										<i class="icon-kabao" style="color: #c4de74;"></i>
									</div>
									<h2>卡包</h2>
								</li>
								<li>
									<div class="orderpic">
										<i class="icon-daifukuan"></i>
									</div>
									<h2>待付款</h2>
								</li>
								<li>
									<div class="orderpic">
										<i class="icon-daifukuan"></i>
									</div>
									<h2>待付款</h2>
								</li>
								<li>
									<div class="orderpic">
										<i class="icon-daifukuan"></i>
									</div>
									<h2>待付款</h2>
								</li>
								<li>
									<div class="orderpic">
										<i class="icon-daifukuan"></i>
									</div>
									<h2>待付款</h2>
								</li>
								<li>
									<div class="orderpic">
										<i class="icon-daifukuan"></i>
									</div>
									<h2>待付款</h2>
								</li>
								<li>
									<div class="orderpic">
										<i class="icon-daifukuan"></i>
									</div>
									<h2>待付款</h2>
								</li>
								<li>
									<div class="orderpic">
										<i class="icon-daifukuan"></i>
									</div>
									<h2>待付款</h2>
								</li>
								
							</ul>
						</div>
					</div>
					<div class="exit">
						退出
					</div>
		</div>
		<!--底部tab切换区域-->
		<!--<div class="tabWrap fiex">
		<div class="tabbar auto">
			<div class="column">
				<div class="itemmenulist cur">
					<i class="icon-shouye_xiala"></i>
					<span class="text">主页</span>
				</div>
				<div class="itemmenulist">
					<i class="icon iconfont icon-fenlei"></i>
					<span class="text">分类</span>
				</div>
				<div class="itemmenulist">
					<i class="icon iconfont icon-fenlei1"></i>
					<span class="text">发现</span>
				</div>
				<div class="itemmenulist">
					<i class="icon iconfont icon-gouwuche"></i>
					<span class="text">购物车</span>
				</div>
				<div class="itemmenulist">
					<i class="icon iconfont icon-wode"></i>
					<span class="text">我的</span>
				</div>
			</div>
		</div>
		</div>-->
<script>
$(document).ready(function() {
    setInterval('AutoScroll("#news")', 3000);
    var indexNum = 0;
$("#more").on("click",function(){
	if(indexNum == 0){
		$(".refreshcontent").each(function(){
//		d = Math.random()*1000; //延迟1s
//		$(this).delay(d).animate({opacity: 0}, {
//			step: function(n){
//				s = 1-n; 
//				$(this).css("transform", "scale("+s+")");
//			}, 
//			duration: 1000, 
//		})
	
	}).promise().done(function(){
		storm();
	});
	
	}
	else{
		card();
	}
	
});
function storm()
{
	indexNum = 1;
$(".refreshcontent").remove();
var oAddElement = '<div class="swiper-container7" id="newmorelist" style="margin-top:.1rem;border-radius: .2rem;"><div class="swiper-wrapper"><div class="swiper-slide"><div class="list-group-item"><a href="https://www.517ybang.com/biz/detail?id=2"><div class="list"><img src="<?php echo CDN_URL ?>media/slider1-2.png" class="fl"><div class="listtext fr"><span class="area">0.3km</span><h1>韦博英语韦博英语韦博英语韦博英语韦博英语(麦岛分路店)</h1><div class="star"><ul><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li></ul></div><div class="tag">麦岛路沿线   英语</div><div class="allbuy"><span class="tuan">团</span><span>99元 单人体验一次</span></div></div></div></a><a href="https://www.517ybang.com/biz/detail?id=2"><div class="list"><img src="<?php echo CDN_URL ?>media/slider1-2.png" class="fl"><div class="listtext fr"><span class="area">0.3km</span><h1>韦博英语韦博英语韦博英语韦博英语韦博英语(麦岛分路店)</h1><div class="star"><ul><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li></ul></div><div class="tag">麦岛路沿线   英语</div><div class="allbuy"><span class="tuan">团</span><span>99元 单人体验一次</span></div></div></div></a><a href="https://www.517ybang.com/biz/detail?id=2"><div class="list"><img src="<?php echo CDN_URL ?>media/slider1-2.png" class="fl"><div class="listtext fr"><span class="area">0.3km</span><h1>韦博英语韦博英语韦博英语韦博英语韦博英语(麦岛分路店)</h1><div class="star"><ul><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li></ul></div><div class="tag">麦岛路沿线   英语</div><div class="allbuy"><span class="tuan">团</span><span>99元 单人体验一次</span></div></div></div></a><a href="https://www.517ybang.com/biz/detail?id=2"><div class="list"><img src="<?php echo CDN_URL ?>media/slider1-2.png" class="fl"><div class="listtext fr"><span class="area">0.3km</span><h1>韦博英语韦博英语韦博英语韦博英语韦博英语(麦岛分路店)</h1><div class="star"><ul><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li></ul></div><div class="tag">麦岛路沿线   英语</div><div class="allbuy"><span class="tuan">团</span><span>99元 单人体验一次</span></div></div></div></a><div class="list"><img src="<?php echo CDN_URL ?>media/slider1-2.png" class="fl"><div class="listtext fr"><span class="area">0.3km</span><h1>韦博英语韦博英语韦博英语韦博英语韦博英语(麦岛分路店)</h1><div class="star"><ul><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li></ul></div><div class="tag">麦岛路沿线   英语</div><div class="allbuy"><span class="tuan">团</span><span>99元 单人体验一次</span></div></div></div></a><a href="https://www.517ybang.com/biz/detail?id=2"><div class="list"><img src="<?php echo CDN_URL ?>media/slider1-2.png" class="fl"><div class="listtext fr"><span class="area">0.3km</span><h1>韦博英语韦博英语韦博英语韦博英语韦博英语(麦岛分路店)</h1><div class="star"><ul><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li></ul></div><div class="tag">麦岛路沿线   英语</div><div class="allbuy"><span class="tuan">团</span><span>99元 单人体验一次</span></div></div></div></a></div></div></div></div>';
	$(oAddElement).insertBefore($("#morelist"));
	$("#more").find("img").attr("src","<?php echo CDN_URL ?>media/home/icon_4@3x.png");

}
function card()
{
	indexNum = 0;
	$("#newmorelist").remove();
	var addCardElement = '<a href="https://www.517ybang.com/biz/detail?id=2"><div class="left fl refreshcontent"><img src="<?php echo CDN_URL ?>media/home/banner@3x.png"><h1>The Diner  啤酒配披萨</h1></div></a><a href="https://www.517ybang.com/biz/detail?id=2"><div class="right fr refreshcontent"><img src="<?php echo CDN_URL ?>media/home/banner@3x.png"><h1>遇见你 很高兴  啤酒配披萨</h1></div></a><div class="mid fl" style="margin-top:.1rem"><a href="https://www.517ybang.com/biz/detail?id=2"><div class="midleft refreshcontent"><img src="<?php echo CDN_URL ?>media/home/banner@3x.png"><h1>买了面包大面包也可以带有亲情人</h1><h2>面包也可以带有亲情面包也可以带有亲情面包也可以带有亲情</h2></div></a><a href="https://www.517ybang.com/biz/detail?id=2"><div class="midright fr refreshcontent"><img src="<?php echo CDN_URL ?>media/home/banner@3x.png"><h1>买了面包大面包也可以带有亲情人</h1><h2>面包也可以带有亲情面包也可以带有亲情面包也可以带有亲情</h2></div></a></div>';
	$(addCardElement).insertBefore($("#morelist .botWrap"));
	$("#more").find("img").attr("src","<?php echo CDN_URL ?>media/home/list.png");
	
}
//商家搜罗tab切换
$(".coloroverlaywrap div").on("click",function(){
	$("#morelist .colorovertab").eq($(this).index()).show().siblings(".colorovertab").hide();
});

});
//懒加载
$(document).ready(function(){

	var lazyLoadImg = new LazyLoadImg({
	    el: document.querySelector('#list'),
	    mode: 'default', //默认模式，将显示原图，diy模式，将自定义剪切，默认剪切居中部分
	    time: 300, // 设置一个检测时间间隔
	    complete: true, //页面内所有数据图片加载完成后，是否自己销毁程序，true默认销毁，false不销毁
	    position: { // 只要其中一个位置符合条件，都会触发加载机制
	      top: 0, // 元素距离顶部
	      right: 0, // 元素距离右边
	      bottom: 0, // 元素距离下面
	      left: 0 // 元素距离左边
	    },
	    before: function (el) { // 图片加载之前执行方法
//	    	el.css({
//	    		'height' : '100%'
//	    	})
//			el.style.width='auto';
//			el.style.display = 'block';
//			el.style.margin = '0 auto';
			
	      el.src = '<?php echo CDN_URL ?>media/home/default.png';
	      if( el.src = '<?php echo CDN_URL ?>media/home/default.png'){
	      	el.style.width='auto';
			el.style.display = 'block';
			el.style.margin = '0 auto';
			el.style.border = 'none';
	      }
	    },
	    success: function (el) { // 图片加载成功执行方法
	      el.classList.add('success')
	    },
	    error: function (el) { // 图片加载失败执行方法
//	  	图片加载不出来的默认图片
		el.src = '<?php echo CDN_URL ?>media/home/default.png'
	      
	    }
	});
function TotalPrice() {
    var allprice = 0; //总价
    $(".shop-group-item").each(function() { //循环每个店铺
      var oprice = 0; //店铺总价
      $(this).find(".goodsCheck").each(function() { //循环店铺里面的商品
        if ($(this).is(":checked")) { //如果该商品被选中
          var num = parseInt($(this).parents(".shop-info").find(".num").text()); //得到商品的数量
          var price = parseFloat($(this).parents(".shop-info").find(".price").text()); //得到商品的单价
          var total = price * num; //计算单个商品的总价
          oprice += total; //计算该店铺的总价
        }
        $(this).closest(".shop-group-item").find(".ShopTotal").text(oprice.toFixed(2)); //显示被选中商品的店铺总价
      });
      var oneprice = parseFloat($(this).find(".ShopTotal").text()); //得到每个店铺的总价
      allprice += oneprice; //计算所有店铺的总价
    });
    $("#AllTotal").text(allprice.toFixed(2)); //输出全部总价
}

    $(".itemlist").on("swipeleft",function(){
    	$(".itemlist").removeClass('selected');
        $(this).addClass('selected');
        $(this).find("a.remove").on("click",function(){
            var touchId = $(this).parents(".itemlist");
            if(touchId.siblings().length - 1 == 0){
            	touchId.parents('.touch').parents('.shop-group-item').remove();
            	TotalPrice();
            }
            TotalPrice();
            //执行删除效果
            touchId.css("border","0");
            touchId.stop().animate({
                height:"0",
                margin:"0"
            },300,function(){
            	//alert($(this).parents().siblings().length);
                $(this).remove();
                TotalPrice();
            });
            
        })
    }).on("swiperight",function(){
        $(this).parents(".touch").find(".itemlist").removeClass('selected');
    });

});
//banner焦点图
//banner焦点图
	//$('.coloroverlaywrap').fsBanner();	
</script>
