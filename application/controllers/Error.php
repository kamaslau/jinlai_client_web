<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Error 类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Error extends MY_Controller
	{
		/* 类名称小写，应用于多处动态生成内容 */
		public $class_name;

		/* 类名称中文，应用于多处动态生成内容 */
		public $class_name_cn;

		/* 主要相关表名 */
		public $table_name;

		/* 主要相关表的主键名*/
		public $id_name;

		/* 视图文件所在目录名 */
		public $view_root;

		public function __construct()
		{
			parent::__construct();
			
			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '错误'; // 改这里……
			$this->table_name = NULL; // 和这里……
			$this->id_name = NULL; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name;
		} // end __construct

		/**
		 * 列表页
		 */
		public function index()
		{
			redirect( base_url() );
		}
		
		/**
		 * 404
		 */
		public function code_400()
		{
			// 页面信息
			$data = array(
				'title' => '400',
				'class' => 'error error-400',
				'content' => '必要的请求参数未全部传入。',
			);

			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/400', $data);
			$this->load->view('templates/footer', $data);
		}
		
		/**
		 * 404
		 */
		public function code_404()
		{
			// 页面信息
			$data = array(
				'title' => '404',
				'class' => 'error error-404',
				'content' => '未找到相应的信息。',
			);

			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/404', $data);
			$this->load->view('templates/footer', $data);
		}
		
		/**
		 * 权限 所有权不符
		 */
		public function not_yours()
		{
			// 页面信息
			$data = array(
				'title' => '权限问题 - 所有权不符',
				'class' => 'error error-role',
				'content' => '您无法操作该项。',
			);

			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/not_yours', $data);
			$this->load->view('templates/footer', $data);
		}
		
		/**
		 * 权限 角色不符
		 */
		public function permission_role()
		{
			// 页面信息
			$data = array(
				'title' => '权限问题 - 角色不符',
				'class' => 'error error-role',
				'content' => '只有特定角色的用户可以进行该操作。',
			);

			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/permission', $data);
			$this->load->view('templates/footer', $data);
		}
		
		/**
		 * 权限 级别不足
		 */
		public function permission_level()
		{
			// 页面信息
			$data = array(
				'title' => '权限问题 - 级别不足',
				'class' => 'error error-role',
				'content' => '只有达到特定级别的用户可以进行该操作。',
			);

			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/permission', $data);
			$this->load->view('templates/footer', $data);
		}
	}

/* End of file Error.php */
/* Location: ./application/controllers/Error.php */
