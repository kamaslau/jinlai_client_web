<style>
    body {padding:.2rem;}

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
        font-size: .28rem;
        color: #666464;
		margin-top: .6rem;
	}
	.articletext h1{
		text-align: center;
		color: #3e3a39;
		font-size: .30rem;
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
		line-height: .36rem;
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


<!--<div class="wid670 auto mt20 abstracts">
	<h1>摘要</h1>
	<p>
		《进来》是首款需要严苛标准认证的品控网购平台,是高质量产品的输出桥梁。我们旨在联合最优秀的商家及企业，让所有的高品质的商品和服务在同一个地方(《进来》)让用户共享。
	</p>
</div>
-->

<ul class=row>
    <?php
    $figure_image_urls = explode(',', $item['url_images']);
    foreach($figure_image_urls as $url):
        ?>
        <li class="col-xs-6 col-sm-4 col-md-3">
            <img src="<?php echo $url ?>">
        </li>
    <?php endforeach ?>
</ul>

<!--内容区域-->
<div class="articletext wid670 auto">
	<h1><?php echo $item['title'] ?></h1>
	<time><?php echo $item['time_edit'] ?></time>

    <?php echo $item['content'] ?>
</div>