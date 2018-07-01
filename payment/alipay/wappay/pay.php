<?php
    $page_title = '支付宝 - 网页支付';
/* *
 * 功能：支付宝手机网站支付接口(alipay.trade.wap.pay)接口调试入口页面
 * 版本：2.0
 * 修改日期：2016-11-01
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 请确保项目文件有可写权限，不然打印不了日志。
 */

header("Content-type: text/html; charset=utf-8");

require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'service/AlipayTradeService.php';
require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'buildermodel/AlipayTradeWapPayContentBuilder.php';
require dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'./../config.php';

/*$info_array = array('type', 'body', 'order_id', 'total_fee');
foreach ($info_array as $item):
    ${$item} = empty($_GET[$item])? NULL: $_GET[$item];
endforeach;

//超时时间
$timeout_express = '1m';

$payRequestBuilder = new AlipayTradeWapPayContentBuilder();
$payRequestBuilder->setBody($body);
$payRequestBuilder->setSubject($subject);
$payRequestBuilder->setOutTradeNo($out_trade_no);
$payRequestBuilder->setTotalAmount($total_amount);
$payRequestBuilder->setTimeExpress($timeout_express);

$payResponse = new AlipayTradeService($config);
$result = $payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);

return;*/


if ( !empty($_POST['WIDout_trade_no']) && trim($_POST['WIDout_trade_no']) != '')
{
    // 商户订单号，商户网站订单系统中唯一订单号，必填
    $out_trade_no = $_POST['WIDout_trade_no'];

    // 订单名称，必填
    $subject = $_POST['WIDsubject'];

    // 付款金额，必填
    $total_amount = $_POST['WIDtotal_amount'];

    // 商品描述，可空
    $body = $_POST['WIDbody'];

    // 超时时间
    $timeout_express = '1m';

    $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
    $payRequestBuilder->setBody($body);
    $payRequestBuilder->setSubject($subject);
    $payRequestBuilder->setOutTradeNo($out_trade_no);
    $payRequestBuilder->setTotalAmount($total_amount);
    $payRequestBuilder->setTimeExpress($timeout_express);

    $payResponse = new AlipayTradeService($config);
    $result = $payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);

    return ;
}
?>
<!doctype html>
<html lang=zh-cn>
<head>
    <meta charset=utf-8>
    <meta http-equiv=x-dns-prefetch-control content=on>
    <?php define('CDN_URL', 'https://cdn-remote.517ybang.com/') ?>
    <link rel=dns-prefetch href="<?php echo CDN_URL ?>">
    <title><?php echo $page_title ?></title>
    <meta name=robots content="noindex, nofollow">
    <meta name=version content="revision20180701">
    <meta name=author content="刘亚杰Kamas,青岛意帮网络科技有限公司产品部&amp;技术部">
    <meta name=copyright content="进来商城,青岛意帮网络科技有限公司">
    <meta name=contact content="kamaslau@dingtalk.com">
    <!--<meta name=viewport content="width=device-width,user-scalable=0">-->
    <meta name=viewport content="width=750,user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script>
        window.onload = function()
        {
            var current_time = GetDateNow();

            document.getElementById("WIDout_trade_no").value = current_time+'_'+get_url_param('type')+'_'+get_url_param('order_id');
            document.getElementById("WIDsubject").value = get_url_param('body');
            document.getElementById("WIDtotal_amount").value = get_url_param('total_fee');
            document.getElementById("WIDbody").value = get_url_param('body');

            // 自动提交表单
            var form = document.getElementsByTagName('form')[0];
            form.submit();
        }

        // 根据键名获取URL中参数值
        function get_url_param(name)
        {
            var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            return (r != null)? decodeURI(r[2]): null;
        }

        // 获取当前时间
        function GetDateNow()
        {
            var vNow = new Date();
            var sNow = '';
            sNow += String(vNow.getFullYear());
            sNow += String(vNow.getMonth() + 1);
            sNow += String(vNow.getDate());
            sNow += String(vNow.getHours());
            sNow += String(vNow.getMinutes());
            sNow += String(vNow.getSeconds());
            //sNow += String(vNow.getMilliseconds());

            return sNow;
        }
    </script>

    <link rel=stylesheet media=all href="<?php echo CDN_URL ?>css/reset.css">
</head>

<body>
    <header class="am-header">
        <h1>支付宝手机网站支付接口快速通道(接口名：alipay.trade.wap.pay)</h1>
    </header>

    <div id="main">
        <form name=alipayment action='' method=post target="_blank">
            <div id="body" style="clear:left">
                <dl class="content">
                    <dt>商户订单号</dt>
                    <dd>
                        <input id="WIDout_trade_no" name="WIDout_trade_no">
                    </dd>
                    <hr class="one_line">
                    <dt>订单名称</dt>
                    <dd>
                        <input id="WIDsubject" name="WIDsubject">
                    </dd>
                    <hr class="one_line">
                    <dt>付款金额</dt>
                    <dd>
                        <input id="WIDtotal_amount" name="WIDtotal_amount">
                    </dd>
                    <hr class="one_line">
                    <dt>商品描述</dt>
                    <dd>
                        <input id="WIDbody" name="WIDbody">
                    </dd>
                    <hr class="one_line">
                    <dt></dt>
                    <dd id="btn-dd">
                        <span class="new-btn-login-sp">
                            <button class="new-btn-login" type=submit style="text-align:center;">确认</button>
                        </span>
                    </dd>
                </dl>
            </div>
		</form>
	</div>
</body>

</html>