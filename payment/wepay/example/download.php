<?php
$page_title = '微信支付 - 下载对账单';
require_once 'header.php';

require_once '../lib/WxPay.Api.php';

if (isset($_REQUEST['bill_date']) && $_REQUEST['bill_date'] != ''):
	$bill_date = $_REQUEST['bill_date'];
    $bill_type = $_REQUEST['bill_type'];
	$input = new WxPayDownloadBill();
	$input->SetBill_date($bill_date);
	$input->SetBill_type($bill_type);
	$file = WxPayApi::downloadBill($input);
	echo $file;

	//TODO 对账单文件处理
    exit(0);
}
?>
	<body class=wepay>
		<div id=content class=container>

			<form action="#" method=post>
				<fieldset>
			        <label for=bill_date>对账日期</label>
			        <input name=bill_date class=form-control type=text>

					<label for=bill_type>账单类型</label>
					<select name=bill_type class=form-control>
						<option value="ALL">所有</option>
						<option value="SUCCESS">成功支付</option>
						<option value="REFUND">已退款</option>
						<option value="REVOKED">已撤销</option>
					</select>
				</fieldset>

				<button type=submit class="btn btn-primary btn-lg">下载对账单</button>
			</form>
		
		</div>

	</body>
</html>