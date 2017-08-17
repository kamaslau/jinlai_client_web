<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Order 类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Order extends CI_Controller
	{
		/* 类名称小写，应用于多处动态生成内容 */
		public $class_name;

		/* 类名称中文，应用于多处动态生成内容 */
		public $class_name_cn;

		/* 主要相关表名 */
		public $table_name;

		/* 主要相关表的主键名*/
		public $id_name;

		/* 视图文件所在目录名 */
		public $view_root;

		public function __construct()
		{
			parent::__construct();

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '订单'; // 改这里……
			$this->table_name = 'order'; // 和这里……
			$this->id_name = 'order_id';  // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name;

			// 设置并调用Basic核心库
			$basic_configs = array(
				'table_name' => $this->table_name,
				'id_name' => $this->id_name,
				'view_root' => $this->view_root,
			);

			// 载入Basic库
			$this->load->library('basic', $basic_configs);

			/**
			 * 订单状态判断
			 *
			 * 以最后变更记录为准
			 */
		    function order_status($order)
			{
				if ($order['time_delete'] !== NULL):
					$status = '已删除';
				elseif ($order['time_refund'] !== NULL):
					$status = '已退款';
				elseif ($order['time_comment'] !== NULL):
					$status = '已评价';
				elseif ($order['time_finish'] !== NULL):
					$status = '待评价';
				elseif ($order['time_deliver'] !== NULL):
					$status = '待收货';
				elseif ($order['time_refuse'] !== NULL):
					$status = '已拒绝';
				elseif ($order['time_pay'] !== NULL):
					$status = '待发货';
				elseif ($order['time_expire'] !== NULL):
					$status = '已过期';
				elseif ($order['time_cancel'] !== NULL):
					$status = '已取消';
				else:
					$status = '待付款';
				endif;
				
				return $status;
		    }
		}

		/**
		 * 列表页
		 */
		public function index()
		{
			($this->session->logged_in === TRUE) OR redirect( base_url('login') );

			// 从API服务器获取相应数据
			$url = api_url($this->class_name);
			$params = array(
				'user_id' => $this->session->user_id,
				'status' => $this->input->get('status'),
			);
			$result = $this->curl->go($url, $params, 'array');

			// 设置页面
			$data = array(
				'title' => '我的'. $this->class_name_cn,
				'class' => $this->class_name.' '. $this->class_name.'-index',
			);

			// 页面数据
			$data['items'] = $result['content'];

			// 输出页面
			$this->load->view('templates/header', $data); // 载入视图文件，下同
			$this->load->view($this->view_root.'/index', $data);
			$this->load->view('templates/footer', $data);
		}

		/**
		 * 详情页
		 */
		public function detail()
		{
			($this->session->logged_in === TRUE) OR redirect( base_url('login') );
			
			// 检查是否已传入必要参数
			$id = $this->input->get_post('id')? $this->input->get_post('id'): NULL;
			if ( empty($id) )
				redirect(base_url('error/code_404'));

			// 从API服务器获取相应数据
			$url = api_url($this->class_name. '/detail');
			$params = array(
				'user_id' => $this->session->user_id,
				'id' => $id,
			);
			$result = $this->curl->go($url, $params, 'array');

			// 页面信息
			$data = array(
				'title' => $this->class_name_cn. '详情',
				'class' => $this->class_name.' '. $this->class_name.'-detail',
			);

			// 获取订单信息并传递到视图
			$order = $result['content'];
			$data['order'] = $order;

			// 判断订单类型（快捷订单、购物车订单），并获取订单相关商品信息
			$this->basic_model->table_name = 'item';
			$this->basic_model->id_name = 'item_id';
			if ($order['item'] === NULL):
				// 拆分现购物车数组中各项，并获取商品信息
				$order_items = array_filter( explode(' ', $order['items']) );

				// 创建商品信息数组
				$items = array();

				// 获取各商品信息
				foreach ($order_items as $item):
					$this_item = explode('|', $item);
					$this_id = $this_item[0];
					$this_count = $this_item[1];
					$item = $this->basic_model->select_by_id($this_id);
					$item['unit'] = $this_count;
					$items[] = $item;
				endforeach;
				$data['items'] = $items; // 将商品信息传入视图

			else:
				$this_item = explode('|', $order['item']);
				$this_id = $this_item[0];
				$this_count = $this_item[1];
				$item = $this->basic_model->select_by_id($this_id);
				$item['unit'] = $this_count;
				$data['items'][] = $item; // 将商品信息传入视图

			endif;

			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/detail', $data);
			$this->load->view('templates/footer', $data);
		}

		// 生成快捷订单信息（单品订单）
		// 如果不可使用优惠券，进行标记
		private function generate_quick_order($item)
		{
			// 计算1份该商品的订单小计、运费、折扣金额，及实际支付金额
			$subtotal = $item['price'] * $item['unit'];
			$freight = $item['freight'] * $item['unit'];
			$discount = (empty($item['discount']) || $item['discount'] === '0.00')? '0.00': (1 - $item['discount']) * $subtotal;
			$discount_credit = (empty($item['discount_credit']) || $item['discount_credit'] === '0.00')? '0.00': (1 - $item['discount_credit']) * $subtotal;
			$total = ($subtotal + $freight - $discount);
			
			// 若不允许使用优惠券
			if ($item['coupon_allowed'] === '0') $coupon_banned = TRUE;
			
			//TODO 检测是否参与折扣（预备功能，如全店折扣等）

			// 生成并返回订单信息数组
			$order_data = array(
				'item' => $item['item_id'].'|'.$item['unit'],
				'subtotal' => round($subtotal, 2),
				'freight' => round($freight, 2),
				'discount' => round($discount, 2),
				'discount_credit' => round($discount_credit), // 保留整数
				'total' => round($total, 2),
				'coupon_allowed' => (isset($coupon_banned))? '0': '1',
			);
			return $order_data;
		}

		// 生成购物车订单信息
		// 如果不可使用优惠券，进行标记
		private function generate_cart_order($items)
		{
			// 计算购物车中所有商品的订单小计、运费、折扣金额，及实际支付金额
			$subtotal = $freight = $discount = $discount_credit = $total = 0.00;

			foreach ($items as $item):
				$subtotal += $item['price'] * $item['unit'];
				$freight += $item['freight'] * $item['unit'];
				$discount += (empty($item['discount']) || $item['discount'] === '0.00')? '0.00': (1 - $item['discount']) * $subtotal;
				$discount_credit += (empty($item['discount_credit']) || $item['discount_credit'] === '0.00')? '0.00': (1 - $item['discount_credit']) * $subtotal;
				// 若不允许使用优惠券
				if ($item['coupon_allowed'] === '0') $coupon_banned = TRUE;
			endforeach;

			$total = ($subtotal + $freight - $discount - $discount_credit);

			// 生成并返回订单信息数组
			$order_data = array(
				'items' => $this->valid_items_string($items),
				'subtotal' => round($subtotal, 2),
				'freight' => round($freight, 2),
				'discount' => round($discount, 2),
				'discount_credit' => round($discount_credit), // 保留整数
				'total' => round($total, 2),
				'coupon_allowed' => (isset($coupon_banned))? '0': '1',
			);
			return $order_data;
		}
		
		// 生成有效商品的 id|数量 字符串
		private function valid_items_string($items)
		{
			$items_string = '';
			
			foreach ($items as $item):
				$items_string .= ' '.$item['item_id'].'|'.$item['unit'];
			endforeach;
			
			return $items_string;
		}

		/**
		 * 创建订单
		 *
		 * 获取商品信息
		 * 获取商家信息
		 * 获取优惠券信息
		 * 获取积分信息
		 * 计算运费
		 * 生成最终订单信息
		 * 将订单信息写入数据库
		 */
		public function create()
		{
			($this->session->logged_in === TRUE) OR redirect( base_url('login') );

			// 页面信息
			$data = array(
				'title' => '创建'.$this->class_name_cn,
				'class' => $this->class_name.' '. $this->class_name.'-create',
			);

			// 若传入id请求参数，则为仅购买1项商品的快捷订单
			// 若不传入id请求参数，则为从购物车创建订单的购物车订单
			$id = $this->input->get_post('id')? $this->input->get_post('id'): NULL;
			
			// 若id和session中商品信息均为空，则转到购物车
			if (empty($id) && empty($this->session->cart))
				redirect( base_url('cart') );

			// 获取订单相关商品信息并生成订单信息
			$this->basic_model->table_name = 'item';
			$this->basic_model->id_name = 'item_id';

			// 从购物车创建订单
			if ($id === NULL):
				// 拆分现购物车数组中各项，并获取商品信息
				$current_cart = array_filter( explode(' ', $this->session->cart) );

				// 创建有效商品信息及失效产品信息数组
				$items = array();
				$items_invalid = array();

				// 获取各商品信息
				foreach ($current_cart as $cart_item):
					$this_item = explode('|', $cart_item);
					$this_id = $this_item[0];
					$this_count = $this_item[1];
					$item = $this->basic_model->select_by_id($this_id);

					// 若商品已经下架/删除，不加入订单
					if ($item['time_delete'] === NULL):
						$item['unit'] = $this_count;
						$items[] = $item;
					else:
						$items_invalid[] = $item;
					endif;
				endforeach;

				$order = $this->generate_cart_order($items);
				$order['biz_id'] = $this->session->biz_id; // 订单相关商家biz_id（在biz/detail方法中已赋值）

				// 如果所有商品都已失效，返回购物车页面
				if ( empty($items) && !empty($items_invalid) )
					redirect('cart');

				// 将有效商品信息及失效产品信息（若有）传入视图
				$data['items'] = $items;
				$data['items_invalid'] = $items_invalid;

			// 从商品详情页创建订单
			else:
				$item = $this->basic_model->select_by_id($id);
				
				// 如果所有商品都已失效，返回购物车页面
				if ($item['time_delete'] === NULL)
					redirect('cart');

				// 获取购买数量
				$unit = $this->input->get_post('unit')? $this->input->get_post('unit'): 1;
				$item['unit'] = $unit;
				$order = $this->generate_quick_order($item);
				
				$data['items'][] = $item; // 将商品信息传入视图

			endif;

			// 获取商家信息
			// 从API服务器获取相应商家信息
			$url = api_url('biz/detail');
			$params['id'] = $this->session->biz_id;
			$result = $this->curl->go($url, $params, 'array');
			$biz = $result['content'];

			// 检查是否达到最低订单金额
			$difference_to_total = $order['total'] - $biz['min_order_subtotal'];
			if ($difference_to_total < 0):
				$data['content'] = '<p class="alert alert-warning">订单金额需多于'.$min_total_required.'元，目前订单金额为'.$order['total'].'元，还差'.abs($difference_to_total).'元，您可继续选购后下单。</p>';
				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/result', $data);
				$this->load->view('templates/footer', $data);

			else:
				// 若不含不准使用优惠券的商品，则使用优惠券
				if ($order['coupon_allowed'] === '1'):
					// 准备获取优惠券相关数据
					$this->basic_model->table_name = 'coupon';
					$this->basic_model->id_name = 'coupon_id';

					// 根据订单金额获取适用的可抵扣金额最高的优惠券
					$coupon_condition = array(
						'user_id' => $this->session->user_id,
						'biz_id' => $order['biz_id'],
						'time_expire >' => date('Y-m-d H:i:s'), 
						'time_used' => NULL,
						'status' => '正常',
						'min_order_subtotal <=' => $order['total'],
					);
					// 优先获取可抵扣金额最高的优惠券
					$coupon_order['amount'] = 'DESC';

					// 获取优惠券
					$coupons = $this->basic_model->select($coupon_condition, $coupon_order);
					if ( !empty($coupons) ):
						$data['coupon'] = $coupon = $coupons[0];
				
						// 更新订单相关信息
						$order['coupon_id'] = $coupon['coupon_id']; // 记录订单使用的优惠券ID
						$order['discount'] += $coupon['amount']; // 更新订单折扣/减免金额
						$order['total'] -= $coupon['amount']; // 更新订单实际支付金额
					endif;
				endif;
				// 删除无需写入订单数据的信息
				unset($order['coupon_allowed']);

				// 如订单含可用积分抵扣金额的商品
				if ( !empty($order['discount_credit']) ):
					// 获取当前用户积分
					$this->basic_model->table_name = 'credit';
					$this->basic_model->id_name = 'credit_id';

					// 获取积分总收入
					$this->db->select_sum('amount');
					$credit_condition = array(
						'user_id' => $this->session->user_id,
						'type' => 'income',
					);
					$credit_income = $this->basic_model->select($credit_condition, NULL)[0]['amount'];

					// 获取积分总支出并计算总积分余额
					if ( !empty($credit_income) ):
						$this->db->select_sum('amount');
						$credit_condition = array(
							'user_id' => $this->session->user_id,
							'type' => 'outgo',
						);
						$credit_outgo = $this->basic_model->select($credit_condition, NULL)[0]['amount'];

						// 计算总积分余额
						$credit_balance = $credit_income - $credit_outgo;

						// 计算当前用户积分是否大于可抵扣金额
						if ($credit_balance >= $order['discount_credit']):
							$credit_to_discount = $order['discount_credit'];
						else:
							$credit_to_discount = 0;
						endif;

					else:
						$credit_to_discount = 0;

					endif; //end 获取积分总支出并计算总积分余额

					// 若不足够，将可用积分支付的金额重新计入应付金额，并清零可用积分支付的金额
					if ($credit_to_discount === 0):
						$order['total'] += $order['discount_credit'];
						$order['discount_credit'] = 0;

					// 若足够，创建相应积分流水记录并将相应订单流水记录ID记入订单信息
					else:
						$data_to_create = array(
							'user_id' => $this->session->user_id,
							'type' => 'outgo',
							'amount' => $order['discount_credit'],
						);
						$credit_id = $this->basic_model->create($data_to_create, TRUE);

					endif; //end 检查积分余额是否足以支付可用积分支付的金额部分

					if ($this->session->mobile === '13668865673'):
						var_dump($order);
						
						$this->output->enable_profiler(TRUE);
					endif;

				endif; //end 如订单含可用积分抵扣金额的商品

				// 检查是否满足免运费条件
				if ( $order['total'] >= $biz['freight_free_subtotal'] ):
					$order['freight'] += 0; // 如果有单品设置了运费，则不免运费
				// 若不符合免邮费条件，则计算运费
				else:
					$order['freight'] = $biz['freight'];
					$order['total'] += $biz['freight'];
				endif; //end 检查是否满足免运费条件


				// 将订单信息、商家信息传入视图
				$data['order'] = $order;
				$data['biz'] = $biz;

				// 待验证的表单项
				$this->form_validation->set_rules('address', '地址', 'trim|required');
				$this->form_validation->set_rules('note_user', '留言', 'trim');


				// 若表单提交不成功
				if ($this->form_validation->run() === FALSE):
					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/create', $data);
					$this->load->view('templates/footer', $data);

				// 尝试存入数据库
				else:
					// 需要存入数据库的信息
					$data_to_create = array(
						'user_id' => $this->session->user_id,
						'user_ip' => $this->input->ip_address(),
						'address' => $this->input->post('address'),
						'note_user' => $this->input->post('note_user'),
					);
					$data_to_create = array_merge($data_to_create, $order);

					// 将上述信息存入商品订单信息表
					$this->basic_model->table_name = 'order';
					$this->basic_model->id_name = 'order_id';
					$order_id = $this->basic_model->create($data_to_create, TRUE);

					// 检查订单是否创建成功
					if ($order_id !== FALSE):
						// 若为购物车订单，则清空购物车
						if ($id === NULL):
							unset($_SESSION['cart']);
						endif;

						// 若订单使用了优惠券，更新优惠券数据
						if ( !empty($coupon_id) ):
							$data_to_edit = array(
								'order_id' => $order_id,
								'time_used' => date('Y-m-d H:i:s'),
							);

							$this->basic_model->table_name = 'coupon';
							$this->basic_model->id_name = 'coupon_id';
							$coupon_update = $this->basic_model->edit($coupon_id, $data_to_edit);
						endif;

						// 转到订单支付页面
						$this->pay($order_id);

					else:
						$data['content'] = '<p class="alert alert-warning">下单失败，请重试。</p>';
						$this->load->view('templates/header', $data);
						$this->load->view($this->view_root.'/result', $data);
						$this->load->view('templates/footer', $data);

					endif; //end 检查订单是否创建成功

				endif; //end 尝试存入数据库

			endif; //end 检查是否达到最低订单金额
		}

		/**
		 * 订单支付
		 *
		 * @param int $id 需要支付的订单ID
		 */
		public function pay($id = NULL)
		{
			($this->session->logged_in === TRUE) OR redirect( base_url('login') );
			
			// 页面信息
			$data = array(
				'title' => '商品订单支付',
				'class' => $this->class_name.' '. $this->class_name.'-pay',
			);

			// 获取订单ID，并获取订单信息
			$id = isset($id)? $id: $this->input->get_post('id');
			$data['order'] = $this->basic_model->select_by_id($id);

			// 如订单有优惠券，则获取优惠券信息
			if ( !empty($data['order']['coupon_id']) ):
				$this->basic_model->table_name = 'coupon';
				$this->basic_model->id_name = 'coupon_id';
				
				$data['coupon'] = $this->basic_model->select_by_id($data['order']['coupon_id']);
			endif;

			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/pay', $data);
			$this->load->view('templates/footer', $data);
		}

		/**
		 * 确认收货
		 *
		 * 修改time_finish为当前时间，并根据实付金额创建积分流水
		 */
		public function finish()
		{
			($this->session->logged_in === TRUE) OR redirect( base_url('login') );

			// 检查是否已传入必要参数
			$id = $this->input->get_post('id')? $this->input->get_post('id'): NULL;
			if ( empty($id) ):
				$this->basic->error(404, '网址不完整');
				exit;
			endif;

			// 页面信息
			$data = array(
				'title' => '确认收货',
				'class' => $this->class_name.' '. $this->class_name.'-finish',
			);

			// 从API服务器获取相应数据
			$url = api_url($this->class_name. '/detail');
			$params = array(
				'user_id' => $this->session->user_id,
				'id' => $id,
			);
			$result = $this->curl->go($url, $params, 'array');
			$data['order'] = $result['content'];

			// 待验证的表单项
			$this->form_validation->set_rules('id', '订单ID', 'trim|required|is_natural_no_zero');

			// 验证表单值格式
			if ($this->form_validation->run() === FALSE):
				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/finish', $data);
				$this->load->view('templates/footer', $data);

			else:
				// 创建积分流水
				$data_to_create = array(
					'user_id' => $this->session->user_id,
					'order_id' => $id,
					'type' => 'income',
					'amount' => round($data['order']),
				);
				// 创建后返回积分流水ID
				$credit_id = $this->basic_model->create($data_to_create, TRUE);

				// 修改订单信息
				$data_to_edit['time_finish'] = date('Y-m-d H:i:s');
				if ( !empty($credit_id) ) $data_to_edit['credit_id'] = $credit_id;
				$result = $this->basic_model->edit($id, $data_to_edit);
				if ($result !== FALSE):
					$data['content'] = '<p class="alert alert-success">保存成功。</p>';
				else:
					$data['content'] = '<p class="alert alert-warning">保存失败。</p>';
				endif;

				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/result', $data);
				$this->load->view('templates/footer', $data);

			endif;
		}

		/**
		 * 删除
		 *
		 * 一般用于存为草稿、上架、下架、删除、恢复等状态变化，请根据需要修改方法名，例如delete、restore、draft等
		 */
		public function delete()
		{
			($this->session->logged_in === TRUE) OR redirect( base_url('login') );
			
			$op_name = '删除'; // 操作的名称
			$op_view = 'delete'; // 视图文件名

			// 页面信息
			$data = array(
				'title' => $op_name. $this->class_name_cn,
				'class' => $this->class_name.' '. $this->class_name.'-'. $op_view,
			);
			// 将需要显示的数据传到视图以备使用
			$data['data_to_display'] = $this->data_to_display;

			// 待验证的表单项
			$this->form_validation->set_rules('password', '密码', 'trim|required|is_natural|exact_length[6]');

			// 需要存入数据库的信息
			$data_to_edit = array(
				'time_delete' => date('y-m-d H:i:s'), // 批量删除
			);

			// Go Basic!
			$this->basic->bulk($data, $data_to_edit, $op_name, $op_view);
		}

		// 修改订单状态（比如付款后接收通知等）
		public function status()
		{
			// 验证token
			$token = $this->input->post('token');
			if ($token !== TOKEN_PAY):
				exit('TOKEN未传入或不正确');
			endif;

			$order_id = $this->input->post('order_id');
			$payment_type = $this->input->post('payment_type')? $this->input->post('payment_type'): NULL; // 付款方式
			$payment_account = $this->input->post('payment_account')? $this->input->post('payment_account'): NULL; // 付款账号
			$payment_id = $this->input->post('payment_id')? $this->input->post('payment_id'): NULL; // 支付流水号
			$total = $this->input->post('total')? $this->input->post('total'): NULL; // 实际支付金额
			$data_to_edit = array(
				'payment_type' => $payment_type,
				'payment_account' => $payment_account,
				'payment_id' => $payment_id,
				'total' => $total,
			);

			// 检查是否已处理过当前订单
			$result = $this->basic_model->match($data_to_edit);
			if ( ! empty($result) ):
				// 若当前订单已经处理过，则终止订单状态更改（及后续的短信通知）
				$output['status'] = 400;
				$output['content'] = 'success';

			else:
				// 添加支付通知完成时间
				$data_to_edit['time_pay'] = date('Y-m-d H:i:s');

				// 更新订单数据
				$result = $this->basic_model->edit($order_id, $data_to_edit);
				if ($result !== FALSE):
					$output['status'] = 200;
					$output['content'] = 'success';
				else:
					$output['status'] = 400;
					$output['content'] = 'fail';
				endif;
				
				// 发送短信通知
				@$this->send_sms($order_id);
			endif;

			header("Content-type:application/json;charset=utf-8");
			$output_json = json_encode($output);
			echo $output_json;
		}
		
		// 发送短信通知
		public function send_sms($order_id)
		{
			// 获取订单信息
			$url = api_url($this->class_name. '/detail');
			$params['id'] = $order_id;
			$order = $this->curl->go($url, $params, 'array');
			$payment_type = $order['content']['payment_type'];
			$user_id = $order['content']['user_id'];
			$biz_id = $order['content']['biz_id'];

			// 获取商家信息
			$url = api_url('biz/detail');
			$params['id'] = $biz_id;
			$biz = $this->curl->go($url, $params, 'array');
			$biz_mobile = $biz['content']['tel_protected_order'];

			// 获取用户信息
			$url = api_url('user/detail');
			$params['id'] = $user_id;
			$user = $this->curl->go($url, $params, 'array');
			$user_mobile = $user['content']['mobile'];

			// 清空无关请求参数
			$params = NULL;

			// 发送短信到用户
			$message_to_user = '您的商品订单（编号%s）已成功付款，我们将尽快为您处理，敬请期待！';
			$params['content'] = sprintf($message_to_user, $order_id);
			$params['mobile'] = $user_mobile;
			$url = api_url('sms/send');
			$this->curl->go($url, $params, 'array');

			// 发送短信到管理员
			$message_to_manager = '用户（编号%s）的商品订单（编号%s）已成功通过%s完成付款，请尽快处理！';
			$params['content'] = sprintf($message_to_manager, $user_id, $order_id, $payment_type);
			$params['mobile'] = $biz_mobile;
			$url = api_url('sms/send');
			$this->curl->go($url, $params, 'array');
		}
	}

/* End of file Order.php */
/* Location: ./application/controllers/Order.php */
