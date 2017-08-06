<?php 
require_once '../lib/WxPay.Api.php';
require_once 'WxPay.JsApiPay.php';

// ①、获取用户openid
/*
$type = $_GET['type'];
$body = $_GET['body'];
$order_id = $_GET['order_id'];
$total_fee = $_GET['total_fee'];
*/
$info_array = array('type', 'body', 'order_id', 'total_fee');
foreach ($info_array as $item):
	!empty($_GET[$item])? setcookie($item, $_GET[$item]): NULL;
endforeach;

$tools = new JsApiPay();
$openId = $tools->GetOpenid();

// ②、统一下单
$input = new WxPayUnifiedOrder();
// 设置必填参数；appid、mch_id、noncestr、spbill_create_ip、sign已填,商户无需重复填写
$input->SetOpenid($openId);
$input->SetNotify_url(WxPayConfig::NOTIFY_URL);
$input->SetTrade_type('JSAPI');
// 自定义订单号，此处仅作举例；与已经成功支付过的订单号相同的订单号将无法成功获取prepayID，因此测试和生产环境时请务必加前缀（by Kamas 'Iceberg' Lau）
$type = $_COOKIE['type'];
$body = $_COOKIE['body'];
$order_id = $_COOKIE['order_id'];
$total_fee = $_COOKIE['total_fee'];
$standard_order_id = date('YmdHis').'_'. $type.'_'. $order_id;
$input->SetOut_trade_no($standard_order_id); //商户订单号(自定义)
$input->SetTotal_fee($total_fee * 100); // 待支付金额，数字单位为分
$input->SetBody($body); // 商品描述
// 以下非必填参数，可根据实际情况选填
//$input->SetGoods_tag('test');
//$input->SetAttach('test');
//$input->SetTime_start(date('YmdHis'));
//$input->SetTime_expire(date('YmdHis', time() + 600));

$order = WxPayApi::unifiedOrder($input);

$jsApiParameters = $tools->GetJsApiParameters($order);

// ③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
?>
<!doctype html>
<html lang=zh-cn>
	<head>
		<meta charset=utf-8>
		<meta http-equiv=x-dns-prefetch-control content=on>
		<link rel=dns-prefetch href="https://cdn.key2all.com">
		<link rel=dns-prefetch href="https://images.bandaodian.com">
	    <title>微信支付 - 公众号支付</title>
		<meta name=robots content="noindex, nofollow">
		<meta name=version content="revision20170807">
		<meta name=author content="刘亚杰">
		<meta name=copyright content="刘亚杰">
		<meta name=contact content="kamaslau@outlook.com, http://weibo.com/kamaslau">
		<meta name=viewport content="width=device-width, user-scalable=0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<link rel=stylesheet media=all href="//cdn.key2all.com/css/reset.css">
		<link rel=stylesheet media=all href="//cdn.key2all.com/font-awesome/css/font-awesome.min.css">
		<style>
		* {box-sizing:border-box;}
		body {color:#333;background-color:#d4d5d7;}
			.container {background-color:#fff;width:95%;margin:0 auto;position:relative;padding:0 5% 5%;}
	
			#total_fee {color:#585858;border-top:3px solid #e0e3eb;border-bottom:1px solid #d0d8e4;font-size:60px;font-weight:400;line-height:68px;padding-bottom:20px;padding-top:50px;_margin-top:60px;}
			#detail {padding:18px 0 40px;}
				h1 {color:#4a4a4a;font-size:20px;line-height:24px;padding-bottom:16px;border-bottom: 1px solid #e5e7ea;}
				#info {color:#8e8e8e;line-height:26px;padding-top:10px;overflow:hidden;}
				#info>*{width:50%;display:inline;}
				#info dt {text-align:right;}
				#info dd {color:#333;text-align:left;}
	
			p#close_tip {color:#c40001;margin-top:15px;}
	
			button {color:#fff;font-size:18px;text-align:center;background-color:#1aad19;display:block;width:100%;height:48px;line-height:48px;border-radius:1rem;margin-top:15px;}
		</style>

		<!--<link rel="shortcut icon" href="//images.guangchecheng.com/logos/logo_32x32.png">-->
		<!--<link rel="apple-touch-icon" href="//images.guangchecheng.com/logos/logo_120x120.png">-->
	    <script>
		// 调用微信支付JSAPI进行支付
		function jsApiCall()
		{
			WeixinJSBridge.invoke(
				'getBrandWCPayRequest',
				<?php echo $jsApiParameters ?>,
				function(res){
					WeixinJSBridge.log(res.err_msg);
					if (res.err_msg == 'get_brand_wcpay_request:ok')
					{
						// AJAX根据订单号检查订单状态，若支付成功则转到订单确认页
						location.href = <?php echo WxPayConfig::CLIENT_URL.$type ?> + '/detail?id=<?php echo $order_id ?>';
					}
					else if (res.err_msg == 'get_brand_wcpay_request:cancel')
					{
						alert('您已取消支付');
					}
					else
					{
						alert('支付失败，请重新支付');
					}
				}
			);
		}

		function callpay()
		{
			if (typeof WeixinJSBridge == "undefined")
			{
			    if ( document.addEventListener )
				{
			        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
			    }
				else if (document.attachEvent)
				{
			        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
			        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
			    }
			}else{
			    jsApiCall();
			}
		}
		</script>
	</head>

<body class=wepay>
	<div id=maincontainer class=container>
		<div id=total_fee>
			<p>￥ <?php echo $total_fee ?></p>
		</div>
		<div id=detail>
			<h1><?php echo $body ?></h1>
			<dl id=info>
				<dt>订单编号</dt>
				<dd><?php echo $order_id ?></dd>
			</dl>
		</div>
		<p id=close_tip>完成支付后，您可以到 <a title="订单中心" href="<?php echo WxPayConfig::CLIENT_URL.'mine' ?>">个人中心</a> 查看相关信息。</p>
		<button type=button onclick="callpay()">确定</button>
	</div>
</body>
</html>