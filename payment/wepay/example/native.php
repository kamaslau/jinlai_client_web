<?php
require_once '../lib/WxPay.Api.php';
require_once 'WxPay.NativePay.php';

//模式一
/**
 * 流程：
 * 1、组装包含支付信息的url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、确定支付之后，微信服务器会回调预先配置的回调地址，在【微信开放平台-微信支付-支付配置】中进行配置
 * 4、在接到回调通知之后，用户进行统一下单支付，并返回支付信息以完成支付（见：native_notify.php）
 * 5、支付完成之后，微信服务器会通知支付成功
 * 6、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */
$notify = new NativePay();
$url1 = $notify->GetPrePayUrl("123456789");

//模式二
/**
 * 流程：
 * 1、调用统一下单，取得code_url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、支付完成之后，微信服务器会通知支付成功
 * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */
$input = new WxPayUnifiedOrder();
$input->SetBody('test');
$input->SetAttach('test');
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
$input->SetTotal_fee("1");
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag('test');
$input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
$input->SetTrade_type('NATIVE');
$input->SetProduct_id("123456789");
$result = $notify->GetPayUrl($input);
$url2 = $result["code_url"];
?>
<!doctype html>
<html lang=zh-cn>
	<head>
		<meta charset=utf-8>
		<meta http-equiv=x-dns-prefetch-control content=on>
		<link rel=dns-prefetch href="https://cdn.key2all.com">
		<link rel=dns-prefetch href="https://images.guangchecheng.com">
	    <title>微信支付 - 扫码支付</title>
		<meta name=robots content="noindex, nofollow">
		<meta name=version content="revision20170807">
		<meta name=author content="刘亚杰">
		<meta name=copyright content="刘亚杰">
		<meta name=contact content="kamaslau@outlook.com, http://weibo.com/kamaslau">
		<meta name=viewport content="width=device-width, user-scalable=0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<link rel=stylesheet media=all href="//cdn.key2all.com/css/reset.css">
		<link rel=stylesheet media=all href="//cdn.key2all.com/font-awesome/css/font-awesome.min.css">
		
		<!--<link rel="shortcut icon" href="//images.guangchecheng.com/logos/logo_32x32.png">-->
		<!--<link rel="apple-touch-icon" href="//images.guangchecheng.com/logos/logo_120x120.png">-->
	</head>
	<body>
		<div style="margin-left: 10px;color:#556B2F;font-size:30px;font-weight: bolder;">扫描支付模式一</div><br/>
		<img alt="模式一扫码支付" src="http://paysdk.weixin.qq.com/example/qrcode.php?data=<?php echo urlencode($url1) ?>" style="width:150px;height:150px;"/>
		<br/><br/><br/>
		<div style="margin-left: 10px;color:#556B2F;font-size:30px;font-weight: bolder;">扫描支付模式二</div><br/>
		<img alt="模式二扫码支付" src="http://paysdk.weixin.qq.com/example/qrcode.php?data=<?php echo urlencode($url2) ?>" style="width:150px;height:150px;"/>
	
	</body>
</html>