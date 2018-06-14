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
			'signup_allowed', 'max_user_total', 'max_user_daily', 'max_user_daily_each', 'time_start', 'time_end',
            'time_create', 'time_delete', 'time_edit', 'creator_id', 'operator_id', 'time_create_min', 'time_create_max',
		);

		public function __construct()
		{
			parent::__construct();

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '投票'; // 改这里……
			$this->table_name = 'vote'; // 和这里……
			$this->id_name = 'vote_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 视图文件所在目录
			$this->media_root = MEDIA_URL. $this->class_name.'/'; // 媒体文件所在目录
		} // end __construct

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

            // 已关注微信公众号且登录未超时，或传入了code参数时无需跳转
            $code = $this->input->get('code');
            (
                ( (get_cookie('wechat_subscribe') == 1) && ($this->session->time_expire_login > time()) )
                ||
                ( !empty($code) && ($code <> get_cookie('last_code_used')) )
            ) OR redirect(WECHAT_AUTH_URL);

			// 从API服务器获取相应详情信息
			$url = api_url($this->class_name. '/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
                // 获取候选项标签、投票候选项
                $data['tags'] = $result['content']['tags'];
                unset($result['content']['tags']);
                $data['options'] = $result['content']['options'];
                unset($result['content']['options']);

                $data['item'] = $result['content'];

                // 若活动已开始则显示活动详情页；已结束则转到活动结果页。
                if (time() > $data['item']['time_end']) redirect('vote/detail_result?id='.$id);
                
                $this->load->view('templates/header-vote', $data);
                $this->load->view($this->view_root.'/detail', $data);
                $this->load->view('templates/footer-vote', $data);

			else:
                redirect( base_url('error/code_404') ); // 若缺少参数，转到错误提示页

			endif;
		} // end detail

        /**
         * 详情结果页
         */
        public function detail_result()
        {
            // 检查是否已传入必要参数
            $id = $this->input->get_post('id')? $this->input->get_post('id'): NULL;
            if ( !empty($id) ):
                $params['id'] = $id;
                $params['orderby_ballot_overall'] = 'DESC';// 将候选项按票数从多到少排序
            else:
                redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页
            endif;

            // 从API服务器获取相应详情信息
            $url = api_url($this->class_name. '/detail');
            $result = $this->curl->go($url, $params, 'array');
            if ($result['status'] === 200):
                // 获取候选项标签、投票候选项
                $data['tags'] = $result['content']['tags'];
                unset($result['content']['tags']);
                $data['options'] = $result['content']['options'];
                unset($result['content']['options']);

                $data['item'] = $result['content'];

                // 页面信息
                $data['title'] = '"'. $data['item']['name']. '"全民评选结果';
                $data['class'] = $this->class_name.' detail';

                // 若活动已结束，则将页面缓存1分钟
                if (time() > $data['item']['time_end']) $this->output->cache(1);

                $this->load->view('templates/header-vote', $data);
                $this->load->view($this->view_root.'/detail-result', $data);
                $this->load->view('templates/footer-vote', $data);

            else:
                redirect( base_url('error/code_404') ); // 若缺少参数，转到错误提示页

            endif;
        } // end detail_result
		
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
