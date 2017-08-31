<!-- TODO 银行账户重置功能备用视图 -->

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
		if ( !empty($error) ) echo '<div class="alert alert-warning" role=alert>'.$error.'</div>';
		$attributes = array('class' => 'form-'.$this->class_name.'-bank-reset form-horizontal', 'role' => 'form');
		echo form_open_multipart($this->class_name.'/bank_reset?id='.$item[$this->id_name], $attributes);
	?>
		<fieldset>
			<input name=id type=hidden value="<?php echo $item[$this->id_name] ?>">

			<div class=form-group>
				<label for=bank_name class="col-sm-2 control-label">开户行名称</label>
				<div class=col-sm-10>
					<input class=form-control name=bank_name type=text value="<?php echo $item['bank_name'] ?>" placeholder="请输入有效的银行名称">
				</div>
			</div>

			<div class=form-group>
				<label for=bank_account class="col-sm-2 control-label">开户行账号</label>
				<div class=col-sm-10>
					<input class=form-control name=bank_account type=number step=1 value="<?php echo $item['bank_account'] ?>" placeholder="请输入有效的银行账号">
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