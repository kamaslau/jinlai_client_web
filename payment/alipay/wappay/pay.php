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
    <meta name=version content="revision20180130">
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
                $(dom).qrcode(string);

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
        body{
            font-family: "Helvetica Neue",Helvetica,Arial,"Lucida Grande",sans-serif;
        }
        .new-btn-login-sp{
            padding: 1px;
            display: inline-block;
            width: 75%;
        }
        .new-btn-login {
            background-color: #02aaf1;
            color: #FFFFFF;
            font-weight: bold;
            border: none;
            width: 100%;
            height: 30px;
            border-radius: 5px;
            font-size: 16px;
        }
        #main{
            width:100%;
            margin:0 auto;
            font-size:14px;
        }
        .red-star{
            color:#f00;
            width:10px;
            display:inline-block;
        }
        .null-star{
            color:#fff;
        }
        .content{
            margin-top:5px;
        }
        .content dt{
            width:100px;
            display:inline-block;
            float: left;
            margin-left: 20px;
            color: #666;
            font-size: 13px;
            margin-top: 8px;
        }
        .content dd{
            margin-left:120px;
            margin-bottom:5px;
        }
        .content dd input {
            width: 85%;
            height: 28px;
            border: 0;
            -webkit-border-radius: 0;
            -webkit-appearance: none;
        }
        #btn-dd{
            margin: 20px;
            text-align: center;
        }
        .one_line{
            display: block;
            height: 1px;
            border: 0;
            border-top: 1px solid #eeeeee;
            width: 100%;
            margin-left: 20px;
        }
        .am-header {
            display: -webkit-box;
            display: -ms-flexbox;
            display: box;
            width: 100%;
            position: relative;
            padding: 7px 0;
            -webkit-box-sizing: border-box;
            -ms-box-sizing: border-box;
            box-sizing: border-box;
            background: #1D222D;
            height: 50px;
            text-align: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            box-pack: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            box-align: center;
        }
        .am-header h1 {
            -webkit-box-flex: 1;
            -ms-flex: 1;
            box-flex: 1;
            line-height: 18px;
            text-align: center;
            font-size: 18px;
            font-weight: 300;
            color: #fff;
        }
    </style>
</head>

<body text=#000000 bgColor="#ffffff" leftMargin=0 topMargin=4>
    <header class="am-header">
        <h1>支付宝手机网站支付接口快速通道(接口名：alipay.trade.wap.pay)</h1>
    </header>

    <div id="main">
        <form name=alipayment action='' method=post target="_blank">
            <div id="body" style="clear:left">
                <dl class="content">
                    <dt>商户订单号</dt>
                    <dd>
                        <input id="WIDout_trade_no" name="WIDout_trade_no" />
                    </dd>
                    <hr class="one_line">
                    <dt>订单名称</dt>
                    <dd>
                        <input id="WIDsubject" name="WIDsubject" />
                    </dd>
                    <hr class="one_line">
                    <dt>付款金额</dt>
                    <dd>
                        <input id="WIDtotal_amount" name="WIDtotal_amount" />
                    </dd>
                    <hr class="one_line">
                    <dt>商品描述</dt>
                    <dd>
                        <input id="WIDbody" name="WIDbody" />
                    </dd>
                    <hr class="one_line">
                    <dt></dt>
                    <dd id="btn-dd">
                        <span class="new-btn-login-sp">
                            <button class="new-btn-login" type="submit" style="text-align:center;">确认</button>
                        </span>
                    </dd>
                </dl>
            </div>
		</form>
	</div>
</body>

</html>