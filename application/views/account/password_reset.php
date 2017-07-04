<style>
	#content {padding-top:2rem;}
	form {padding-top:2rem;}

	/* 宽度在768像素以上的设备 */
	@media only screen and (min-width:769px)
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
	<?php
		if ( isset($error) ) echo '<div class="alert alert-warning" role=alert>'.$error.'</div>'; // 若有错误提示信息则显示
		$attributes = array('class' => 'form-password-reset', 'role' => 'form');
		echo form_open('password_reset', $attributes);
	?>
		<fieldset>
			<div class=input-group>
				<label for=password>新密码</label>
				<div>
					<input name=password type=password placeholder="新密码" required>
					<?php echo form_error('password') ?>
				</div>
			</div>

			<div class=input-group>
				<label for=password2>确认新密码</label>
				<div>
					<input name=password2 type=password placeholder="确认新密码" required>
					<?php echo form_error('password2') ?>
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
