<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Comment_item 商品评价
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Comment_item extends MY_Controller
	{
		/**
		 * 可作为列表筛选条件的字段名；可在具体方法中根据需要删除不需要的字段并转换为字符串进行应用，下同
		 */
		protected $names_to_sort = array(
			'biz_id', 'category_id', 'category_biz_id', 'item_id', 'name', 'description', 'max_amount', 'max_amount_user', 'min_subtotal', 'amount', 'period', 'time_start', 'time_end', 
			'time_create', 'time_delete', 'time_edit', 'creator_id', 'operator_id',
		);

		public function __construct()
		{
			parent::__construct();

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '商品评价'; // 改这里……
			$this->table_name = 'comment_item'; // 和这里……
			$this->id_name = 'comment_id'; // 还有这里，OK，这就可以了
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

			// 排序条件
			$order_by = NULL;

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

				// 获取系统商品分类信息
				if ( !empty($data['item']['category_id']) ):
					$data['category'] = $this->get_category($data['item']['category_id']);
				endif;
				
				// 获取商家商品分类信息
				if ( !empty($data['item']['category_biz_id']) ):
					$data['category_biz'] = $this->get_category_biz($data['item']['category_biz_id']);
				endif;

                // 页面信息
                $data['title'] = isset($data['item'])? $data['item']['name']: $this->class_name_cn. '详情';
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
		 * 创建
		 *
		 * 即领取单张商品评价
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
            $this->form_validation->set_rules('biz_id', '相关商家ID', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('order_id', '所属订单ID', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('item_id', '相关商品ID', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('score', '描述相符', 'trim|is_natural_no_zero|greater_than[0]|less_than[6]');
            $this->form_validation->set_rules('content', '评价内容', 'trim|max_length[255]');
            $this->form_validation->set_rules('image_urls', '图片URL们', 'trim|max_length[255]');

            // 若表单提交不成功
            if ($this->form_validation->run() === FALSE):
                $data['error'] = validation_errors();

                $this->load->view('templates/header', $data);
                $this->load->view($this->view_root.'/create', $data);
                $this->load->view('templates/footer', $data);

            else:
                // 需要创建的数据；逐一赋值需特别处理的字段
                $data_to_create = array();
                // 自动生成无需特别处理的数据
                $data_need_no_prepare = array(
                    'biz_id', 'order_id', 'user_id', 'biz_id', 'item_id', 'score', 'content', 'image_urls',
                );
                foreach ($data_need_no_prepare as $name)
                    $data_to_create[$name] = $this->input->post($name);

                // 向API服务器发送待创建数据
                $params = $data_to_create;
                $url = api_url($this->class_name. '/create');
                $result = $this->curl->go($url, $params, 'array');
                if ($result['status'] === 200):
                    $data['title'] = $this->class_name_cn. '创建成功';
                    $data['class'] = 'success';
                    $data['content'] = $result['content']['message'];
                    $data['operation'] = 'create';
                    $data['id'] = $result['content']['id']; // 创建后的信息ID

                    $this->load->view('templates/header', $data);
                    $this->load->view($this->view_root.'/result', $data);
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

	} // end class Comment_item

/* End of file Comment_item.php */
/* Location: ./application/controllers/Comment_item.php */
