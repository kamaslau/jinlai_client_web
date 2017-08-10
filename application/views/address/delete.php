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

<div id=content class=container>

	<div class="alert alert-warning" role=alert>
		<p>确定要<?php echo $title ?>？</p>
	</div>

	<?php
		if ( !empty($error) ) echo '<div class="alert alert-warning" role=alert>'.$error.'</div>';
		$attributes = array('class' => 'form-'.$this->class_name.'-delete form-horizontal', 'role' => 'form');
		echo form_open($this->class_name.'/delete', $attributes);
	?>
		<fieldset>
			<input name=ids type=hidden value="<?php echo implode(',', $ids) ?>">

			<div class=form-group>
				<label for=password class="col-sm-2 control-label">密码</label>
				<div class=col-sm-10>
					<input class=form-control name=password type=password placeholder="请输入您的登录密码" autofocus required>
				</div>
			</div>
		</fieldset>

		<div class=form-group>
		    <div class="col-xs-12 col-sm-offset-2 col-sm-2">
				<button class="btn btn-danger btn-lg btn-block" type=submit>删除</button>
		    </div>
		</div>

	</form>

</div>