<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Home 类
	 *
	 * 首页
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Home extends MY_Controller
	{
        public function __construct()
        {
            parent::__construct();
            
            // 向类属性赋值
            $this->class_name = strtolower(__CLASS__);
            $this->class_name_cn = '首页'; // 改这里……
        }

		// 首页
		public function index()
		{
			// 页面信息
			$data = array(
				'title' => NULL, // 直接使用默认标题
				'class' => $this->class_name, // 页面body标签的class属性值
			);
			
			// 获取商家列表
			$data['bizs'] = $this->list_biz();
			
			// 载入视图
			$this->load->view('templates/header', $data);
			$this->load->view('home', $data);
			$this->load->view('templates/nav-main', $data);
			$this->load->view('templates/footer', $data);
		} // end index

	} // end class Home

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
