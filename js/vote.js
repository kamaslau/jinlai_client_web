/**
 * 投票相关功能
 */
$(function(){
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
            target = $('[data-option_name='+content+']');
        } else {
            target = $('[data-option_id='+content+']');
        }

        if (target == null)
        {
            alert('没有对应的候选项');
        } else {
            // 获取目标元素相对于网页顶端的位置
            var target_height = $(target).offset().top;

            // 页面滚动到该位置
            $('body,html').stop(false, false).animate({scrollTop:target_height}, 400);
        }
    }

    // 点击报名按钮
    $('#vote-signup').click(function(){
        $('#form-signup').show();
        return false;
    });

    // 点击投票按钮
    $('.ballot-create').click(function(){
        var vote_id = $(this).attr('data-vote_id');
        var option_id = $(this).attr('data-option_id');
        ballot_create(vote_id, option_id);

        return false;
    });

    // 点击拉票按钮
    $('.option-detail').click(function(){
        var vote_id = $(this).attr('data-vote_id');
        var option_id = $(this).attr('data-option_id');
        option_detail(vote_id, option_id);

        return false;
    });

    // 点击政策按钮
    $('#vote-article').click(function(){
        $('#vote-article-content').show();
        return false;
    });

    // 关闭全屏
    $('.full-screen-close').click(function(){
        $(this).closest('.full-screen').hide();
    });

    // 投票
    function ballot_create(vote_id, option_id)
    {
        $('#vote-succeed').show();
    } // end ballot_create

    // 拉票
    function option_detail(vote_id, option_id)
    {
        $('#share-guide').show();
    } // end option_detail

    // 加载更多
    function load_more()
    {

    } // end load_more
});