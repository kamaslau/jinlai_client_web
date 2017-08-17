<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Cart 类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Cart extends MY_Controller
	{
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

			// 设置并调用Basic核心库
			$basic_configs = array(
				'table_name' => $this->table_name,
				'id_name' => $this->id_name,
				'view_root' => $this->view_root,
			);

			// 载入Basic库
			$this->load->library('basic', $basic_configs);
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
				'title' => $this->class_name_cn,
				'class' => $this->class_name.' '. $this->class_name.'-index',
			);
			
			// 初始化商家及购物车项数组
			$data['bizs'] = $data['items'] = array();

			// 检查购物车是否为空，若空则直接返回相应提示，否则显示购物车详情
			if ( !empty($this->session->cart) ):
				// 拆分现购物车数组中各项，并获取商品信息
				$current_cart = $this->explode_it($this->session->cart);

				// 获取各商品信息
				foreach ($current_cart as $cart_item):
					// 分解出item_id、sku_id、count等
					list($biz_id, $item_id, $sku_id, $count) = explode('|', $cart_item);

					// 获取商家信息
					$data['bizs']['biz_'.$biz_id] = $this->get_biz($biz_id);

					// 获取商品信息
					$item = $this->get_item($item_id);

					// 获取SKU信息（若有）
					if ($sku_id != 0) $item['sku'] = $this->get_sku($sku_id);

					$item['count'] = $count; // 数量保持原状
					$data['items'][] = $item; // 推入商品信息数组
				endforeach;

			endif;

			$this->load->view('templates/header', $data);
			$this->load->view($this->class_name. '/index', $data);
			$this->load->view('templates/footer', $data);
		} // end index

		/**
		 * TODO 放入购物车
		 *
		 * 将商品ID和数量成对写入session->cart，或加量
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

			// 检查购物车是否为空，若空则直接添加当前商品，否则进行修改操作
			if ( isset($this->session->cart) === FALSE ):
				$this->session->cart = $item_to_add;

			else:
				// 拆分session->cart，检查是否有当前商品ID，若无则追加，若有则修改份数；
				$current_cart = $this->session->cart;

				if ( strpos($current_cart, $item_to_check) === FALSE ):
					$this->session->cart = $current_cart. $item_to_add;

				else:
					// 拆分现购物车数组中各项，并将需要加量的单品加量
					$current_cart = $this->explode_it($this->session->cart);

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

					$this->session->cart = implode(' ', $new_cart);
				endif;
				
			endif;

			redirect( base_url('cart') );
		} // end add
		
		/**
		 * TODO 移出购物车
		 *
		 * 将商品ID和数量成对移出session->cart，或减量
		 */
		public function remove()
		{
			// 获取待加入购物车的biz_id、item_id、sku_id
			$biz_id = $this->input->get_post('biz_id')? $this->input->get_post('biz_id'): NULL;
			$item_id = $this->input->get_post('item_id')? $this->input->get_post('item_id'): NULL;
			$sku_id = $this->input->get_post('sku_id')? $this->input->get_post('sku_id'): '0';

			// 需要减量的购物车项
			$item_to_check = $biz_id.'|'.$item_id.'|'.$sku_id.'|';

			//拆分session->cart，检查是否有当前商品ID，若无则追加，若有则修改份数；
			$current_cart = $this->session->cart;

			// 检查购物车是否为空，或购物车中是否有此商品；进行相应提示
			if ( (isset($current_cart) === FALSE) OR (strpos($current_cart, $item_to_check) === FALSE) ):
				$data = array(
					'title' => '移出'.$this->class_name_cn,
					'class' => $this->class_name.' '. $this->class_name.'-remove',
				);
				$data['content'] = '<p>购物车中无此商品，请确认。</p>';

				$this->load->view('templates/header', $data);
				$this->load->view($this->class_name. '/index', $data);
				$this->load->view('templates/footer', $data);

			else:
				// 拆分现购物车数组中各项，并将需要减量的单品减量
				$current_cart = $this->explode_it($this->session->cart);

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

				$this->session->cart = implode(',', $new_cart);
				
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
			redirect('cart');
		} // end clear

		// 拆分文本为数组
		private function explode_it($text, $seperator = ',')
		{
			// 清理可能存在的冗余分隔符及空字符
			$text = trim($text);
			$text = trim($text, $seperator);

			// 拆分文本为数组并清理可被转换为布尔型FALSE的数组元素（空数组、空字符、NULL、0、’0‘等）
			$array = array_filter( explode(',', $text) );

			return $array;
		} // end explode_it

	} // end class Cart

/* End of file Cart.php */
/* Location: ./application/controllers/Cart.php */