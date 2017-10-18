//banner焦点图
		var swiper = new Swiper('.swiper-container', {
	        pagination: '.swiper-pagination',
	        paginationClickable: true,
	        autoplay: 2000,
	        loop:true
	   });	
	   //左右滑动的滑块
	   var mySwiper1 = new Swiper('.swiper-container5', {
	        scrollbar: '.swiper-scrollbar',
	        scrollbarHide: false,
	        slidesPerView: 'auto',
	        centeredSlides: false,
	        grabCursor: true,
	        spaceBetween : 10,
	    });
    	//列表切换
        var mySwiper = new Swiper('.swiper-container2', {
            onSlideChangeEnd: function (swiper) {
                var j=mySwiper.activeIndex;
                $('.maple-tab li, .maple-tab2 li').removeClass('active').eq(j).addClass('active');
            }
        });
       
        /*列表切换*/
        $('.maple-tab li, .maple-tab2 li').on('click', function (e) {
            e.preventDefault();
            //得到当前索引
            var i=$(this).index();
            $('.maple-tab li, .maple-tab2 li').removeClass('active').eq(i).addClass('active');
            mySwiper.slideTo(i,1000,false);
        });
        //色块下降效果
		 var x = 0.7;
        $(".swiper-wrapper .move").on("click",function(){
        	$(".colorarea").stop().animate({
        		'height':0.7 + 'rem'
        	},500);
        	$(".colorarea").eq($(this).parents().index() - 2).stop().animate({
        		'height':0.3 + 'rem'
        	},1000);

        });
      //下拉刷新
    var loadFlag = true;
	var oi = 0;
	var mySwiper6 = new Swiper('.swiper-container6',{
//		direction: 'vertical',
//		scrollbar: '.swiper-scrollbar',
		slidesPerView: 'auto',
//		mousewheelControl: true,
//		freeMode: true,
//		onTouchMove: function(swiper){		//手动滑动中触发
//			var _viewHeight = document.getElementsByClassName('swiper-wrapper')[0].offsetHeight;
//          var _contentHeight = document.getElementsByClassName('swiper-slide')[0].offsetHeight;
//          
//          
//          if(mySwiper6.translate < 50 && mySwiper6.translate > 0) {
//				$(".init-loading").html('下拉刷新...').show();
//			}else if(mySwiper6.translate > 50 ){
//				$(".init-loading").html('释放刷新...').show();
//			}
//		},
//		onTouchEnd: function(swiper) {
//			var _viewHeight = document.getElementsByClassName('swiper-wrapper')[0].offsetHeight;
//          var _contentHeight = document.getElementsByClassName('swiper-slide')[0].offsetHeight;
//           // 上拉加载
//          if(mySwiper6.translate <= _viewHeight - _contentHeight - 50 && mySwiper6.translate < 0) {
//              // console.log("已经到达底部！");
//             
//              if(loadFlag){
//              	$(".loadtip").html('正在加载...');
//              }else{
//              	$(".loadtip").html('没有更多啦！');
//              }
//              
//              setTimeout(function() {
//                  for(var i = 0; i <5; i++) {
//                  	oi++;
//                      $(".list-group").eq(mySwiper7.activeIndex).find(".list-group-item").append('<div class="list">我是加载出来的'+oi+'...</div>');
//                  }
//                   $(".loadtip").html('上拉加载更多...');
//                  mySwiper6.update(); // 重新计算高度;
//              }, 800);
//          }
//          
//          // 下拉刷新
//          if(mySwiper6.translate >= 50) {
//              $(".init-loading").html('正在刷新...').show();
//              $(".loadtip").html('上拉加载更多');
//              loadFlag = true;
//              
//              setTimeout(function() {
//                  $(".refreshtip").show(0);
//                  $(".init-loading").html('刷新成功！');
//                  setTimeout(function(){
//                  	$(".init-loading").html('').hide();
//                  },800);
//                  $(".loadtip").show(0);
//                  
//                  //刷新操作
//                  mySwiper6.update(); // 重新计算高度;
//              }, 1000);
//          }else if(mySwiper6.translate >= 0 && mySwiper6.translate < 50){
//          	$(".init-loading").html('').hide();
//          }
//          return false;
//		}
	});
	var mySwiper7 = new Swiper('.swiper-container7',{
		onTransitionEnd: function(swiper){
			
			$('.w').css('transform', 'translate3d(0px, 0px, 0px)')
			$('.swiper-container2 .swiper-slide-active').css('height','auto').siblings('.swiper-slide').css('height','0px');
			mySwiper6.update();
			
			$('.tab a').eq(mySwiper7.activeIndex).addClass('active').siblings('a').removeClass('active');
		}
		
	});
	$('.tab a').click(function(){
		
		$(this).addClass('active').siblings('a').removeClass('active');
		mySwiper7.slideTo($(this).index(), 500, false)
		
		$('.w').css('transform', 'translate3d(0px, 0px, 0px)')
		$('.swiper-container7 .swiper-slide-active').css('height','auto').siblings('.swiper-slide').css('height','0px');
		mySwiper6.update();
	});
