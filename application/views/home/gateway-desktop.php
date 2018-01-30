<style>
body {background-color:#b61b21;}

    #list-clients li {background-color:#fff;width:48%;border-radius:8%;}
        #list-clients li:nth-of-type(2n+0) {margin-left:4%;}
        #list-clients h3 {text-align:center;}
        #list-clients figure {padding:5rem;padding-top: 0;}

    .fa-apple {color:#b3b3b3;}
    .fa-android {color:#aacd06;}
    .fa-weixin {color:#51c332;}
</style>

<script defer src="/js/jquery.qrcode.min.js"></script>
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
            var mycanvas = dom.find('canvas').get(0);

            // 将转换后的img标签插入到html中，并移除canvas格式的二维码
            var img = convertCanvasToImage(mycanvas);
            dom.append(img).find('canvas').remove();
        }
    });
</script>

<div id=content class="container">
    <ul id=list-clients class="horizontal">
        <!--
        <li class="ios">
            <h3><i class="fa fa-apple" aria-hidden=true></i></h3>
            <figure class=qrcode data-qrcode-string="<?php echo base_url('gateway?app_platform=ios') ?>"></figure>
        </li>

        <li class="android">
            <h3><i class="fa fa-android" aria-hidden=true></i></h3>
            <figure class=qrcode data-qrcode-string="<?php echo base_url('gateway?app_platform=android') ?>"></figure>
        </li>
        -->

        <li>
            <h3><i class="fa fa-weixin" aria-hidden=true></i></h3>
            <figure class=qrcode data-qrcode-string="http://weixin.qq.com/r/2SphebLESu81rfYa93-L"></figure>
        </li>

        <li>
            <h3>
                <i class="fa fa-edge" aria-hidden=true></i>
                <i class="fa fa-firefox" aria-hidden=true></i>
                <i class="fa fa-chrome" aria-hidden=true></i>
                <i class="fa fa-opera" aria-hidden=true></i>
            </h3>
            <figure class=qrcode data-qrcode-string="<?php echo base_url() ?>"></figure>
        </li>
    </ul>
</div>
