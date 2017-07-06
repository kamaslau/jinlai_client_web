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
		$attributes = array('class' => 'form-password-reset col-xs-12 col-md-6 col-md-offset-3', 'role' => 'form');
		echo form_open('password_reset', $attributes);
	?>
		<fieldset>
			<div class=form-group>
				<label for=mobile>手机号</label>
				<div class=input-group>
					<span class="input-group-addon"><i class="fa fa-mobile fa-fw" aria-hidden=true></i></span>
					<input class=form-control name=mobile type=tel value="<?php echo $this->input->post('mobile')? set_value('mobile'): $this->input->cookie('mobile') ?>" size=11 pattern="\d{11}" placeholder="手机号" required>
				</div>
			</div>

			<div class=form-group>
				<label for=captcha_verify>图片验证码</label>
				<div class=input-group>
					<input id=captcha-verify class=form-control name=captcha_verify type=number max=9999 min=0001 step=1 size=4 placeholder="请输入图片验证码" required>
					<img id=captcha-image src="<?php echo base_url('captcha') ?>">
				</div>
			</div>

			<div class=form-group>
				<label for=captcha>短信验证码</label>
				<div class=input-group>
					<input id=captcha-input class=form-control name=captcha type=number max=999999 step=1 size=6 pattern="\d{6}" placeholder="请输入短信验证码" disabled required>
					<span class="input-group-addon">
						<a id=sms-send class=append href="#">获取验证码</a>
					</span>
				</div>
			</div>
		</fieldset>

		<fieldset>
			<div class=form-group>
				<label for=password>新密码</label>
				<div class=input-group>
					<span class=input-group-addon><i class="fa fa-key fa-fw" aria-hidden=true></i></span>
					<input class=form-control name=password type=password placeholder="新密码" required>
				</div>
			</div>

			<div class=form-group>
				<label for=password2>确认新密码</label>
				<div class=input-group>
					<span class=input-group-addon><i class="fa fa-key fa-fw" aria-hidden=true></i></span>
					<input class=form-control name=password2 type=password placeholder="确认新密码" required>
				</div>
			</div>
		</fieldset>

		<div class=form-group>
		    <div class="col-xs-12 col-sm-offset-2 col-sm-2">
				<button class="btn btn-primary btn-block btn-lg" type=submit>确定</button>
		    </div>
		</div>
	</form>
</div>
