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

<div id=content class=container>
	<?php
		if ( !empty($error) ) echo '<div class="alert alert-warning" role=alert>'.$error.'</div>';
		$attributes = array('class' => 'form-'.$this->class_name.'-create form-horizontal', 'role' => 'form');
		echo form_open_multipart($this->class_name.'/create', $attributes);
	?>
		<p class=help-block>必填项以“※”符号标示</p>

		<fieldset>
			
			<div class=form-group>
				<label for=vote_id class="col-sm-2 control-label">所属投票ID ※</label>
				<div class=col-sm-10>
					<input class=form-control name=vote_id type=number min="1" step="1" value="<?php echo set_value('vote_id') ?>" placeholder="所属投票ID" required>
				</div>
			</div>

			<div class=form-group>
				<label for=option_id class="col-sm-2 control-label">候选项ID ※</label>
				<div class=col-sm-10>
					<input class=form-control name=option_id type=number min="1" step="1" value="<?php echo set_value('option_id') ?>" placeholder="候选项ID" required>
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