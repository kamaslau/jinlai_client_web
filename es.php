<?php
header("Content-Type:text/event-stream;charset=utf-8");
header('Cache-Control:no-cache');

$content = array(
    array('type' => 'text', 'content' => '测试一下前端是否可以正常接收'."<br>".'并解析JSON格式返回的EventStream信息'), // 文字
    array('type' => 'image', 'url_image' => 'https://media.517ybang.com/user/avatar/201801/0129/1407221.jpg'), // 图片
    array('type' => 'url', 'url_page' => 'https://www.517ybang.com/', 'title' => '进来商城', 'url_image' => NULL), // 网页
    array('type' => 'item', 'item_id' => 3), // 商品
    array('type' => 'order', 'order_id' => 1, 'content' => array()), // 订单
);

$data = array(
    'stuff_id' => 3,
);

$total = 0;
$max = 5;
while ($total < $max)
{
    $timestamp = time();

    // 生成一个0-1之间的随机数，根据随机数是否大于0.5决定是客户类消息还是商家类消息（即相应字段是否有值）
    $random = rand(0,1);
    $content_type = $_GET['biz_id'] - 1;

    $extra_data = array(
        'message_id' => substr($timestamp, 7),

        'user_id' => ($random > 0.5)? 1: NULL,
        'biz_id' => $_GET['biz_id'],
        'time_create' => $timestamp
    );
    $data = array_merge($data, $extra_data);
    $data = array_merge($data, $content[$content_type]);

    // 输出数据
    try {
        output($data);
    } catch(Exception $e) {
        print $e->getMessage();
        exit();
    }

    //$total += 1; // 若需始终输出，注释掉此行即可
    if ($total < $max)
        sleep(3);
}

function output($data)
{
    echo "id:". $data['id']. "\n"; // 可选
    // echo "event:message". "\n"; // 可选，默认为message
    echo "retry:5000". "\n"; // 可选
    echo "data:". json_encode($data). "\n";
    echo "\n";

    @ob_flush();@flush();
    // 若上述语句无效，需禁用Nginx的buffering，即在nginx.conf文件中添加/替换配置项（若有则修改值），并重启Nginx。
    //proxy_buffering off;
    //fastcgi_keep_conn on;
}