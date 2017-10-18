$(document).ready(function(){
	$(".tabbar .item").on("click",function(){
		var index = $(this).index();
		$(this).css({
			"borderRadius" : "50%"
		}).siblings(".item").css({
			"borderRadius" : 0
		});
		$(this).find("i").css({
			"marginTop" : 0
		}).parents(".item").siblings(".item").children("i").css({
			"marginTop" : "-.17rem"
		});
		$(this).find(".text").css({
			"top" : 300
		}).parents(".item").siblings(".item").children("span").css({
			"top" : ".27rem"
		});;
		$(this).addClass("cur").siblings(".item").removeClass("cur");
		$(".tabcontent>.item").eq(index).show().siblings("div").hide();
	});
	
	$(".tabbar .item").eq(0).click();
	
//	首页菜单焦点图
		var swiperIndex = new Swiper('.swiper-container', {
	        pagination: '.swiper-pagination',
	        paginationClickable: true,
	        autoplay: 2000,
	        loop:true
	   });	
});

//新闻公告自动轮播区域

function AutoScroll(obj) {
    $(obj).find("ul:first").animate({
        marginTop: "-.76rem"
    },
    500,
    function() {
        $(this).css({
            marginTop: "0px"
        }).find("li:eq(0),li:eq(1)").appendTo(this);
    });
}
$(document).ready(function() {
    setInterval('AutoScroll("#news")', 3000);
});

//首页点击四个小方格,显示更多列表,动画区域
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
var oAddElement = '<div class="swiper-container7" id="newmorelist" style="margin-top:.1rem;border-radius: .2rem;"><div class="swiper-wrapper"><div class="swiper-slide"><div class="list-group-item"><div class="list"><img src="media/slider1-2.png" class="fl"><div class="listtext fr"><span class="area">0.3km</span><h1>韦博英语韦博英语韦博英语韦博英语韦博英语(麦岛分路店)</h1><div class="star"><ul><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li></ul></div><div class="tag">麦岛路沿线   英语</div><div class="allbuy"><span class="tuan">团</span><span>99元 单人体验一次</span></div></div></div><div class="list"><img src="media/slider1-2.png" class="fl"><div class="listtext fr"><span class="area">0.3km</span><h1>韦博英语韦博英语韦博英语韦博英语韦博英语(麦岛分路店)</h1><div class="star"><ul><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li></ul></div><div class="tag">麦岛路沿线   英语</div><div class="allbuy"><span class="tuan">团</span><span>99元 单人体验一次</span></div></div></div><div class="list"><img src="media/slider1-2.png" class="fl"><div class="listtext fr"><span class="area">0.3km</span><h1>韦博英语韦博英语韦博英语韦博英语韦博英语(麦岛分路店)</h1><div class="star"><ul><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li></ul></div><div class="tag">麦岛路沿线   英语</div><div class="allbuy"><span class="tuan">团</span><span>99元 单人体验一次</span></div></div></div><div class="list"><img src="media/slider1-2.png" class="fl"><div class="listtext fr"><span class="area">0.3km</span><h1>韦博英语韦博英语韦博英语韦博英语韦博英语(麦岛分路店)</h1><div class="star"><ul><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li></ul></div><div class="tag">麦岛路沿线   英语</div><div class="allbuy"><span class="tuan">团</span><span>99元 单人体验一次</span></div></div></div><div class="list"><img src="media/slider1-2.png" class="fl"><div class="listtext fr"><span class="area">0.3km</span><h1>韦博英语韦博英语韦博英语韦博英语韦博英语(麦岛分路店)</h1><div class="star"><ul><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li></ul></div><div class="tag">麦岛路沿线   英语</div><div class="allbuy"><span class="tuan">团</span><span>99元 单人体验一次</span></div></div></div><div class="list"><img src="media/slider1-2.png" class="fl"><div class="listtext fr"><span class="area">0.3km</span><h1>韦博英语韦博英语韦博英语韦博英语韦博英语(麦岛分路店)</h1><div class="star"><ul><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li><li><i class="icon iconfont icon-wuxing"></i></li></ul></div><div class="tag">麦岛路沿线   英语</div><div class="allbuy"><span class="tuan">团</span><span>99元 单人体验一次</span></div></div></div></div></div></div></div>';
	$(oAddElement).insertBefore($("#morelist"));

}
function card()
{
	indexNum = 0;
	$("#newmorelist").remove();
	var addCardElement = '<div class="left fl refreshcontent"><img src="media/home/banner@3x.png"><h1>The Diner  啤酒配披萨</h1></div><div class="right fr refreshcontent"><img src="media/home/banner@3x.png"><h1>遇见你 很高兴  啤酒配披萨</h1></div><div class="mid fl"><div class="midleft refreshcontent"><img src="media/home/banner@3x.png"><h1>买了面包大面包也可以带有亲情人</h1><h2>面包也可以带有亲情面包也可以带有亲情面包也可以带有亲情</h2></div><div class="midright fr refreshcontent"><img src="media/home/banner@3x.png"><h1>买了面包大面包也可以带有亲情人</h1><h2>面包也可以带有亲情面包也可以带有亲情面包也可以带有亲情</h2></div></div>';
	$(addCardElement).insertBefore($("#morelist .botWrap"));
	
}

//点击刷新按钮旋转
$(function() {
	var i = 0;
    var usercenter = {
	init:function(){
        this.modal();
},
        modal: function() {
        	
            $(".square img").click(function(){   
            	i++;
                //点击箭头旋转180度
                    $(this).css({
                    	  "transform-origin":'center center', //旋转中心要是正中间 才行
						    "transform": 'rotate('+180*i+'deg)',
						    "-webkit-transform": 'rotate('+180*i+'deg)',
						    "-moz-transform": 'rotate('+180*i+'deg)',
						    "-ms-transform": 'rotate('+180*i+'deg)',
						    "-o-transform": 'rotate('+180*i+'deg)',
						    "transition": 'transform 0.2s', //过度时间 可调
						    "-moz-transition": '-moz-transform 0.2s',
						    "-moz-transition": '-moz-transform 0.2s',
						    "-o-transition": '-o-transform 0.2s',
						    "-ms-transition": '-ms-transform 0.2s' 
                    })
            })
        }
    }
    usercenter.init();
});
//商家搜罗tab切换
$(".coloroverlaywrap div").on("click",function(){
	$("#morelist .colorovertab").eq($(this).index()).show().siblings(".colorovertab").hide();
});
