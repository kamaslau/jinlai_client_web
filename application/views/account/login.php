<style>
	#content {padding-top:2rem;}
	form {padding-top:2rem;}
	
	#actions {margin-top:4rem;}
		#actions>li {margin-bottom:2rem;}

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
	<div class="btn-group btn-group-justified" role=group>
		<a class="btn btn-primary" href="#">密码登录</a>
		<a class="btn btn-default" href="<?php echo base_url('login_sms') ?>">短信登录</a>
	</div>

	<?php
		if ( !empty($error) ) echo '<div class="alert alert-warning" role=alert>'.$error.'</div>'; // 若有错误提示信息则显示
		$attributes = array('class' => 'form-login col-xs-12 col-md-6 col-md-offset-3', 'role' => 'form');
		echo form_open('login', $attributes);
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
				<label for=password>密码</label>
				<div class=input-group>
					<span class="input-group-addon"><i class="fa fa-key fa-fw" aria-hidden=true></i></span>
					<input class=form-control name=password type=password <?php if ($this->input->cookie('mobile')) echo 'autofocus '; ?> placeholder="密码" required>
				</div>
			</div>
		</fieldset>
		
		<div class=form-group>
		    <div class="col-xs-12 col-sm-offset-2 col-sm-2">
				<button class="btn btn-primary btn-lg btn-block" type=submit role=button>确定</button>
		    </div>
		</div>
	</form>
	
	<ul id=actions class="col-xs-12 col-sm-offset-2 col-sm-2">
		<li><a title="注册" class="btn btn-default btn-block" href="<?php echo base_url('login_sms') ?>">短信登录/注册</a></li>
		<li><a title="忘记密码" class="btn btn-default btn-block" href="<?php echo base_url('password_reset') ?>">忘记密码</a></li>
	</ul>
</div>
