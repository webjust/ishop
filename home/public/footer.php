<?php 
	require_once('/../../comm/conn.php');
	
	// 获取友情链接
	$sql = "SELECT * FROM `shop_friendlink` ORDER BY `sort` DESC";
	$res = mysqli_query($conn, $sql);
	if ($res) {
		while ($row = mysqli_fetch_assoc($res)){
			$frined_links[] = $row;
		}
	}

	mysqli_free_result($res);
	mysqli_close($conn);

	// var_dump($frined_links);

?>
	<!-- BEGIN 尾部 -->
	<div id="footer">
		<div id="fcon">
			<div class="mblock">
				<div class="tel"></div>
				<div>
					<div class="telphone">4000-800-577</div>
					<div>
						客服热线：<br/>
						周一至周日 09:00 - 22:00
					</div>
				</div>
			</div>
			<div class="mblock">
				<h4>买家帮助</h4>
				<ul>
					<li><a href="../../article_show.php?id=4">新手指南</a></li>
					<li><a href="../../article_show.php?id=5">服务保障</a></li>
					<li><a href="../../article_show.php?id=6">帮助中心</a></li>
				</ul>
			</div>
			<div class="mblock">
				<h4>商家帮助</h4>
				<ul>
					<li><a href="../../article_show.php?id=7">商家入驻</a></li>
					<li><a href="../../article_show.php?id=8">商家推广</a></li>
					<li><a href="../../article_show.php?id=6">帮助中心</a></li>
				</ul>
			</div>
			<div class="mblock">
				<h4>关于我们</h4>
				<ul>
					<li><a href="../../article_show.php?id=9">关于美丽说</a></li>
					<li><a href="../../article_show.php?id=10">联系我们</a></li>
					<li><a href="../../article_show.php?id=11">加入美丽说</a></li>
				</ul>
			</div>
			<div class="mblock">
				<h4>关注我们</h4>
				<ul>
					<li><a href="#">新浪微博</a></li>
					<li><a href="#">QQ空间</a></li>
					<li><a href="#">腾讯微博</a></li>
				</ul>
			</div>
			<div class="mblock">
				<h5>美丽说微信公众号</h5>
				<div>
					<img src="./home/images/qrcode-new.jpg" width="115" height="115">
				</div>
			</div>

			<div class="mblock last">
				<h5>美丽说客户端下载</h5>
				<div>
					<img src="./home/images/mls_app.jpg">
				</div>
			</div>
		</div>
		<div class="clear"></div>
		<div class="friendlinks">
			<span>友情链接：</span>
			<ul>
				<?php foreach($frined_links as $val): ?>
				<?php 
					$website = $val['website'];
					$webaddress = $val['webaddress'];
				?>
				<li><a href="<?php echo $webaddress; ?>"><?php echo $website; ?></a></li>
				<?php endforeach; ?>
			</ul>
			<span class="more"><a href="#">更多</a></span>
		</div>
		<div class="ffooter">
			<p>Copyright &copy;2016 <a href="#">Meilishuo.com</a>  电信与信息服务业务经营许可证100798号 经营性网站备案信息  <a href="#">京ICP备11031139号</a>  <a href="#">京公网安备110108006045</a><br/>客服电话：4000-800-577  文明办网文明上网举报电话：010-82615762  违法不良信息举报中心 我最喜爱的人民警察评选>> <a href="#">反诈骗信息</a></p>
		</div>
	</div>
</div>
</body>
</html>