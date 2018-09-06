<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Home 首页类
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
        } // __construct

		/**
         * 首页
         */
		public function index()
		{
           // 页面信息
            $data = array(
                'title' => NULL, // 直接使用默认标题
                'class' => $this->class_name, // 页面body标签的class属性值
                'message' => isset($_GET['message']) && $_GET['message'] == 'none' ? '商品已经被抢光啦' : ''
            );
            
            // 获取商家列表
              $data['bizs'] = $this->list_biz();
              $redis = new Redis();  
              $redis->connect('47.100.19.150',6379);
              $xmldata = unserialize($redis->get('homepage'));
              //轮播图数据
              $data['broadcastlist'] = $xmldata['broadcastlist']['broadcast'];
              //第一部分
              $data['part0'] = $xmldata['partlist']['part'][0];
              $data['part1'] = $xmldata['partlist']['part'][1];
              $data['part2'] = $xmldata['partlist']['part'][2];
              $data['part3'] = $xmldata['partlist']['part'][3];
              $data['part4'] = $xmldata['partlist']['part'][4];
              $data['part5'] = $xmldata['partlist']['part'][5];
              $data['part6'] = $xmldata['partlist']['part'][6];
              $data['part7'] = $xmldata['partlist']['part'][7];
              $data['part8'] = $xmldata['partlist']['part'][8];
              if (isset($xmldata['partlist']['part'][9])) {
                  $data['part9'] = $xmldata['partlist']['part'][9];  
                }

            // 载入视图
            
            $this->load->view('templates/header', $data);
            $this->load->view('newhome', $data);
            $this->load->view('templates/nav-main', $data);
            $this->load->view('templates/footer', $data);
		} // end index
        public function testindex()
        {

            // 页面信息
            $data = array(
                'title' => NULL, // 直接使用默认标题
                'class' => $this->class_name, // 页面body标签的class属性值
            );
            
            // 获取商家列表
              $data['bizs'] = $this->list_biz();
              $redis = new Redis();  
              $redis->connect('47.100.19.150',6379);
              $xmldata = unserialize($redis->get('homepage'));
              //轮播图数据
              $data['broadcastlist'] = $xmldata['broadcastlist']['broadcast'];
              //第一部分
              $data['part0'] = $xmldata['partlist']['part'][0];
              $data['part1'] = $xmldata['partlist']['part'][1];
              $data['part2'] = $xmldata['partlist']['part'][2];
              $data['part3'] = $xmldata['partlist']['part'][3];
              $data['part4'] = $xmldata['partlist']['part'][4];
              $data['part5'] = $xmldata['partlist']['part'][5];
              $data['part6'] = $xmldata['partlist']['part'][6];
              $data['part7'] = $xmldata['partlist']['part'][7];
              $data['part8'] = $xmldata['partlist']['part'][8];

            // 载入视图
            $this->load->view('templates/header', $data);
            $this->load->view('newhome', $data);
            $this->load->view('templates/nav-main', $data);
            $this->load->view('templates/footer', $data);
        } // end index

        /**
         * 路由页
         *
         * 提供iOS、Android下载地址，及客户端/商家端微信公众号、移动端二维码
         */
        public function gateway()
        {
            // 页面信息
            $data = array(
                'title' => NULL, // 直接使用默认标题
                'class' => $this->class_name. ' gateway', // 页面body标签的class属性值
            );

            // 载入视图
            $this->load->view('templates/header-simple', $data);
            if ($this->user_agent['is_desktop'] === TRUE):
                $this->load->view('home/gateway-desktop', $data);
            else:
                $this->load->view('home/gateway-mobile', $data);
            endif;
            $this->load->view('templates/footer', $data);
        } // end gateway

	} // end class Home

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
