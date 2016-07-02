<?php 
	require_once('./conn.php');
	// var_dump($_SERVER);

	// 判断是否登录
	session_start();
	// var_dump($_SESSION);

	$isLoginBuyer = isset($_SESSION['buyer']['isLogin'])?$_SESSION['buyer']['isLogin']:NULL;
	$isLoginAdmin = isset($_SESSION['admin']['isLogin'])?$_SESSION['admin']['isLogin']:NULL;

	if ($isLoginBuyer!=1 && $isLoginAdmin!=1) {
		echo "<script>alert('非法操作');</script>";
		exit;
	}

	// 通过GET获取订单编号，和当前状态值
	$order = isset($_GET['order'])?$_GET['order']:NULL;
	$status = isset($_GET['status'])?$_GET['status']:NULL;

	if (is_null($order)||is_null($status)) {
		echo "<script>alert('非法操作');</script>";
		// exit;
	}

	// echo "order:".$order."<br>";
	// echo "status: ".$status."<br>";

	// 更改状态
	$status += 1;
	// echo "更改后的status: ".$status."<br>";

	// 把更改后的状态更新到数据库
	$sql = "UPDATE `shop_order` SET `order_status` = '{$status}' WHERE `order_num` = '{$order}'";

	// echo $sql;
	$res = mysqli_query($conn, $sql);
	if ($res) {
		echo "<script>alert('操作成功，返回当前页');window.location.href='{$_SERVER['HTTP_REFERER']}'</script>";
		exit;
	} else{
		echo "<script>alert('操作失败，返回当前页');window.location.href='{$_SERVER['HTTP_REFERER']}'</script>";
		exit;
	}

?>