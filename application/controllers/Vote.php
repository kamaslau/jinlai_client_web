<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Vote 投票类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Vote extends MY_Controller
	{
		/**
		 * 可作为列表筛选条件的字段名；可在具体方法中根据需要删除不需要的字段并转换为字符串进行应用，下同
		 */
		protected $names_to_sort = array(
			'name', 'description', 'url_image', 'url_video', 'url_audio', 'url_name', 'signup_allowed', 'max_user_total', 'max_user_daily', 'max_user_daily_each', 'time_start', 'time_end', 'time_create', 'time_delete', 'time_edit', 'creator_id', 'operator_id', 'time_create_min', 'time_create_max',
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
			$this->class_name_cn = '投票'; // 改这里……
			$this->table_name = 'vote'; // 和这里……
			$this->id_name = 'vote_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 视图文件所在目录
			$this->media_root = MEDIA_URL. $this->class_name.'/'; // 媒体文件所在目录
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

			// 输出视图
			$this->load->view('templates/header-simple', $data);
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
                $data['title'] = '"'. $data['item']['name']. '"全民评选活动';
                $data['class'] = $this->class_name.' detail';

			    // 获取投票候选项、候选项标签信息
                $data['options'] = $this->list_vote_option($id, '正常');
                $data['tags'] = $this->list_vote_tag($id);

                // 若活动已开始则显示活动详情页；已结束则显示活动结果页。
                $view_name = (time() < $data['item']['time_end'])? 'detail': 'detail-result';
                
                $this->load->view('templates/header-vote', $data);
                $this->load->view($this->view_root.'/'.$view_name, $data);
                $this->load->view('templates/footer-vote', $data);

			else:
                redirect( base_url('error/code_404') ); // 若缺少参数，转到错误提示页

			endif;
		} // end detail
		
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

	} // end class Vote

/* End of file Vote.php */
/* Location: ./application/controllers/Vote.php */
