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
<html lang=zh-cn>
	<head>
		<meta charset=utf-8>
		<meta http-equiv=x-dns-prefetch-control content=on>
		<link rel=dns-prefetch href="<?php echo CDN_URL ?>">
		<title><?php echo $title ?></title>
		<meta name=description content="<?php echo $description ?>">
		<meta name=keywords content="<?php echo $keywords ?>">
		<meta name=version content="revision20180322">
		<meta name=author content="刘亚杰Kamas,青岛意帮网络科技有限公司产品部&amp;技术部">
		<meta name=copyright content="进来商城,青岛意帮网络科技有限公司">
		<meta name=contact content="kamaslau@dingtalk.com">

        <meta name=viewport content="width=750,user-scalable=0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

        <script src="<?php echo CDN_URL ?>js/jquery-3.3.1.min.js"></script>
        <script src="https://res.wx.qq.com/open/js/jweixin-1.3.0.js"></script>
        <script defer src="<?php echo CDN_URL ?>font-awesome/v5.0.8/fontawesome-all.min.js"></script>
        <script defer src="<?php echo CDN_URL ?>jquery/jquery.lazyload.min.js"></script>
        <script defer src="/js/vote.js"></script>

        <?php
        // 使修改的COOKIE即时生效
        function instant_cookie($var, $value = '', $time = 0, $path = '', $domain = '', $s = false)
        {
            $_COOKIE[$var] = $value;
            setcookie($var, $value, $time, $path, $domain, $s);
        }

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
            return $result['access_token'];
        }

        // 获取jsapi_ticket
        function get_jsapi_ticket($access_token)
        {
            $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token='.$access_token;
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
            return ($result['status'] === 200)? $result['content']: FALSE;
        }

        // 判断是否打开测试模式
        $test_mode = $this->input->get('test_mode');

        // 获取access_token；若已获得授权则一并获取微信用户资料
        $access_token = get_access_token();

        // 若未登录且从微信登录页转入，则尝试登录
        $code = $this->input->get('code');
        $last_code_used = get_cookie('last_code_used');
        if ( !empty($code) && ($last_code_used <> $code)):
            // 清除当前登录信息
            //$this->session->sess_destroy();

            // 获取微信用户资料
            $sns_token = get_sns_token($code);
            if ($test_mode === 'on') var_dump($sns_token);
            $sns_info = get_user_info($access_token, $sns_token['openid']);
            if ($test_mode === 'on') var_dump($sns_info);
            //set_cookie('last_code_used', $code);
            instant_cookie('last_code_used', $code); // 标记当前code为已使用

            // 若当前用户已订阅微信公众号，尝试使用微信union_id登录本站账户
            if ($sns_info['subscribe'] == 1 && !empty($sns_token['unionid'])):
                // 尝试使用微信union_id登录
                $user_info = login_wechat($sns_token['unionid']);
                if ($test_mode === 'on') var_dump($user_info);
                if ($user_info !== FALSE):
                    // 将信息键值对写入session
                    foreach ($user_info as $key => $value):
                        $user_data[$key] = $value;
                    endforeach;
                    $user_data['time_expire_login'] = time() + 60*60*24 *30; // 默认登录状态保持30天
                    $this->session->set_userdata($user_data);
                    $this->session->sns_info = json_encode($sns_info);

                    //set_cookie('wechat_subscribe', 1);
                    instant_cookie('wechat_subscribe', 1); // 标记当前已关注微信公众号
                endif;
            else:
                //set_cookie('wechat_subscribe', 0);
                instant_cookie('wechat_subscribe', 0); // 标记当前未关注微信公众号
            endif;
        endif;

        // 生成微信网页API签名参数
        $wesign['timestamp'] = time();
        $wesign['noncestr'] = 'Wm3WZYTPz0wzccnW';
        $wesign['jsapi_ticket'] = get_jsapi_ticket($access_token);
        $current_url = 'https://'. $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        if (strpos($current_url, '#') !== FALSE)
            $current_url = substr($current_url, 0, strpos($current_url, '#'));
        $wesign['url'] = $current_url;
        ?>

        <script>
        <?php if ($test_mode != 'on'): ?>
        // 百度统计
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?7c5231bd92955bfd7dfd7dc3be1a0206";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
        <?php endif ?>

        $(function(){
            // 微信用户信息
            var wx_userinfo;
            wx_userinfo_subscribe = <?php echo empty(get_cookie('wechat_subscribe'))? 0: get_cookie('wechat_subscribe') ?>;
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
                ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
            });

            wx.ready(function(){
                // 隐藏部分按钮
                wx.hideMenuItems({
                    menuList:[
                        'menuItem:share:qq', 'menuItem:share:QZone', 'menuItem:share:facebook', 'menuItem:copyUrl', 'menuItem:readMode', 'menuItem:openWithQQBrowser', 'menuItem:openWithSafari', 'menuItem:share:email',
                    ] // 要隐藏的菜单项，只能隐藏“传播类”和“保护类”按钮，所有menu项见附录3
                });

                <?php $url_page_figure = empty($item['url_image'])? MEDIA_URL.'/icon/jinlai_client/64x64.png': $this->media_root.$item['url_image'] ?>

                // 分享到朋友圈
                wx.onMenuShareTimeline({
                    title: '<?php echo $title ?>', // 分享标题
                    link: '<?php echo 'https://'. $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] ?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                    imgUrl: '<?php echo $url_page_figure ?>', // 分享图标
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
                    imgUrl: '<?php echo $url_page_figure ?>', // 分享图标
                    type: '', // 分享类型,music、video或link，不填默认为link
                    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                    success: function () {
                        // 用户确认分享后执行的回调函数
                        alert('分享成功');
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                        alert('未完成分享');
                    }
                });
            }); // end wx.ready
        });
        </script>

		<!--清除浏览器默认样式css-->
		<link rel=stylesheet media=all href="<?php echo CDN_URL ?>css/reset.css?<?php echo time() ?>">
		<!--公用部分css-->
        <link rel=stylesheet media=all href="/css/vote.css?<?php echo time() ?>">

        <meta name=format-detection content="telephone=yes, address=no, email=no">
    </head>

<?php

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