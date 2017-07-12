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
		<!--<link rel=dns-prefetch href="https://cdn.key2all.com">-->
		<title><?php echo $title ?></title>
		<meta name=description content="<?php echo $description ?>">
		<meta name=keywords content="<?php echo $keywords ?>">
		<meta name=version content="revision20170712">
		<meta name=author content="刘亚杰Kamas">
		<meta name=copyright content="青岛意帮网络科技有限公司">
		<meta name=contact content="kamaslau@dingtalk.com">

		<meta name=viewport content="width=device-width,user-scalable=0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<script src="https://cdn.key2all.com/js/jquery/new.js"></script>
		<script defer src="https://cdn.key2all.com/js/jquery/jquery.cookie.js"></script>
		<!--<script defer src="/js/xx.js"></script>-->
		<!--<script asnyc src="/js/xx.js"></script>-->

		<link rel=stylesheet media=all href="https://cdn.key2all.com/css/reset.css">
		<link rel=stylesheet media=all href="https://cdn.key2all.com/bootstrap/css/bootstrap-3_3_7.min.css">
		<link rel=stylesheet media=all href="https://cdn.key2all.com/flat-ui/css/flat-ui.min.css">
		<link rel=stylesheet media=all href="https://cdn.key2all.com/font-awesome/css/font-awesome.min.css">
		<link rel=stylesheet media=all href="/css/style.css">

		<link rel="shortcut icon" href="//images.ybslux.com/logos/logo_32x32.png">
		<link rel=apple-touch-icon href="//images.ybslux.com/logos/logo_120x120.png">

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

				<a id=nav-switch class=nav-icon href="#header">
					<i class="fa fa-bars" aria-hidden=true></i>
				</a>
				<a id=to-mine class=nav-icon href="<?php echo base_url('mine') ?>">
					<i class="fa fa-user" aria-hidden=true></i>
				</a>
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
						<a title="<?php echo $username ?>" href="<?php echo base_url('mine') ?>">
							<img class="img-circle" alt="<?php echo $username ?>" src="<?php echo $avatar ?>">
						</a>
					</figure>
					<div class=col-xs-8>
						<a title="<?php echo $username ?>" href="<?php echo base_url('mine') ?>">
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
					<li><a title="我的钱包" href="<?php echo base_url('balance/mine') ?>">我的钱包</a></li>
					<li><a title="我的卡券" href="<?php echo base_url('coupon/mine') ?>">我的卡券</a></li>
					<li><a title="我的订单" href="<?php echo base_url('order/mine') ?>">我的订单</a></li>
					<li><a title="我的地址" href="<?php echo base_url('address/mine') ?>">我的地址</a></li>
					<li><a title="邀请好友" href="<?php echo base_url('invite/mine') ?>">邀请好友</a></li>
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

		<main id=maincontainer role=main>
