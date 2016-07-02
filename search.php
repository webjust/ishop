<?php 
	include('./home/public/header.php');
	require_once('./comm/conn.php');

	// 传入当前分类的id
	// print_r($_GET);

	// 接收关键词，搜索产品
	$keyword = trim(isset($_GET['keyword'])?$_GET['keyword']:'');

	// 翻页代码
	$p = isset($_GET['p'])?$_GET['p']:1;

	$sql = "SELECT COUNT(*) FROM `shop_product` WHERE `name` LIKE '%{$keyword}%'";
	// echo $sql."<br>";
	$total = mysqli_query($conn, $sql);
	$total_rows = mysqli_fetch_row($total)[0];	

	// 每页产品数量
	$page_num = 10;
	$pages = ceil($total_rows/$page_num);

	if (!is_numeric($p)||$p<1) {
		$p=1;
	}

	if (!is_numeric($p)||$p>$pages) {
		$p=$pages;
	}

	// offset
	$offset = ($p-1)*$page_num;

	$sql = "SELECT * FROM `shop_product` WHERE `name` LIKE '%{$keyword}%' LIMIT {$offset}, {$page_num}";
	// echo $sql."<br>";

	$res = mysqli_query($conn, $sql);
	$result = array();
	$msg = NULL;
	if ($res) {
		while($row = mysqli_fetch_assoc($res)){
			$result[] = $row;
		}
	} else{
		$msg = "没有结果！";
	}



?>	

<div id="content">
	<div class="sub-nav">
		<!-- 子分类 -->
		<div style="height:20px; display:block;"></div>
	</div>
	<div>
		<?php echo $msg; ?>
	</div>
	<div class="pro-list">
		<ul>
			<?php $i=1; foreach($result as $val): ?>
			<li <?php echo (($i%5)==0)?"class='last'":NULL; ?>>
				<div class="p-img">
					<a href="./product.php?id=<?php echo $val['id']; ?>"><img src="./comm/p_image/<?php echo $val['image'] ?>" width="224" height="340" alt="<?php echo $val['name'] ?>" title="<?php echo $val['name'] ?>"></a>
				</div>
				<div class="p-price">
					<span class="price">￥ <?php echo $val['price'] ?></span>
					<span class="zan"><?php echo $val['viewed'] ?></span>
				</div>
				<div class="p-name"><a href="./product.php?id=<?php echo $val['id']; ?>"><?php echo $val['name'] ?></a></div>
			</li>
			<?php $i++; endforeach; ?>
			<div class="clear"></div>
		</ul>

		<!-- 分页代码开始 -->
			<div class="page_num">
			<span><?php echo "第".$p."页" ?></span>						
			<span><a href="<?php echo $_SERVER['PHP_SELF']."?keyword=".$keyword."&p=1" ?>">首页</a></span>
			<span><a href="<?php echo $_SERVER['PHP_SELF']."?keyword=".$keyword."&p=".($p-1) ?>">上一页</a></span>
			<?php 
				for ($i=1; $i <= $pages; $i++) {
					$active = ($i==$p)? 'active':'';

					$url = $_SERVER['PHP_SELF']."?p={$i}";

					$str = "<span class='num {$active}'>".'<a href="'.$url.'">';
					$str .= $i;
					$str .= "</a></span>";
					echo $str;
				}
			?>
			<span><a href="<?php echo $_SERVER['PHP_SELF']."?keyword=".$keyword."&p=".($p+1) ?>">下一页</a></span>
			<span><a href="<?php echo $_SERVER['PHP_SELF']."?keyword=".$keyword."&p=".$pages ?>">尾页</a></span>
			<span><?php echo "共".$total_rows."条" ?></span>
			</div>
			<!-- 分页代码结束 -->
	</div>
</div>

<?php 
	include('./home/public/footer.php');
?>