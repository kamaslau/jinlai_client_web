<style>


	/* 宽度在750像素以上的设备 */
	@media only screen and (min-width:751px)
	{
		
	}
	
	/* 宽度在960像素以上的设备 */
	@media only screen and (min-width:961px)
	{

	}

	/* 宽度在1280像素以上的设备 */
	@media only screen and (min-width:1281px)
	{

	}
</style>

<div id=breadcrumb>
	<ol class="breadcrumb container">
		<li><a href="<?php echo base_url() ?>">首页</a></li>
		<li><a href="<?php echo base_url($this->class_name) ?>"><?php echo $this->class_name_cn ?></a></li>
		<li class=active><?php echo $title ?></li>
	</ol>
</div>

<div id=content class=container>
	<?php
	// 需要特定角色和权限进行该操作
	$current_role = $this->session->role; // 当前用户角色
	$current_level = $this->session->level; // 当前用户级别
	$role_allowed = array('管理员', '经理');
	$level_allowed = 30;
	if ( in_array($current_role, $role_allowed) && ($current_level >= $level_allowed) ):
	?>
	<div class=btn-group role=group>
		<a class="btn btn-default" title="所有<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>"><i class="fa fa-list fa-fw" aria-hidden=true></i> 所有<?php echo $this->class_name_cn ?></a>
	  	<a class="btn btn-default" title="<?php echo $this->class_name_cn ?>回收站" href="<?php echo base_url($this->class_name.'/trash') ?>"><i class="fa fa-trash fa-fw" aria-hidden=true></i> 回收站</a>
		<a class="btn btn-default" title="创建<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name.'/create') ?>"><i class="fa fa-plus fa-fw" aria-hidden=true></i> 创建<?php echo $this->class_name_cn ?></a>
	</div>
	<?php endif ?>
	
	<ul class=list-unstyled>
		<?php
		// 需要特定角色和权限进行该操作
		if ( in_array($current_role, $role_allowed) && ($current_level >= $level_allowed) ):
		?>
		<li><a title="编辑" href="<?php echo base_url($this->class_name.'/edit?id='.$item[$this->id_name]) ?>" target=_blank><i class="fa fa-edit"></i> 编辑</a></li>
		<?php endif ?>
	</ul>

	<dl id=list-info class=dl-horizontal>
		<dt>简称</dt>
		<dd><?php echo empty($item['brief'])? '未设置': $item['brief'] ?></dd>
		<dt>姓名</dt>
		<dd><?php echo $item['fullname'] ?></dd>
		<dt>手机号</dt>
		<dd><?php echo $item['mobile'] ?></dd>

		<dt>邮政编码</dt>
		<dd><?php echo $item['zipcode'] ?></dd>
		<dt>地址</dt>
		<dd>
			<p>
				<?php echo $item['nation'] ?> <?php echo $item['province'] ?>省 <?php echo $item['city'] ?>市 <?php echo $item['county'] ?>区/县<br>
				<?php echo $item['street'] ?>
			</p>
			
			<?php if ( !empty($item['longitude']) && !empty($item['latitude']) ): ?>
			<figure class="row">
				<figcaption>
					<p class=help-block>经纬度 <?php echo $item['longitude'] ?>, <?php echo $item['latitude'] ?></p>
				</figcaption>
				<div id=map style="height:300px;background-color:#aaa"></div>
			</figure>
			
			<script src="https://webapi.amap.com/maps?v=1.3&key=d698fd0ab2d88ad11f4c6a2c0e83f6a8"></script>
			<script src="https://webapi.amap.com/ui/1.0/main.js"></script>
			<script>
				var lnglat = [<?php echo $item['longitude'] ?>, <?php echo $item['latitude'] ?>];
			    var map = new AMap.Map('map',{
					center: lnglat,
			        zoom: 16,
		            scrollWheel: false,
					mapStyle: 'amap://styles/2daddd87cfd0fa58d0bc932eed31b9d8', // 自定义样式
			    });
				marker = new AMap.Marker({
		            position: lnglat,
		        });
		        marker.setMap(map);

				// 为BasicControl设置DomLibrary，jQuery
				AMapUI.setDomLibrary($);
				AMapUI.loadUI(['control/BasicControl'], function(BasicControl) {
					// 缩放控件
				    map.addControl(new BasicControl.Zoom({
				        position: 'rb', // 右下角
				    }));
				});
			</script>
			<?php endif ?>
		</dd>
	</dl>

	<dl id=list-record class=dl-horizontal>
		<dt>创建时间</dt>
		<dd>
			<?php echo $item['time_create'] ?>
			<a href="<?php echo base_url('stuff/detail?id='.$item['creator_id']) ?>" target=new>查看创建者</a>
		</dd>

		<?php if ( ! empty($item['time_delete']) ): ?>
		<dt>删除时间</dt>
		<dd><?php echo $item['time_delete'] ?></dd>
		<?php endif ?>

		<?php if ( ! empty($item['operator_id']) ): ?>
		<dt>最后操作时间</dt>
		<dd>
			<?php echo $item['time_edit'] ?>
			<a href="<?php echo base_url('stuff/detail?id='.$item['operator_id']) ?>" target=new>查看最后操作者</a>
		</dd>
		<?php endif ?>
	</dl>
</div>