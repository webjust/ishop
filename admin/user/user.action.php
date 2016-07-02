<?php 
	require('../../comm/conn.php');
	require_once('../../comm/comm.function.php');
	$id = isset($_GET['id'])?$_GET['id']+0:NULL;
	$action = isset($_GET['a'])?$_GET['a']:NULL;
	$status = isset($_GET['status'])?$_GET['status']:NULL;
	$p = isset($_GET['p'])?$_GET['p']:1;

	/*查询登录用户的等级*/
	session_start();
	$isLogin_admin = $_SESSION['admin']['username'];
	// 从数据库获取用户等级
	$sql = "SELECT * FROM `shop_user` WHERE `username` = '{$isLogin_admin}'";
	$res = mysqli_query($conn, $sql);
	$user_grade = mysqli_fetch_assoc($res)['grade'];

	// 判断如果不属于管理员，没有修改用户状态
	if ($user_grade >= 1 ) {
		echo "<script>alert('您没有修改用户状态，请联系超级管理员'); window.location.href='./user.list.php?p={$p}';</script>";
		exit;		
	}

	switch ($action) {
		case 'status':

			$status += 1;
			$status = $status%2; 
			$sql = "UPDATE `shop_user` SET `status` = {$status} WHERE id=".$id;

			// echo $sql;
			// die();

			$res = mysqli_query($conn, $sql);

			if ($res) {
				echo "<script>alert('修改成功'); window.location.href='./user.list.php?p={$p}';</script>";
			} else{
				echo "<script>alert('修改失败，请重新修改'); window.location.href='./user.list.php?p={$p}';</script>";
			}

			mysqli_close($conn);
			break;
	}
?>