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
		$attributes = array('class' => 'form-'.$this->class_name.'-edit form-horizontal', 'role' => 'form');
		echo form_open_multipart($this->class_name.'/edit?id='.$item[$this->id_name], $attributes);
	?>
		<p class="help-block">必填项以“※”符号标示</p>

		<fieldset>
			<input name=id type=hidden value="<?php echo $item[$this->id_name] ?>">

			<div class=form-group>
				<label for=biz_id class="col-sm-2 control-label">商户ID</label>
				<div class=col-sm-10>
					<input class=form-control name=biz_id type=text value="<?php echo $item['biz_id'] ?>" placeholder="商户ID" required>
				</div>
			</div>
			<div class=form-group>
				<label for=user_id class="col-sm-2 control-label">用户ID</label>
				<div class=col-sm-10>
					<input class=form-control name=user_id type=text value="<?php echo $item['user_id'] ?>" placeholder="用户ID" required>
				</div>
			</div>
			<div class=form-group>
				<label for=user_ip class="col-sm-2 control-label">用户下单IP地址</label>
				<div class=col-sm-10>
					<input class=form-control name=user_ip type=text value="<?php echo $item['user_ip'] ?>" placeholder="用户下单IP地址" required>
				</div>
			</div>
			<div class=form-group>
				<label for=subtotal class="col-sm-2 control-label">小计（元）</label>
				<div class=col-sm-10>
					<input class=form-control name=subtotal type=text value="<?php echo $item['subtotal'] ?>" placeholder="小计（元）" required>
				</div>
			</div>
			<div class=form-group>
				<label for=promotion_id class="col-sm-2 control-label">营销活动ID</label>
				<div class=col-sm-10>
					<input class=form-control name=promotion_id type=text value="<?php echo $item['promotion_id'] ?>" placeholder="营销活动ID" required>
				</div>
			</div>
			<div class=form-group>
				<label for=discount_promotion class="col-sm-2 control-label">营销活动折抵金额（元）</label>
				<div class=col-sm-10>
					<input class=form-control name=discount_promotion type=text value="<?php echo $item['discount_promotion'] ?>" placeholder="营销活动折抵金额（元）" required>
				</div>
			</div>
			<div class=form-group>
				<label for=coupon_id class="col-sm-2 control-label">优惠券ID</label>
				<div class=col-sm-10>
					<input class=form-control name=coupon_id type=text value="<?php echo $item['coupon_id'] ?>" placeholder="优惠券ID" required>
				</div>
			</div>
			<div class=form-group>
				<label for=discount_coupon class="col-sm-2 control-label">优惠券折抵金额（元）</label>
				<div class=col-sm-10>
					<input class=form-control name=discount_coupon type=text value="<?php echo $item['discount_coupon'] ?>" placeholder="优惠券折抵金额（元）" required>
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