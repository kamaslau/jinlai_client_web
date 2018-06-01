<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Coupon_combo 优惠券包类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Coupon_combo extends MY_Controller
	{
		/**
		 * 可作为列表筛选条件的字段名；可在具体方法中根据需要删除不需要的字段并转换为字符串进行应用，下同
		 */
		protected $names_to_sort = array(
			'biz_id', 'name', 'description', 'template_ids', 'max_amount', 'time_start', 'time_end',
			'time_create', 'time_delete', 'time_edit', 'creator_id', 'operator_id',
		);

		public function __construct()
		{
			parent::__construct();

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '优惠券包'; // 改这里……
			$this->table_name = 'coupon_combo'; // 和这里……
			$this->id_name = 'combo_id'; // 还有这里，OK，这就可以了
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

			// 将需要显示的数据传到视图以备使用
			$data['data_to_display'] = $this->data_to_display;

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
                $data['title'] = isset($data['item'])? $data['item']['name']: $this->class_name_cn. '详情';
                $data['class'] = $this->class_name.' detail';

			else:
                redirect( base_url('error/code_404') ); // 若缺少参数，转到错误提示页

			endif;
		} // end detail

		/**
		 * 创建
		 *
		 * 即领取优惠券包中所有优惠券
		 */
		public function create()
		{
			// 获取待创建项ID
			$id = $this->input->get('id');

			// 待验证的表单项
			$this->form_validation->set_error_delimiters('', '；');
			$data_to_validate['combo_id'] = $id;
			$this->form_validation->set_data($data_to_validate);
			$this->form_validation->set_rules('combo_id', '优惠券包ID', 'trim|required');

			// 需要创建的数据；逐一赋值需特别处理的字段
			$data_to_create = array(
				'combo_id' => $id,
			);

			// 对AJAX请求特别处理
			if ( $this->input->is_ajax_request() ):
				// 若表单提交不成功
				if ($this->form_validation->run() === FALSE):
					$this->result['status'] = 401;
					$this->result['content']['error']['message'] = validation_errors();

				else:
					// 向API服务器发送待创建数据
					$params = $data_to_create;
					$url = api_url('coupon/create');
					$result = $this->curl->go($url, $params, 'array');
					if ( !empty($result) ):
						$this->result = $result;

					else:
						$this->result['status'] = 400;
						$this->result['content']['error']['message'] = '操作失败：网络问题';

					endif;

				endif;
			
				// 返回JSON
				$this->output_json();

			// 非AJAX请求
			else:
				// 页面信息
				$data = array(
					'title' => '领取'.$this->class_name_cn,
					'class' => $this->class_name.' create',
					'error' => '', // 预设错误提示
				);

				// 若表单提交不成功
				if ($this->form_validation->run() === FALSE):
					$data['content'] = validation_errors();

				else:
					// 向API服务器发送待创建数据
					$params = $data_to_create;
					$url = api_url($this->class_name. '/create');
					$result = $this->curl->go($url, $params, 'array');
					if ($result['status'] === 200):
						$data['title'] = $this->class_name_cn. '领取成功';
						$data['class'] = 'success';
						$data['content'] = $result['content']['message'];
						$data['operation'] = 'create';
						$data['id'] = $result['content']['id']; // 创建后的信息ID

					else:
						// 若创建失败，则进行提示
						$data['content'] = $result['content']['error']['message'];

					endif;

				endif;

				// 转到优惠券领取结果
				$this->load->view('templates/header', $data);
				$this->load->view('coupon/result', $data);
				$this->load->view('templates/footer', $data);
			endif;
		} // end create

	} // end class Coupon_combo

/* End of file Coupon_combo.php */
/* Location: ./application/controllers/Coupon_combo.php */
