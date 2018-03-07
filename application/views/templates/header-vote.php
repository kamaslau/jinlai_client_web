<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

    // 生成SEO相关变量，一般为页面特定信息与在config/config.php中设置的站点通用信息拼接
    $title = isset($title)? $title: SITE_NAME.' - '.SITE_SLOGAN;
    $keywords = isset($keywords)? $keywords.',': NULL;
    $keywords .= SITE_KEYWORDS;
    $description = isset($description)? $description: NULL;
    $description .= SITE_DESCRIPTION;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset=utf-8>
		<meta http-equiv=x-dns-prefetch-control content=on>
		<link rel=dns-prefetch href="<?php echo CDN_URL ?>">
		<title><?php echo $title ?></title>
		<meta name=description content="<?php echo $description ?>">
		<meta name=keywords content="<?php echo $keywords ?>">
		<meta name=version content="revision20180308">
		<meta name=author content="刘亚杰Kamas,青岛意帮网络科技有限公司产品部&amp;技术部">
		<meta name=copyright content="进来商城,青岛意帮网络科技有限公司">
		<meta name=contact content="kamaslau@dingtalk.com">

        <meta name=viewport content="width=750,user-scalable=0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<script>
            var user_agent = new Object();
            user_agent.is_wechat = <?php echo ($this->user_agent['is_wechat'])? 'true': 'false' ?>;
            user_agent.is_ios = <?php echo ($this->user_agent['is_ios'])? 'true': 'false' ?>;
            user_agent.is_android = <?php echo ($this->user_agent['is_android'])? 'true': 'false' ?>;
        </script>
        <script src="<?php echo CDN_URL ?>js/jquery-3.3.1.min.js"></script>
        <script defer src="<?php echo CDN_URL ?>font-awesome/v5.0.8/fontawesome-all.min.js"></script>
        <script defer src="/js/vote.js"></script>
        <script defer src="/js/jquery.downCount.js"></script>

		<?php
            if ($this->user_agent['is_wechat']):

            function curl($url, $params = NULL, $return = 'array', $method = 'get')
            {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);

                // 设置cURL参数，要求结果保存到字符串中还是输出到屏幕上。
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');

                // 需要通过POST方式发送的数据
                if ($method === 'post'):
                    $params['app_type'] = 'biz'; // 应用类型默认为biz
                    curl_setopt($curl, CURLOPT_POST, count($params));
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                endif;

                // 运行cURL，请求API
                $result = curl_exec($curl);

                // 输出CURL请求头以便调试
                //var_dump(curl_getinfo($curl));

                // 关闭URL请求
                curl_close($curl);

                // 转换返回的json数据为相应格式并返回
                if ($return === 'object'):
                    $result = json_decode($result);
                elseif ($return === 'array'):
                    $result = json_decode($result, TRUE);
                endif;

                return $result;
            }

            // 获取access_token
            function get_access_token()
            {
                $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.WECHAT_APP_ID.'&secret='.WECHAT_APP_SECRET;
                $result = curl($url);
                //var_dump($result);
                return $result['access_token'];
            }

            // 获取jsapi_ticket
            function get_jsapi_ticket($access_token)
            {
                $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$access_token.'&type=jsapi';
                $result = curl($url);
                return $result['ticket'];
            }

            // 微信JSAPI签名过程
            function wechat_sign_generate($params)
            {
                // 对参与签名的参数进行排序
                ksort($params);

                // 拼接字符串
                $param_string = '';
                foreach ($params as $key => $value)
                    $param_string .= '&'. $key.'='.$value;
                $param_string = trim($param_string, '&'); // 清除开头的“&”

                // 计算字符串SHA1值
                $sign = SHA1($param_string);
                return $sign;
            }

            // 获取sns_token
            function get_sns_token($code)
            {
                $url =  'https://api.weixin.qq.com/sns/oauth2/access_token?grant_type=authorization_code&appid='.WECHAT_APP_ID.'&secret='.WECHAT_APP_SECRET.'&code='.$code;
                $result = curl($url);
                return $result;
            }

            // 重新获取sns_token
            function refresh_sns_token($refresh_token)
            {
                $url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?grant_type=refresh_token&appid='.WECHAT_APP_ID.'&refresh_token='.$refresh_token;
                $result = curl($url);
                return $result;
            }

            // 获取用户资料
            function get_user_info($access_token, $openid)
            {
                $url = 'https://api.weixin.qq.com/cgi-bin/user/info?lang=zh_CN&access_token='.$access_token.'&openid='.$openid;
                $result = curl($url);
                return $result;
            }

            // 使用微信union_id登录
            function login_wechat($union_id)
            {
                $params = array(
                    'wechat_union_id' => $union_id
                );
                $url = api_url('account/login_wechat');
                $result = curl($url, $params, 'array', 'post');
                if ($result['status'] !== 200):
                    return FALSE;

                else:
                    return $result['content'];

                endif;
            }

            // 获取access_token；若已获得授权则一并获取微信用户资料
            $access_token = get_access_token();

            if (empty( get_cookie('wechat_subscribe') ))
                set_cookie('wechat_subscribe', 0);

            // 若无微信公众号关注记录，则初始化为未关注
            if ( ! isset($this->session->wechpat_subscribe)):
                $this->session->wechat_subscribe = get_cookie('wechat_subscribe'); // 标记当前code为已使用;
            endif;

            // 若未登录且从微信登录页转入，则尝试登录
            $code = $this->input->get('code');
            $last_code_used = get_cookie('last_code_used');
            if ( !empty($code) && ($last_code_used != $code)):
                // 清除当前登录信息
                //$this->session->sess_destroy();
                set_cookie('wechat_subscribe', 0);

                // 获取微信用户资料
                $sns_token = get_sns_token($code);
                $sns_info = get_user_info($access_token, $sns_token['openid']);
                set_cookie('last_code_used', $code); // 标记当前code为已使用

                // 若当前用户已订阅微信公众号，尝试使用微信union_id登录本站账户
                if ($sns_info['subscribe'] == 1 && isset($sns_token['unionid'])):
                    // 尝试使用微信union_id登录
                    $user_info = login_wechat($sns_token['unionid']);
                    if ($user_info !== FALSE):
                        // 将信息键值对写入session
                        foreach ($user_info as $key => $value):
                            $user_data[$key] = $value;
                        endforeach;
                        $user_data['time_expire_login'] = time() + 60*60*24 *30; // 默认登录状态保持30天
                        $this->session->set_userdata($user_data);

                        set_cookie('wechat_subscribe', 1); // 标记当前已关注微信公众号
                        $this->session->wechat_subscribe = 1;
                        $this->session->sns_info = json_encode($sns_info);
                    endif;
                endif;
            endif;

            // 生成微信网页API签名参数
            $wesign['timestamp'] = time();
            $wesign['noncestr'] = 'Wm3WZYTPz0wzccnW';
            $wesign['jsapi_ticket'] = get_jsapi_ticket($access_token);
            $current_url = 'https://'. $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
            if (strpos($current_url, '#') !== FALSE) $current_url = substr($current_url, 0, strpos($current_url, '#'));
            $wesign['url'] = $current_url;
        ?>
        <script src="https://res.wx.qq.com/open/js/jweixin-1.3.0.js"></script>
        <script>
        $(function(){
            // 微信用户信息
            var wx_userinfo;
            wx_userinfo_subscribe = <?php echo get_cookie('wechat_subscribe') ?>;
            if (wx_userinfo_subscribe != 1)
            {
                $('#follow-guide').show();
            }

            wx.config({
                debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
                appId: '<?php echo WECHAT_APP_ID ?>', // 必填，公众号的唯一标识
                timestamp: <?php echo $wesign['timestamp'] ?>, // 必填，生成签名的时间戳
                nonceStr: '<?php echo $wesign['noncestr'] ?>', // 必填，生成签名的随机串
                signature: '<?php echo wechat_sign_generate($wesign) ?>',// 必填，签名，见附录1
                jsApiList: [
                    'onMenuShareTimeline',
                    'onMenuShareAppMessage',
                    'hideMenuItems',
                    'scanQRCode',
                ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
            });

            wx.ready(function(){
                // 隐藏部分按钮
                wx.hideMenuItems({
                    menuList:[
                        'menuItem:share:qq', 'menuItem:share:QZone', 'menuItem:share:facebook', /*'menuItem:copyUrl',*/ 'menuItem:readMode', 'menuItem:openWithQQBrowser', 'menuItem:openWithSafari', 'menuItem:share:email',
                    ] // 要隐藏的菜单项，只能隐藏“传播类”和“保护类”按钮，所有menu项见附录3
                });

                // 分享到朋友圈
                wx.onMenuShareTimeline({
                    title: '<?php echo $title ?>', // 分享标题
                    link: '<?php echo 'https://'. $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] ?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                    imgUrl: '<?php echo base_url('/media/icon120@3x.png') ?>', // 分享图标
                    success: function () {
                        // 用户确认分享后执行的回调函数
                        alert('分享成功');
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                        alert('未完成分享');
                    }
                });

                // 分享给朋友
                wx.onMenuShareAppMessage({
                    title: '<?php echo $title ?>', // 分享标题
                    desc: '<?php echo $description ?>', // 分享描述
                    link: '<?php echo 'https://'. $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] ?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                    imgUrl: '<?php echo base_url('/media/icon120@3x.png') ?>', // 分享图标
                    type: '', // 分享类型,music、video或link，不填默认为link
                    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                    success: function () {
                        // 用户确认分享后执行的回调函数
                        alert('分享成功');
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                        alert('您未完成分享');
                    }
                });

                // 调起扫一扫
                document.getElementById('wechat-scan').onclick = function (){

                    wx.scanQRCode({
                        needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                        scanType: ['qrCode','barCode'], // 可以指定扫二维码还是一维码，默认二者都有
                        success: function (res){
                            var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
                            //TODO 若为条形码，输出条码；若为二维码，转到URL
                            alert(JSON.stringify(res));
                        }
                    });

                    return false;
                };

                // 获取地理位置及网络类型
                document.getElementById('locate').onclick = function (){
                    wx.getLocation({
                        type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
                        success: function (res) {
                            var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                            var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                            alert(longitude + ',' +latitude);
                            //var speed = res.speed; // 速度，以米/每秒计
                            //var accuracy = res.accuracy; // 位置精度
                        }
                    });
                    wx.getNetworkType({
                        success: function (res) {
                            var networkType = res.networkType; // 返回网络类型2g，3g，4g，wifi
                            alert(networkType);
                        }
                    });

                    return false;
                };
            }); // end wx.ready
        });
        </script>
        <?php endif ?>

		<!--清除浏览器默认样式css-->
		<link rel=stylesheet media=all href="<?php echo CDN_URL ?>css/reset.css">
		<!--公用部分css-->
        <?php if ($this->session->time_expire_login > time()): ?>
        <script defer src="/js/file-upload.js"></script>
        <link rel=stylesheet media=all href="/css/file-upload.css">
        <?php endif ?>

        <link rel=stylesheet media=all href="/css/vote.css">


        <link rel=canonical href="<?php echo current_url() ?>">
        <link rel="shortcut icon" href="<?php echo CDN_URL ?>icon/jinlai_client/icon28@3x.png">

        <?php if ($this->user_agent['is_mobile']): ?>
        <meta name=format-detection content="telephone=yes, address=no, email=no">
        <?php endif ?>
    </head>

<?php
    // 将head内容立即输出，让用户浏览器立即开始请求head中各项资源，提高页面加载速度
    ob_flush();flush();

    // 生成body的class
    $body_class = ( isset($class) )? $class: NULL;
    $body_class .= ($this->user_agent['is_wechat'] === TRUE)? ' is_wechat': NULL;
    $body_class .= ($this->user_agent['is_ios'] === TRUE)? ' is_ios': NULL;
    $body_class .= ($this->user_agent['is_android'] === TRUE)? ' is_android': NULL;
    $body_class .= ($this->user_agent['is_mobile'])? ' is_mobile': NULL; // 移动端设备

    $body_class .= ($this->user_agent['is_macos'] === TRUE)? ' is_macos': NULL;
    $body_class .= ($this->user_agent['is_windows'] === TRUE)? ' is_windows': NULL;
    $body_class .= ($this->user_agent['is_desktop'])? ' is_desktop': NULL; // 非移动端设备
?>

<!-- 内容开始 -->
    <body<?php echo ( !empty($body_class) )? ' class="'.$body_class.'"': NULL ?>>
		<noscript>
			<p>您的浏览器功能加载出现问题，请刷新浏览器重试；如果仍然出现此提示，请考虑更换浏览器。</p>
		</noscript>

		<main id=maincontainer role=main>