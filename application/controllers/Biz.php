<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Biz 商家类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Biz extends MY_Controller
	{	
		/**
		 * 可作为列表筛选条件的字段名；可在具体方法中根据需要删除不需要的字段并转换为字符串进行应用，下同
		 */
		protected $names_to_sort = array(
			'longitude', 'latitude', 'nation', 'province', 'city', 'county', 'time_create', 'time_delete', 'time_edit', 'creator_id', 'operator_id', 'status',
		);

		public function __construct()
		{
			parent::__construct();

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '商家'; // 改这里……
			$this->table_name = 'biz'; // 和这里……
			$this->id_name = 'biz_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 视图文件所在目录
			$this->media_root = MEDIA_URL. $this->class_name.'/'; // 媒体文件所在目录
		} // end __construct
		
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

			// 从API服务器获取相应列表信息
			$params = $condition;
			$url = api_url($this->class_name. '/index');
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
		 * 详情页
		 */
		public function detail()
		{
			// 检查是否已传入必要参数
			$id = $this->input->get_post('id')? $this->input->get_post('id'): NULL;
			if ( !empty($id) ):
				$params['id'] = $id;
			else:
				redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页
			endif;

			// 从API服务器获取相应详情信息
			$url = api_url($this->class_name. '/detail');
			$result = $this->curl->go($url, $params, 'array');
			if ($result['status'] !== 200):
				$data['error'] = $result['content']['error']['message'];

			else:
				$data['item'] = $result['content'];

				// 获取该商家商品未删除商品
				$params['time_delete'] = 'NULL';
				$params['biz_id'] = $id;
				$url = api_url('item/index');
				$result = $this->curl->go($url, $params, 'array');
				if ($result['status'] === 200):
					$data['items'] = $result['content'];
				else:
                    $data['items'] = array();
					$data['error'] = $result['content']['error']['message'];
				endif;
				
				// 获取该商家店铺装修方案
				if ( !empty($data['item']['ornament']) ):
                    $ornament = $data['item']['ornament'];

                    // 获取顶部模块装修商品；忽略是否下架或删除
                    if ( !empty( $ornament['home_m0_ids'] ) ):
                        $params['biz_id'] = $id;
                        $params['ids'] = $ornament['home_m0_ids'];
                        $url = api_url('item/index');
                        $result = $this->curl->go($url, $params, 'array');
                        if ($result['status'] === 200):
                            $data['item']['m0_items'] = $result['content'];
                        else:
                            $data['error'] = $result['content']['error']['message'];
                        endif;
                    endif;

					// 获取模块一装修商品；忽略是否下架或删除
					if ( !empty( $ornament['home_m1_ids'] ) ):
						$params['biz_id'] = $id;
						$params['ids'] = $ornament['home_m1_ids'];
						$url = api_url('item/index');
						$result = $this->curl->go($url, $params, 'array');
						if ($result['status'] === 200):
							$data['item']['m1_items'] = $result['content'];
						else:
							$data['error'] = $result['content']['error']['message'];
						endif;
					endif;
					
					// 获取模块二装修商品；忽略是否下架或删除
					if ( !empty( $ornament['home_m2_ids'] ) ):
						$params['biz_id'] = $id;
						$params['ids'] = $ornament['home_m2_ids'];
						$url = api_url('item/index');
						$result = $this->curl->go($url, $params, 'array');
						if ($result['status'] === 200):
							$data['item']['m2_items'] = $result['content'];
						else:
							$data['error'] = $result['content']['error']['message'];
						endif;
					endif;

					// 获取模块三装修商品；忽略是否下架或删除
					if ( !empty( $ornament['home_m3_ids'] ) ):
						$params['biz_id'] = $id;
						$params['ids'] = $ornament['home_m3_ids'];
						$url = api_url('item/index');
						$result = $this->curl->go($url, $params, 'array');
						if ($result['status'] === 200):
							$data['item']['m3_items'] = $result['content'];
						else:
							$data['error'] = $result['content']['error']['message'];
						endif;
					endif;
				endif;
				
			endif;

			// 页面信息
			$data['title'] = isset($data['item'])? $data['item']['brief_name']: $this->class_name_cn. '详情';
			$data['class'] = $this->class_name.' detail';

			// 输出视图
			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/detail', $data);
			$this->load->view('templates/footer', $data);
		} // end detail

	} // end class Biz

/* End of file Biz.php */
/* Location: ./application/controllers/Biz.php */
