<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Fav_biz 商家关注类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Fav_biz extends MY_Controller
	{	
		/**
		 * 可作为列表筛选条件的字段名；可在具体方法中根据需要删除不需要的字段并转换为字符串进行应用，下同
		 */
		protected $names_to_sort = array(
			'user_id', 'biz_id', 'time_create', 'time_delete', 'time_edit', 'creator_id', 'operator_id',
		);

		public function __construct()
		{
			parent::__construct();

			// （可选）未登录用户转到登录页
			($this->session->time_expire_login > time()) OR redirect( base_url('login') );

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '关注商家'; // 改这里……
			$this->table_name = 'fav_biz'; // 和这里……
			$this->id_name = 'record_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 视图文件所在目录
			$this->media_root = MEDIA_URL. 'biz/'; // 媒体文件所在目录
		} // __construct

		/**
		 * 列表页
		 */
		public function index()
		{
			// 页面信息
			$data = array(
				'title' => '我关注的',
				'class' => $this->class_name.' index',
				'error' => '',
			);

			// 若存在类属性data，合并（并覆盖）
			if ( isset($this->data) ):
				$data = array_merge($data, $this->data);
			endif;

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
		 * 创建
		 */
		public function create()
		{
			// 获取待创建项ID
			$id = $this->input->get('id');

			// 待验证的表单项
			$this->form_validation->set_error_delimiters('', '；');
			$data_to_validate['biz_id'] = $id;
			$this->form_validation->set_data($data_to_validate);
            $this->form_validation->set_rules('biz_id', '所属商家ID', 'trim|required|is_natural_no_zero');

			// 需要创建的数据；逐一赋值需特别处理的字段
			$data_to_create = array(
				'biz_id' => $id,
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
					$url = api_url($this->class_name. '/create');
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
					'title' => '新增'.$this->class_name_cn,
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
						$data['title'] = $this->class_name_cn. '关注成功';
						$data['class'] = 'success';
						$data['content'] = $result['content']['message'];
						$data['operation'] = 'create';
						$data['id'] = $result['content']['id']; // 创建后的信息ID

					else:
						// 若创建失败，则进行提示
						$data['content'] = $result['content']['error']['message'];

					endif;

				endif;
				
				// 转到首页
				$this->data = $data;
				$this->index();
			endif;
		} // end create

		/**
		 * 删除单行或多行项目
		 */
		public function delete()
		{
			$op_name = '删除'; // 操作的名称
			$op_view = 'delete'; // 视图文件名
			
			// 待验证的表单项
			$this->form_validation->set_error_delimiters('', '；');
			$data_to_validate['ids'] = $this->input->get('ids');
			$this->form_validation->set_data($data_to_validate);
			$this->form_validation->set_rules('ids', '待操作数据ID们', 'trim|required|regex_match[/^(\d|\d,?)+$/]'); // 仅允许非零整数和半角逗号
			
			// 获取待操作项ID（们）
			$ids = $this->input->get('ids');

			// 需要存入数据库的信息
			$data_to_edit = array(
				'operation' => $op_view, // 操作名称
				'ids' => $ids,
			);

			// 对AJAX请求特别处理
			if ( $this->input->is_ajax_request() ):
				// 若表单提交不成功
				if ($this->form_validation->run() === FALSE):
					$this->result['status'] = 401;
					$this->result['content']['error']['message'] = validation_errors();

				else:
					// 向API服务器发送待创建数据
					$params = $data_to_edit;
					$url = api_url($this->class_name. '/edit_bulk');
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

			else:
				// 页面信息
				$data = array(
					'title' => $op_name. $this->class_name_cn,
					'class' => $this->class_name. ' '. $op_view,
					'error' => '', // 预设错误提示
				);

				// 若表单提交不成功
				if ($this->form_validation->run() === FALSE):
					$data['content'] = validation_errors();

				else:
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

					else:
						// 若创建失败，则进行提示
						$data['content'] = $result['content']['error']['message'];

					endif;

				endif;

				// 转到首页
				$this->data = $data;
				$this->index();

			endif;
		} // end delete

	} // end class Fav_biz

/* End of file Fav_biz.php */
/* Location: ./application/controllers/Fav_biz.php */
