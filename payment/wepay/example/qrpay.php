<?php
$page_title = '微信支付 - 扫码支付';
require_once 'header.php';

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
//$url1 = $notify->GetPrePayUrl("123456789");

//模式二
/**
 * 流程：
 * 1、调用统一下单，取得code_url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、支付完成之后，微信服务器会通知支付成功
 * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */
$input = new WxPayUnifiedOrder();
$input->SetTrade_type('NATIVE');
$input->SetNotify_url(WxPayConfig::NOTIFY_URL);

$standard_order_id = 'biz_res_'.WxPayConfig::MCHID.date('YmdHis'); // 商户订单号
$input->SetOut_trade_no($standard_order_id); // 商户订单号
$input->SetTotal_fee('1000' * 100); // 待支付金额，数字单位为分
$input->SetBody('进来商城入驻意向金'); // 商品描述
$input->SetProduct_id('biz_join_reserve');
// 以下非必填参数，可根据实际情况选填
//$input->SetGoods_tag('test');
//$input->SetAttach('test');
//$input->SetTime_start(date('YmdHis'));
//$input->SetTime_expire(date('YmdHis', time() + 600));
$result = $notify->GetPayUrl($input);
$url2 = $result['code_url'];

$input = new WxPayUnifiedOrder();
$input->SetTrade_type('NATIVE');
$input->SetNotify_url(WxPayConfig::NOTIFY_URL);

$standard_order_id = 'biz_dep_'.WxPayConfig::MCHID.date('YmdHis'); // 商户订单号
$input->SetOut_trade_no($standard_order_id); // 商户订单号
$input->SetTotal_fee('10000' * 100); // 待支付金额，数字单位为分
$input->SetBody('进来商城入驻保证金'); // 商品描述
$input->SetProduct_id('biz_join_deposit');
// 以下非必填参数，可根据实际情况选填
//$input->SetGoods_tag('test');
//$input->SetAttach('test');
//$input->SetTime_start(date('YmdHis'));
//$input->SetTime_expire(date('YmdHis', time() + 600));
$result = $notify->GetPayUrl($input);
$url3 = $result['code_url'];
?>

<style>
    @font-face {
        font-family: Impact;
        src:url('/font/Impact.ttf'); /* ttf字体格式的在移动端兼容性足够好 */
    }

    html,body{margin:0 auto;height:100%;}
    body {color:#fff;background:#b61b21 url('/media/images/payment/gateway/bg-body.png') no-repeat center center;background-size:cover;padding-top:21.2%;}
    li {width:27.5%;margin:0 auto 14.5%;text-align:center;}
    figure.qrcode {background-color:#fff;border-radius:5px;padding:5px;}

    h2,h3 {line-height:1;font-family:"微软雅黑",sans-serif;}
    h2 {font-size:40px;height:40px;}
    small {font-size:50px;height:50px;line-height:1;font-family:Impact;margin-top:8px;display:block;}
    h3 {font-size:24px;height:24px;margin:20px 0 22px;}
</style>

	<body class="payment gateway">
		<div id=content class=container>

			<ul>
                <li>
                    <h2>进来商城</h2>
                    <small>COME IN</small>
                    <h3>入驻意向金</h3>

                    <figure class=qrcode data-qrcode-string="<?php echo $url2 ?>"></figure>
                </li>

                <li>
                    <h2>进来商城</h2>
                    <small>COME IN</small>
                    <h3>入驻保证金</h3>

                    <figure class=qrcode data-qrcode-string="<?php echo $url3 ?>"></figure>

                    <?php //$url3 = WxPayConfig::CLIENT_URL. 'payment/wepay/example/qrcode.php?data='. urlencode($url3); ?>
                    <!--<img alt="进来商城入驻保证金" src="<?php echo $url3 ?>" style="width:200px;height:200px;">-->
                    <!--<a href="<?php echo urlencode($url3) ?>">我要入驻</a>-->
                </li>
            </ul>

		</div>
	</body>
</html>