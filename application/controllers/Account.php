<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Account Class
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Account extends CI_Controller
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
			$this->class_name_cn = '账户'; // 改这里……
			$this->table_name = 'user'; // 和这里……
			$this->id_name = 'user_id';  // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name;
		}
		
		/**
		 * 我的
		 *
		 * 个人中心页
		 */
		public function mine()
		{
			// 页面信息
			$data = array(
				'title' => '我的', // 页面标题
				'class' => $this->class_name.' mine', // 页面body标签的class属性值
			);

			// 筛选条件
			$condition['user_id'] = $this->session->user_id;

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
				redirect( base_url('error/code_404') ); // 若未成功获取信息，则转到错误页
			endif;

			// 将需要显示的数据传到视图以备使用
			$data['data_to_display'] = $this->data_to_display;

			// 输出视图
			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/mine', $data);
			$this->load->view('templates/nav-main', $data);
			$this->load->view('templates/footer', $data);
		} // end mine

		/**
		 * 密码登录
		 *
		 * 使用手机号及密码进行账户登录
		 *
		 * @param string $_POST['mobile']
		 * @param string $_POST['password']
		 * @return void
		 */
		public function login()
		{
			if ($this->session->logged_in === TRUE) redirect(base_url());

			// 页面信息
			$data = array(
				'title' => '密码登录',
				'class' => $this->class_name.' login',
			);

			$this->form_validation->set_rules('mobile', '手机号', 'trim|required|is_natural_no_zero|exact_length[11]');
			$this->form_validation->set_rules('password', '密码', 'trim|required|min_length[6]|max_length[20]');

			if ($this->form_validation->run() === FALSE):
				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/login', $data);
				$this->load->view('templates/footer', $data);

			else:
				$data_to_search = array(
					'mobile' => $this->input->post('mobile'),
					'password' => sha1($this->input->post('password'))
				);
				$result = $this->basic_model->match($data_to_search); // 使用密码登录

				// 成功登录
				if ( ! empty($result)):
					// 获取用户信息
					$data['user'] = $result;

					// 将信息键值对写入session
					foreach ($data['user'] as $key => $value):
						$user_data[$key] = $value;
					endforeach;
					$user_data['logged_in'] = TRUE; // 标记登录状态，便于快速判断是否已登录
					$this->session->set_userdata($user_data);

					// 将管理员手机号写入cookie并保存1个月
					$this->input->set_cookie('mobile', $data['user']['mobile'], 60*60*24*30, COOKIE_DOMAIN);
					// 转到首页
					redirect(base_url());

				// 若用户不存在
				$if_exsit = $this->basic_model->find('mobile', $this->input->post('mobile'));
				elseif ( empty($if_exsit) ):
					$data['error'] = '<p>此手机号未注册为用户，请<a title="注册" href="'. base_url('register') .'">注册</a>。</p>';
					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/login', $data);
					$this->load->view('templates/footer', $data);

				// 若密码错误
				else:
					$data['error'] = '<p>密码不正确，请确认后重试。</p>';
					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/login', $data);
					$this->load->view('templates/footer', $data);

				endif;
			endif;
		}

		/**
		 * 邮箱注册
		 *
		 * 使用邮箱及密码进行注册
		 *
		 * @param string $_POST['mobile']
		 * @param string $_POST['password']
		 * @param string $_POST['password2']
		 * @return void
		 */
		public function register()
		{
			if ($this->session->logged_in === TRUE) redirect(base_url());

			// 页面信息
			$data = array(
				'title' => '密码注册',
				'class' => $this->class_name.' register',
			);

			$this->form_validation->set_rules('mobile', '手机号', 'trim|required|is_natural|exact_length[11]');
			$this->form_validation->set_rules('password', '密码', 'trim|required|is_natural|exact_length[6]');
			$this->form_validation->set_rules('password2', '确认密码', 'trim|required|matches[password]');

			if ($this->form_validation->run() === FALSE):
				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/register', $data);
				$this->load->view('templates/footer', $data);

			elseif ( ! empty($this->basic_model->find('mobile', $this->input->post('mobile')))):
				// 若用户已存在
				$data['error'] = '<p>该手机号已注册过账户，请<a title="登录" href="'. base_url('login') .'">登录</a>。</p>';
				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/register', $data);
				$this->load->view('templates/footer', $data);

			else:

				$data_to_create = array(
					'mobile' => $this->input->post('mobile'),
					'password' => sha1($this->input->post('password')),
				);
				$result = $this->basic_model->create($data_to_create, TRUE); // 尝试创建用户

				// 成功创建
				if ( ! empty($result)):
					// 获取用户信息
					$data['user'] = $this->basic_model->select_by_id($result);

					// 将信息键值对写入session
					foreach ($data['user'] as $key => $value):
						$user_data[$key] = $value;
					endforeach;
					$user_data['logged_in'] = TRUE; // 标记登录状态，便于快速判断是否已登录
					$this->session->set_userdata($user_data);

					// 将管理员手机号写入cookie并保存1个月
					$this->input->set_cookie('mobile', $data['user']['mobile'], 60*60*24*30, COOKIE_DOMAIN);
					// 转到首页
					redirect(base_url());

				// 若密码错误
				else:
					$data['error'] = '<p>注册失败，请确认后重试。</p>';
					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/register', $data);
					$this->load->view('templates/footer', $data);

				endif;
			endif;
		}

		/**
		 * 密码修改
		 *
		 * 用户登录后可修改密码
		 *
		 * @param string $_POST['old_password']
		 * @param string $_POST['password']
		 * @param string $_POST['password2']
		 * @return void
		 */
		public function password_change()
		{
			// 若用户未登录，转到密码重置页
			if ($this->session->logged_in !== TRUE) redirect(base_url('password_reset'));

			// 页面信息
			$data = array(
				'title' => '修改密码',
				'class' => $this->class_name.' password-change',
				'id' => $this->session->user_id,
			);
			$data1 = array(
				'user_id' => $this->session->user_id,
				'password' => sha1($this->input->post('password'))
			);
			var_dump($data1);

			// 待验证的表单项
			$this->form_validation->set_rules('old_password', '原密码', 'trim|required|is_natural|exact_length[6]');
			$this->form_validation->set_rules('password', '新密码', 'trim|required|is_natural|exact_length[6]');
			$this->form_validation->set_rules('password2', '确认密码', 'trim|required|matches[password_new]');

			if ($this->input->post('old_password') === $this->input->post('password')):
				$data['error'] = '新密码需要不同于原密码';

				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/password_change', $data);
				$this->load->view('templates/footer', $data);
				exit();
			endif;

			// 需要存入数据库的信息
			$data_to_edit = array(
				'password' => sha1($this->input->post('password'))
			);

			// Go Basic!
			$this->basic->edit($data, $data_to_edit, 'password_change');
		}

		/**
		 * TODO 密码重置
		 *
		 * 用户未登录时可重置密码
		 *
		 * @param string $_POST['password']
		 * @param string $_POST['password_new']
		 * @param string $_POST['password2']
		 * @return void
		 */
		public function password_reset()
		{
			// 若用户已登录，转到密码修改页
			if ($this->session->logged_in === TRUE) redirect(base_url('password_change'));

			// 页面信息
			$data = array(
				'title' => '密码重置',
				'class' => $this->class_name.' password-reset',
			);
		}

		/**
		 * 退出账户
		 *
		 * @param void
		 * @return void
		 */
		public function logout()
		{
			// 清除当前SESSION
			$this->session->sess_destroy();

			// 转到登录页
			redirect( base_url('login') );
		}
	}

/* End of file Account.php */
/* Location: ./application/controllers/Account.php */
