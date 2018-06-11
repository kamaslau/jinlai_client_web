<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Order 商品订单类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Order extends MY_Controller
	{	
		/**
		 * 可作为列表筛选条件的字段名；可在具体方法中根据需要删除不需要的字段并转换为字符串进行应用，下同
		 */
		protected $names_to_sort = array(
			'biz_id', 'user_id', 'user_ip', 'subtotal', 'promotion_id', 'discount_promotion', 'coupon_id', 'discount_coupon', 'credit_id', 'discount_payed', 'freight', 'discount_reprice', 'repricer_id', 'total', 'total_payed', 'total_refund', 'fullname', 'mobile', 'province', 'city', 'county', 'street', 'longitude', 'latitude', 'payment_type', 'payment_account', 'payment_id', 'note_user', 'note_stuff', 'commission', 'promoter_id', 'time_create', 'time_cancel', 'time_expire', 'time_pay', 'time_refuse', 'time_accept', 'time_deliver', 'time_confirm', 'time_confirm_auto', 'time_comment', 'time_refund', 'time_delete', 'time_edit', 'operator_id', 'status', 'refund_status', 'invoice_status',
		);

		/**
		 * 可被编辑的字段名
		 */
		protected $names_edit_allowed = array(
			'promotion_id', 'discount_promotion', 'coupon_id', 'discount_coupon', 'credit_id', 'discount_payed', 'freight', 'discount_reprice', 'repricer_id', 'total', 'total_payed', 'total_refund', 'fullname', 'mobile', 'province', 'city', 'county', 'street', 'longitude', 'latitude', 'payment_type', 'payment_account', 'payment_id', 'note_user', 'note_stuff', 'commission', 'promoter_id', 'time_create', 'time_cancel', 'time_expire', 'time_pay', 'time_refuse', 'time_accept', 'time_deliver', 'time_confirm', 'time_confirm_auto', 'time_comment', 'time_refund', 'time_delete', 'time_edit', 'operator_id', 'status', 'refund_status', 'invoice_status',
		);

		/**
		 * 完整编辑单行时必要的字段名
		 */
		protected $names_edit_required = array(
			'id',
			'user_id', 'promotion_id', 'discount_promotion', 'coupon_id', 'discount_coupon', 'credit_id', 'discount_payed', 'freight', 'discount_reprice', 'repricer_id', 'total', 'total_payed', 'total_refund', 'fullname', 'mobile', 'province', 'city', 'county', 'street', 'longitude', 'latitude', 'payment_type', 'payment_account', 'payment_id', 'note_user', 'note_stuff', 'commission', 'promoter_id', 'time_create', 'time_cancel', 'time_expire', 'time_pay', 'time_refuse', 'time_accept', 'time_deliver', 'time_confirm', 'time_confirm_auto', 'time_comment', 'time_refund', 'time_delete', 'time_edit', 'operator_id', 'status', 'refund_status', 'invoice_status',
		);

		/**
		 * 编辑单行特定字段时必要的字段名
		 */
		protected $names_edit_certain_required = array(
			'id', 'name', 'value',
		);

		/**
		 * 编辑多行特定字段时必要的字段名
		 */
		protected $names_edit_bulk_required = array(
			'ids', 'password',
		);

		public function __construct()
		{
			parent::__construct();

			// 未登录用户转到登录页
			($this->session->time_expire_login > time()) OR redirect( base_url('login') );

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '商品订单'; // 改这里……
			$this->table_name = 'order'; // 和这里……
			$this->id_name = 'order_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 视图文件所在目录
			$this->media_root = MEDIA_URL. 'item/'; // 媒体文件所在目录，此处默认为商品的媒体文件
		} // __construct

		/**
		 * 列表页
		 */
		public function index()
		{
			// 页面信息
			$data = array(
				'title' => $this->class_name_cn. '列表',
				'class' => $this->class_name.' index',
			);

			// 筛选条件
			$condition['time_delete'] = 'NULL'; // 默认不获取已删除订单
			// （可选）遍历筛选条件
			foreach ($this->names_to_sort as $sorter):
				if ( !empty($this->input->post($sorter)) )
					$condition[$sorter] = $this->input->post($sorter);
			endforeach;

			// 从API服务器获取相应列表信息
			$params = $condition;
            $data['limit'] = $params['limit'] = empty($this->input->get_post('limit'))? 10: $this->input->get_post('limit');
            $data['offset'] = $params['offset'] = empty($this->input->get_post('offset'))? 0: $this->input->get_post('offset');
			$url = api_url($this->class_name. '/index');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['items'] = $result['content'];
			else:
				$data['error'] = $result['content']['error']['message'];
			endif;

			// 输出视图
			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/index', $data);
			$this->load->view('templates/footer', $data);
		} // end index

		/**
		 * 详情页
		 */
		public function detail()
		{
			// 检查是否已传入必要参数
			$id = $this->input->get_post('id')? $this->input->get_post('id'): NULL;
			if ( !empty($id) ):
				$params['id'] = $id;
			else:
				redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页
			endif;

			// 从API服务器获取相应详情信息
			$url = api_url($this->class_name. '/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['item'] = $result['content'];

                // 页面信息
                $data['title'] = $this->class_name_cn. '详情';
                $data['class'] = $this->class_name.' detail';

                // 输出视图
                $this->load->view('templates/header', $data);
                $this->load->view($this->view_root.'/detail', $data);
                $this->load->view('templates/footer', $data);

			else:
                redirect( base_url('error/code_404') ); // 若缺少参数，转到错误提示页

			endif;
		} // end detail

		/**
		 * 回收站
		 */
		public function trash()
		{
			// 页面信息
			$data = array(
				'title' => $this->class_name_cn. '回收站',
				'class' => $this->class_name.' trash',
			);

			// 筛选条件
			$condition['time_delete'] = 'IS NOT NULL';
			// （可选）遍历筛选条件
			foreach ($this->names_to_sort as $sorter):
				if ( !empty($this->input->post($sorter)) )
					$condition[$sorter] = $this->input->post($sorter);
			endforeach;

			// 从API服务器获取相应列表信息
			$params = $condition;
            $data['limit'] = $params['limit'] = empty($this->input->get_post('limit'))? 10: $this->input->get_post('limit');
            $data['offset'] = $params['offset'] = empty($this->input->get_post('offset'))? 0: $this->input->get_post('offset');
			$url = api_url($this->class_name. '/index');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['items'] = $result['content'];
			else:
				$data['error'] = $result['content']['error']['message'];
			endif;

			// 输出视图
			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/trash', $data);
			$this->load->view('templates/footer', $data);
		} // end trash

		/**
		 * 创建
		 */
		public function create()
		{
			// 页面信息
			$data = array(
				'title' => '创建'.$this->class_name_cn,
				'class' => $this->class_name.' create',
				'error' => '', // 预设错误提示
			);

			// 获取当前用户可用的收货地址列表
			$data['addresses'] = $this->list_address();

			// 若是单商品订单，获取相应商家、商品信息
			if ( !empty($this->input->get_post('item_id')) ):
				$data['item'] = $this->get_item($this->input->get_post('item_id'));

				// 获取相应商家信息
				if ( !empty($data['item']) ):
					$data['biz'] = $this->get_biz($data['item']['biz_id']);
				endif;
				
				// 若已指定规格，获取相应规格信息
				if ( !empty($this->input->get_post('sku_id')) ):
					$data['sku'] = $this->get_sku($this->input->get_post('sku_id'));
				endif;

			// 若为购物车订单，解析购物车
			elseif ( !empty($this->session->cart) ):
				$data['cart_data'] = $this->cart_decode();

			endif;

			// 待验证的表单项
			$this->form_validation->set_error_delimiters('', '；');
			// 验证规则 https://www.codeigniter.com/user_guide/libraries/form_validation.html#rule-reference
			$this->form_validation->set_rules('address_id', '收件地址', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('note_user', '用户留言', 'trim|max_length[255]');
			// 仅单品订单涉及以下字段
			$this->form_validation->set_rules('item_id', '商品ID', 'trim|is_natural_no_zero');
			$this->form_validation->set_rules('sku_id', '规格ID', 'trim|is_natural_no_zero');
			$this->form_validation->set_rules('count', '份数', 'trim|is_natural_no_zero|less_than_equal_to[]');

			// 若表单提交不成功
			if ($this->form_validation->run() === FALSE):
				$data['error'] = validation_errors();

				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/create', $data);
				$this->load->view('templates/footer', $data);

			else:
				// 需要创建的数据；逐一赋值需特别处理的字段
				$data_to_create = array(
					'user_ip' => $this->input->ip_address(),
					'cart_string' => $this->session->cart, // 仅购物车订单涉及该项
				);
				// 自动生成无需特别处理的数据
				$data_need_no_prepare = array(
					'address_id', 'note_user', 'item_id', 'sku_id', 'count',
				);
				foreach ($data_need_no_prepare as $name)
					$data_to_create[$name] = $this->input->post($name);

				// 向API服务器发送待创建数据
				$params = $data_to_create; // 清理空参数，并按键名升序对数组排序
				//$params = array_filter($data_to_create); // 清理空参数，并按键名升序对数组排序
				ksort($params);
				$this->key_value($params);exit(); // 测试
				$url = api_url($this->class_name. '/create');
				$result = $this->curl->go($url, $params, 'array');
				if ($result['status'] === 200):
					$data['title'] = $this->class_name_cn. '创建成功';
					$data['class'] = 'success';
					$data['content'] = $result['content']['message'];
					$data['operation'] = 'create';
					$data['id'] = $result['content']['id']; // 创建后的信息ID

					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/result_create', $data);
					$this->load->view('templates/footer', $data);

				else:
					// 若创建失败，则进行提示
					$data['error'] = $result['content']['error']['message'];

					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/create', $data);
					$this->load->view('templates/footer', $data);

				endif;

			endif;
		} // end create

		/**
		 * 支付
		 */
		public function pay()
		{
			// 检查是否已传入必要参数
			$id = $this->input->get_post('id')? $this->input->get_post('id'): NULL;
			if ( !empty($id) ):
				$params['id'] = $id;
				$params['status'] = '待付款'; // 仅待付款状态的订单可以支付
			else:
				redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页
			endif;

			// 页面信息
			$data['title'] = $this->class_name_cn. '支付';
			$data['class'] = $this->class_name.' pay';

			// 从API服务器获取相应详情信息
			$url = api_url($this->class_name. '/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['item'] = $result['content'];
			else:
				$data['error'] = $result['content']['error']['message'];
			endif;

			// 输出视图
			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/pay', $data);
			$this->load->view('templates/footer', $data);
		} // end detail

        // TODO 取消、删除、确认、再来一单

	} // end class Order

/* End of file Order.php */
/* Location: ./application/controllers/Order.php */
