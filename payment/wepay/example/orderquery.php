<?php
$page_title = '微信支付 - 订单查询';
require_once 'header.php';

require_once '../lib/WxPay.Api.php';
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("./logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

function printf_info($data)
{
    foreach($data as $key => $value)
	{
        echo "<font color='#f00;'>$key</font> : $value <br/>";
    }
}

if ( isset($_REQUEST['transaction_id']) && $_REQUEST['transaction_id'] != '' ):
	$transaction_id = $_REQUEST['transaction_id'];

	$input = new WxPayOrderQuery();
	$input->SetTransaction_id($transaction_id);
	printf_info(WxPayApi::orderQuery($input));
	exit();
endif;

if ( isset($_REQUEST['out_trade_no']) && $_REQUEST['out_trade_no'] != '' ):
	$out_trade_no = $_REQUEST['out_trade_no'];

	$input = new WxPayOrderQuery();
	$input->SetOut_trade_no($out_trade_no);
	printf_info(WxPayApi::orderQuery($input));
	exit();
endif;
?>
	<body class=wepay>
		<div id=content class=container>

			<form action="#" method=post>
		        <p class=help-block>微信支付流水号和商户订单号至少需填一个，微信支付流水号优先</p>
				
				<fieldset>
			        <label for=transaction_id>微信支付流水号</label>
			        <input name=transaction_id class=form-control type=text>

					<label for=out_trade_no>商户订单号</label>
			        <input name=out_trade_no class=form-control type=text>
				</fieldset>
				
				<button type=submit class="btn btn-primary btn-lg">查询</button>
			</form>
		
		</div>
	</body>
</html>