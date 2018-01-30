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

        <link rel=stylesheet media=all href="<?php echo CDN_URL ?>css/reset.css">
		<!--
        <link rel=stylesheet media=all href="https://cdn-remote.517ybang.com/bootstrap/css/bootstrap.min.css">
		<link rel=stylesheet media=all href="https://cdn.key2all.com/flat-ui/css/flat-ui.min.css">
		<link rel=stylesheet media=all href="https://cdn-remote.517ybang.com/font-awesome/css/font-awesome.min.css">
		<link rel=stylesheet media=all href="/css/style.css">
		-->

		<link rel="shortcut icon" href="<?php echo CDN_URL ?>icon/jinlai_client/icon28@3x.png">
		<link rel=apple-touch-icon href="<?php echo CDN_URL ?>icon/jinlai_client/icon120@3x.png">
		
		<meta name=format-detection content="telephone=yes, address=no, email=no">
	</head>

<?php
	// 将head内容立即输出，让用户浏览器立即开始请求head中各项资源，提高页面加载速度
	ob_flush();flush();
?>