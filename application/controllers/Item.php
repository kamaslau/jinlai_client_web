<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Item 商品类
	 *
	 * 以我的XX列表、列表、详情、创建、单行编辑、单/多行编辑（删除、恢复）等功能提供了常见功能的APP示例代码
	 * CodeIgniter官方网站 https://www.codeigniter.com/user_guide/
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

			// 未登录用户转到登录页
			//($this->session->time_expire_login > time()) OR redirect( base_url('login') );

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '商品'; // 改这里……
			$this->table_name = 'item'; // 和这里……
			$this->id_name = 'item_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name;
		}

		/**
		 * 截止3.1.3为止，CI_Controller类无析构函数，所以无需继承相应方法
		 */
		public function __destruct()
		{
			// 调试信息输出开关
			// $this->output->enable_profiler(TRUE);
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

				$data['skus'] = $this->list_sku($data['item']['item_id']);

				// 获取系统商品分类信息
				$data['category'] = $this->get_category($data['item']['category_id']);

				// 获取商家商品分类信息
				if ( !empty($data['item']['category_biz_id']) ):
					$data['category_biz'] = $this->get_category_biz($data['item']['category_biz_id']);
				endif;

				// 若参与店内活动，获取店内活动详情
				if ( !empty($data['item']['promotion_id']) ):
					$data['promotion'] = $this->get_promotion_biz($data['item']['promotion_id']);
				endif;

				// 获取商家运费模板详情
				$data['freight_template'] = $this->get_freight_template_biz($data['item']['freight_template_id']);

			else:
				$data['error'] = $result['content']['error']['message'];

			endif;

			// 页面信息
			$data['title'] = isset($data['item'])? $data['item']['name']: $this->class_name_cn. '详情';
			$data['class'] = $this->class_name.' detail';

			// 输出视图
			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/detail', $data);
			$this->load->view('templates/footer', $data);
		} // end detail

	} // end class Item

/* End of file Item.php */
/* Location: ./application/controllers/Item.php */
