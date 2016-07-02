<?php 
	include('./home/public/header.php');
	// 连接数据库
	require_once('./comm/conn.php');
	$id = isset($_GET['id'])?($_GET['id']+0):NULL;
	$sql = "SELECT * FROM `shop_articles` WHERE id = ".$id;
	$res = mysqli_query($conn, $sql);
	// $rows = mysqli_affected_rows($conn);
	if($res){
		$showarticle = mysqli_fetch_assoc($res);
	} else{
		echo "<script>alert('系统错误！请联系网站管理员');window.location.href='./index.php'</script>";
		exit();
	}
	// var_dump($showarticle);
	mysqli_free_result($res);
	// mysqli_close($conn);


?>
	<!-- BEGIN 首页 -->
	<div id="content">
		<div class="article_l">
		<H1><?php echo $showarticle['title'] ?></H1>
		<p><?php echo $showarticle['author'].date('Y-m-d H:i:s', $showarticle['dateline']) ?></p>
		<hr>
		<div>
			<?php echo $showarticle['content']; ?>
		</div>
		
		<div class="more"><a class="hot" href="./article_list.php">更多文章 >></a></div>
		</div>

	</div>
	<!-- END 首页 -->
<?php 
	include('./home/public/footer.php');
?>