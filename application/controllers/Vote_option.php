<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Vote_option 投票候选项类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Vote_option extends MY_Controller
	{	
		/**
		 * 可作为列表筛选条件的字段名；可在具体方法中根据需要删除不需要的字段并转换为字符串进行应用，下同
		 */
		protected $names_to_sort = array(
			'vote_id', 'name', 'description', 'url_image', 'time_create', 'time_delete', 'time_edit', 'creator_id', 'operator_id', 'status', 'time_create_min', 'time_create_max',
		);

		/**
		 * 可被编辑的字段名
		 */
		protected $names_edit_allowed = array(
			'name', 'description', 'url_image',
		);

		/**
		 * 完整编辑单行时必要的字段名
		 */
		protected $names_edit_required = array(
			'id',
			'name',
		);

		public function __construct()
		{
			parent::__construct();

            // 微信登录授权URL
            $current_url = 'https://'. $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
            $target_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.WECHAT_APP_ID.'&redirect_uri='.urlencode($current_url).'&response_type=code&scope=snsapi_userinfo#wechat_redirect';

            // 登录已已超时，或未获取微信用户资料的用户转到微信授权页
            (
                ($this->session->time_expire_login > time() && !empty($this->session->sns_info))
                || !empty($this->input->get('code'))
            ) OR redirect($target_url);

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '投票候选项'; // 改这里……
			$this->table_name = 'vote_option'; // 和这里……
			$this->id_name = 'option_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 视图文件所在目录
			$this->media_root = MEDIA_URL. $this->class_name.'/'; // 媒体文件所在目录

			// 设置需要自动在视图文件中生成显示的字段
			$this->data_to_display = array(
				'name' => '名称',
				'description' => '描述',
			);
		} // end __construct

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
				if ( !empty($this->input->get_post($sorter)) )
					$condition[$sorter] = $this->input->get_post($sorter);
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
				$data['items'] = array();
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
                $data['title'] = $this->class_name_cn. '"'. $data['item']['name']. '"';
                $data['class'] = $this->class_name.' detail';

                // 获取投票信息
                $data['vote'] = $this->get_vote($data['item']['vote_id']);

			else:
                redirect( base_url('error/code_404') ); // 若缺少参数，转到错误提示页

			endif;

			// 输出视图
			$this->load->view('templates/header-vote', $data);
			$this->load->view($this->view_root.'/detail', $data);
			$this->load->view('templates/footer-vote', $data);
		} // end detail

		/**
		 * 创建
		 */
		public function create()
		{
			// 操作可能需要检查操作权限
			// $role_allowed = array('管理员', '经理'); // 角色要求
            // $min_level = 30; // 级别要求
            // $this->basic->permission_check($role_allowed, $min_level);

            // 检查是否已传入必要参数
            $vote_id = $this->input->get_post('vote_id')? $this->input->get_post('vote_id'): NULL;
            if ( empty($vote_id) )
                redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页

			// 页面信息
			$data = array(
				'title' => '创建'.$this->class_name_cn,
				'class' => $this->class_name.' create',
				'error' => '', // 预设错误提示
			);

			// 待验证的表单项
			$this->form_validation->set_error_delimiters('', '；');
			// 验证规则 https://www.codeigniter.com/user_guide/libraries/form_validation.html#rule-reference
			$this->form_validation->set_rules('name', '名称', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('description', '描述', 'trim|max_length[100]');
			$this->form_validation->set_rules('url_image', '形象图URL', 'trim|max_length[255]');

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
                    'vote_id' => $vote_id,
				);
				// 自动生成无需特别处理的数据
				$data_need_no_prepare = array(
					'name', 'description', 'url_image',
				);
				foreach ($data_need_no_prepare as $name)
					$data_to_create[$name] = $this->input->post_get($name);

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

				else:
					// 若创建失败，则进行提示
					$data['error'] = $result['content']['error']['message'];

				endif;

				// 转到投票详情页
				redirect(base_url('vote/detail?id='.$vote_id));
				
			endif;
		} // end create
		
		/**
         * 删除
         *
         * 商家不可删除
         */
        public function delete()
        {
            exit('不可删除'.$this->class_name_cn);
        } // end delete

        /**
         * 找回
         *
         * 商家不可找回
         */
        public function restore()
        {
            exit('不可恢复'.$this->class_name_cn);
        } // end restore

	} // end class Vote_option

/* End of file Vote_option.php */
/* Location: ./application/controllers/Vote_option.php */
