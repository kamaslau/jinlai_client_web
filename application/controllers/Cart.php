<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Cart 购物车类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Cart extends MY_Controller
	{
		// 购物车容量，默认可放入30项
		public $max_count = 30;

		public function __construct()
		{
			parent::__construct();

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '购物车'; // 改这里……
			$this->table_name = 'item'; // 和这里……
			$this->id_name = 'item_id';  // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 视图文件所在目录
			$this->media_root = MEDIA_URL. 'item/'; // 媒体文件所在目录

			// 从API获取当前用户购物车项
			if ($sync_result !== FALSE)
				$this->session->cart = $this->sync_down();
		}

		/**
		 * 截止3.1.3为止，CI_Controller类无析构函数，所以无需继承相应方法
		 */
		public function __destruct()
		{
			// 调试信息输出开关
			//$this->output->enable_profiler(TRUE);
		}

		/**
		 * 列表页
		 */
		public function index()
		{
			// 页面信息
			$data = array(
				'title' => $this->class_name_cn,
				'class' => $this->class_name,
			);

			// 解析购物车
			$data['cart_data'] = $this->cart_decode();

			$this->load->view('templates/header', $data);
			$this->load->view($this->class_name. '/index', $data);
			$this->load->view('templates/nav-main', $data);
			$this->load->view('templates/footer', $data);
		} // end index

		/**
		 * 加量
		 *
		 * 增加数量或加入购物车
		 */
		public function add()
		{
			// 获取待加入购物车的biz_id、item_id、sku_id
			$biz_id = $this->input->get_post('biz_id')? $this->input->get_post('biz_id'): NULL;
			$item_id = $this->input->get_post('item_id')? $this->input->get_post('item_id'): NULL;
			$sku_id = $this->input->get_post('sku_id')? $this->input->get_post('sku_id'): '0';

			// 生成待添加的购物车项
			$item_to_add = $biz_id.'|'.$item_id.'|'.$sku_id.'|1'; // 默认添加1个单位的商品
			$item_to_check = $biz_id.'|'.$item_id.'|'.$sku_id.'|';

			// 检查购物车是否为空，若空则直接添加当前商品，否则进行相应操作
			if ( isset($this->session->cart) === FALSE ):
				$this->session->cart = $item_to_add;
				$this->sync_up();

			else:
				// TODO 处理最高、最低限购情景

				// 拆分session->cart，检查是否有当前商品ID，若无则追加，若有则修改份数；
				$current_cart = $this->session->cart;

				if ( strpos($current_cart, $item_to_check) === FALSE ):
					$this->session->cart = trim($current_cart.','.$item_to_add, ',');
					$this->sync_up();

				else:
					// 拆分现购物车数组中各项，并将需要加量的单品加量
					$current_cart = $this->explode_csv($this->session->cart);
					
					// 如果已达到最高容量，中止并提示
					if ( count($current_cart) == $this->max_count ):
						$data = array(
							'title' => '购物车',
							'class' => $this->class_name.' '. $this->class_name.'-add',
						);
						$data['content'] = '购物车已经装满了';

						$this->load->view('templates/header', $data);
						$this->load->view($this->class_name. '/index', $data);
						$this->load->view('templates/footer', $data);

					else:
						// 创建新购物车数组
						$new_cart = array();

						// 获取待加量项
						foreach ($current_cart as $cart_item):
							// 将待加量项加量
							if ( strpos($cart_item, $item_to_check) === FALSE ):
								$new_cart[] = ','.$cart_item; // 不相关项保持原状
							else:
								// 分解出item_id、sku_id、count等
								list($biz_id, $item_id, $sku_id, $count) = explode('|', $cart_item);

								$count ++;
								$new_cart[] = ','.$biz_id.'|'.$item_id.'|'.$sku_id.'|'.$count;
							endif;
						endforeach;

						$this->session->cart = trim(implode(',', $new_cart), ',');
						$this->sync_up();
					endif;
				endif;

			endif;

			// 转到购物车页
			redirect( base_url('cart') );
		} // end add

		/**
		 * 减量
		 *
		 * 减少数量，减少为0后移出购物车
		 */
		public function reduce()
		{
			// 获取待减量购物车的biz_id、item_id、sku_id
			$biz_id = $this->input->get_post('biz_id')? $this->input->get_post('biz_id'): NULL;
			$item_id = $this->input->get_post('item_id')? $this->input->get_post('item_id'): NULL;
			$sku_id = $this->input->get_post('sku_id')? $this->input->get_post('sku_id'): '0';

			// 需要减量的购物车项
			$item_to_check = $biz_id.'|'.$item_id.'|'.$sku_id.'|';

			// 获取购物车数据
			$current_cart = $this->session->cart;

			// 检查购物车是否为空，或购物车中是否有此商品；进行相应提示
			if ( (isset($current_cart) === FALSE) OR (strpos($current_cart, $item_to_check) === FALSE) ):
				$data = array(
					'title' => '购物车',
					'class' => $this->class_name.' '. $this->class_name.'-reduce',
				);
				$data['content'] = '购物车里没有这个商品';

				$this->load->view('templates/header', $data);
				$this->load->view($this->class_name. '/index', $data);
				$this->load->view('templates/footer', $data);

			else:
				// 拆分现购物车数组中各项，并将需要减量的单品减量
				$current_cart = $this->explode_csv($this->session->cart);

				// 创建新购物车数组
				$new_cart = array();

				// 获取待减量项
				foreach ($current_cart as $cart_item):
					// 将待减量项减量
					if ( strpos($cart_item, $item_to_check) === FALSE ):
						$new_cart[] = ','.$cart_item; // 不相关项保持原状
					else:
						// 分解出item_id、sku_id、count等
						list($biz_id, $item_id, $sku_id, $count) = explode('|', $cart_item);

						// 若减量后该商品份数至少为1，则保留在购物车里
						if ($count > 1):
							$count --;
							$new_cart[] = ','.$biz_id.'|'.$item_id.'|'.$sku_id.'|'.$count;
						endif;
					endif;
				endforeach;

				$this->session->cart = trim(implode(',', $new_cart), ',');
				$this->sync_up();
				
				// 转到购物车页
				redirect( base_url('cart') );
			endif;
		} // end reduce

		/**
		 * 移除购物车
		 *
		 * 直接将相应项移除出购物车
		 */
		public function remove()
		{
			// 获取待移出购物车的biz_id、item_id、sku_id
			$biz_id = $this->input->get_post('biz_id')? $this->input->get_post('biz_id'): NULL;
			$item_id = $this->input->get_post('item_id')? $this->input->get_post('item_id'): NULL;
			$sku_id = $this->input->get_post('sku_id')? $this->input->get_post('sku_id'): '0';

			// 需要移除的购物车项
			$item_to_check = $biz_id.'|'.$item_id.'|'.$sku_id.'|';

			// 获取购物车数据
			$current_cart = $this->session->cart;

			// 检查购物车是否为空，或购物车中是否有此商品；进行相应提示
			if ( (isset($current_cart) === FALSE) OR (strpos($current_cart, $item_to_check) === FALSE) ):
				$data = array(
					'title' => '购物车',
					'class' => $this->class_name.' '. $this->class_name.'-remove',
				);
				$data['content'] = '购物车里没有这个商品';

				$this->load->view('templates/header', $data);
				$this->load->view($this->class_name. '/index', $data);
				$this->load->view('templates/footer', $data);

			else:
				// 拆分现购物车数组中各项，并在重新拼合购物车信息时跳过待移除项
				$current_cart = $this->explode_csv($this->session->cart);

				// 创建新购物车数组
				$new_cart = array();

				// 获取待减量项
				foreach ($current_cart as $cart_item):
					// 将待减量项减量
					if ( strpos($cart_item, $item_to_check) === FALSE ):
						$new_cart[] = ','.$cart_item; // 不相关项保持原状
					endif;
				endforeach;

				$this->session->cart = trim(implode(',', $new_cart), ',');
				$this->sync_up();

				// 转到购物车页
				redirect( base_url('cart') );
			endif;
		} // end remove

		/**
		 * 清空购物车
		 */
		public function clear()
		{
			// 页面信息
			$data = array(
				'title' => '清空'. $this->class_name_cn,
				'class' => $this->class_name.' '. $this->class_name.'-clear',
			);

			$this->session->cart = NULL;
			$this->sync_up();

			redirect('cart');
		} // end clear

		// 向数据库上传用户购物车数据
		private function sync_up()
		{
			// 需要编辑的数据
			$params = array(
				'user_id' => $this->session->user_id,
				'id' => $this->session->user_id,
				'name' => 'cart_string',
				'value' => $this->session->cart,
			);

			// 向API服务器发送待创建数据
			$url = api_url($this->class_name.'/edit_certain');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				return TRUE;

			else:
				return FALSE;

			endif;
		} // end sync_up
		
		// 从数据库获取用户购物车数据
		private function sync_down()
		{
			// 需要搜索的数据
			$params = array(
				'id' => $this->session->user_id,
			);

			// 向API服务器发送待创建数据
			$url = api_url($this->class_name.'/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				return $result['content']['cart_string'];

			else:
				return FALSE;

			endif;
		} // end sync_down

	} // end class Cart

/* End of file Cart.php */
/* Location: ./application/controllers/Cart.php */