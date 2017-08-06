<?php
require_once '../lib/WxPay.Api.php';
require_once '../lib/WxPay.Notify.php';
require_once 'log.php';

function curl_go($params, $url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);

    // 设置cURL参数，要求结果保存到字符串中还是输出到屏幕上。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
	curl_setopt($curl, CURLOPT_POST, count($params));
	curl_setopt($curl, CURLOPT_POSTFIELDS, $params);

    // 运行cURL，请求API
	$result = curl_exec($curl);
	// 关闭URL请求
    curl_close($curl);
	
	return json_decode($result, TRUE);
}

// 初始化日志
$logHandler = new CLogFileHandler('../logs/'.date('Y-m-d_H').'.log');
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
	// 查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		Log::DEBUG('query:'. json_encode($result));

		if (array_key_exists('return_code', $result)
			&& array_key_exists('result_code', $result)
			&& $result['return_code'] == 'SUCCESS'
			&& $result['result_code'] == 'SUCCESS')
		{
			return TRUE;
		}
		return FALSE;
	}

	// 重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		Log::DEBUG('call back:'. json_encode($data));
		$notfiyOutput = array();

		if ( ! array_key_exists('transaction_id', $data) )
		{
			$msg = '输入参数不正确';
			return FALSE;
		}
		// 查询订单，判断订单真实性
		if ( ! $this->Queryorder($data['transaction_id']) )
		{
			$msg = '订单查询失败';
			return FALSE;
		}

		// 获取所需支付数据，并通过API处理支付状态更新
		// 微信支付开发文档 支付结果通知 https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_7
		@list($order_prefix, $order_type, $order_id) = split('_', $data['out_trade_no']); // 分解出订单前缀、订单类型、订单号等
		$params = array(
			'token' => '7C4l8JLaM3Fq5biQurtmk6nFS', // 须与API端TOKEN_PAY保持一致
			'order_type' => $order_type, // 订单类型
			'order_id' => $order_id, // 交易订单号

			'payment_type' => '微信支付', // 付款方式
			'payment_id' => $data['transaction_id'], // 微信支付流水号
			'payment_account' => $data['openid'], // 付款微信openID、
			'bank_type' => $data['bank_type'], // 付款银行，参考https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=4_2
			'total' => $data['total_fee'] / 100, // 实际须支付金额；接口返回的数字单位为“分”，因此需转换为“元”
		);

		/* 通过API处理支付状态更新 */
		// $url = 'https://www.517ybang.com/'.$type.'/status'; // 原处理方法（可参考半岛店此文件相关代码）
		$url = WxPayConfig::PAYMENT_PROCESS_URL;
		$result = curl_go($params, $url);

		// 若订单已更新，或更新不成功，终止运行程序
		if ($result['status'] !== 200):
			return FALSE;

		// 若订单更新成功，发送短信提示
		else:
			return TRUE;

		endif;
	}
}

Log::DEBUG('begin notify');
$notify = new PayNotifyCallBack();
$notify->Handle(FALSE);