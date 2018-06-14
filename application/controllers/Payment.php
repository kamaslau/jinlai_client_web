<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * TODO Payment 支付类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Payment extends MY_Controller
	{
		/**
		 * 可作为列表筛选条件的字段名；可在具体方法中根据需要删除不需要的字段并转换为字符串进行应用，下同
		 */
		protected $names_to_sort = array(
			'brief', 'fullname', 'mobile', 'nation', 'province', 'city', 'county', 'street', 'longitude', 'latitude', 'zipcode', 'time_create', 'time_delete', 'time_edit', 'creator_id', 'operator_id',
		);

		public function __construct()
		{
			parent::__construct();

			// 未登录用户转到登录页
			//($this->session->time_expire_login > time()) OR redirect( base_url('login') );

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '地址'; // 改这里……
			$this->table_name = 'Payment'; // 和这里……
			$this->id_name = 'Payment_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name;
		} // end __construct

		/**
		 * 列表页
		 */
		public function index()
		{
			$this->gateway();
		} // end index

        // 根据设备类型转到相应支付方式页面
        // 一般用于线下付款等场景
        public function gateway()
        {
            if ($this->user_agent['is_wechat'] === TRUE):
                redirect( base_url('payment/wepay/example/qrpay.php') );

            elseif ($this->user_agent['is_alipay'] === TRUE):
                redirect( base_url('payment/alipay/wappay/qrpay.php') );

            else:
                // 若非微信或支付宝，则暂时转到支付宝付款页面
                redirect( base_url('payment/alipay/wappay/qrpay.php') );

            endif;
        } // end gateway

	} // end class Payment

/* End of file Payment.php */
/* Location: ./application/controllers/Payment.php */
