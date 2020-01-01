<?php
	defined('BASEPATH') OR exit('此文件不可被直接访问');

	/**
	 * Item_category_biz/IBK 店内商品分类
	 *
	 * @version 1.0.0
	 * @author Kamas 'Iceberg' Lau <kamaslau@outlook.com>
	 * @copyright ICBG <www.bingshankeji.com>
	 */
	class Item_category_biz extends MY_Controller
	{	
		/**
		 * 可作为列表筛选条件的字段名；可在具体方法中根据需要删除不需要的字段并转换为字符串进行应用，下同
		 */
		protected $names_to_sort = array(
			'biz_id', 'parent_id', 'name',
			'time_create', 'time_delete', 'time_edit', 'creator_id', 'operator_id',
		);

		public function __construct()
		{
			parent::__construct();

			// 向类属性赋值
			$this->class_name = strtolower(__CLASS__);
			$this->class_name_cn = '店内商品分类'; // 改这里……
			$this->table_name = 'item_category_biz'; // 和这里……
			$this->id_name = 'category_id'; // 还有这里，OK，这就可以了
			$this->view_root = $this->class_name; // 视图文件所在目录
			$this->media_root = MEDIA_URL. $this->class_name.'/'; // 媒体文件所在目录
		} // end __construct

		/**
		 * 列表页
		 */
		public function index()
		{
            // 检查必要参数
            $biz_id = $this->input->get_post('biz_id');
            if ( empty($biz_id) )
                redirect( base_url('error/code_400') ); // 若缺少参数，转到错误提示页

			// 页面信息
			$data = array(
				'title' => $this->class_name_cn,
				'class' => $this->class_name.' index',
                'biz_id' => $biz_id,
			);

			// 筛选条件
			$condition['time_delete'] = 'NULL';
			// （可选）遍历筛选条件
			foreach ($this->names_to_sort as $sorter):
				if ( !empty($this->input->get_post($sorter)) )
					$condition[$sorter] = $this->input->get_post($sorter);
			endforeach;

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
                $data['items'] = array();
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
			if ($result['status'] === 200):
				$data['item'] = $result['content'];

				// 获取所属商品分类信息
				//$data['category_biz'] = $this->get_category_biz($data['item']['parent_id']);

                // 页面信息
                $data['title'] = $this->class_name_cn. ' "'.$data['item']['name']. '"';
                $data['class'] = $this->class_name.' detail';

            else:
                redirect( base_url('error/code_404') ); // 若缺少参数，转到错误提示页

            endif;

			// 输出视图
			$this->load->view('templates/header', $data);
			$this->load->view($this->view_root.'/detail', $data);
			$this->load->view('templates/footer', $data);
		} // end detail

        /**
         * 删除
         *
         * 不可删除
         */
        public function delete()
        {
            exit('不可删除'.$this->class_name_cn.'；您意图违规操作的记录已被发送到安全中心。');
        } // end delete

        /**
         * 找回
         *
         * 不可找回
         */
        public function restore()
        {
            exit('不可找回'.$this->class_name_cn.'；您意图违规操作的记录已被发送到安全中心。');
        } // end restore

        /**
         * 以下为工具类方法
         */

	} // end class Item_category_biz

/* End of file Item_category_biz.php */
/* Location: ./application/controllers/Item_category_biz.php */
