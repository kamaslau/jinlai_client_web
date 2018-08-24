<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Account 账户类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Account extends MY_Controller
	{
        // 登录后跳转的目标页面BASE_URL之后部分
        public $url_after_login = 'mine';

		public function __construct()
		{
			parent::__construct();

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '账户'; // 改这里……
			$this->table_name = 'user'; // 和这里……
			$this->id_name = 'user_id';  // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 视图文件所在目录
			$this->media_root = MEDIA_URL. 'user/'; // 媒体文件所在目录

            // 若传入了登录后跳转页面值，覆盖默认类属性值
            $url_after_login = $this->input->get_post('url_after_login');
                $this->url_after_login = empty($url_after_login)? base_url('mine'): base_url($url_after_login);
		} // end __construct

		/**
		 * 密码登录
		 *
		 * 使用手机号及密码进行账户登录
		 *
		 * @return void
		 */
		public function login()
		{
			// 若已登录，转到首页
            ($this->session->time_expire_login < time()) OR redirect( $this->url_after_login );

			// 页面信息
			$data = array(
				'title' => '登录',
				'class' => $this->class_name.' login',
			);

			//$this->form_validation->set_rules('captcha_verify', '图片验证码', 'trim|required|exact_length[4]|callback_verify_captcha');
			$this->form_validation->set_rules('mobile', '手机号', 'trim|required|exact_length[11]|is_natural_no_zero');
			$this->form_validation->set_rules('password', '密码', 'trim|min_length[6]|max_length[20]');
			$this->form_validation->set_rules('sms_id', '短信ID', 'trim|is_natural_no_zero');
			$this->form_validation->set_rules('captcha', '短信验证码', 'trim|exact_length[6]|is_natural_no_zero');
			
			if ($this->form_validation->run() === FALSE):
				$data['error'] = validation_errors();
				

			else:
				$mobile = $this->input->post('mobile');
				$password = $this->input->post('password');
				$sms_id = $this->input->post('sms_id');
				$captcha = $this->input->post('captcha');

				$data_to_search = array(
					'user_ip' => $this->input->ip_address(),
					'mobile' => $mobile,
					'password' => $password,
					'sms_id' => $sms_id,
					'captcha' => $captcha,
				);

				if ( !empty($password) ):
					// 若传入了密码，则调用密码登录API
					$url = api_url($this->class_name. '/login');
				else:
					// 若未传入密码，则调用短信登录API
					$url = api_url($this->class_name. '/login_sms');
				endif;

				// 从API服务器获取相应详情信息
				$params = $data_to_search;
				$result = $this->curl->go($url, $params, 'array');

				if ($result['status'] !== 200):
					$data['error'] = $result['content']['error']['message'];

				else:
					// 获取用户信息
					$data['item'] = $result['content'];
					// 将信息键值对写入session
					foreach ($data['item'] as $key => $value):
						$user_data[$key] = $value;
					endforeach;
					$user_data['time_expire_login'] = time() + 60*60*24 *30; // 默认登录状态保持30天
					$this->session->set_userdata($user_data);

					// 将用户手机号写入cookie并保存30天
					$this->input->set_cookie('mobile', $data['item']['mobile'], 60*60*24 *30, COOKIE_DOMAIN);

					// 若用户已设置密码则转到登录后页面，否则转到密码设置页
					if ( !empty($data['item']['password']) ):
						redirect( $this->url_after_login );
					else:
						redirect( base_url('password_set') );
					endif;

				endif;

			endif;

			// 载入视图
			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/login', $data);
			$this->load->view('templates/footer', $data);
		} // end login

        /**
         * 微信登录
         *
         * 获取微信用户信息成功后应转到绑定页，询问是否需绑定手机号，若提供手机号则调用ACT1（需传入wechat_union_id等参数，头像等参数亦可一并传入），不提供手机号则调用ACT7
         */
        public function login_wechat()
        {
            // 询问是否提供手机号

            // 若传入了手机号则调用ACT1

            // 否则调用ACT7

            $code = $this->input->get('code');

            // 若已关注微信公众号且已登录，或未传入微信授权CODE，或CODE已使用过，则无需登录，直接转到需登录后跳转的目标页面
            if (
                (get_cookie('wechat_subscribe') == 1) && $this->session->time_expire_login > time()
                || empty($code)
                || $code === get_cookie('last_code_used')
            ):
                redirect( $this->url_after_login );
            endif;

            $this->wechat->grab_user();
            $sns_info = $this->wechat->sns_info;

            $data_to_search = array(
                'user_ip' => $this->input->ip_address(),

                'wechat_union_id' => $sns_info['unionid'],
                'sns_info' => json_encode($sns_info),
            );

            // 从API服务器获取相应详情信息
            $params = array_filter($data_to_search); // 清理空项
            $url = api_url($this->class_name. '/login_wechat');
            $result = $this->curl->go($url, $params, 'array');

            if ($result['status'] !== 200):
                $data['error'] = $result['content']['error']['message'];

            else:
                // 获取用户信息
                $data['item'] = $result['content'];
                $data['item']['wechat_subscribe'] = $sns_info['subscribe']; // TODO 微信公众号关注情况；应抽空改为写入数据库相应字段
                // 将信息键值对写入session
                foreach ($data['item'] as $key => $value):
                    $user_data[$key] = $value;
                endforeach;
                $user_data['time_expire_login'] = time() + 60*60*24 *30; // 默认登录状态保持30天
                $this->session->set_userdata($user_data);

                // 将用户手机号写入cookie并保存30天
                $this->input->set_cookie('mobile', $data['item']['mobile'], 60*60*24 *30, COOKIE_DOMAIN);

                // 若用户已设置密码则转到登录后页面，否则转到密码设置页
                if ( !empty($data['item']['password']) ):
                    redirect( $this->url_after_login );
                else:
                    redirect( base_url('password_set') );
                endif;

            endif;
        } // end login_wechat

        /**
		 * 短信登录/注册
         *
         * @return void
		 */
		public function login_sms()
		{
            // 若已登录，转到首页
            ($this->session->time_expire_login < time()) OR redirect( $this->url_after_login );

            // TODO 若是从微信端获取用户资料，则获取相应数据
            //$wechat_info = $this->get_wechat_info();

			// 页面信息
			$data = array(
				'title' => '短信登录/注册',
				'class' => $this->class_name.' login-sms',
			);

			//$this->form_validation->set_rules('captcha_verify', '图片验证码', 'trim|required|exact_length[4]|callback_verify_captcha');
			$this->form_validation->set_rules('mobile', '手机号', 'trim|required|exact_length[11]');
			$this->form_validation->set_rules('sms_id', '短信ID', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('captcha', '短信验证码', 'trim|required|exact_length[6]|is_natural_no_zero');
            $this->form_validation->set_rules('wechat_union_id', '微信UnionID', 'trim|max_length[29]');

			if ($this->form_validation->run() === FALSE):
				$data['error'] = validation_errors();

			else:
				$data_to_search = array(
					'user_ip' => $this->input->ip_address(),
					'mobile' => $this->input->post('mobile'),
					'sms_id' => $this->input->post('sms_id'),
					'captcha' => $this->input->post('captcha'),
				);

				// 从API服务器获取相应详情信息
				$params = $data_to_search;
				$url = api_url($this->class_name. '/login_sms');
				$result = $this->curl->go($url, $params, 'array');

				if ($result['status'] !== 200):
					$data['error'] = $result['content']['error']['message'];

				else:
					// 获取用户信息
					$data['item'] = $result['content'];
					// 将信息键值对写入session
					foreach ($data['item'] as $key => $value):
						$user_data[$key] = $value;
					endforeach;
					$user_data['time_expire_login'] = time() + 60*60*24 *30; // 默认登录状态保持30天
					$this->session->set_userdata($user_data);

					// 将用户手机号写入cookie并保存30天
					$this->input->set_cookie('mobile', $data['item']['mobile'], 60*60*24 *30, COOKIE_DOMAIN);

					// 若用户已设置密码则转到登录后页面，否则转到密码设置页
					if ( !empty($data['item']['password']) ):
                        redirect( $this->url_after_login );
					else:
						redirect( base_url('password_set') );
					endif;

				endif;

			endif;

			// 载入视图
			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/login_sms', $data);
			$this->load->view('templates/footer', $data);
		} // end login_sms

		/**
		 * 密码设置
		 *
		 * 未设置密码的用户可以设置密码
         *
         * @return void
		 */
		public function password_set()
		{
			// 若未登录，转到密码重置页
			($this->session->time_expire_login > time()) OR redirect( base_url('password_reset') );

			// 若当前用户已设置密码，转到密码修改页
			if ( !empty($this->session->password) )
				redirect( base_url('password_change') );

			// 页面信息
			$data = array(
				'title' => '密码设置',
				'class' => $this->class_name.' password-set',
			);

			$this->form_validation->set_rules('password', '密码', 'trim|required|min_length[6]|max_length[20]');
			$this->form_validation->set_rules('password_confirm', '确认密码', 'trim|required|matches[password]');

			if ($this->form_validation->run() === FALSE):
				$data['error'] = validation_errors();

				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/password_set', $data);
				$this->load->view('templates/footer', $data);

			else:
				$data_to_search = array(
					'user_id' => $this->session->user_id,

					'password' => $this->input->post('password'),
					'password_confirm' => $this->input->post('password_confirm'),
				);

				// 从API服务器获取相应详情信息
				$params = $data_to_search;
				$url = api_url($this->class_name. '/password_set');
				$result = $this->curl->go($url, $params, 'array');

				if ($result['status'] !== 200):
					$data['error'] = $result['content']['error']['message'];

					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/password_set', $data);
					$this->load->view('templates/footer', $data);

				else:
					// 更新本地用户密码字段
					$this->session->password = 'set';

				    // 转到个人中心页
				    redirect(base_url('mine'));
				endif;

			endif;
		} // end password_set

		/**
		 * 密码修改
		 *
		 * 用户登录后可修改密码
		 *
		 * @return void
		 */
		public function password_change()
		{
			// 若未登录，转到密码重置页
			($this->session->time_expire_login > time()) OR redirect( base_url('password_reset') );

			// 若当前用户未设置密码，转到密码设置页
			if ( empty($this->session->password) )
				redirect( base_url('password_set') );

			// 页面信息
			$data = array(
				'title' => '修改密码',
				'class' => $this->class_name.' password-change',
				'id' => $this->session->user_id,
			);

			// 待验证的表单项
			$this->form_validation->set_rules('password_current', '原密码', 'trim|required|min_length[6]|max_length[20]');
			$this->form_validation->set_rules('password', '新密码', 'trim|required|min_length[6]|max_length[20]');
			$this->form_validation->set_rules('password_confirm', '确认密码', 'trim|required|matches[password]');
			
			if ($this->form_validation->run() === FALSE):
				$data['error'] = validation_errors();
				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/password_change', $data);
				$this->load->view('templates/footer', $data);

			// 新密码需要不同于原密码
			elseif ($this->input->post('password_current') === $this->input->post('password')):
				$data['error'] = '请设置不同于原密码的新密码';

				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/password_change', $data);
				$this->load->view('templates/footer', $data);

			else:
				// 需要存入数据库的信息
				$data_to_edit = array(
					'user_id' => $this->session->user_id,
					'password_current' => $this->input->post('password_current'),
					'password' => $this->input->post('password'),
					'password_confirm' => $this->input->post('password_confirm'),
				);

				// 从API服务器获取相应详情信息
				$params = $data_to_edit;
				$url = api_url($this->class_name. '/password_change');
				$result = $this->curl->go($url, $params, 'array');

				if ($result['status'] !== 200):
					$data['error'] = $result['content']['error']['message'];
					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/password_change', $data);
					$this->load->view('templates/footer', $data);

				else:
                    // 转到个人中心页
                    redirect(base_url('mine'));

				endif;

			endif;
		} // end password_change

		/**
		 * 密码重置
		 *
		 * 用户使用短信验证码重置密码
		 *
		 * @return void
		 */
		public function password_reset()
		{
			// 清除当前SESSION
			$this->session->sess_destroy();

			// 页面信息
			$data = array(
				'title' => '密码重置',
				'class' => $this->class_name.' password-reset',
			);

			// 待验证的表单项
			$this->form_validation->set_rules('captcha_verify', '图片验证码', 'trim|required|exact_length[4]|callback_verify_captcha');
			$this->form_validation->set_rules('mobile', '手机号', 'trim|required|exact_length[11]');
			$this->form_validation->set_rules('sms_id', '短信ID', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('captcha', '短信验证码', 'trim|required|exact_length[6]|is_natural_no_zero');
			$this->form_validation->set_rules('password', '密码', 'trim|required|min_length[6]|max_length[20]');
			$this->form_validation->set_rules('password_confirm', '确认密码', 'trim|required|matches[password]');

			if ($this->form_validation->run() === FALSE):
				$data['error'] = validation_errors();
				$this->load->view('templates/header', $data);
				$this->load->view($this->view_root.'/password_reset', $data);
				$this->load->view('templates/footer', $data);

			else:
				$data_to_edit = array(
					'user_id' => $this->session->user_id,
					'mobile' => $this->input->post('mobile'),
					'sms_id' => $this->input->post('sms_id'),
					'captcha' => $this->input->post('captcha'),
					'password' => $this->input->post('password'),
					'password_confirm' => $this->input->post('password_confirm'),
				);

				// 从API服务器获取相应详情信息
				$params = $data_to_edit;
				$url = api_url($this->class_name. '/password_reset');
				$result = $this->curl->go($url, $params, 'array');

				if ($result['status'] !== 200):
					$data['error'] = $result['content']['error']['message'];
					$this->load->view('templates/header', $data);
					$this->load->view($this->view_root.'/password_reset', $data);
					$this->load->view('templates/footer', $data);

				else:
					// 转到密码登录页
					redirect( base_url('login') );

				endif;

			endif;

		} // end password_reset

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

			// 转到密码登录页
			redirect( base_url('login') );
		} // end logout

		/**
		 * 验证图片验证码是否有效
		 *
		 * @params string $captcha 图片验证码内容
         * @return boolean
		 */
		public function verify_captcha($captcha)
		{
			// 依次验证是否存在有效期之内的图片验证码、验证码是否正确
			if (time() > $this->session->captcha_time_expire):
				$this->form_validation->set_message('verify_captcha', '验证码已失效');
				return FALSE;
			elseif ($captcha !== $this->session->captcha):
				$this->form_validation->set_message('verify_captcha', '验证码错误');
				return FALSE;
			else:
				return TRUE;
			endif;
		} // end verify_captcha

		/**
		 * TODO 邮箱注册；暂不开放此功能
		 *
		 * 使用邮箱及密码进行注册
		 *
		 * @return void
		 */
		public function register()
		{
            // 若已登录，转到首页
            ($this->session->time_expire_login < time()) OR redirect( $this->url_after_login );

			// 页面信息
			$data = array(
				'title' => '邮箱注册',
				'class' => $this->class_name.' register',
			);

			$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[50]|valid_email');
			$this->form_validation->set_rules('password', '密码', 'trim|required|min_length[6]|max_length[20]');
			$this->form_validation->set_rules('password2', '确认密码', 'trim|required|matches[password]');

			if ($this->form_validation->run() === FALSE):
				$data['error'] = validation_errors();

			else:
				$data_to_create = array(
					'mobile' => $this->input->post('mobile'),
					'password' => sha1($this->input->post('password')),
				);

				// 从API服务器获取相应详情信
				$params = $data_to_create;
				$url = api_url($this->class_name. '/register');
				$result = $this->curl->go($url, $params, 'array');

				if ($result['status'] !== 200):
					$data['error'] = $result['content']['error']['message'];
				else:
				endif;

			endif;
		} // end register
		
		/**
		 * 用户存在性
		 */
		public function user_exist()
		{
			// 手机号及Email须至少传入一项
			$mobile = $this->input->get('mobile');
			$email = $this->input->get('email');
			$wechat_union_id = $this->input->get('wechat_union_id');
			if ( empty($mobile) && empty($email) && empty($wechat_union_id) ):
				$this->result['status'] = 400;
				$this->result['content']['error']['message'] = '手机号、Email及微信UnionID须至少传入一项';
				exit();
			endif;

			// 初始化并配置表单验证库
			$this->form_validation->set_error_delimiters('', '');
			$data_to_validate['mobile'] = $mobile;
			$data_to_validate['email'] = $email;
			$data_to_validate['wechat_union_id'] = $wechat_union_id;
			$this->form_validation->set_data($data_to_validate);
			// 待验证的表单项
			$this->form_validation->set_rules('mobile', '手机号', 'trim|exact_length[11]|is_natural_no_zero');
			$this->form_validation->set_rules('email', 'Email', 'trim|max_length[40]|valid_email');
			$this->form_validation->set_rules('wechat_union_id', '微信UnionID', 'trim|max_length[29]');

			// 需要创建的数据；逐一赋值需特别处理的字段
			$data_to_search = array(
				'mobile' => $mobile,
				'email' => $email,
				'wechat_union_id' => $wechat_union_id,
			);

			// 只接受AJAX请求
			if ( !$this->input->is_ajax_request() ):
				redirect( base_url() ); // 转到首页

			else:
				// 若表单提交不成功
				if ($this->form_validation->run() === FALSE):
					$this->result['status'] = 401;
					$this->result['content']['error']['message'] = validation_errors();

				else:
					// 向API服务器发送待查询数据
					$params = $data_to_search;
					$url = api_url('account/user_exist');
					$result = $this->curl->go($url, $params, 'array');
					if ( !empty($result) ):
						$this->result = $result;

					else:
						$this->result['status'] = 400;
						$this->result['content']['error']['message'] = '操作失败：网络问题';

					endif;

				endif;

				// 返回JSON
				$this->output_json();
			endif;
		} // end user_exist

        /**
         * 以下为工具方法
         */

        /**
         * 测试方法
         */
        public function test()
        {

        } // end test

	} // end class Account

/* End of file Account.php */
/* Location: ./application/controllers/Account.php */
