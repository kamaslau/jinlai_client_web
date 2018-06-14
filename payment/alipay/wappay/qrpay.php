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

require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'service/AlipayTradeService.php';
require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'buildermodel/AlipayTradeWapPayContentBuilder.php';
require dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'./../config.php';

if ( !empty($_POST['WIDout_trade_no']) && trim($_POST['WIDout_trade_no']) != '')
{
    //商户订单号，商户网站订单系统中唯一订单号，必填
    $out_trade_no = $_POST['WIDout_trade_no'];

    //订单名称，必填
    $subject = $_POST['WIDsubject'];

    //付款金额，必填
    $total_amount = $_POST['WIDtotal_amount'];

    //商品描述，可空
    $body = $_POST['WIDbody'];

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
    <meta name=version content="revision20180614">
    <meta name=author content="刘亚杰Kamas,青岛意帮网络科技有限公司产品部&amp;技术部">
    <meta name=copyright content="进来商城,青岛意帮网络科技有限公司">
    <meta name=contact content="kamaslau@dingtalk.com">
    <!--<meta name=viewport content="width=device-width,user-scalable=0">-->
    <meta name=viewport content="width=750,user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <script src="<?php echo CDN_URL ?>js/jquery-3.2.1.min.js"></script>
    <script defer src="<?php echo CDN_URL ?>js/jquery.qrcode.min.js"></script>
    <script>
        $(function(){
            // 生成二维码
            $('figure.qrcode').each(function(){
                var qrcode_string = $(this).attr('data-qrcode-string');
                var dom = $(this);
                qrcode_generate(qrcode_string, dom);
            });
            function qrcode_generate(string, dom)
            {
                // 若未传入二维码容器，则默认为#qrcode
                var dom = dom || '#qrcode';

                // 创建二维码并转换为图片格式，以使微信能识别该二维码
                $(dom).qrcode({
                    foreground: "#b61b21",
                    background: "#fff",
                    text: string,
                });

                // 将canvas转换为Base64格式的图片内容
                function convertCanvasToImage(canvas)
                {
                    // 新Image对象，可以理解为DOM
                    var image = new Image();
                    // canvas.toDataURL 返回的是一串Base64编码的URL，当然,浏览器自己肯定支持
                    // 指定格式 PNG
                    image.src = canvas.toDataURL("image/png");
                    return image;
                }

                // 获取网页中的canvas对象
                var mycanvas = document.getElementsByTagName('canvas')[0];

                // 将转换后的img标签插入到html中
                var img = convertCanvasToImage(mycanvas);
                $(dom).append(img);
                dom.find('canvas').remove(); // 移除canvas格式的二维码
            }
        });
    </script>
    <script>
        window.onload = function()
        {
            GetDateNow();
        }

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
            sNow += String(vNow.getMilliseconds());

            document.getElementById("WIDout_trade_no").value = sNow;
            document.getElementById("WIDsubject").value = '进来商城入驻意向金';
            document.getElementById("WIDtotal_amount").value = '1000';
            document.getElementById("WIDbody").value = '确定入驻进来商城意向，预留席位';
        }
    </script>

    <link rel=stylesheet media=all href="<?php echo CDN_URL ?>css/reset.css">
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
</head>

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
                </li>
            </ul>

        </div>
    </body>
</html>