<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Member_biz 商家会员类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Member_biz extends MY_Controller
	{	
		/**
		 * 可作为列表筛选条件的字段名；可在具体方法中根据需要删除不需要的字段并转换为字符串进行应用，下同
		 */
        protected $names_to_sort = array(
            'user_id', 'biz_id', 'mobile', 'level', 'time_create', 'time_delete', 'time_edit', 'creator_id', 'operator_id',
        );

		/**
		 * 可被编辑的字段名
		 */
        protected $names_edit_allowed = array(
            'mobile', 'level',
        );

		/**
		 * 完整编辑单行时必要的字段名
		 */
        protected $names_edit_required = array(
            'mobile', 'level',
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
            //($this->session->time_expire_login > time()) OR redirect( base_url('login') );

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '会员卡'; // 改这里……
			$this->table_name = 'member_biz'; // 和这里……
			$this->id_name = 'member_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 视图文件所在目录
			$this->media_root = MEDIA_URL. $this->class_name.'/'; // 媒体文件所在目录
		}

        /**
         * 列表页
         */
        public function mine()
        {
            // 页面信息
            $data = array(
                'title' => '我的'. $this->class_name_cn,
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

            // 从API服务器获取商家列表信息（及装修信息）
            $params = $condition;
            $url = api_url($this->class_name.'/index');
            $result = $this->curl->go($url, $params, 'array');
            if ($result['status'] === 200):
                $data['items'] = $result['content'];
            else:
                // $data['error'] = $result['content']['error']['message'];
                redirect( base_url($this->class_name) ); // 若未领取任何会员卡，转到会员卡列表页
            endif;

            // 输出视图
            $this->load->view('templates/header', $data);
            $this->load->view($this->view_root.'/mine', $data);
            $this->load->view('templates/footer', $data);
        } // end index

		/**
		 * 列表页
		 */
		public function index()
		{
			// 页面信息
			$data = array(
				'title' => '所有'. $this->class_name_cn,
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
			
			// 从API服务器获取商家列表信息（及装修信息）
			$params = $condition;
			$url = api_url('biz/index');
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
			$id = $this->input->get_post('biz_id')? $this->input->get_post('biz_id'): NULL;
			if ( !empty($id) ):
				$params['id'] = $id;
			else:
				redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页
			endif;

			// 获取商家详情信息
			$url = api_url('biz/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['item'] = $result['content'];
			else:
                // 若商家不存在，转回列表页
				redirect(base_url($this->class_name));
			endif;

            // 获取当前用户相应商家会员卡信息
            $params = array(
                'biz_id' => $id,
            );
            $url = api_url($this->class_name.'/detail');
            $result = $this->curl->go($url, $params, 'array');
            if ($result['status'] === 200):
                $data['member_biz'] = $result['content'];
            endif;

			// 若已是会员，显示会员卡详情，否则显示加入会员页面
			$view_name = ( isset($data['member_biz']) )? 'detail': 'create';

            // 页面信息
            $data['title'] = isset($data['member_biz'])? $data['item']['brief_name'].$this->class_name_cn: '领取'.$data['item']['brief_name'].$this->class_name_cn;
            $data['class'] = $this->class_name.' '.$view_name;

            // 输出视图
            $this->load->view('templates/header', $data);
            $this->load->view($this->view_root.'/'.$view_name, $data);
			$this->load->view('templates/footer', $data);
		} // end detail

        /**
         * 创建
         */
        public function create()
        {
            // 检查是否已传入必要参数
            $biz_id = $this->input->get_post('biz_id')? $this->input->get_post('biz_id'): NULL;
            if ( !empty($biz_id) ):
                $params['id'] = $biz_id;
            else:
                redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页
            endif;

            // 页面信息
            $data = array(
                'title' => '领取'.$this->class_name_cn,
                'class' => $this->class_name.' create',
                'error' => '', // 预设错误提示
            );

            // 获取商家详情信息
            $url = api_url('biz/detail');
            $result = $this->curl->go($url, $params, 'array');
            if ($result['status'] === 200):
                $data['item'] = $result['content'];
            else:
                // 若商家不存在，转回列表页
                redirect(base_url($this->class_name));
            endif;

            // 待验证的表单项
            $this->form_validation->set_error_delimiters('', '；');
            $this->form_validation->set_rules('mobile', '登记手机号', 'trim|required|exact_length[11]|is_natural_no_zero');

            // 若表单提交不成功
            if ($this->form_validation->run() === FALSE):
                $data['error'] = trim(validation_errors(), '；');

                $this->load->view('templates/header', $data);
                $this->load->view($this->view_root.'/create', $data);
                $this->load->view('templates/footer', $data);

            else:
                // 需要创建的数据；逐一赋值需特别处理的字段
                $data_to_create = array(
                    //'user_id' => $this->session->user_id,
                    'user_id' => 1,
                    'biz_id' => $biz_id,
                );
                // 自动生成无需特别处理的数据
                $data_need_no_prepare = array(
                    'mobile',
                );
                foreach ($data_need_no_prepare as $name)
                    $data_to_create[$name] = $this->input->post($name);

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

                    // 转到商家会员卡详情页
                    redirect(base_url('member_biz/detail?biz_id='.$biz_id));

                else:
                    // 若创建失败，则进行提示
                    $data['error'] = $result['content']['error']['message'];

                    $this->load->view('templates/header', $data);
                    $this->load->view($this->view_root.'/create', $data);
                    $this->load->view('templates/footer', $data);

                endif;

            endif;
        } // end create

	} // end class Member_biz

/* End of file Member_biz.php */
/* Location: ./application/controllers/Member_biz.php */
