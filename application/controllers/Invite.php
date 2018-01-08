<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Invite 邀请类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Invite extends MY_Controller
	{
		public function __construct()
		{
			parent::__construct();

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '邀请'; // 改这里……
			$this->table_name = 'user'; // 和这里……
			$this->id_name = 'user_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 视图文件所在目录
			$this->media_root = MEDIA_URL. 'user/'; // 媒体文件所在目录
		} // __construct

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

			$code = $this->encode($this->session->user_id);
			
			// 筛选条件
			//$condition['promoter_id'] = $this->session->user_id;
            $condition['promoter_id'] = 1;
            $condition['user_id'] = 'NULL';

			// 从API服务器获取相应列表信息
			$params = $condition;
			$url = api_url('user/index');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['items'] = $result['content'];
			else:
				$data['error'] = $result['content']['error']['message'];
			endif;

			// 输出视图
			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/index', $data);
			$this->load->view('templates/footer', $data);
		} // end index

		/**
		 * 确认邀请
         *
         * 输入邀请码
		 */
		public function verify()
		{
            // 页面信息
            $data = array(
                'title' => '确认'. $this->class_name_cn,
                'class' => $this->class_name.' verify',
            );

		    echo $this->encode('promoter_id=1');

            echo '<br>';

		    echo $this->decode('%3D%3DDZ9DJnsWKM09JoiWUp9XQvbW%3DHQ%3DM9cZaWJJf0');

            // 输出视图
            $this->load->view('templates/header', $data);
            $this->load->view($this->view_root.'/verify', $data);
            $this->load->view('templates/footer', $data);
		} // end verify

        /**
         * 接受邀请
         *
         * 直接点击
         */
        public function accept()
        {
            // 页面信息
            $data = array(
                'title' => '接受'. $this->class_name_cn,
                'class' => $this->class_name.' accept',
            );

            // 输出视图
            $this->load->view('templates/header', $data);
            $this->load->view($this->view_root.'/accept', $data);
            $this->load->view('templates/footer', $data);
        } // end accept

        /**
         * TODO 领取成功
         *
         * 仅供测试，需删除
         */
        public function result()
        {
            // 页面信息
            $data = array(
                'title' => '成功接受'. $this->class_name_cn,
                'class' => $this->class_name.' accept',
            );

            // 输出视图
            $this->load->view('templates/header', $data);
            $this->load->view($this->view_root.'/result', $data);
            $this->load->view('templates/footer', $data);
        } // end accept

        /**
         * 以下为工具方法
         */


        /**
         * 对明码参数进行加密
         *
         * @param string $link 待处理的参数
         * @return string $code 加密后的参数
         */
        protected function encode($link)
        {
            // str_shuffle() 函数生成的随机乱序字符串纯为干扰用
            $code = strrev(str_rot13( str_rot13(str_shuffle(base64_encode($link))).base64_encode($link) ));

            $code = rawurlencode($code);

            return $code;
        } // end encode

        /**
         * 对加密链接进行解密
         *
         * @param string $code 待处理的参数
         * @return string $link 解密后的参数
         */
        protected function decode($code)
        {
            $code = rawurldecode($code);

            // 忽略占总字符串长度一半，起干扰作用的字符串
            $link = substr(strrev($code), (- strlen(strrev($code)) / 2)); // 从字符串末尾开始截取
            $link = base64_decode( str_rot13($link) );

            return $link;
        } // end decode

	} // end class Invite

/* End of file Invite.php */
/* Location: ./application/controllers/Invite.php */
