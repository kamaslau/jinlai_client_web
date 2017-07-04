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
		$attributes = array('class' => 'form-register form-horizontal', 'role' => 'form');
		echo form_open('register', $attributes);
	?>
		<fieldset>
			<div class=input-group>
				<label for=mobile>手机号</label>
				<div class=col-sm-10>
					<i class="prepend fa fa-mobile"></i>
					<input name=mobile type=tel size=11 pattern="\d{11}" autofocus required>
					<?php echo form_error('mobile') ?>
				</div>
			</div>

			<div class=input-group>
				<label for=password>密码</label>
				<div class=col-sm-10>
					<input name=password type=password placeholder="密码" required>
					<?php echo form_error('password') ?>
				</div>
			</div>

			<div class=input-group>
				<label for=password2>确认密码</label>
				<div class=col-sm-10>
					<input name=password2 type=password placeholder="确认密码" required>
					<?php echo form_error('password2') ?>
				</div>
			</div>
		</fieldset>

		<div class=form-group>
		    <div class="col-xs-12 col-sm-offset-2 col-sm-2">
				<button class="btn btn-primary btn-lg btn-block" type=submit>确定</button>
		    </div>
		</div>
		<p>点击“确定”，即表示您已完整阅读并同意<a title="查看用户协议详细内容" href="<?php echo base_url('article/user-agreement') ?>" target=_blank>用户协议</a>。</p>
	</form>
</div>
