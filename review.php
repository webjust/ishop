<?php
	require_once('./comm/conn.php');
	require_once('./comm/comm.function.php');

	session_start();
	$father_urls = $_SERVER['HTTP_REFERER'];
	// 评论前检查是否登录
	if (!checkuserLogin()) {
		// echo "<script>alert('评论前需要先登录你的账户');window.location.href=".$_SERVER['HTTP_REFERER']."</script>";
		echo "<script>alert('评论前需要先登录你的账户');window.location.href='".$father_urls."'</script>";
		exit();
	}
	// 打印提交的评价内容

	// 从数据库查找指定用户名的ID
	$customer_name = $_SESSION['buyer']['username'];
	$sql = "SELECT * FROM `shop_user` WHERE `username` = '{$customer_name}'";
	$res = mysqli_query($conn, $sql);

	if($res){
		$row = mysqli_fetch_assoc($res);
	}

	$customer_id = $row['id'];

	// 接收提交内容
	$product_id = isset($_POST['product_id'])?$_POST['product_id']:NULL;
	$author = trim(isset($_POST['author'])?$_POST['author']:NULL);
	$review_text = trim(isset($_POST['review_text'])?$_POST['review_text']:'');
	$rating = isset($_POST['rating'])?$_POST['rating']:NULL;
	$date_added = time();

	// 对提交内容做处理
	if (empty($author)) {
		echo "<script>alert('用户名不能为空');window.location.href='".$father_urls."'</script>";
		exit;
	}

	// 评价内容，不能少于10个字
	if (empty($review_text)) {
		echo "<script>alert('内容不能为空');window.location.href='".$father_urls."'</script>";
		exit;
	} else{
		if (strlen($review_text)<10) {
		echo "<script>alert('内容不能少于10个字');window.location.href='".$father_urls."'</script>";
		exit;
		}
	}

	// 评分
	if (!isset($rating)) {
		echo "<script>alert('评分不能为空');window.location.href='".$father_urls."'</script>";
		exit;
	}

	// 写入数据库
	$sql = "INSERT INTO `shop_review` (`product_id`, `customer_id`, `author`, `text`, `rating`, `date_added`) VALUES ($product_id, $customer_id, '{$author}', '{$review_text}', '{$rating}', $date_added)";

	$res = mysqli_query($conn, $sql);

	if ($res) {
		echo "<script>alert('评论成功，等待管理员审核才会显示，请耐心等待');window.location.href='".$father_urls."'</script>";
		exit;
	} else{		
		echo "<script>alert('评价失败');window.location.href='".$father_urls."'</script>";
		exit;
	}

	// 释放连接
	mysqli_close($conn);

?>