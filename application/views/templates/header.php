<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	// 检查当前设备信息
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$is_wechat = strpos($user_agent, 'MicroMessenger')? TRUE: FALSE;
	$is_ios = strpos($user_agent, 'iPhone')? TRUE: FALSE;
	$is_android = strpos($user_agent, 'Android')? TRUE: FALSE;

	// 生成SEO相关变量，一般为页面特定信息与在config/config.php中设置的站点通用信息拼接
	$title = isset($title)? $title.' - '.SITE_NAME: SITE_NAME.' - '.SITE_SLOGAN;
	$keywords = isset($keywords)? $keywords.',': NULL;
	$keywords .= SITE_KEYWORDS;
	$description = isset($description)? $description: NULL;
	$description .= SITE_DESCRIPTION;
?>
<!doctype html>
<html lang=zh-cn>
	<head>
		<meta charset=utf-8>
		<meta http-equiv=x-dns-prefetch-control content=on>
		<link rel=dns-prefetch href="<?php echo CDN_URL ?>">
		<title><?php echo $title ?></title>
		<meta name=description content="<?php echo $description ?>">
		<meta name=keywords content="<?php echo $keywords ?>">
		<meta name=version content="revision20170909">
		<meta name=author content="刘亚杰Kamas,青岛意帮网络科技有限公司产品部&amp;技术部">
		<meta name=copyright content="进来商城,青岛意帮网络科技有限公司">
		<meta name=contact content="kamaslau@dingtalk.com">

		<!--<meta name=viewport content="width=device-width,user-scalable=0">-->
		<meta name=viewport content="width=750,user-scalable=0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<?php //if ($is_wechat): ?>
		<script src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
		<script>
			<?php
				function curl($url, $params = NULL, $return = 'array', $method = 'get')
				{
				    $curl = curl_init();
				    curl_setopt($curl, CURLOPT_URL, $url);

				    // 设置cURL参数，要求结果保存到字符串中还是输出到屏幕上。
				    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				    curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');

					// 需要通过POST方式发送的数据
					if ($method === 'post'):
						$params['app_type'] = 'biz'; // 应用类型默认为biz
						curl_setopt($curl, CURLOPT_POST, count($params));
						curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
					endif;

				    // 运行cURL，请求API
					$result = curl_exec($curl);

					// 输出CURL请求头以便调试
					//var_dump(curl_getinfo($curl));

					// 关闭URL请求
				    curl_close($curl);

					// 转换返回的json数据为相应格式并返回
					if ($return === 'object'):
						$result = json_decode($result);
					elseif ($return === 'array'):
						$result = json_decode($result, TRUE);
					endif;

					return $result;
				}

				// 获取access_token
				function get_access_token()
				{
					$params = NULL;
					$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.WECHAT_APP_ID.'&secret='.WECHAT_APP_SECRET;
					$result = curl($url, $params, 'array');
					//var_dump($result);
					return $result['access_token'];
				}

				// 获取jsapi_ticket
				function get_jsapi_ticket($access_token)
				{
					$params = NULL;
					$url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$access_token.'&type=jsapi';
					$result = curl($url, $params, 'array');
					return $result['ticket'];
				}

				$access_token = get_access_token();
				$wesign['timestamp'] = time();
				$wesign['noncestr'] = 'Wm3WZYTPz0wzccnW';
				$wesign['jsapi_ticket'] = get_jsapi_ticket($access_token);
				$current_url = 'https://'. $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
				if (strpos($current_url, '#') !== FALSE) $current_url = substr($current_url, 0, strpos($current_url, '#'));
				$wesign['url'] = $current_url;

				// 微信JSAPI签名过程
				function wechat_sign_generate($params)
				{
					// 对参与签名的参数进行排序
					ksort($params);

					// 拼接字符串
					$param_string = '';
					foreach ($params as $key => $value)
						$param_string .= '&'. $key.'='.$value;
					$param_string = trim($param_string, '&'); // 清除开头的“&”
				
					// 计算字符串SHA1值
					$sign = SHA1($param_string);
					return $sign;
				}
			?>

			wx.config({
			    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
			    appId: '<?php echo WECHAT_APP_ID ?>', // 必填，公众号的唯一标识
			    timestamp: <?php echo $wesign['timestamp'] ?>, // 必填，生成签名的时间戳
			    nonceStr: '<?php echo $wesign['noncestr'] ?>', // 必填，生成签名的随机串
			    signature: '<?php echo wechat_sign_generate($wesign) ?>',// 必填，签名，见附录1
			    jsApiList: [
					'onMenuShareTimeline',
					'onMenuShareAppMessage',
					'hideMenuItems',
					'scanQRCode',
				] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
			});

			wx.ready(function(){
				// 隐藏部分按钮
				wx.hideMenuItems({
				    menuList:[
				    	'menuItem:share:qq', 'menuItem:share:QZone', 'menuItem:share:facebook', 'menuItem:copyUrl', 'menuItem:readMode', 'menuItem:openWithQQBrowser', 'menuItem:openWithSafari', 'menuItem:share:email',
				    ] // 要隐藏的菜单项，只能隐藏“传播类”和“保护类”按钮，所有menu项见附录3
				});

				// 分享到朋友圈
				wx.onMenuShareTimeline({
				    title: '分享一个好平台 <?php echo $title ?>', // 分享标题
				    link: '<?php echo 'https://'. $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] ?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
				    imgUrl: '<?php echo base_url('/media/icon120@3x.png') ?>', // 分享图标
				    success: function () {
				        // 用户确认分享后执行的回调函数
						alert('分享成功');
				    },
				    cancel: function () {
				        // 用户取消分享后执行的回调函数
						alert('未完成分享');
				    }
				});

				// 分享给朋友
				wx.onMenuShareAppMessage({
				    title: '分享一个好平台 <?php echo $title ?>', // 分享标题
				    desc: '<?php echo $description ?>', // 分享描述
				    link: '<?php echo 'https://'. $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] ?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
				    imgUrl: '<?php echo base_url('/media/icon120@3x.png') ?>', // 分享图标
				    type: '', // 分享类型,music、video或link，不填默认为link
				    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
				    success: function () {
				        // 用户确认分享后执行的回调函数
						alert('分享成功');
				    },
				    cancel: function () {
				        // 用户取消分享后执行的回调函数
						alert('您未完成分享');
				    }
				});

				// 调起扫一扫
				document.getElementById('scan').onclick = function (){

					wx.scanQRCode({
					    needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
					    scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
					    success: function (res){
						    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
							//alert(result);
						}
					});

					return false;
				};

				// 获取地理位置及网络类型
				document.getElementById('locate').onclick = function (){
					wx.getLocation({
					    type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
					    success: function (res) {
					        var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
					        var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
							alert(longitude + ',' +latitude);
					        //var speed = res.speed; // 速度，以米/每秒计
					        //var accuracy = res.accuracy; // 位置精度
					    }
					});
					wx.getNetworkType({
					    success: function (res) {
					        var networkType = res.networkType; // 返回网络类型2g，3g，4g，wifi
							alert(networkType);
					    }
					});
				
					return false;
				};
			});
		</script>
		<?php //endif ?>

		<script src="<?php echo CDN_URL ?>js/jquery-3.2.1.min.js"></script>
		<script defer src="<?php echo CDN_URL ?>js/js.cookie.js"></script>
		<script src="/js/main.js"></script>

		<link rel=stylesheet media=all href="<?php echo CDN_URL ?>css/reset.css">
		<link rel=stylesheet media=all href="<?php echo CDN_URL ?>bootstrap/css/bootstrap.min.css">
		<link rel=stylesheet media=all href="https://cdn.key2all.com/flat-ui/css/flat-ui.min.css">
		<link rel=stylesheet media=all href="<?php echo CDN_URL ?>font-awesome/css/font-awesome.min.css">
		<link rel=stylesheet media=all href="/css/style.css">

		<link rel="shortcut icon" href="<?php echo CDN_URL ?>icon/jinlai_client/icon28@3x.png">
		<link rel=apple-touch-icon href="<?php echo CDN_URL ?>icon/jinlai_client/icon120@3x.png">

		<link rel=canonical href="<?php echo current_url() ?>">

		<meta name=format-detection content="telephone=yes, address=no, email=no">
		<meta name=apple-itunes-app content="app-id=1066224229">
	</head>
<?php
	// 将head内容立即输出，让用户浏览器立即开始请求head中各项资源，提高页面加载速度
	ob_flush();flush();
?>

<!-- 内容开始 -->
	<body<?php echo (isset($class))? ' class="'.$class.'"': NULL; ?>>
		<noscript>
			<p>您的浏览器功能加载出现问题，请刷新浏览器重试；如果仍然出现此提示，请考虑更换浏览器。</p>
		</noscript>

<?php
	/**
	 * APP中调用webview时配合URL按需显示相应部分
	 * 此处以在APP中以WebView打开页面时不显示页面header部分为例
	 */
	//if ($is_wechat === FALSE):
?>
<?php //endif ?>
		<header id=header role=banner>
			<div class=container>
				<h1>
					<a id=logo title="<?php echo SITE_NAME ?>" href="<?php echo base_url() ?>"><?php echo SITE_NAME ?></a>
				</h1>

				<a id=locate class=nav-icon>
					<i class="fa fa-map-marker" aria-hidden="true"></i>
				</a>
				<a id=scan class=nav-icon>
					<i class="fa fa-qrcode" aria-hidden="true"></i>
				</a>
				<!--
				<a id=nav-switch class=nav-icon href="#header">
					<i class="fa fa-bars" aria-hidden=true></i>
				</a>
				<a id=to-mine class=nav-icon href="<?php echo base_url('mine') ?>">
					<i class="fa fa-user" aria-hidden=true></i>
				</a>
				-->
			</div>
		</header>

		<nav id=nav-header role=navigation>
			<div class=container>
				<div id=user-info class=row>
					<?php
						// 用户名
						$username = !empty($this->session->nickname)? $this->session->nickname: $this->session->mobile;
						// 用户头像
						$avatar = !empty($this->session->avatar)? $this->session->avatar: NULL;
					?>
					<figure class=col-xs-4>
						<a title="<?php echo $username ?>" href="<?php echo base_url('user/mine') ?>">
							<img class="img-circle" alt="<?php echo $username ?>" src="<?php echo $avatar ?>">
						</a>
					</figure>
					<div class=col-xs-8>
						<a title="<?php echo $username ?>" href="<?php echo base_url('user/mine') ?>">
							<h1><?php echo $username ?> <i class="fa fa-angle-right pull-right" aria-hidden=true></i></h1>
						</a>
					</div>
				</div>

				<ul id=user-records class=horizontal>
					<li class=col-xs-4><a title="收藏宝贝" href="<?php echo base_url('fav_item') ?>">收藏宝贝</a></li>
					<li class=col-xs-4><a title="关注店铺" href="<?php echo base_url('fav_biz') ?>">关注店铺</a></li>
					<li class=col-xs-4><a title="我的足迹" href="<?php echo base_url('footprint') ?>">我的足迹</a></li>
				</ul>

				<ul id=main-nav>
					<li><a title="我的订单" href="<?php echo base_url('order') ?>">我的订单</a></li>
					<li><a title="我的钱包" href="<?php echo base_url('balance') ?>">我的钱包</a></li>
					<li><a title="我的卡券" href="<?php echo base_url('coupon') ?>">我的卡券</a></li>
					<li><a title="我的地址" href="<?php echo base_url('address') ?>">我的地址</a></li>
					<!--<li><a title="邀请好友" href="<?php echo base_url('invite') ?>">邀请好友</a></li>-->
				</ul>

				<div id=user-panel>
					<ul id=user-actions class=horizontal>
						<?php if ( !isset($this->session->time_expire_login) ): ?>
						<li><a title="登录" href="<?php echo base_url('login') ?>">登录</a></li>
						<?php else: ?>
						<li><a title="设置" href="<?php echo base_url('setup') ?>">设置</a></li>
						<li><a title="退出" href="<?php echo base_url('logout') ?>">退出</a></li>
						<?php endif ?>
					</ul>
				</div>

				<a id=tel-flatform-public href="tel:4008820532">
					<i class="fa fa-phone" aria-hidden=true></i> 400-882-0532
				</a>

			</div>
		</nav>

		<!--
		<script>
		// 手机版菜单的显示和隐藏
		$(function(){
			var nav_icon = $('#nav-switch>i');
			$('#nav-switch').click(
				function(){
					var current_class = nav_icon.attr('class');
					if (current_class == 'fa fa-bars'){
						// 展开页首导航栏
						nav_icon.attr('class', 'fa fa-minus');
						$('#nav-header').stop().fadeIn(400);
						$('#nav-header>.container').animate({width:"85%"}, 300);
						nav_icon.css('color', '#ff484c');
					} else {
						hide_nav_header();
					}
					return false;
				}
			);

			// 点击展开的菜单可将其隐藏
			$('#nav-header').click(function(){
				hide_nav_header();
			});

			// 收起页首导航栏
			function hide_nav_header()
			{
				nav_icon.attr('class', 'fa fa-bars');
				$('#nav-header>.container').stop().animate({width:"0"}, 300);
				$('#nav-header').fadeOut(200);
				nav_icon.css('color', '#fff');
			}
		});
		</script>
		-->

		<main id=maincontainer role=main>
