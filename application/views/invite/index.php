
    <style>
        body {background:#fff;}
    </style>

    <div class="sharetop auto wid710">

    </div>

    <div class="invitecode auto">
        <h1>您的专属邀请码</h1>
        <span><?php //echo $code ?>1234567890</span>
        <a href="###">我收到的邀请码
            <i class="arrow-right">
                <img src="https://cdn-remote.517ybang.com/media/invite/fenxiangyouli-arrow.png" />
            </i>
        </a>
    </div>

    <div class="redcard">
        <span>¥</span>
        388
        <span>元</span>
    </div>
    <p class="sharetext" style="padding-top: .22rem;">邀请好友加入进来,</p>
        <p class="sharetext">给他/她发放388元红包,好友完成下单,<p>
        <p class="sharetext">你亦获得388元红包</p>

    <div class="shareprogress">
        <p></p>
        <span>0</span>
        <span class="two"><?php echo count($items) ?></span>
        <span class="five">5</span>
    </div>

    <?php if ( ! isset($items)): ?>
    <div class="nosharetext">
        <span>尚未成功邀请好友,</span>
        <span>立即分享吧!</span>
    </div>

    <?php else: ?>
    <div class="evergetcodetext">
        您已邀请<span><?php echo count($items) ?></span>位好友 | 获得<span>0</span>元礼券
    </div>
    <div class="sharetable wid670 auto">
        <table>
                <tr>
            <td class="tdtitle">5人</td>
            <td class="tdbnone">额外奖励100元</td>
        </tr>
        <tr>
            <td class="tdtitle">5人</td>
            <td class="tdbnone">额外奖励100元</td>
        </tr>
        <tr>
            <td class="tdtitle">5人</td>
            <td class="tdbnone">额外奖励100元</td>
        </tr>
        <tr>
            <td class="tdtitle">5人</td>
            <td class="tdbnone">额外奖励100元</td>
        </tr>

        </table>

    </div>
    <!--奖励明细-->
    <div class="awardlist">
        <span></span>
        <a>奖励明细</a>
        <span style="right: 0px;"></span>
    </div>
    <div class="awardlistcontent auto">
        <ul>
            <?php foreach ($items as $item): ?>
            <li>
                <span class="fl"><?php echo $item['mobile'] ?></span>
                <span class="fr"><?php echo $item['time_create'] ?></span>
            </li>
            <?php endforeach ?>
        </ul>
    </div>
    <?php endif ?>

    <div class="fiex sharefooter">
        <span class="fl">
            进来 COME IN!
        </span>
        <a id=share-wechat href="#" class="fr">
            即刻邀请
        </a>
    </div>

    <script>
    wx.ready(function() {

        // 配置微信分享功能
        document.getElementById('share-wechat').onclick = function (){
            const invitation_text = '点击右上角按钮，即可分享邀请';
            alert(invitation_text);

            // 邀请页URL
            const invitation_url = '<?php echo base_url('login?promoter_id=1') ?>';

            // 分享到朋友圈
            wx.onMenuShareTimeline({
                title: '<?php echo $title ?>', // 分享标题
                link: invitation_url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
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
                desc: '<?php //echo $description ?>', // 分享描述
                link: invitation_url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
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

            return false;
        };

    });
    </script>
