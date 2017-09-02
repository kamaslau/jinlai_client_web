$(function(){
	// AJAX根URL
	var ajax_root = 'https://www.517ybang.com/';

	// AJAX程序范例
	function ajax_go(api_url)
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

	// 智能登录页
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
				$('[name=password]').attr('required',true);
			}
			else // 若失败，进行提示
			{
				$('#login-sms').removeClass('hide');
				$('[name=captcha]').attr('required',true);
				console.log($('[name=captcha]').attr('required'));
			}

			$('[type=submit]').removeClass('hide');
		});

		return false;
	});

	// 切换图片（更改src）
	function img_switch(dom_to_change)
	{
		var target_src = dom_to_change.attr('data-src-success');
		dom_to_change.attr('src', target_src);
	}

	// 创建（领取优惠券、TODO:加入购物车、收藏商品、关注商家 等）
	$('a[data-op-name=create]').click(function(){
		var api_url = $(this).attr('data-op-class') + '/create';
		var dom_to_change = $(this).find('img[data-src-success]'); // 待修改样式的dom

		params = new Object();
		params.id = $(this).attr('data-id');

		// AJAX获取结果并生成相关HTML
		$.getJSON(ajax_root+api_url, params, function(data)
		{
			console.log(data); // 输出回调数据到控制台

			if (data.status == 200)
			{
				alert(data.content.message);

				// 检查是否需要切换图片
				if (dom_to_change !== undefined)
				{
					img_switch(dom_to_change);
				}
			}
			else // 若失败，进行提示
			{
				alert(data.content.error.message);
			}
		});

		return false;
	});
	
	// 删除（关注商家、收藏商品、TODO:地址 等）
	$('a[data-op-name=delete]').click(function(){
		var is_confirm = confirm('确定要删除此项？');
		console.log(is_confirm);

		if (is_confirm == true)
		{
			var op_class = $(this).attr('data-op-class');
			var op_name = $(this).attr('data-op-name');
			var api_url = op_class + '/' + op_name;

			params = new Object();
			params.ids = $(this).attr('data-id');
			
			// AJAX获取结果并生成相关HTML
			$.getJSON(ajax_root+api_url, params, function(data)
			{
				console.log(data); // 输出回调数据到控制台

				if (data.status == 200)
				{
					// 移除DOM
					$('[data-item-id='+ params.ids +']').remove();
				}
				else // 若失败，进行提示
				{
					alert(data.content.error.message);
				}
			});
		}

		return false;
	});

});