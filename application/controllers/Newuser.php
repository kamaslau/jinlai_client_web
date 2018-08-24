<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * 添加员工
	 *

	 */
	class Newuser extends MY_Controller {



		public function __construct()
		{
			parent::__construct();

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '收货地址'; // 改这里……
			$this->table_name = 'user'; // 和这里……
			$this->id_name = 'user_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name;
		} // end __construct


		public function create(){
			$startCount = 0;
			$user = ['password'=>'123456', 'mobile'=>'18112345', 'last_login_ip'=>'218.201.110.203','status'=>'正常'];

			while ($startCount < 100) {
				$user['mobile'] =  $user['mobile'] . sprintf('%3d', $startCount++);
				echo $this->basic_model->create($user);
				echo PHP_EOL;
			}
			echo 'done';

		}
	}