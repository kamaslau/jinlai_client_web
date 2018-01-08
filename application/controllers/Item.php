<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Item 商品类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Item extends MY_Controller
	{	
		/**
		 * 可作为列表筛选条件的字段名；可在具体方法中根据需要删除不需要的字段并转换为字符串进行应用，下同
		 */
		protected $names_to_sort = array(
			'category_id', 'brand_id', 'biz_id', 'category_biz_id', 'tag_price', 'price', 'unit_name', 'weight_net', 'weight_gross', 'weight_volume', 'stocks', 'quantity_max', 'quantity_min', 'coupon_allowed', 'discount_credit', 'commission_rate', 'time_to_publish', 'time_to_suspend', 'promotion_id', 'status',
			'time_create', 'time_delete', 'time_publish', 'time_suspend', 'time_edit', 'creator_id', 'operator_id',
		);

		public function __construct()
		{
			parent::__construct();

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '商品'; // 改这里……
			$this->table_name = 'item'; // 和这里……
			$this->id_name = 'item_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 视图文件所在目录
			$this->media_root = MEDIA_URL. $this->class_name.'/'; // 媒体文件所在目录
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
			$condition['time_delete'] = 'NULL';
			// （可选）遍历筛选条件
			foreach ($this->names_to_sort as $sorter):
				if ( !empty($this->input->post($sorter)) )
					$condition[$sorter] = $this->input->post($sorter);
			endforeach;

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
			else:
				redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页
			endif;

			// 从API服务器获取相应详情信息
			$url = api_url($this->class_name. '/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['item'] = $result['content'];
				$data['item_in_json'] = json_encode($result['content']);

				// TODO 检查是否已在购物车内
				$item_to_check = $data['item']['biz_id'].'|'.$data['item']['item_id'].'|';
				$data['in_cart'] = $this->in_cart($item_to_check);

				// 判断商品是否在售、是否可加入购物车、是否可立即下单
				if ( empty($item['time_publish']) ):
					$is_valid = FALSE;

				else:
					$url_param .= '&item_id='.$item['item_id'];

					// 判断库存是否充足
					if ( $item['stocks'] < $item['count'] ):
						$is_enough = FALSE;
					endif;

					// 判断是否可减量
					if ( $item['quantity_min'] >= $item['count'] ):
						$can_reduce = FALSE;
					endif;

					// 判断是否可加量
					if ( $item['stocks'] == $item['count'] || $item['quantity_max'] <= $item['count']):
						$can_add = FALSE;
					endif;
				endif;

				// 获取规格信息
				$data['skus'] = $this->list_sku($data['item']['item_id']);

				// 获取系统分类信息
				$data['category'] = $this->get_category($data['item']['category_id']);
				
				// 获取商家信息
				$data['biz'] = $this->get_biz($data['item']['biz_id']);

				// 获取商家分类信息
				if ( !empty($data['item']['category_biz_id']) ):
					$data['category_biz'] = $this->get_category_biz($data['item']['category_biz_id']);
				endif;

				//TODO 获取品牌信息
				//if ( !empty($data['brand']) ):
				//	$data['brand'] = $this->get_brand('');
				//endif;

				// 若参与店内活动，获取店内活动详情
				if ( !empty($data['item']['promotion_id']) ):
					$data['promotion'] = $this->get_promotion_biz($data['item']['promotion_id']);
				endif;

				// 运费计算
				if ( !empty($data['item']['freight_template_id']) ):
					// 获取商家运费模板详情
					$data['freight_template'] = $this->get_freight_template_biz($data['item']['freight_template_id']);
				endif;

			else:
				$data['error'] = $result['content']['error']['message'];

			endif;

			// 页面信息
			$data['title'] = isset($data['item'])? $data['item']['name']: $this->class_name_cn. '详情';
			$data['class'] = $this->class_name.' detail';
			$data['description'] = isset($data['item']['slogan'])? $data['item']['slogan']: SITE_NAME;

			// 输出视图
			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/detail', $data);
			$this->load->view('templates/footer', $data);
		} // end detail

	} // end class Item

/* End of file Item.php */
/* Location: ./application/controllers/Item.php */
