<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Vote_ballot 投票选票类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Vote_ballot extends MY_Controller
	{	
		/**
		 * 可作为列表筛选条件的字段名；可在具体方法中根据需要删除不需要的字段并转换为字符串进行应用，下同
		 */
		protected $names_to_sort = array(
			'vote_id', 'option_id', 'user_id', 'date_create', 'time_create', 'time_delete', 'time_edit', 'creator_id', 'operator_id', 'status', 'time_create_min', 'time_create_max',
		);

		public function __construct()
		{
			parent::__construct();

            $code = $this->input->get('code');
            // 已关注微信公众号且登录未超时，或传入了code参数时无需跳转
            (
                ( (get_cookie('wechat_subscribe') == 1) && ($this->session->time_expire_login > time()) )
                ||
                ( !empty($code) && ($code <> get_cookie('last_code_used')) )
            ) OR redirect(WECHAT_AUTH_URL);

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '选票'; // 改这里……
			$this->table_name = 'vote_ballot'; // 和这里……
			$this->id_name = 'ballot_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 视图文件所在目录
			$this->media_root = MEDIA_URL. $this->class_name.'/'; // 媒体文件所在目录
		} // end __construct

		/**
		 * 创建
		 */
		public function create()
		{
			// 页面信息
			$data = array(
				'title' => '投票',
				'class' => $this->class_name.' create',
				'error' => '', // 预设错误提示
			);

			// 检查是否已传入必要参数
			$vote_id = $this->input->get_post('vote_id');
            $option_id = $this->input->get_post('option_id');
            if (empty($vote_id) || empty($option_id))
                redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页

			// 待验证的表单项
			$this->form_validation->set_error_delimiters('', '；');
			// 验证规则 https://www.codeigniter.com/user_guide/libraries/form_validation.html#rule-reference
            $data_to_validate['vote_id'] = $vote_id;
            $data_to_validate['option_id'] = $option_id;
            $this->form_validation->set_data($data_to_validate);
			$this->form_validation->set_rules('vote_id', '所属投票ID', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('option_id', '候选项ID', 'trim|required|is_natural_no_zero');

			// 若表单提交不成功
			if ($this->form_validation->run() === FALSE):
				$data['error'] = validation_errors();

			    // TODO
			    $this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/create', $data);
				$this->load->view('templates/footer', $data);

			else:
				// 需要创建的数据；逐一赋值需特别处理的字段
				$data_to_create = array(
					'user_id' => $this->session->user_id,
					'vote_id' => $vote_id,
					'option_id' => $option_id,
				);

				// 向API服务器发送待创建数据
				$params = $data_to_create;
				$url = api_url($this->class_name. '/create');
				$result = $this->curl->go($url, $params, 'array');
				if ($result['status'] === 200):
                    // 记录最后投票的候选项信息
                    $this->session->last_ballot_created = $option_id;
                    redirect('vote_option/detail?ballot_create_result=succeed&id='.$option_id);

				else:
                    redirect('vote_option/detail?ballot_create_result=failed&id='.$option_id.'&error='.$result['content']['error']['message']);

				endif;
				
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

	} // end class Vote_ballot

/* End of file Vote_ballot.php */
/* Location: ./application/controllers/Vote_ballot.php */
