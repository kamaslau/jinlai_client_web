<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Page 页面类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Page extends MY_Controller
	{	
		/**
		 * 可作为列表筛选条件的字段名；可在具体方法中根据需要删除不需要的字段并转换为字符串进行应用，下同
		 */
		protected $names_to_sort = array(
			'page_id', 'name', 'url_name', 'description', 'content_type', 'content_html', 'content_file', 'time_create', 'time_delete', 'time_edit', 'creator_id', 'operator_id',
		);

		public function __construct()
		{
			parent::__construct();

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '页面'; // 改这里……
			$this->table_name = 'page'; // 和这里……
			$this->id_name = 'page_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 视图文件所在目录
			$this->media_root = MEDIA_URL. $this->class_name.'/'; // 媒体文件所在目录
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

			// 筛选条件
			$condition['time_delete'] = 'NULL';
			// （可选）遍历筛选条件
			foreach ($this->names_to_sort as $sorter):
				if ( !empty($this->input->post($sorter)) )
					$condition[$sorter] = $this->input->post($sorter);
			endforeach;

			// 排序条件
			$order_by = NULL;

			// 从API服务器获取相应列表信息
			$params = $condition;
			$url = api_url($this->class_name. '/index');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] === 200):
				$data['items'] = $result['content'];
			else:
				$data['error'] = $result['content']['error']['message'];
			endif;

			// 将需要显示的数据传到视图以备使用
			$data['data_to_display'] = $this->data_to_display;

			// 输出视图
			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/index', $data);
			$this->load->view('templates/footer', $data);
		} // end index

		/**
		 * 详情页
		 */
		public function detail($url_name = NULL)
		{
            // 检查是否已传入必要参数
            $id = $this->input->get_post('id')? $this->input->get_post('id'): NULL;
            if ( !empty($id) ):
                $params['id'] = $id;
            elseif ( !empty($url_name) ):
                $params['url_name'] = $url_name;
            else:
                redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页
            endif;

            // 从API服务器获取相应详情信息
            $url = api_url($this->class_name. '/detail');
            $result = $this->curl->go($url, $params, 'array');
            if ($result['status'] === 200):
                $data['item'] = $result['content'];

                // 页面信息
                $data['title'] = isset($data['item'])? $data['item']['name']: $this->class_name_cn. '详情';
                $data['class'] = $this->class_name.' detail';

                // 输出视图
                if ($data['item']['page_id'] == 7):
                    $this->load->view('templates/header-page', $data);
                else:
                    $this->load->view('templates/header', $data);
                endif;

                $this->load->view($this->view_root.'/'.$data['item']['content_file'], $data);
                $this->load->view('templates/footer', $data);

            else:
                redirect( base_url('error/code_404') ); // 若缺少参数，转到错误提示页

            endif;
		} // end detail
		/**
		 * 测试详情页
		 */
		public function newdetail($url_name = NULL)
		{	
			
            // 检查是否已传入必要参数
            $id = $this->input->get_post('id')? $this->input->get_post('id'): NULL;
            if ( !empty($id) ):
                $params['id'] = $id;
                $data['classtype'] = $id;
            else:
                redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页
            endif;

            // 从API服务器获取相应详情信息
            $url = api_url($this->class_name. '/detail');
            $result = $this->curl->go($url, $params, 'array');
            if ($result['status'] === 200):
                $data['item'] = $result['content'];
                // 页面信息
                $data['title'] = isset($data['item'])? $data['item']['name']: $this->class_name_cn. '详情';
                $data['class'] = $this->class_name.' detail';
                 $redis = new Redis();  
	             $redis->connect('47.100.19.150',6379);
	             if($redis->exists('classpage_'. $id)){
	             $data['xmldata'] = unserialize($redis->get('classpage_'. $id));
	         }else{
	         	  redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页
	         }
                // 输出视图
                $this->load->view('templates/header', $data);
                $this->load->view('page/newclasspage', $data);
                $this->load->view('templates/footer', $data);

            else:
                redirect( base_url('error/code_404') ); // 若缺少参数，转到错误提示页

            endif;
		} // end detail

		/**
		 * 测试详情页
		 */
		public function tabdetail($url_name = NULL)
		{	
            // 检查是否已传入必要参数
            $id = $this->input->get_post('id')? $this->input->get_post('id'): NULL;
            if ( !empty($id) ):
                $params['id'] = $id;
                $data['classtype'] = $id;
            else:
                redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页
            endif;

            // 从API服务器获取相应详情信息
            //$url = api_url($this->class_name. '/detail');
            $result = ['status'=>200];//$this->curl->go($url, $params, 'array');
            if ($result['status'] === 200):
                //$data['item'] = $result['content'];
                // 页面信息
                $data['title'] = isset($data['item'])? $data['item']['name']: $this->class_name_cn. '详情';
                $data['class'] = $this->class_name.' detail';
                 $redis = new Redis();  
	             $redis->connect('47.100.19.150',6379);
	             if($redis->exists('classpage_'. $id)){
	             $data['xmldata'] = unserialize($redis->get('classpage_'. $id));
	         }else{
	         	  redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页
	         }
                // 输出视图
                $this->load->view('templates/header', $data);
                $this->load->view('page/tabclass', $data);
                $this->load->view('templates/footer', $data);

            else:
                redirect( base_url('error/code_404') ); // 若缺少参数，转到错误提示页

            endif;
		} // end detail

		public function festival(){
			$data = [];
			// 输出视图
            $this->load->view('templates/header', $data);
            $this->load->view('page/festival', $data);
            $this->load->view('templates/footer', $data);
		}
	} // end class Page

/* End of file Page.php */
/* Location: ./application/controllers/Page.php */
