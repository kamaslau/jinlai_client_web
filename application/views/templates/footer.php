		<!--</main>-->
<!-- End #maincontainer -->
<style>
	#footer{
		text-align: center;
		font-size: .2rem;
	}
</style>
		<!--<footer id=footer role=contentinfo>
			<div id=copyright>
				<div class=container>
					<p>&copy;<?php echo date('Y') ?>

					<a title="<?php echo SITE_DESCRIPTION ?>" href="<?php echo base_url() ?>"><?php echo SITE_NAME ?></a>

					<?php if ( !empty(ICP_NUMBER)): ?>
					<a title="工业和信息化部网站备案系统" href="http://www.miitbeian.gov.cn/" target=_blank rel=nofollow><?php echo ICP_NUMBER ?></a>
					<?php endif ?>

					<a id=support title="访问BasicCodeigniter的Github主页" href="https://www.lagou.com/gongsi/145180.html" target=_blank>意帮科技</a></p>
				</div>
			</div>

			<a id=totop title="回到页首" href="#"><i class="fa fa-chevron-up" aria-hidden=true></i></a>
		</footer>-->

		<script>
			$(function(){
				// 回到页首按钮
				$('a#totop').click(function()
				{
					$('body,html').stop(false, false).animate({scrollTop:0}, 800);
					return false;
				});
			});
		</script>
	</body>
</html>