<link rel=stylesheet media=all href="/css/detail.css">
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

<script defer src="/js/detail.js"></script>

<base href="<?php echo $this->media_root ?>">

<div id=content class=container>
	<?php if ( empty($item) ): ?>
	<p><?php echo $error ?></p>

	<?php else: ?>
	<dl id=list-info class=dl-horizontal>		
		<dt>选票ID</dt>
		<dd><?php echo $item['ballot_id'] ?></dd>
		<dt>所属投票ID</dt>
		<dd><?php echo $item['vote_id'] ?></dd>
		<dt>候选项ID</dt>
		<dd><?php echo $item['option_id'] ?></dd>
		<dt>用户ID</dt>
		<dd><?php echo $item['user_id'] ?></dd>
		<dt>投票日期</dt>
		<dd><?php echo $item['date_create'] ?></dd>
		<dt>投票时间</dt>
		<dd><?php echo date('Y-m-d H:i:s', $item['time_create']) ?></dd>
	</dl>

	<?php endif ?>
</div>