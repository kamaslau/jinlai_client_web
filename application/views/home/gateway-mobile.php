<style>
    figure.qrcode {color:#ae424f;background-color:#ae424f;}
    canvas {padding:10rem;}
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
                foreground: "#ae424f",
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

<?php if ($this->user_agent['is_ios'] === TRUE): ?>
iOS
<?php elseif ($this->user_agent['is_android'] === TRUE): ?>
Android
<?php endif ?>

<a id="wechat-scan" class="btn btn-primary btn-block">
    <i class="fa fa-qrcode" aria-hidden="true"></i>
    <i class="fa fa-barcode" aria-hidden="true"></i>
    扫一扫
</a>