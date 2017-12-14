<style>
	.abstracts{
		padding: .4rem .2rem;
		background: #b5b5b6;
		border-radius: .2rem;
	}
	.abstracts>h1{
		text-align: center;
		font-size: .28rem;
		color: #fff;
		padding-bottom: .3rem;
	}
	.abstracts>p{
		color: #fff;
		font-size: .22rem;
		line-height: .36rem;
	}
	.articletext{
		margin-top: .6rem;
	}
	.articletext h1{
		text-align: center;
		color: #3E3A39;
		font-size: .28rem;
		padding-bottom: .2rem;
	}
	.articletext time{
		font-size: .22rem;
		color: #9fa0a0;
		padding-bottom: .3rem;
		display: block;
		float: right;
	}
	.articletext p{
		font-size: .28rem;
		color: #666464;
		line-height: .36rem;
		float: left;
	}
	.articletext h2{
		margin-top: .5rem;
		margin-bottom: .22rem;
		font-size: .24rem;
		color: #666464;
		font-weight: bold;
		float: left;
	}
</style>

<?php if ( !empty($item['excerpt']) ): ?>
<div class="wid670 auto mt20 abstracts">
	<p><?php echo $item['excerpt'] ?></p>
</div>
<?php endif ?>

<!--内容区域-->
<div class="articletext wid670 auto">
	<h1><?php echo $item['title'] ?></h1>
	<time><?php echo $item['time_create'] ?></time>

    <?php echo $item['content'] ?>
</div>