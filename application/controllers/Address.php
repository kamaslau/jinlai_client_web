<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Address 地址类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Address extends MY_Controller
	{
		/**
		 * 可作为列表筛选条件的字段名；可在具体方法中根据需要删除不需要的字段并转换为字符串进行应用，下同
		 */
		protected $names_to_sort = array(
			'address_id', 'user_id', 'brief', 'fullname', 'mobile', 'nation', 'province', 'city', 'county', 'street', 'longitude', 'latitude', 'zipcode', 'time_create', 'time_delete', 'time_edit', 'creator_id', 'operator_id',
		);

		/**
		 * 可被编辑的字段名
		 */
		protected $names_edit_allowed = array(
			'brief', 'fullname', 'mobile', 'nation', 'province', 'city', 'county', 'street', 'longitude', 'latitude', 'zipcode',
		);

		/**
		 * 完整编辑单行时必要的字段名
		 */
		protected $names_edit_required = array(
			'user_id', 'id',
			'fullname', 'mobile', 'province', 'city', 'street',
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
			$this->class_name_cn = '地址'; // 改这里……
			$this->table_name = 'address'; // 和这里……
			$this->id_name = 'address_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name;
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
				'title' => $this->class_name_cn. '列表',
				'class' => $this->class_name.' index',
			);

			// 筛选条件
			$condition['time_delete'] = 'NULL';
			$condition['user_id'] = $this->session->user_id; // 仅可获取本人的数据

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
			
			// 检查是否传入了回调跳转URL
			if ( !empty($this->input->get_post('return_to')) ):
				$data['return_to'] = $this->input->get_post('return_to');
			endif;

			// 待验证的表单项
			$this->form_validation->set_error_delimiters('', '；');
			// 验证规则 https://www.codeigniter.com/user_guide/libraries/form_validation.html#rule-reference
			$this->form_validation->set_rules('brief', '简称', 'trim|max_length[10]');
			$this->form_validation->set_rules('fullname', '姓名', 'trim|required|max_length[15]');
			$this->form_validation->set_rules('mobile', '手机号', 'trim|required|exact_length[11]|is_natural');
			$this->form_validation->set_rules('nation', '国别', 'trim');
			$this->form_validation->set_rules('province', '省', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('city', '市', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('county', '区/县', 'trim|max_length[10]');
			$this->form_validation->set_rules('street', '具体地址；小区名、路名、门牌号等', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('longitude', '经度', 'trim|min_length[7]|max_length[10]|decimal');
			$this->form_validation->set_rules('latitude', '纬度', 'trim|min_length[7]|max_length[10]|decimal');
			$this->form_validation->set_rules('zipcode', '邮政编码', 'trim|integer|max_length[6]');

			// 若表单提交不成功
			if ($this->form_validation->run() === FALSE):
				$data['error'] = validation_errors();

				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/create', $data);
				$this->load->view('templates/footer', $data);

			else:
				// 需要创建的数据；逐一赋值需特别处理的字段
				$data_to_create = array(
					'user_id' => $this->session->user_id,
				);
				// 自动生成无需特别处理的数据
				$data_need_no_prepare = array(
					'brief', 'fullname', 'mobile', 'province', 'city', 'county', 'street', 'longitude', 'latitude', 'zipcode',
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
					
					// 检查是否需要更新本地默认地址
					if ( isset($result['content']['address_id']) )
						$this->session->address_id = $result['content']['address_id'];

					// 检查是否已指定回调跳转URL
					if ( !empty($this->input->post('return_to')) ):
						redirect( $this->input->post('return_to') );
						
					else:
						$this->load->view('templates/header', $data);
						$this->load->view($this->view_root.'/result', $data);
						$this->load->view('templates/footer', $data);

					endif;

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
				$params['user_id'] = $this->session->user_id; // 仅可修改本人的数据
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
			$this->form_validation->set_rules('brief', '简称', 'trim|max_length[10]');
			$this->form_validation->set_rules('fullname', '姓名', 'trim|required|max_length[15]');
			$this->form_validation->set_rules('mobile', '手机号', 'trim|required|exact_length[11]|is_natural');
			$this->form_validation->set_rules('nation', '国别', 'trim');
			$this->form_validation->set_rules('province', '省', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('city', '市', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('county', '区/县', 'trim|max_length[10]');
			$this->form_validation->set_rules('street', '具体地址；小区名、路名、门牌号等', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('longitude', '经度', 'trim|min_length[7]|max_length[10]|decimal');
			$this->form_validation->set_rules('latitude', '纬度', 'trim|min_length[7]|max_length[10]|decimal');
			$this->form_validation->set_rules('zipcode', '邮政编码', 'trim|integer|max_length[6]');

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
					'brief', 'fullname', 'mobile', 'province', 'city', 'county', 'street', 'longitude', 'latitude', 'zipcode',
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

					// 检查是否需要更新本地默认地址
					if ( isset($result['content']['address_id']) )
						$this->session->address_id = $result['content']['address_id'];

					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/result', $data);
					$this->load->view('templates/footer', $data);

				else:
					// 若创建失败，则进行提示
					$data['error'] = $result['content']['error']['message'];

					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/edit', $data);
					$this->load->view('templates/footer', $data);

				endif;

			endif;
		} // end edit

		/**
		 * 删除单行或多行项目
		 *
		 * 一般用于发货、退款、存为草稿、上架、下架、删除、恢复等状态变化，请根据需要修改方法名，例如deliver、refund、delete、restore、draft等
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
				// 不可删除默认地址
				if ($id == $this->session->address_id):
					$data['title'] = $this->class_name_cn.$op_name. '失败';
					$data['class'] = 'fail';
					$data['content'] = '不可删除默认地址';

					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/result', $data);
					$this->load->view('templates/footer', $data);
					exit();

				else:
					// 从API服务器获取相应详情信息
					$params['id'] = $id;
					$params['user_id'] = $this->session->user_id; // 仅可修改本人的数据
					$url = api_url($this->class_name. '/detail');
					$result = $this->curl->go($url, $params, 'array');
					if ($result['status'] === 200):
						$data['items'][] = $result['content'];
					else:
						$data['error'] .= 'ID'.$id.'项不可操作，“'.$result['content']['error']['message'].'”';
					endif;
				endif;
			endforeach;

			// 将需要显示的数据传到视图以备使用
			$data['data_to_display'] = $this->data_to_display;

			// 待验证的表单项
			$this->form_validation->set_error_delimiters('', '；');
			$this->form_validation->set_rules('ids', '待操作数据ID们', 'trim|required|regex_match[/^(\d|\d,?)+$/]'); // 仅允许非零整数和半角逗号

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

		// 设置特定地址为特定用户的默认地址
		public function default_this()
		{
			// 检查必要参数是否已传入
			$required_params = array('id');
			foreach ($required_params as $param):
				${$param} = $this->input->post_get($param);
				if ( empty( ${$param} ) ):
					$this->result['status'] = 400;
					$this->result['content']['error']['message'] = '必要的请求参数未全部传入';
					exit();
				endif;
			endforeach;

			// 页面信息
			$data = array(
				'title' => '修改默认'.$this->class_name_cn,
				'class' => $this->class_name.' default-this',
				'error' => '',
			);

			// 需要编辑的数据
			$data_to_edit = array(
				'user_id' => $this->session->user_id,
				'id' => $this->session->user_id,
				'name' => 'address_id',
				'value' => $id,
			);

			// 向API服务器发送待修改数据
			$params = $data_to_edit;
			$url = api_url('user/edit_certain');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['title'] = $this->class_name_cn. '修改成功';
				$data['class'] = 'success';
				$data['content'] = $result['content']['message'];
				$data['operation'] = 'edit_certain';
				$data['id'] = $id;

				// 更新本地session默认地址ID
				$this->session->address_id = $id;

			else:
				// 若修改失败，则进行提示
				$data['error'] .= $result['content']['error']['message'];

			endif;
			
			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/result', $data);
			$this->load->view('templates/footer', $data);

		} // end default_this

	} // end class Address

/* End of file Address.php */
/* Location: ./application/controllers/Address.php */
