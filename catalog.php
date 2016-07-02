<?php 
	include('./home/public/header.php');
	require_once('./comm/conn.php');

	// 传入当前分类的id
	$cata_id = @$_GET['cid']+0;

	// 翻页代码
	$p = isset($_GET['p'])?$_GET['p']:1;

	$sql = "SELECT COUNT(*) FROM `shop_product` WHERE `status` = 1 AND `cata_id` = {$cata_id}";
	$total = mysqli_query($conn, $sql);
	$total_rows = @mysqli_fetch_row($total)[0];

	// 产品数量为0时，输出信息
	if ($total_rows==0) {
		$msg = "抱歉，该分类下暂时没有产品！";
	} else{
		$msg = NULL;
	}

	// 每页产品数量
	$page_num = 10;
	$pages = ceil($total_rows/$page_num);

	if (!is_numeric($p)||$p<1) {
		$p=1;
	}

	if (!is_numeric($p)||$p>$pages) {
		$p=$pages;
	}

	// $sql = "SELECT * FROM `shop_manufacturer` ORDER BY CONCAT(`path`, `id`) LIMIT ".($p-1)*$page_num.", {$page_num}";

	// 数据库读取产品
	$sql = "SELECT * FROM `shop_product` WHERE `status` = 1 AND `cata_id` = {$cata_id} ORDER BY `id` DESC LIMIT ".($p-1)*$page_num.", {$page_num}";

	$res = mysqli_query($conn, $sql);
	if ($res) {
		while ($row = mysqli_fetch_assoc($res)) {
			$pro_list[] = $row;
		}
		mysqli_free_result($res);
	} else{
		$pro_list = [];
	}

	// 获取分类名称
	$sql = "SELECT * FROM `shop_catalog` WHERE id = {$cata_id}";
	$res = mysqli_query($conn, $sql);
	$cata = @mysqli_fetch_assoc($res);
	$cataName = $cata['name'];
	$cataTitle = empty($cata['title'])?$cata['name']:$cata['title'];
	$cataDescription = $cata['description'];
?>

<div id="content">
	<div class="sub-nav">
		<!-- 子分类 -->
		<div style="height:20px; display:block;"></div>
	</div>
	<div>
		<?php echo $msg; ?>
	</div>
	<?php 
		// echo "<pre>";	
		// print_r($pro_list);
		// echo "</pre>";	
	?>
	<h2>当前分类：<span style="color:#f69;"><?php echo $cataTitle; ?></span></h2>
	<p><?php echo $cataDescription; ?></p>
	<div class="pro-list">
		<ul>
			<?php $i=1; foreach($pro_list as $val): ?>
			<!-- 路径p_image下，如果图片不存在就去p400_image路径寻找 -->
			<?php
				$picurl = "./comm/p_image/{$val['image']}";
				// echo $picurl;
				if (file_exists($picurl)) {
					$picurl = $picurl;
				} else{
					$picurl = "./comm/p400_image/{$val['image']}";
				}
			?>			
			<li <?php echo (($i%5)==0)?"class='last'":NULL; ?>>
				<div class="p-img">
					<a href="./product.php?id=<?php echo $val['id']; ?>"><img src="<?php echo $picurl ?>" width="224" height="340" alt="<?php echo $val['name'] ?>" title="<?php echo $val['name'] ?>"></a>
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
			<span><a href="<?php echo $_SERVER['PHP_SELF']."?cid=".$cata_id."&p=" ?>">首页</a></span>
			<span><a href="<?php echo $_SERVER['PHP_SELF']."?cid=".$cata_id."&p=".($p-1) ?>">上一页</a></span>
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
			<span><a href="<?php echo $_SERVER['PHP_SELF']."?cid=".$cata_id."&p=".($p+1) ?>">下一页</a></span>
			<span><a href="<?php echo $_SERVER['PHP_SELF']."?cid=".$cata_id."&p=".$pages ?>">尾页</a></span>
			<span><?php echo "共".$total_rows."条" ?></span>
			</div>
			<!-- 分页代码结束 -->
	</div>
</div>

<?php 
	include('./home/public/footer.php');
?>