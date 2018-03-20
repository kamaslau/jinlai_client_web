/**
 * 投票相关功能
 */
$(function(){
    // 图片延迟加载
    $('img.lazyload').lazyload({
        threshold : 200,
        effect : "fadeIn"
    });

    // 播放或暂停音频
    $('#audio-control').click(function(){
        var audio = document.getElementById('vote-audio');

        if (audio.paused)
        {
            audio.play();
            $(this).html('<i class="far fa-pause" aria-hidden=true></i>');
            return;
        } else {
            audio.pause();
            $(this).html('<i class="far fa-play" aria-hidden=true></i>');
        }
    });

    // 搜索
    $('[name=content]').focus(function(){
        // 显示所有候选项并重置部分样式（以避免通过标签筛选后仅可显示部分候选项的情况）
        $('.vote-option').show();
        $('.vote-option:visible:odd').css('margin-left', '20px');
        $('.vote-option:visible:even').css('margin-left', '0');
    });
    $('[name=content]').change(function(){
        var content = $(this).val();
        search_in_page(content);
        $('[name=content]').val('');
        return false;
    });
    $('#search-button').click(function(){
        var content = $('[name=content]').val();
        search_in_page(content);
        $('[name=content]').val('');
        return false;
    });
    function search_in_page(content)
    {
        var target = null;

        // 获取目标元素
        if (isNaN(content))
        {
            target = $('[data-option_name^='+content+'], [data-option_name*='+content+'], [data-option_name$='+content+']');
        } else {
            target = $('[data-option_id='+content+']');
        }

        if (target == null)
        {
            alert('没有对应的候选项');
        } else {
            console.log(target);
            // 获取目标元素相对于网页顶端的位置
            var target_height = $(target[0]).offset().top - 20; // 顶端留出20像素的空间

            // 页面滚动到该位置
            $('body,html').stop(false, false).animate({scrollTop:target_height}, 400);
        }
    }

    // 点击政策按钮
    $('#vote-article').click(function(){
        $('#vote-article-content').show();
        return false;
    });

    // 点击媒体矩阵按钮
    $('#media-board').click(function(){
        $('#media-list').show();
        return false;
    });

    // 点击标签导航栏内某标签
    $('#options-naver a').click(function(){
        var tag_id = $(this).attr('data-tag_id');

        $('.vote-option').hide();
        if (tag_id != 'all')
        {

            $('.vote-option[data-tag_id='+ tag_id +']').show();
        }
        else
        {
            $('.vote-option').show();
        }

        // 仅对可见DOM添加奇偶样式
        $('.vote-option:visible:odd').css('margin-left', '20px');
        $('.vote-option:visible:even').css('margin-left', '0');

        // 获取标签导航栏相对于网页顶端的位置
        var target = $('#options-naver');
        var target_height = target.offset().top - 20; // 顶端留出20像素的空间

        // 页面滚动到该位置
        $('body,html').stop(false, false).animate({scrollTop:target_height}, 400);

        return false
    });

    // 关闭全屏
    $('.full-screen-close').click(function(){
        $(this).closest('.full-screen').hide();
    });

    // 加载更多
    function load_more()
    {

    } // end load_more
});