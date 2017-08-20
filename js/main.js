$(function(){
	var ajax_root = 'https://www.517ybang.com/';
	// AJAX主程序
	function ajax_go(api_url, input_params)
	{
		// AJAX获取结果并生成相关HTML
		$.getJSON(ajax_root+api_url, params, function(data)
		{
			console.log(data); // 输出回调数据到控制台

			if (data.status == 200)
			{
				alert(data.content.message);
			}
			else // 若失败，进行提示
			{
				alert(data.content.error.message);
			}
		});
	}
	
	// 收藏商家
	$('a.fav-add-biz').click(function(){
		// 初始化参数数组
		params = new Object();

		params.biz_id = $(this).attr('data-biz-id');

		var api_url = 'fav_biz/create';
		ajax_go(api_url, params);

		return false;
	});
	
	// 收藏商品
	$('a.fav-add-item').click(function(){
		// 初始化参数数组
		params = new Object();

		params.item_id = $(this).attr('data-item-id');

		var api_url = 'fav_item/create';
		ajax_go(api_url, params);

		return false;
	});

});