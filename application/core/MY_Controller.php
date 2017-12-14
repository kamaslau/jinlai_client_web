<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');
	
	/**
	 * MY_Controller 基础控制器类
	 *
	 * 针对客户端类型应用，对Controller类进行了扩展
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class MY_Controller extends CI_Controller
	{
		// 初始化返回结果
		public $result = array(
			'status' => null, // 请求响应状态
			'content' => null, // 返回内容
			'param' => array(
				'get' => array(), // GET请求参数
				'post' => array(), // POST请求参数
			), // 接收到的请求参数
			'timestamp' => null, // 返回时时间戳
			'datetime' => null, // 返回时可读日期
			'timezone' => null, // 服务器本地市区
			'elapsed_time' => null, // 处理业务请求时间
		);
		
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

		/* 媒体文件（非样式图片、视频、音频等）所在目录名 */
		public $media_root;

		/* 需要显示的字段 */
		public $data_to_display;

        // 访问设备信息
        public $user_agent = array();

		// 客户端类型
        public $app_type;

		// 客户端版本号
        public $app_version;

		// 设备操作系统平台ios/android；非移动客户端传空值
        public $device_platform;

		// 设备唯一码；全小写
		protected $device_number;

		// 请求时间戳
		protected $timestamp;

		// 请求签名
		private $sign;

		public function __construct()
	    {
	        parent::__construct();

			// 向类属性赋值
			$this->timestamp = time();
			$this->app_type = 'client';
			$this->app_version = '0.0.1';
			$this->device_platform = 'web';
			$this->device_number = '';

            // 检查当前设备信息
            $this->user_agent_determine();
        } // end __construct

        /**
         * 截止3.1.3为止，CI_Controller类无析构函数，所以无需继承相应方法
         */
        public function __destruct()
        {
            // 如果已经打开测试模式，则输出调试信息
            if ($this->input->post_get('test_mode') === 'on')
                $this->output->enable_profiler(TRUE);
        } // end __destruct

        /**
         * 检查访问设备类型
         */
        protected function user_agent_determine()
        {
            // 获取当前设备信息
            $user_agent = $_SERVER['HTTP_USER_AGENT'];

            // 判断是否为移动端
            $this->user_agent['is_wechat'] = strpos($user_agent, 'MicroMessenger/')? TRUE: FALSE;
            $this->user_agent['is_ios'] = strpos($user_agent, 'like Mac OS')? TRUE: FALSE;
            $this->user_agent['is_android'] = strpos($user_agent, 'Android;')? TRUE: FALSE;
            $this->user_agent['is_mobile'] = ($this->user_agent['is_wechat'] || $this->user_agent['is_ios'] || $this->user_agent['is_android'])? TRUE: FALSE; // 移动端设备

            // 判断是否为非移动端
            $this->user_agent['is_macos'] = strpos($user_agent, 'Macintosh;')? TRUE: FALSE;
            $this->user_agent['is_linux'] = strpos($user_agent, 'Linux;')? TRUE: FALSE;
            $this->user_agent['is_windows'] = strpos($user_agent, 'Windows ')? TRUE: FALSE;
            $this->user_agent['is_desktop'] = ( ! $this->user_agent['is_mobile'])? TRUE: FALSE; // 非移动端设备
        } // user_agent_determine

		/**
		 * 签名有效性检查
		 *
		 * 依次检查签名的时间是否过期、参数是否完整、签名是否正确
		 *
		 * @params array sign_to_check 待检查的签名数据
		 */
		protected function sign_check($sign_to_check)
		{
			$this->sign_check_exits();
			$this->sign_check_time();
			$this->sign_check_params();
			$this->sign_check_string();
		}

		// 检查签名是否传入
		protected function sign_check_exits()
		{
			$this->sign = $this->input->post('sign');

			if ( empty($this->sign) ):
				$this->result['status'] = 444;
				$this->result['content']['error']['message'] = '未传入签名';
				exit();
			endif;
		}

		// 签名时间检查
		protected function sign_check_time()
		{
			$timestamp_sign = $this->input->post('timestamp');

			if ( empty($timestamp_sign) ):
				$this->result['status'] = 440;
				$this->result['content']['error']['message'] = '必要的签名参数未全部传入；安全起见不做具体提示，请参考开发文档。';
				exit();

			else:
				$this->timestamp = time();
				$time_difference = ($this->timestamp - $timestamp_sign);

				// 测试阶段签名有效期为600秒，生产环境应为60秒
				if ($time_difference > 600):
					$this->result['status'] = 441;
					$this->result['content']['error']['message'] = '签名时间已超过有效区间。';
					exit();

				else:
					return TRUE;

				endif;

			endif;
		}

		// 签名参数检查
		protected function sign_check_params()
		{
			// 检查需要参与签名的必要参数；
			$params_required = array(
				'app_type',
				'app_version',
				'device_platform',
				'device_number',
				'timestamp',
				'random',
			);

			// 获取传入的参数们
			$params = $_POST;

			// 检查必要参数是否已传入
			if ( array_intersect_key($params_required, array_keys($params)) !== $params_required ):
				$this->result['status'] = 440;
				$this->result['content']['error']['message'] = '必要的签名参数未全部传入；安全起见不做具体提示，请参考开发文档。';
			else:
				return TRUE;
			endif;
		}

		// 签名正确性检查
		protected function sign_check_string()
		{
			// 获取传入的参数们
			$params = $_POST;
			unset($params['sign']); // sign本身不参与签名计算

			// 生成参数
			$sign = $this->sign_generate($params);

			// 对比签名是否正确
			if ($this->sign !== $sign):
				$this->result['status'] = 449;
				$this->result['content']['error']['message'] = '签名错误，请参考开发文档。';
				$this->result['content']['sign_expected'] = $sign;
				$this->result['content']['sign_offered'] = $this->sign;
				exit();

			else:
				return TRUE;

			endif;
		}

		/**
		 * 生成签名
		 */
		protected function sign_generate($params)
		{
			// 对参与签名的参数进行排序
			ksort($params);

			// 对随机字符串进行SHA1计算
			$params['random'] = SHA1( $params['random'] );

			// 拼接字符串
			$param_string = '';
			foreach ($params as $key => $value)
				$param_string .= '&'. $key.'='.$value;

			// 拼接密钥
			$param_string .= '&key='. API_TOKEN;

			// 计算字符串SHA1值并转为大写
			$sign = strtoupper( SHA1($param_string) );

			return $sign;
		}

		/**
		 * 权限检查
		 *
		 * @param array $role_allowed 拥有相应权限的角色
		 * @param int $min_level 最低级别要求
		 * @return void
		 */
		protected function permission_check($role_allowed, $min_level)
		{
			// 目前管理员角色和级别
			$current_role = $this->session->role;
			$current_level = $this->session->level;

			// 检查执行此操作的角色及权限要求
			if ( ! in_array($current_role, $role_allowed)):
				redirect( base_url('error/permission_role') );
			elseif ( $current_level < $min_level):
				redirect( base_url('error/permission_level') );
			endif;
		}

        /**
         * 计算特定表数据量
         *
         * @params string $table_name 需要计数的表名
         * @params array $conditions 筛选条件
         * @return int/boolean
         */
        protected function count_table($table_name, $conditions = NULL)
        {
            $params['user_id'] = 'NULL'; // 默认可获取不属于当前用户的数据

            // 获取筛选条件
            if ( !empty($conditions) )
                $params = array_merge($params, $conditions);

            // 从API服务器获取相应列表信息
            $url = api_url($table_name. '/count');
            $result = $this->curl->go($url, $params, 'array');
            if ($result['status'] === 200):
                $count = $result['content']['count'];
            else:
                $count = 0; // 若获取失败则返回“0”
            endif;

            return $count;
        } // count_table

        // 将数组输出为key:value格式，主要用于在postman等工具中进行api测试
        protected function key_value($params)
        {
            foreach (array_filter($params) as $key => $value):
                echo $key .':' .$value ."\n";
            endforeach;
        } // end key_value

        /**
         * 拆分CSV为数组
         */
        protected function explode_csv($text, $seperator = ',')
        {
            // 清理可能存在的空字符、冗余分隔符
            $text = trim($text);
            $text = trim($text, $seperator);

            // 拆分文本为数组并清理可被转换为布尔型FALSE的数组元素（空数组、空字符、NULL、0、’0‘等）
            $array = array_filter( explode(',', $text) );

            return $array;
        } // end explode_csv

        /**
         * 获取批量操作时的ID数组
         *
         * @return array $ids 解析为数组的ID们
         */
        protected function parse_ids_array()
        {
            // 检查是否已传入必要参数
            if ( !empty($this->input->get_post('ids')) ):
                $ids = $this->input->get_post('ids');

                // 将字符串格式转换为数组格式
                if ( !is_array($ids) ):
                    $ids = explode(',', $ids);
                endif;

            elseif ( !empty($this->input->post('ids[]')) ):
                $ids = $this->input->post('ids[]');

            else:
                redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页

            endif;

            return $ids;
        } // end parse_ids_array

		// 解析购物车
		protected function cart_decode()
		{
			// 初始化商家及购物车项数组
			$data['bizs'] = $data['items'] = array();

			// 检查购物车是否为空，若空则直接返回相应提示，否则显示购物车详情
			if ( !empty($this->session->cart) ):
				// 拆分现购物车数组中各项，并获取商品信息
				$current_cart = $this->explode_csv($this->session->cart);

				// 获取各商品信息
				foreach ($current_cart as $cart_item):
					// 分解出item_id、sku_id、count等
					list($biz_id, $item_id, $sku_id, $count) = explode('|', $cart_item);

					// 获取商家信息
					$data['bizs']['biz_'.$biz_id] = $this->get_biz($biz_id);

					// 获取商品信息
					$item = $this->get_item($item_id);

					// 获取SKU信息（若有）
					if ($sku_id != 0) $item['sku'] = $this->get_sku($sku_id);

					$item['count'] = $count; // 数量保持原状
					$data['items'][] = $item; // 推入商品信息数组
				endforeach;

			endif;

			return $data;
		} // end cart_decode

		// 检查商品是否已在购物车中
		protected function in_cart($item_to_check)
		{
			$current_cart = $this->session->cart;
			// 检查购物车中是否有商品
			if ( empty($current_cart) ):
				return FALSE;

			// 检查当前商品是否在购物车中
			else:
				$start_from = strpos(','.$current_cart, ','.$item_to_check);
				if ( $start_from === FALSE ):
					return FALSE;

				// 获取购物车中相应商品信息数组（考虑到多规格情况）
				else:
					// 拆分现购物车数组中各项，并获取商品信息
					$current_cart = $this->explode_csv($this->session->cart);

					// 创建购物车项数组
					$cart_items = array();

					// 获取吻合的购物车项
					foreach ($current_cart as $cart_item):
						// 将待加量项加量
						if ( strpos($cart_item, $item_to_check) !== FALSE ):
							$cart_items[] = $cart_item;
						endif;
					endforeach;

					return $cart_items;

				endif;

			endif;
		} // end in_cart

		// 获取商家列表
		protected function list_biz()
		{
			// 从API服务器获取相应列表信息
            $params['user_id'] = 'NULL'; // 可获取不属于当前用户的数据
			$params['time_delete'] = 'NULL';

			$url = api_url('biz/index');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['items'] = $result['content'];
			else:
				$data['items'] = NULL;
			endif;

			return $data['items'];
		} // end list_biz
		
		// 获取特定商家信息
		protected function get_biz($id)
		{
			// 从API服务器获取相应列表信息
			$params['id'] = $id;
            $params['user_id'] = 'NULL'; // 可获取不属于当前用户的数据
			$params['time_delete'] = 'NULL';

			$url = api_url('biz/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['item'] = $result['content'];
			else:
				$data['item'] = NULL;
			endif;

			return $data['item'];
		} // end get_biz

		// 获取特定商品信息
		protected function get_item($id)
		{
			// 从API服务器获取相应列表信息
			$params['id'] = $id;
            $params['user_id'] = 'NULL'; // 可获取不属于当前用户的数据
			$params['time_delete'] = 'NULL';

			$url = api_url('item/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['item'] = $result['content'];
			else:
				$data['item'] = NULL;
			endif;
			
			return $data['item'];
		} // end get_item
		
		// 获取商品列表
		protected function list_sku($item_id = NULL)
		{	
			if ( !empty($item_id) )
			    $params['item_id'] = $item_id;
            $params['user_id'] = 'NULL'; // 可获取不属于当前用户的数据
			$params['time_delete'] = 'NULL';

			// 从API服务器获取相应列表信息
			$url = api_url('sku/index');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['items'] = $result['content'];
			else:
				$data['items'] = NULL;
			endif;
			
			return $data['items'];
		} // end list_sku

		// 获取特定商品信息
		protected function get_sku($id)
		{
			// 从API服务器获取相应列表信息
			$params['id'] = $id;
            $params['user_id'] = 'NULL'; // 默认可获取不属于当前用户的数据
			$params['time_delete'] = 'NULL';

			$url = api_url('sku/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['item'] = $result['content'];
			else:
				$data['item'] = NULL;
			endif;
			
			return $data['item'];
		} // end get_sku
		
		// 获取品牌列表
		protected function list_brand()
		{
			// 从API服务器获取相应列表信息
            $params['user_id'] = 'NULL'; // 默认可获取不属于当前用户的数据
			$params['time_delete'] = 'NULL';

			$url = api_url('brand/index');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['items'] = $result['content'];
			else:
				$data['items'] = NULL;
			endif;

			return $data['items'];
		} // end list_brand
		
		// 获取特定品牌信息
		protected function get_brand($id)
		{
			// 从API服务器获取相应列表信息
			$params['id'] = $id;
            $params['user_id'] = 'NULL'; // 默认可获取不属于当前用户的数据
			$params['time_delete'] = 'NULL';

			$url = api_url('brand/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['item'] = $result['content'];
			else:
				$data['item'] = NULL;
			endif;
			
			return $data['item'];
		} // end get_brand

        // 获取系统分类列表
        protected function list_category($level = 1)
        {
            $params['user_id'] = 'NULL'; // 默认可获取不属于当前用户的数据
            $params['time_delete'] = 'NULL';
            $params['level'] = $level;

            // 从API服务器获取相应列表信息
            $url = api_url('item_category/index');
            $result = $this->curl->go($url, $params, 'array');
            if ($result['status'] === 200):
                $data['items'] = $result['content'];
            else:
                $data['items'] = NULL;
            endif;

            return $data['items'];
        } // end list_category
		
		// 获取特定系统分类信息
		protected function get_category($id)
		{
			// 从API服务器获取相应列表信息
			$params['id'] = $id;
            $params['user_id'] = 'NULL'; // 默认可获取不属于当前用户的数据
			$params['time_delete'] = 'NULL';
			
			$url = api_url('item_category/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['item'] = $result['content'];
			else:
				$data['item'] = NULL;
			endif;
			
			return $data['item'];
		} // end get_category
		
		// 获取商家分类列表
		protected function list_category_biz($id = NULL)
		{
		    $params['biz_id'] = $id;
            $params['user_id'] = 'NULL'; // 默认可获取不属于当前用户的数据
			$params['time_delete'] = 'NULL';

			// 从API服务器获取相应列表信息
			$url = api_url('item_category_biz/index');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['items'] = $result['content'];
			else:
				$data['items'] = NULL;
			endif;
			
			return $data['items'];
		} // end list_category_biz
		
		// 获取特定商家分类信息
		protected function get_category_biz($id)
		{
			// 从API服务器获取相应列表信息
			$params['id'] = $id;
            $params['user_id'] = 'NULL'; // 默认可获取不属于当前用户的数据
			$params['time_delete'] = 'NULL';

			$url = api_url('item_category_biz/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['item'] = $result['content'];
			else:
				$data['item'] = NULL;
			endif;
			
			return $data['item'];
		} // end get_category_biz
		
		// 获取店内活动详情
		protected function get_promotion_biz($id)
		{
			// 从API服务器获取相应列表信息
			$params['id'] = $id;
            $params['user_id'] = 'NULL'; // 默认可获取不属于当前用户的数据
			$params['time_delete'] = 'NULL';

			$url = api_url('promotion_biz/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['item'] = $result['content'];
			else:
				$data['item'] = NULL;
			endif;
			
			return $data['item'];
		} // end get_promotion_biz
		
		// 获取特定商家运费模板详情
		protected function get_freight_template_biz($id)
		{
			// 从API服务器获取相应列表信息
			$params['id'] = $id;
            $params['user_id'] = 'NULL'; // 默认可获取不属于当前用户的数据
			$params['time_delete'] = 'NULL';

			$url = api_url('freight_template_biz/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['item'] = $result['content'];
			else:
				$data['item'] = NULL;
			endif;
			
			return $data['item'];
		} // end get_freight_template_biz

		// 获取当前用户可用地址列表
		protected function list_address()
		{
			// 从API服务器获取相应列表信息
			$params['time_delete'] = 'NULL';

			$url = api_url('address/index');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['items'] = $result['content'];
			else:
				$data['items'] = NULL;
			endif;

			return $data['items'];
		} // end list_address

    } // end class MY_Controller

/* End of file MY_Controller.php */
/* Location: ./application/controllers/MY_Controller.php */