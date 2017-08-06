<!doctype html>
<html lang=zh-cn>
	<head>
		<meta charset=utf-8>
		<meta http-equiv=x-dns-prefetch-control content=on>
		<link rel=dns-prefetch href="https://cdn.key2all.com">
		<link rel=dns-prefetch href="https://images.guangchecheng.com">
	    <title>微信支付 - 刷卡支付</title>
		<meta name=robots content="noindex, nofollow">
		<meta name=version content="revision20170807">
		<meta name=author content="刘亚杰">
		<meta name=copyright content="刘亚杰">
		<meta name=contact content="kamaslau@outlook.com, http://weibo.com/kamaslau">
		<meta name=viewport content="width=device-width, user-scalable=0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<link rel=stylesheet media=all href="//cdn.key2all.com/css/reset.css">
		<link rel=stylesheet media=all href="//cdn.key2all.com/font-awesome/css/font-awesome.min.css">
		<style>
			* {box-sizing:border-box;}
			body {color:#333;background-color:#d4d5d7;}
				.container {background-color:#fff;width:95%;margin:0 auto;position:relative;padding:0 5% 5%;}

		label {margin-bottom:1.4rem;}
		input {width:100%;border:2px solid #1aad19;padding:.8rem 1.2rem;margin-bottom:1.6rem;}
		button {color:#fff;font-size:18px;text-align:center;background-color:#1aad19;display:block;width:100%;height:48px;line-height:48px;border-radius:1rem;margin-top:15px;}

		#status-order {color:#fff;background-color:#1aad19;}
		</style>

		<!--<link rel="shortcut icon" href="//images.guangchecheng.com/logos/logo_32x32.png">-->
		<!--<link rel="apple-touch-icon" href="//images.guangchecheng.com/logos/logo_120x120.png">-->
	</head>
<?php
	require_once '../lib/WxPay.Api.php';
	require_once 'WxPay.MicroPay.php';
	require_once 'log.php';

	// 初始化日志
	$logHandler= new CLogFileHandler('../logs/'. date('Y-m-d'). '.log');
	$log = Log::Init($logHandler, 15);

	// 打印输出数组信息
	function printf_info($data)
	{
	    foreach ($data as $key => $value)
		{
	        echo '<font color="#00ff55;">'.$key. '</font> : '.$value. '<br/>';
	    }
	}

	if ( isset($_POST['auth_code']) && !empty($_POST['auth_code']) ):
		$auth_code = $_POST['auth_code'];  // 授权码（即微信支付码）
		$body = $_POST['body']; // 商品描述
		$total_fee = $_POST['total_fee'] * 100; // 待支付金额，数字单位为分
		$input = new WxPayMicroPay();
		$input->SetAuth_code($auth_code);
		$input->SetBody( $body );
		$input->SetTotal_fee( $total_fee );
		$input->SetOut_trade_no(WxPayConfig::MCHID.date('YmdHis'));

		$microPay = new MicroPay();
		$result = $microPay->pay($input);
		//printf_info($result); // 生产环境须关闭调试信息
		//var_dump($result);
	endif;

	/**
	 * 注意：
	 * 1、提交被扫之后，返回系统繁忙、用户输入密码等错误信息时需要循环查单以确定是否支付成功
	 * 2、多次（一般10次）确认都未明确成功时需要调用撤单接口撤单，防止用户重复支付
	 */
?>
	<body>
		<div id=content class=container>
			<?php if ( isset($result) ): ?>
			<div id=status-order>
				<?php
					if (array_key_exists('return_code', $result)
								&& array_key_exists('result_code', $result)
								&& $result['return_code'] == 'SUCCESS'
								&& $result['result_code'] == 'SUCCESS'):
				?>
				<dl>
					<dt>已支付金额（元）</dt>
					<dd><strong>￥ <?php echo $result['total_fee'] / 100 ?></strong></dd>
					<dt>商户交易订单号</dt>
					<dd><?php echo $result['out_trade_no'] ?></dd>
					<dt>微信支付流水号</dt>
					<dd><?php echo $result['transaction_id'] ?></dd>
					<dt>付款银行</dt>
					<dd><?php echo $result['bank_type'] ?></dd>
				</dl>

				<?php else: ?>
				<p>交易失败，请重试。</p>

				<?php endif ?>
			</div>

			<a class=button href="<?php echo WxPayConfig::CLIENT_URL ?>payment/wepay/example/micropay.php">再收一笔</a>

			<?php else: ?>
			<form action="#" method=post>
				<fieldset>
					<label for=auth_code>商品描述</label>
					<input type=text name=body value="扫码付款订单" required>

					<label for=auth_code>待支付金额（元）</label>
					<input type=number min=0.01 step=0.01 max=9999.99 name=total_fee value="<?php echo $_GET['total'] ?>" required autofocus>

					<label for=auth_code>授权码（即微信付款码，通过微信客户端的“我”→“钱包”→“收付款”页面扫码，或直接在此处完整输入该页面条形码上方的数字编码）</label>
					<input type=text name=auth_code value="<?php echo $_GET['auth_code'] ?>" required>
				</fieldset>

				<button type=submit>确定</button>
			</form>
			
			<?php endif ?>
		</div>
	</body>
</html>