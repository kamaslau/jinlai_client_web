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

<div id=content>
	<?php
		if ( !empty($error) ) echo '<div class="alert alert-warning" role=alert>'.$error.'</div>'; // 若有错误提示信息则显示
		$attributes = array('class' => 'form-password-change col-xs-12 col-md-6 col-md-offset-3', 'role' => 'form');
		echo form_open('password_change', $attributes);
	?>
		<fieldset>
			<div class=form-group>
				<label for=password_old class="col-sm-2 control-label">现密码</label>
				<div class=input-group>
					<span class="input-group-addon"><i class="fa fa-lock fa-fw" aria-hidden=true></i></span>
					<input class=form-control name=password_old type=password placeholder="现密码" autofocus required>
				</div>
			</div>

			<div class=form-group>
				<label for=password class="col-sm-2 control-label">新密码</label>
				<div class=input-group>
					<span class="input-group-addon"><i class="fa fa-lock fa-fw" aria-hidden=true></i></span>
					<input class=form-control name=password type=password placeholder="新密码" required>
				</div>
			</div>

			<div class=form-group>
				<label for=password2 class="col-sm-2 control-label">确认新密码</label>
				<div class=input-group>
					<span class="input-group-addon"><i class="fa fa-lock fa-fw" aria-hidden=true></i></span>
					<input class=form-control name=password2 type=password placeholder="确认新密码" required>
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
