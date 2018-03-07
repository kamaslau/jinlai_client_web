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

            // 微信登录授权URL
            $current_url = 'https://'. $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
            $target_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.WECHAT_APP_ID.'&redirect_uri='.urlencode($current_url).'&response_type=code&scope=snsapi_userinfo#wechat_redirect';

            // 登录已登录未获取微信用户资料的用户转到微信授权页
			(
			    ($this->session->time_expire_login > time() && !empty($this->session->sns_info))
                || !empty($this->input->get('code'))
            ) OR redirect($target_url);

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '投票'; // 改这里……
			$this->table_name = 'vote'; // 和这里……
			$this->id_name = 'vote_id'; // 还有这里，OK，这就可以了
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
                $data['title'] = '"'. $data['item']['name']. '"投票活动';
                $data['class'] = $this->class_name.' detail';

                // 若活动已开始，则显示活动详情页；已结束则显示活动结果页；未开始则显示活动预告页。
                if (!empty($data['item']['time_end']) && time() > $data['item']['time_end']):
                    $view_name = 'detail-after';
                elseif (!empty($data['item']['time_start']) && time() < $data['item']['time_start']):
                    $view_name = 'detail-before';
                else:
                    $view_name = 'detail';
                endif;

			    // 获取投票候选项信息（若有）
                $data['options'] = $this->list_vote_option($id);

                // 获取投票候选项标签（若有）
                $data['tags'] = $this->list_vote_tag($id);

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
