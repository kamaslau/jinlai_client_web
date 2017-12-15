<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Setup 设置页类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Setup extends MY_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			// 若未登录，转到密码登录页
			($this->session->time_expire_login > time()) OR redirect( base_url('login') );

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '设置'; // 改这里……
			$this->table_name = 'user'; // 和这里……
			$this->id_name = 'user_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 视图文件所在目录
			$this->media_root = MEDIA_URL. 'user/'; // 媒体文件所在目录
		}

		/**
		 * 列表页
		 */
		public function index()
		{
			// 若当前用户未设置密码，转到密码设置页
			if ( empty($this->session->password) )
				redirect( base_url('password_set') );

			// 页面信息
			$data = array(
				'title' => '设置中心', // 页面标题
				'class' => $this->class_name.' index', // 页面body标签的class属性值
			);

			// 从API服务器获取当前用户资料
			$params['id'] = $this->session->user_id;
			$url = api_url('user/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['user'] = $result['content'];
			else:
				$this->logout(); // 若获取用户资料失败，退出账户
			endif;

			// 输出视图
			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/index', $data);
			$this->load->view('templates/footer', $data);
		} // end index

	} // end class Setup

/* End of file Setup.php */
/* Location: ./application/controllers/Setup.php */
