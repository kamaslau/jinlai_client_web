<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Refund 退款/售后类
     *
     * 仅退款类型，当商家同意后进行退款；退货退款类型，当商家收货后进行退款
     * 若货款未结算，则直接从商家余额中扣除相应商家余额到平台余额，平台向用户原路退款
     * 若货款已结算，商家余额足够时扣除相应商家余额到平台余额，平台向用户原路退款；余额不足时创建对商家的待收款项和对用户的待付款项
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Refund extends MY_Controller
	{
		/**
		 * 可作为列表筛选条件的字段名；可在具体方法中根据需要删除不需要的字段并转换为字符串进行应用，下同
		 */
		protected $names_to_sort = array(
			'order_id', 'user_id', 'record_id', 'type', 'cargo_status', 'reason', 'total_applied', 'total_approved', 'deliver_method', 'deliver_biz', 'waybill_id',
            'time_create', 'time_cancel', 'time_close', 'time_refuse', 'time_accept', 'time_refund', 'time_edit', 'operator_id', 'status',
		);

		public function __construct()
		{
			parent::__construct();

			// 未登录用户转到登录页
			($this->session->time_expire_login > time()) OR redirect( base_url('login') );

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '退款/售后'; // 改这里……
			$this->table_name = 'refund'; // 和这里……
			$this->id_name = 'refund_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 视图文件所在目录
            $this->media_root = MEDIA_URL. 'item/'; // 媒体文件所在目录，默认为商品信息

			// 设置需要自动在视图文件中生成显示的字段
			$this->data_to_display = array(
				'order_id' => '订单ID',
                'cargo_status' => '货物状态',
				'total_applied' => '申请退款金额',
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

            // 根据状态筛选值确定页面标题
            if ( !empty($condition['status'] ) )
                $data['title'] = $condition['status']. '退款';

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
            $record_id = $this->input->get_post('record_id')? $this->input->get_post('record_id'): NULL;
			if ( !empty($id) ):
				$params['id'] = $id;
			elseif (!empty($record_id)):
                $params['record_id'] = $record_id;
			else:
				redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页
			endif;

            // 从API服务器获取相应详情信息
            $url = api_url($this->class_name. '/detail');
            $result = $this->curl->go($url, $params, 'array');
            if ($result['status'] === 200):
                $data['item'] = $result['content'];
                // 页面信息
                $data['title'] = $this->class_name_cn. $data['item'][$this->id_name];
                $data['class'] = $this->class_name.' detail';

            else:
                redirect( base_url('error/code_404') ); // 若缺少参数，转到错误提示页

            endif;

			// 输出视图
			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/detail', $data);
			$this->load->view('templates/footer', $data);
		} // end detail

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

            // 待验证的表单项
            $this->form_validation->set_error_delimiters('', '；');
            // 验证规则 https://www.codeigniter.com/user_guide/libraries/form_validation.html#rule-reference
            $this->form_validation->set_rules('record_id', '订单商品ID', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('type', '类型', 'trim|required');
            $this->form_validation->set_rules('cargo_status', '货物状态', 'trim|required');
            $this->form_validation->set_rules('reason', '原因', 'trim|required|in_list[无理由,退运费,未收到,不开发票]');
            $this->form_validation->set_rules('description', '补充说明', 'trim|max_length[255]');
            $this->form_validation->set_rules('url_images', '相关图片URL', 'trim|max_length[255]');

            // 若表单提交不成功
            if ($this->form_validation->run() === FALSE):
                $data['error'] = validation_errors();

                $this->load->view('templates/header', $data);
                $this->load->view($this->view_root.'/create', $data);
                $this->load->view('templates/footer', $data);

            else:
                // 需要创建的数据；逐一赋值需特别处理的字段
                $data_to_create = array(
                    'user_ip' => $this->input->ip_address(),
                );
                // 自动生成无需特别处理的数据
                $data_need_no_prepare = array(
                    'record_id', 'type', 'cargo_status', 'reason', 'description', 'url_images',
                );
                foreach ($data_need_no_prepare as $name)
                    $data_to_create[$name] = $this->input->post($name);

                // 向API服务器发送待创建数据
                $params = $data_to_create;
                //$this->key_value($params);exit(); // 测试
                $url = api_url($this->class_name. '/create');
                $result = $this->curl->go($url, $params, 'array');
                if ($result['status'] === 200):
                    // 转到退款列表页
                    redirect( base_url('refund/index') );

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
         * 创建并预选退款类型
         */
        public function create_type()
        {
            $type = $this->input->post_get('type');
            $record_id = $this->input->post_get('record_id');

            // 页面信息
            $data = array(
                'title' => '创建'.$this->class_name_cn,
                'class' => $this->class_name.' create',
                'error' => '', // 预设错误提示
            );

            // 待验证的表单项
            $this->form_validation->set_error_delimiters('', '；');
            // 验证规则 https://www.codeigniter.com/user_guide/libraries/form_validation.html#rule-reference
            $this->form_validation->set_rules('record_id', '订单商品ID', 'trim|required|is_natural_no_zero');

            // 若表单提交不成功
            if ($this->form_validation->run() === FALSE):
                $data['error'] = validation_errors();

                $this->load->view('templates/header', $data);
                $this->load->view($this->view_root.'/create_type', $data);
                $this->load->view('templates/footer', $data);

            else:
                if ($result['status'] === 200):
                    // 转到退款创建页
                    redirect( base_url('refund/create?type='.$type.'&record_id='.$record_id) );

                else:
                    // 若创建失败，则进行提示
                    $data['error'] = $result['content']['error']['message'];

                    $this->load->view('templates/header', $data);
                    $this->load->view($this->view_root.'/create_type', $data);
                    $this->load->view('templates/footer', $data);

                endif;

            endif;
        } // end create_type

        /**
         * 删除
         *
         * 不可删除
         */
        public function delete()
        {
            exit('不可删除'.$this->class_name_cn.'；您意图违规操作的记录已被发送到安全中心。');
        } // end delete

        /**
         * 找回
         *
         * 不可找回
         */
        public function restore()
        {
            exit('不可找回'.$this->class_name_cn.'；您意图违规操作的记录已被发送到安全中心。');
        } // end restore
		
		/**
		 * 以下为工具类方法
		 */

	} // end class Refund

/* End of file Refund.php */
/* Location: ./application/controllers/Refund.php */
