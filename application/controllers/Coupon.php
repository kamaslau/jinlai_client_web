<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Coupon 用户优惠券类
	 *
	 * 即优惠券（根据优惠券模板创建的优惠券）
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Coupon extends MY_Controller
	{	
		/**
		 * 可作为列表筛选条件的字段名；可在具体方法中根据需要删除不需要的字段并转换为字符串进行应用，下同
		 */
		protected $names_to_sort = array(
			'category_id', 'biz_id', 'category_biz_id', 'item_id', 'name', 'amount', 'min_subtotal', 'time_start', 'time_end', 'time_expire', 'order_id', 'time_used',
            'time_create', 'time_delete', 'status',
		);

		/**
		 * 编辑多行特定字段时必要的字段名
		 */
		protected $names_edit_bulk_required = array(
			'ids',
		);

		public function __construct()
		{
			parent::__construct();

			// 若未登录，转到密码登录页
			($this->session->time_expire_login > time()) OR redirect( base_url('login') );

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '优惠券'; // 改这里……
			$this->table_name = 'coupon'; // 和这里……
			$this->id_name = 'coupon_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 视图文件所在目录
			$this->media_root = MEDIA_URL. $this->class_name.'/'; // 媒体文件所在目录
		} // __construct

        /**
         * 卡包/我的优惠券
         */
        public function mine()
        {
            // 页面信息
            $data = array(
                'title' => '卡包',
                'class' => $this->class_name.' index',
            );

            // 筛选条件
            $condition['user_id'] = $this->session->user_id;
            // （可选）遍历筛选条件
            foreach ($this->names_to_sort as $sorter):
                if ( !empty($this->input->post($sorter)) )
                    $condition[$sorter] = $this->input->post($sorter);
            endforeach;

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
				'title' => '领券中心',
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

		/**
		 * 创建
		 *
		 * 根据传入了template_id还是combo_id生成一张或多张优惠券
		 */
		public function create()
		{
            // 检查是否已传入必要参数
            $combo_id = $this->input->get_post('combo_id');
            $template_id = $this->input->get_post('template_id');

            // 优先判断是否为优惠券模板
            if ( !empty($template_id) ):
                $api_name = 'coupon_template';
                $params['id'] = $template_id;

            elseif ( !empty($combo_id) ):
                $api_name = 'coupon_combo';
                $params['id'] = $combo_id;

            else:
                redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页

            endif;

			// 页面信息
			$data = array(
				'title' => '领取优惠券',
				'class' => $this->class_name.' create',
				'error' => '', // 预设错误提示
			);

            // 从API服务器获取相应详情信息
            $url = api_url($api_name.'/detail');

            $result = $this->curl->go($url, $params, 'array');
            if ($result['status'] === 200):
                $data['item_type'] = $api_name; // 数据类型
                $data['item'] = $result['content'];

                // 输出视图
                $this->load->view('templates/header', $data);
                $this->load->view($this->view_root.'/create', $data);
                $this->load->view('templates/footer', $data);

            else:
                redirect( base_url('error/code_404') ); // 若缺少参数，转到错误提示页

            endif;
		} // end create

	} // end class Coupon

/* End of file Coupon.php */
/* Location: ./application/controllers/Coupon.php */
