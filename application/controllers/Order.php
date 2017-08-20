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
			'order_id', 'biz_id', 'user_id', 'user_ip', 'subtotal', 'promotion_id', 'discount_promotion', 'coupon_id', 'discount_coupon', 'credit_id', 'discount_payed', 'freight', 'discount_reprice', 'repricer_id', 'total', 'total_payed', 'total_refund', 'fullname', 'mobile', 'province', 'city', 'county', 'street', 'longitude', 'latitude', 'payment_type', 'payment_account', 'payment_id', 'note_user', 'note_stuff', 'commission', 'promoter_id', 'time_create', 'time_cancel', 'time_expire', 'time_pay', 'time_refuse', 'time_accept', 'time_deliver', 'time_confirm', 'time_confirm_auto', 'time_comment', 'time_refund', 'time_delete', 'time_edit', 'operator_id', 'status', 'refund_status', 'invoice_status',
		);

		/**
		 * 可被编辑的字段名
		 */
		protected $names_edit_allowed = array(
			'order_id', 'biz_id', 'user_id', 'user_ip', 'subtotal', 'promotion_id', 'discount_promotion', 'coupon_id', 'discount_coupon', 'credit_id', 'discount_payed', 'freight', 'discount_reprice', 'repricer_id', 'total', 'total_payed', 'total_refund', 'fullname', 'mobile', 'province', 'city', 'county', 'street', 'longitude', 'latitude', 'payment_type', 'payment_account', 'payment_id', 'note_user', 'note_stuff', 'commission', 'promoter_id', 'time_create', 'time_cancel', 'time_expire', 'time_pay', 'time_refuse', 'time_accept', 'time_deliver', 'time_confirm', 'time_confirm_auto', 'time_comment', 'time_refund', 'time_delete', 'time_edit', 'operator_id', 'status', 'refund_status', 'invoice_status',
		);

		/**
		 * 完整编辑单行时必要的字段名
		 */
		protected $names_edit_required = array(
			'id',
			'order_id', 'biz_id', 'user_id', 'user_ip', 'subtotal', 'promotion_id', 'discount_promotion', 'coupon_id', 'discount_coupon', 'credit_id', 'discount_payed', 'freight', 'discount_reprice', 'repricer_id', 'total', 'total_payed', 'total_refund', 'fullname', 'mobile', 'province', 'city', 'county', 'street', 'longitude', 'latitude', 'payment_type', 'payment_account', 'payment_id', 'note_user', 'note_stuff', 'commission', 'promoter_id', 'time_create', 'time_cancel', 'time_expire', 'time_pay', 'time_refuse', 'time_accept', 'time_deliver', 'time_confirm', 'time_confirm_auto', 'time_comment', 'time_refund', 'time_delete', 'time_edit', 'operator_id', 'status', 'refund_status', 'invoice_status',
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

			// （可选）未登录用户转到登录页
			($this->session->time_expire_login > time()) OR redirect( base_url('login') );

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '订单'; // 改这里……
			$this->table_name = 'order'; // 和这里……
			$this->id_name = 'order_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 视图文件所在目录
			$this->media_root = MEDIA_URL. 'item/'; // 媒体文件所在目录

			// （可选）某些用于此类的自定义函数
		    function function_name($parameter)
			{
				//...
		    }
		}
		
		/**
		 * 截止3.1.3为止，CI_Controller类无析构函数，所以无需继承相应方法
		 */
		public function __destruct()
		{
			// 调试信息输出开关
			$this->output->enable_profiler(TRUE);
		}

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
			$condition['user_id'] = $this->session->user_id;
			$condition['time_delete'] = 'NULL';
			//$condition['name'] = 'value';
			// （可选）遍历筛选条件
			foreach ($this->names_to_sort as $sorter):
				if ( !empty($this->input->post($sorter)) )
					$condition[$sorter] = $this->input->post($sorter);
			endforeach;

			// 排序条件
			$order_by = NULL;
			//$order_by['name'] = 'value';

			// 从API服务器获取相应列表信息
			$params = $condition;
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
				$params['user_id'] = $this->session->user_id;
			else:
				redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页
			endif;

			// 从API服务器获取相应详情信息
			$url = api_url($this->class_name. '/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['item'] = $result['content'];
			else:
				$data['error'] = $result['content']['error']['message'];
			endif;

			// 页面信息
			$data['title'] = $this->class_name_cn. '详情';
			$data['class'] = $this->class_name.' detail';

			// 输出视图
			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/detail', $data);
			$this->load->view('templates/footer', $data);
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
			$condition['user_id'] = $this->session->user_id;
			$condition['time_delete'] = 'IS NOT NULL';
			// （可选）遍历筛选条件
			foreach ($this->names_to_sort as $sorter):
				if ( !empty($this->input->post($sorter)) )
					$condition[$sorter] = $this->input->post($sorter);
			endforeach;

			// 排序条件
			$order_by['time_delete'] = 'DESC';
			//$order_by['name'] = 'value';

			// 从API服务器获取相应列表信息
			$params = $condition;
			$url = api_url($this->class_name. '/index');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['items'] = $result['content'];
			else:
				$data['error'] = $result['content']['error']['message'];
			endif;

			// 将需要显示的数据传到视图以备使用
			$data['data_to_display'] = $this->data_to_display;

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

				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/create', $data);
				$this->load->view('templates/footer', $data);

			else:
				// 需要创建的数据；逐一赋值需特别处理的字段
				$data_to_create = array(
					'user_id' => $this->session->user_id,
					'user_ip' => $this->input->ip_address(),
					'cart_string' => $this->session->cart, // 仅购物车订单涉及该项
				);
				// 自动生成无需特别处理的数据
				$data_need_no_prepare = array(
					'item_id', 'sku_id', 'count', 'address_id', 'note_user',
				);
				foreach ($data_need_no_prepare as $name)
					$data_to_create[$name] = $this->input->post($name);

				// 向API服务器发送待创建数据
				$params = $data_to_create;
				$this->key_value($params);exit();
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
		 * 编辑单行
		 */
		public function edit()
		{
			// 检查是否已传入必要参数
			$id = $this->input->get_post('id')? $this->input->get_post('id'): NULL;
			if ( !empty($id) ):
				$params['id'] = $id;
				$params['user_id'] = $this->session->user_id;
			else:
				redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页
			endif;

			// 页面信息
			$data = array(
				'title' => '修改'.$this->class_name_cn,
				'class' => $this->class_name.' edit',
				'error' => '', // 预设错误提示
			);

			// 从API服务器获取相应详情信息
			$url = api_url($this->class_name. '/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['item'] = $result['content'];
			else:
				redirect( base_url('error/code_404') ); // 若未成功获取信息，则转到错误页
			endif;

			// 待验证的表单项
			$this->form_validation->set_error_delimiters('', '；');
			$this->form_validation->set_rules('order_id', '订单ID', 'trim|required');
			$this->form_validation->set_rules('biz_id', '商户ID', 'trim|required');
			$this->form_validation->set_rules('user_id', '用户ID', 'trim|required');
			$this->form_validation->set_rules('user_ip', '用户下单IP地址', 'trim|');
			$this->form_validation->set_rules('subtotal', '小计（元）', 'trim|required');
			$this->form_validation->set_rules('promotion_id', '营销活动ID', 'trim|');
			$this->form_validation->set_rules('discount_promotion', '营销活动折抵金额（元）', 'trim|');
			$this->form_validation->set_rules('coupon_id', '优惠券ID', 'trim|');
			$this->form_validation->set_rules('discount_coupon', '优惠券折抵金额（元）', 'trim|');
			$this->form_validation->set_rules('credit_id', '积分流水ID', 'trim|');
			$this->form_validation->set_rules('discount_payed', '积分折抵金额（元）', 'trim|');
			$this->form_validation->set_rules('freight', '运费（元）', 'trim|');
			$this->form_validation->set_rules('discount_reprice', '改价折抵金额（元）', 'trim|');
			$this->form_validation->set_rules('repricer_id', '改价操作者ID', 'trim|');
			$this->form_validation->set_rules('total', '应支付金额（元）', 'trim|required');
			$this->form_validation->set_rules('total_payed', '实际支付金额（元）', 'trim|');
			$this->form_validation->set_rules('total_refund', '实际退款金额（元）', 'trim|');
			$this->form_validation->set_rules('fullname', '收件人全名', 'trim|required');
			$this->form_validation->set_rules('mobile', '收件人手机号', 'trim|required');
			$this->form_validation->set_rules('province', '收件人省份', 'trim|required');
			$this->form_validation->set_rules('city', '收件人城市', 'trim|required');
			$this->form_validation->set_rules('county', '收件人区/县', 'trim|required');
			$this->form_validation->set_rules('street', '收件人具体地址', 'trim|required');
			$this->form_validation->set_rules('longitude', '经度', 'trim|');
			$this->form_validation->set_rules('latitude', '纬度', 'trim|');
			$this->form_validation->set_rules('payment_type', '付款方式', 'trim|');
			$this->form_validation->set_rules('payment_account', '付款账号', 'trim|');
			$this->form_validation->set_rules('payment_id', '付款流水号', 'trim|');
			$this->form_validation->set_rules('note_user', '用户留言', 'trim|');
			$this->form_validation->set_rules('note_stuff', '员工留言', 'trim|');
			$this->form_validation->set_rules('佣金比例/提成率', 'trim|');
			$this->form_validation->set_rules('commission', '佣金（元）', 'trim|');
			$this->form_validation->set_rules('promoter_id', '推广者ID', 'trim|');
			$this->form_validation->set_rules('time_create', '用户下单时间', 'trim|required');
			$this->form_validation->set_rules('time_cancel', '用户取消时间', 'trim|');
			$this->form_validation->set_rules('time_expire', '自动过期时间', 'trim|');
			$this->form_validation->set_rules('time_pay', '用户付款时间', 'trim|');
			$this->form_validation->set_rules('time_refuse', '商家拒绝时间', 'trim|');
			$this->form_validation->set_rules('time_accept', '商家接单时间', 'trim|');
			$this->form_validation->set_rules('time_deliver', '商家发货时间', 'trim|');
			$this->form_validation->set_rules('time_confirm', '用户确认时间', 'trim|');
			$this->form_validation->set_rules('time_confirm_auto', '系统确认时间', 'trim|');
			$this->form_validation->set_rules('time_comment', '用户评价时间', 'trim|');
			$this->form_validation->set_rules('time_refund', '商家退款时间', 'trim|');
			$this->form_validation->set_rules('time_delete', '用户删除时间', 'trim|');
			$this->form_validation->set_rules('time_edit', '最后操作时间', 'trim|required');
			$this->form_validation->set_rules('operator_id', '最后操作者ID', 'trim|');
			$this->form_validation->set_rules('status', '订单状态', 'trim|required');
			$this->form_validation->set_rules('refund_status', '退款状态', 'trim|required');
			$this->form_validation->set_rules('invoice_status', '发票状态', 'trim|required');

			// 若表单提交不成功
			if ($this->form_validation->run() === FALSE):
				$data['error'] .= validation_errors();

				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/edit', $data);
				$this->load->view('templates/footer', $data);

			else:
				// 需要编辑的数据；逐一赋值需特别处理的字段
				$data_to_edit = array(
					'user_id' => $this->session->user_id,
					'id' => $id,
					//'name' => $this->input->post('name')),
				);
				// 自动生成无需特别处理的数据
				$data_need_no_prepare = array(
					'order_id', 'biz_id', 'user_id', 'user_ip', 'subtotal', 'promotion_id', 'discount_promotion', 'coupon_id', 'discount_coupon', 'credit_id', 'discount_payed', 'freight', 'discount_reprice', 'repricer_id', 'total', 'total_payed', 'total_refund', 'fullname', 'mobile', 'province', 'city', 'county', 'street', 'longitude', 'latitude', 'payment_type', 'payment_account', 'payment_id', 'note_user', 'note_stuff', 'commission', 'promoter_id', 'time_create', 'time_cancel', 'time_expire', 'time_pay', 'time_refuse', 'time_accept', 'time_deliver', 'time_confirm', 'time_confirm_auto', 'time_comment', 'time_refund', 'time_delete', 'time_edit', 'operator_id', 'status', 'refund_status', 'invoice_status',
				);
				foreach ($data_need_no_prepare as $name)
					$data_to_edit[$name] = $this->input->post($name);

				// 向API服务器发送待创建数据
				$params = $data_to_edit;
				$url = api_url($this->class_name. '/edit');
				$result = $this->curl->go($url, $params, 'array');
				if ($result['status'] === 200):
					$data['title'] = $this->class_name_cn. '修改成功';
					$data['class'] = 'success';
					$data['content'] = $result['content']['message'];
					$data['operation'] = 'edit';
					$data['id'] = $id;

					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/result', $data);
					$this->load->view('templates/footer', $data);

				else:
					// 若修改失败，则进行提示
					$data['error'] = $result['content']['error']['message'];

					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/edit', $data);
					$this->load->view('templates/footer', $data);

				endif;

			endif;
		} // end edit

		/**
		 * 修改单项
		 */
		public function edit_certain()
		{
			// 检查必要参数是否已传入
			$required_params = $this->names_edit_certain_required;
			foreach ($required_params as $param):
				${$param} = $this->input->post($param);
				if ( $param !== 'value' && empty( ${$param} ) ): // value 可以为空；必要字段会在字段验证中另行检查
					$data['error'] = '必要的请求参数未全部传入';
					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/'.$op_view, $data);
					$this->load->view('templates/footer', $data);
					exit();
				endif;
			endforeach;

			// 操作可能需要检查操作权限
			// $role_allowed = array('管理员', '经理'); // 角色要求
// 			$min_level = 30; // 级别要求
// 			$this->basic->permission_check($role_allowed, $min_level);

			// 页面信息
			$data = array(
				'title' => '修改'.$this->class_name_cn. $name,
				'class' => $this->class_name.' edit-certain',
				'error' => '', // 预设错误提示
			);
			
			// 从API服务器获取相应详情信息
			$params['id'] = $id;
			$params['user_id'] = $this->session->user_id;
			$url = api_url($this->class_name. '/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['item'] = $result['content'];
			else:
				redirect( base_url('error/code_404') ); // 若未成功获取信息，则转到错误页
			endif;

			// 待验证的表单项
			$this->form_validation->set_error_delimiters('', '；');
			// 动态设置待验证字段名及字段值
			$data_to_validate["{$name}"] = $value;
			$this->form_validation->set_data($data_to_validate);
			$this->form_validation->set_rules('id', '待修改项ID', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('order_id', '订单ID', 'trim|required');
			$this->form_validation->set_rules('biz_id', '商户ID', 'trim|required');
			$this->form_validation->set_rules('user_id', '用户ID', 'trim|required');
			$this->form_validation->set_rules('user_ip', '用户下单IP地址', 'trim|');
			$this->form_validation->set_rules('subtotal', '小计（元）', 'trim|required');
			$this->form_validation->set_rules('promotion_id', '营销活动ID', 'trim|');
			$this->form_validation->set_rules('discount_promotion', '营销活动折抵金额（元）', 'trim|');
			$this->form_validation->set_rules('coupon_id', '优惠券ID', 'trim|');
			$this->form_validation->set_rules('discount_coupon', '优惠券折抵金额（元）', 'trim|');
			$this->form_validation->set_rules('credit_id', '积分流水ID', 'trim|');
			$this->form_validation->set_rules('discount_payed', '积分折抵金额（元）', 'trim|');
			$this->form_validation->set_rules('freight', '运费（元）', 'trim|');
			$this->form_validation->set_rules('discount_reprice', '改价折抵金额（元）', 'trim|');
			$this->form_validation->set_rules('repricer_id', '改价操作者ID', 'trim|');
			$this->form_validation->set_rules('total', '应支付金额（元）', 'trim|required');
			$this->form_validation->set_rules('total_payed', '实际支付金额（元）', 'trim|');
			$this->form_validation->set_rules('total_refund', '实际退款金额（元）', 'trim|');
			$this->form_validation->set_rules('fullname', '收件人全名', 'trim|required');
			$this->form_validation->set_rules('mobile', '收件人手机号', 'trim|required');
			$this->form_validation->set_rules('province', '收件人省份', 'trim|required');
			$this->form_validation->set_rules('city', '收件人城市', 'trim|required');
			$this->form_validation->set_rules('county', '收件人区/县', 'trim|required');
			$this->form_validation->set_rules('street', '收件人具体地址', 'trim|required');
			$this->form_validation->set_rules('longitude', '经度', 'trim|');
			$this->form_validation->set_rules('latitude', '纬度', 'trim|');
			$this->form_validation->set_rules('payment_type', '付款方式', 'trim|');
			$this->form_validation->set_rules('payment_account', '付款账号', 'trim|');
			$this->form_validation->set_rules('payment_id', '付款流水号', 'trim|');
			$this->form_validation->set_rules('note_user', '用户留言', 'trim|');
			$this->form_validation->set_rules('note_stuff', '员工留言', 'trim|');
			$this->form_validation->set_rules('佣金比例/提成率', 'trim|');
			$this->form_validation->set_rules('commission', '佣金（元）', 'trim|');
			$this->form_validation->set_rules('promoter_id', '推广者ID', 'trim|');
			$this->form_validation->set_rules('time_create', '用户下单时间', 'trim|required');
			$this->form_validation->set_rules('time_cancel', '用户取消时间', 'trim|');
			$this->form_validation->set_rules('time_expire', '自动过期时间', 'trim|');
			$this->form_validation->set_rules('time_pay', '用户付款时间', 'trim|');
			$this->form_validation->set_rules('time_refuse', '商家拒绝时间', 'trim|');
			$this->form_validation->set_rules('time_accept', '商家接单时间', 'trim|');
			$this->form_validation->set_rules('time_deliver', '商家发货时间', 'trim|');
			$this->form_validation->set_rules('time_confirm', '用户确认时间', 'trim|');
			$this->form_validation->set_rules('time_confirm_auto', '系统确认时间', 'trim|');
			$this->form_validation->set_rules('time_comment', '用户评价时间', 'trim|');
			$this->form_validation->set_rules('time_refund', '商家退款时间', 'trim|');
			$this->form_validation->set_rules('time_delete', '用户删除时间', 'trim|');
			$this->form_validation->set_rules('time_edit', '最后操作时间', 'trim|required');
			$this->form_validation->set_rules('operator_id', '最后操作者ID', 'trim|');
			$this->form_validation->set_rules('status', '订单状态', 'trim|required');
			$this->form_validation->set_rules('refund_status', '退款状态', 'trim|required');
			$this->form_validation->set_rules('invoice_status', '发票状态', 'trim|required');

			// 若表单提交不成功
			if ($this->form_validation->run() === FALSE):
				$data['error'] .= validation_errors();

				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/edit_certain', $data);
				$this->load->view('templates/footer', $data);

			else:
				// 需要编辑的信息
				$data_to_edit = array(
					'user_id' => $this->session->user_id,
					'id' => $id,
					'name' => $name,
					'value' => $value,
				);

				// 向API服务器发送待创建数据
				$params = $data_to_edit;
				$url = api_url($this->class_name. '/edit_certain');
				$result = $this->curl->go($url, $params, 'array');
				if ($result['status'] === 200):
					$data['title'] = $this->class_name_cn. '修改成功';
					$data['class'] = 'success';
					$data['content'] = $result['content']['message'];
					$data['operation'] = 'edit_certain';
					$data['id'] = $id;

					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/result', $data);
					$this->load->view('templates/footer', $data);

				else:
					// 若修改失败，则进行提示
					$data['error'] = $result['content']['error']['message'];

					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/edit_certain', $data);
					$this->load->view('templates/footer', $data);

				endif;

			endif;
		} // end edit_certain

		/**
		 * 删除单行或多行项目
		 */
		public function delete()
		{
			$op_name = '删除'; // 操作的名称
			$op_view = 'delete'; // 视图文件名

			// 页面信息
			$data = array(
				'title' => $op_name. $this->class_name_cn,
				'class' => $this->class_name. ' '. $op_view,
				'error' => '', // 预设错误提示
			);

			// 检查是否已传入必要参数
			if ( !empty($this->input->get_post('ids')) ):
				$ids = $this->input->get_post('ids');

				// 将字符串格式转换为数组格式
				if ( !is_array($ids) ):
					$ids = explode(',', $ids);
				endif;

			elseif ( !empty($this->input->post('ids[]')) ):
				$ids = $this->input->post('ids[]');

			else:
				redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页

			endif;
			
			// 赋值视图中需要用到的待操作项数据
			$data['ids'] = $ids;
			
			// 获取待操作项数据
			$data['items'] = array();
			foreach ($ids as $id):
				// 从API服务器获取相应详情信息
				$params['id'] = $id;
				$params['user_id'] = $this->session->user_id;
				$url = api_url($this->class_name. '/detail');
				$result = $this->curl->go($url, $params, 'array');
				if ($result['status'] === 200):
					$data['items'][] = $result['content'];
				else:
					$data['error'] .= 'ID'.$id.'项不可操作，“'.$result['content']['error']['message'].'”';
				endif;
			endforeach;

			// 将需要显示的数据传到视图以备使用
			$data['data_to_display'] = $this->data_to_display;

			// 待验证的表单项
			$this->form_validation->set_error_delimiters('', '；');
			$this->form_validation->set_rules('ids', '待操作数据ID们', 'trim|required|regex_match[/^(\d|\d,?)+$/]'); // 仅允许非零整数和半角逗号
			$this->form_validation->set_rules('password', '密码', 'trim|required|min_length[6]|max_length[20]');

			// 若表单提交不成功
			if ($this->form_validation->run() === FALSE):
				$data['error'] .= validation_errors();

				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/'.$op_view, $data);
				$this->load->view('templates/footer', $data);

			else:
				// 检查必要参数是否已传入
				$required_params = $this->names_edit_bulk_required;
				foreach ($required_params as $param):
					${$param} = $this->input->post($param);
					if ( empty( ${$param} ) ):
						$data['error'] = '必要的请求参数未全部传入';
						$this->load->view('templates/header', $data);
						$this->load->view($this->view_root.'/'.$op_view, $data);
						$this->load->view('templates/footer', $data);
						exit();
					endif;
				endforeach;

				// 需要存入数据库的信息
				$data_to_edit = array(
					'user_id' => $this->session->user_id,
					'ids' => $ids,
					'password' => $password,
					'operation' => $op_view, // 操作名称
				);

				// 向API服务器发送待创建数据
				$params = $data_to_edit;
				$url = api_url($this->class_name. '/edit_bulk');
				$result = $this->curl->go($url, $params, 'array');
				if ($result['status'] === 200):
					$data['title'] = $this->class_name_cn.$op_name. '成功';
					$data['class'] = 'success';
					$data['content'] = $result['content']['message'];
					$data['operation'] = 'bulk';
					$data['ids'] = $ids;

					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/result', $data);
					$this->load->view('templates/footer', $data);

				else:
					// 若修改失败，则进行提示
					$data['error'] .= $result['content']['error']['message'];

					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/'.$op_view, $data);
					$this->load->view('templates/footer', $data);
				endif;

			endif;
		} // end delete

		/**
		 * 恢复单行或多行项目
		 */
		public function restore()
		{
			$op_name = '恢复'; // 操作的名称
			$op_view = 'restore'; // 视图文件名

			// 页面信息
			$data = array(
				'title' => $op_name. $this->class_name_cn,
				'class' => $this->class_name. ' '. $op_view,
				'error' => '', // 预设错误提示
			);

			// 检查是否已传入必要参数
			if ( !empty($this->input->get_post('ids')) ):
				$ids = $this->input->get_post('ids');

				// 将字符串格式转换为数组格式
				if ( !is_array($ids) ):
					$ids = explode(',', $ids);
				endif;

			elseif ( !empty($this->input->post('ids[]')) ):
				$ids = $this->input->post('ids[]');

			else:
				redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页

			endif;
			
			// 赋值视图中需要用到的待操作项数据
			$data['ids'] = $ids;
			
			// 获取待操作项数据
			$data['items'] = array();
			foreach ($ids as $id):
				// 从API服务器获取相应详情信息
				$params['id'] = $id;
				$params['user_id'] = $this->session->user_id;
				$url = api_url($this->class_name. '/detail');
				$result = $this->curl->go($url, $params, 'array');
				if ($result['status'] === 200):
					$data['items'][] = $result['content'];
				else:
					$data['error'] .= 'ID'.$id.'项不可操作，“'.$result['content']['error']['message'].'”';
				endif;
			endforeach;

			// 将需要显示的数据传到视图以备使用
			$data['data_to_display'] = $this->data_to_display;

			// 待验证的表单项
			$this->form_validation->set_error_delimiters('', '；');
			$this->form_validation->set_rules('ids', '待操作数据ID们', 'trim|required|regex_match[/^(\d|\d,?)+$/]'); // 仅允许非零整数和半角逗号
			$this->form_validation->set_rules('password', '密码', 'trim|required|min_length[6]|max_length[20]');

			// 若表单提交不成功
			if ($this->form_validation->run() === FALSE):
				$data['error'] .= validation_errors();

				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/'.$op_view, $data);
				$this->load->view('templates/footer', $data);

			else:
				// 检查必要参数是否已传入
				$required_params = $this->names_edit_bulk_required;
				foreach ($required_params as $param):
					${$param} = $this->input->post($param);
					if ( empty( ${$param} ) ):
						$data['error'] = '必要的请求参数未全部传入';
						$this->load->view('templates/header', $data);
						$this->load->view($this->view_root.'/'.$op_view, $data);
						$this->load->view('templates/footer', $data);
						exit();
					endif;
				endforeach;

				// 需要存入数据库的信息
				$data_to_edit = array(
					'user_id' => $this->session->user_id,
					'ids' => $ids,
					'password' => $password,
					'operation' => $op_view, // 操作名称
				);

				// 向API服务器发送待创建数据
				$params = $data_to_edit;
				$url = api_url($this->class_name. '/edit_bulk');
				$result = $this->curl->go($url, $params, 'array');
				if ($result['status'] === 200):
					$data['title'] = $this->class_name_cn.$op_name. '成功';
					$data['class'] = 'success';
					$data['content'] = $result['content']['message'];

					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/result', $data);
					$this->load->view('templates/footer', $data);

				else:
					// 若修改失败，则进行提示
					$data['error'] .= $result['content']['error']['message'];

					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/'.$op_view, $data);
					$this->load->view('templates/footer', $data);
				endif;

			endif;
		} // end restore

	} // end class Order

/* End of file Order.php */
/* Location: ./application/controllers/Order.php */
