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

<base href="<?php echo $this->media_root ?>">

<div id=breadcrumb>
	<ol class="breadcrumb container">
		<li><a href="<?php echo base_url() ?>">首页</a></li>
		<li><a href="<?php echo base_url($this->class_name) ?>"><?php echo $this->class_name_cn ?></a></li>
		<li class=active><?php echo $title ?></li>
	</ol>
</div>

<div id=content class=container>
	<div class=btn-group role=group>
		<a class="btn btn-default" title="所有<?php echo $this->class_name_cn ?>" href="<?php echo base_url($this->class_name) ?>"><i class="fa fa-list fa-fw" aria-hidden=true></i> 所有<?php echo $this->class_name_cn ?></a>
	  	<a class="btn btn-default" title="<?php echo $this->class_name_cn ?>回收站" href="<?php echo base_url($this->class_name.'/trash') ?>"><i class="fa fa-trash fa-fw" aria-hidden=true></i> 回收站</a>
	</div>
	<?php endif ?>

	<?php
		if ( !empty($error) ) echo '<div class="alert alert-warning" role=alert>'.$error.'</div>';
		$attributes = array('class' => 'form-'.$this->class_name.'-create form-horizontal', 'role' => 'form');
		echo form_open_multipart($this->class_name.'/create', $attributes);
	?>
		<p class="help-block">必填项以“※”符号标示</p>

		<fieldset>
			<div class=form-group>
				<label for=biz_id class="col-sm-2 control-label">商户ID</label>
				<div class=col-sm-10>
					<input class=form-control name=biz_id type=text value="<?php echo set_value('biz_id') ?>" placeholder="商户ID" required>
				</div>
			</div>
			<div class=form-group>
				<label for=user_id class="col-sm-2 control-label">用户ID</label>
				<div class=col-sm-10>
					<input class=form-control name=user_id type=text value="<?php echo set_value('user_id') ?>" placeholder="用户ID" required>
				</div>
			</div>
			<div class=form-group>
				<label for=user_ip class="col-sm-2 control-label">用户下单IP地址</label>
				<div class=col-sm-10>
					<input class=form-control name=user_ip type=text value="<?php echo set_value('user_ip') ?>" placeholder="用户下单IP地址" required>
				</div>
			</div>
			<div class=form-group>
				<label for=promotion_id class="col-sm-2 control-label">营销活动ID</label>
				<div class=col-sm-10>
					<input class=form-control name=promotion_id type=text value="<?php echo set_value('promotion_id') ?>" placeholder="营销活动ID" required>
				</div>
			</div>
			<div class=form-group>
				<label for=fullname class="col-sm-2 control-label">收件人全名</label>
				<div class=col-sm-10>
					<input class=form-control name=fullname type=text value="<?php echo set_value('fullname') ?>" placeholder="收件人全名" required>
				</div>
			</div>
			<div class=form-group>
				<label for=mobile class="col-sm-2 control-label">收件人手机号</label>
				<div class=col-sm-10>
					<input class=form-control name=mobile type=text value="<?php echo set_value('mobile') ?>" placeholder="收件人手机号" required>
				</div>
			</div>
			<div class=form-group>
				<label for=province class="col-sm-2 control-label">收件人省份</label>
				<div class=col-sm-10>
					<input class=form-control name=province type=text value="<?php echo set_value('province') ?>" placeholder="收件人省份" required>
				</div>
			</div>
			<div class=form-group>
				<label for=city class="col-sm-2 control-label">收件人城市</label>
				<div class=col-sm-10>
					<input class=form-control name=city type=text value="<?php echo set_value('city') ?>" placeholder="收件人城市" required>
				</div>
			</div>
			<div class=form-group>
				<label for=county class="col-sm-2 control-label">收件人区/县</label>
				<div class=col-sm-10>
					<input class=form-control name=county type=text value="<?php echo set_value('county') ?>" placeholder="收件人区/县" required>
				</div>
			</div>
			<div class=form-group>
				<label for=street class="col-sm-2 control-label">收件人具体地址</label>
				<div class=col-sm-10>
					<input class=form-control name=street type=text value="<?php echo set_value('street') ?>" placeholder="收件人具体地址" required>
				</div>
			</div>
			<div class=form-group>
				<label for=longitude class="col-sm-2 control-label">经度</label>
				<div class=col-sm-10>
					<input class=form-control name=longitude type=text value="<?php echo set_value('longitude') ?>" placeholder="经度" required>
				</div>
			</div>
			<div class=form-group>
				<label for=latitude class="col-sm-2 control-label">纬度</label>
				<div class=col-sm-10>
					<input class=form-control name=latitude type=text value="<?php echo set_value('latitude') ?>" placeholder="纬度" required>
				</div>
			</div>
			<div class=form-group>
				<label for=note_user class="col-sm-2 control-label">用户留言</label>
				<div class=col-sm-10>
					<input class=form-control name=note_user type=text value="<?php echo set_value('note_user') ?>" placeholder="用户留言" required>
				</div>
			</div>

		</fieldset>

		<div class=form-group>
		    <div class="col-xs-12 col-sm-offset-2 col-sm-2">
				<button class="btn btn-primary btn-lg btn-block" type=submit>确定</button>
		    </div>
		</div>
	</form>

</div>