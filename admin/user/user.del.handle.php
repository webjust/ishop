<?php 
	require_once('../../comm/conn.php');

	/*查询登录用户的等级*/
	session_start();
	$isLogin_admin = $_SESSION['admin']['username'];
	// 从数据库获取用户等级
	$sql = "SELECT * FROM `shop_user` WHERE `username` = '{$isLogin_admin}'";
	$res = mysqli_query($conn, $sql);
	$user_grade = mysqli_fetch_assoc($res)['grade'];

	// 获取要删除的ID
	$id = $_GET['id'];
	$p = isset($_GET['p'])?$_GET['p']:1;
	$page = "?p=".$p;

	// 判断如果不属于管理员，没有权限删除
	if ($user_grade >= 1) {
		echo "<script>alert('您没有删除用户的权限，请联系超级管理员'); window.location.href='./user.list.php{$page}';</script>";
		exit;		
	}

	// 获取要删除的用户的权限
	$sql = "SELECT `grade` FROM `shop_user` WHERE `id` = '{$id}'";
	$res = mysqli_query($conn, $sql);
	$user_grade = mysqli_fetch_assoc($res)['grade'];

	// 获取登录管理员的权限
	$admin_username = $_SESSION['admin']['username'];
	$sql = "SELECT `grade` FROM `shop_user` WHERE `username` = '{$admin_username}'";
	$res = mysqli_query($conn, $sql);
	$admin_grade = mysqli_fetch_assoc($res)['grade'];

	// 判断权限
	if ($admin_grade > 0) {
		echo "<script>alert('非法操作！不能删除用户！请联系超级管理员');window.location.href='./user.list.php{$page}'</script>";
		exit;
	}

	if ($admin_grade == 0 && $user_grade != 0) {
		$sql = "DELETE FROM `shop_user` WHERE id=".$id;
		$res = mysqli_query($conn, $sql);

		if ($res) {
			echo "<script>alert('删除成功'); window.location.href='./user.list.php{$page}';</script>";
			exit;
		}
	} else{
		echo "<script>alert('傻逼！非法操作！不能删除自己！'); window.location.href='./user.list.php{$page}';</script>";
		exit;
	}

	mysqli_close($conn);