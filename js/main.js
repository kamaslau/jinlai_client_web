$(function(){
	var ajax_root = 'https://www.517ybang.com/';
	// AJAX主程序
	function ajax_go(api_url, call_back)
	{
		// AJAX获取结果并生成相关HTML
		$.getJSON(ajax_root+api_url, params, function(data)
		{
			console.log(data); // 输出回调数据到控制台

			if (data.status == 200)
			{
				//alert(data.content.message);
				return data;
			}
			else // 若失败，进行提示
			{
				alert(data.content.error.message);
				return false;
			}
		});
	}

	// 登录页
	$('#next button').click(function(){
		$(this).hide();
		
		// 初始化参数数组
		params = new Object();
		params.mobile = $('[name=mobile]').val();

		var api_url = 'account/user_exist';
		$.getJSON(ajax_root+api_url, params, function(data)
		{
			console.log(data); // 输出回调数据到控制台

			if (data.status == 200)
			{
				$('#login-password').removeClass('hide');
			}
			else // 若失败，进行提示
			{
				$('#login-sms').removeClass('hide');
			}
			
			$('[type=submit]').removeClass('hide');
		});

		return false;
	});

	// 关注商家
	$('a.fav-add-biz').click(function(){
		// 初始化参数数组
		params = new Object();
		params.biz_id = $(this).attr('data-biz-id');

		var api_url = 'fav_biz/create';
		var result = ajax_go(api_url);
		if (result != false)
		{
			// 切换图标为已关注样式
			var icon_to_change = $(this).find('i.fa');
			icon_to_change.attr('class', 'fa fa-heart');
		}

		return false;
	});

	// 收藏商品
	$('a.fav-add-item').click(function(){
		// 初始化参数数组
		params = new Object();
		params.item_id = $(this).attr('data-item-id');

		var api_url = 'fav_item/create';
		var result = ajax_go(api_url);
		if (result != false)
		{
			// 切换图标为已关注样式
			var icon_to_change = $(this).find('i.fa');
			icon_to_change.attr('class', 'fa fa-star');
		}

		return false;
	});

	// 删除（关注商家、收藏商品、TODO:地址 等）
	$('a[data-op-class]').click(function(){
		var is_confirm = confirm('确定要删除此项？');
		console.log(is_confirm);

		if (is_confirm == true)
		{
			var op_class = $(this).attr('data-op-class');
			var op_name = $(this).attr('data-op-name');
			var api_url = op_class + '/' + op_name;

			params = new Object();
			params.ids = $(this).attr('data-id');

			var result = ajax_go(api_url);
			if (result != false)
			{
				// 移除DOM
				$(this).closest('li.item').remove();
			}
		}

		return false;
	});

});