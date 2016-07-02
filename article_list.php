<?php 
	include('./home/public/header.php');
	// 连接数据库
	include('./comm/conn.php');

	// 获取当前页
	$p = isset($_GET['p'])?$_GET['p']:1;

	// 翻页
	$sql = "SELECT COUNT(*) total FROM `shop_articles`";
	$total = mysqli_query($conn, $sql);
	$total_nums = mysqli_fetch_assoc($total)['total'];

	$page_num = 10;
	$total_page = ceil($total_nums/$page_num);

	$sql = "SELECT * FROM `shop_articles` ORDER BY `id` DESC LIMIT ".($p-1)*$page_num. ", {$page_num}";

	$res = mysqli_query($conn, $sql);
	// $rows = mysqli_affected_rows($conn);
	if($res){
		while ($row = mysqli_fetch_assoc($res)) {
			$articles_list[] = $row;
		}
	}

	// var_dump($articles_list);
?>
	<!-- BEGIN 首页 -->
	<div id="first">
		<h1>
			文章列表
		</h1>
		<hr>
		<div class="article_l">
			<ul>
				<?php foreach($articles_list as $val): ?>
					<li><a href="<?php echo "./article_show.php?id={$val['id']}"; ?>"><?php echo $val['title'] ?></a></li>
				<?php endforeach; ?>
			</ul>
			<div class="next_page">
				<a href="<?php echo $_SERVER['PHP_SELF']."?p=1" ?>">首页</a>
				<a href="<?php echo $_SERVER['PHP_SELF']."?p=".($p-1) ?>">上一页</a>
				<a href="<?php echo $_SERVER['PHP_SELF']."?p=".($p+1) ?>">下一页</a>
				<a href="<?php echo $_SERVER['PHP_SELF']."?p=".$total_page ?>">末页</a>
			</div>
		</div>		
	</div>
	<!-- END 首页 -->
<?php 
	include('./home/public/footer.php');
?>