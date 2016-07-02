<?php 
session_start();
$username = isset($_SESSION['admin']['username'])?$_SESSION['admin']['username']:"";
$isLogin = isset($_SESSION['admin']['isLogin'])?$_SESSION['admin']['isLogin']:"";

if ($isLogin!=1 || empty($isLogin)) {
	header("Location:./login.php");
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>后台首页</title>
	<meta charset="utf-8" />
</head>
<frameset rows="60, *" noresize border="1">
	<frame src="./public/header.php" name="header" scrolling="no"></frame>
	<frameset cols="140, *">
		<frame src="./public/menu.php" name="menu"></frame>
		<frame src="./public/main.php" name="main"></frame>
	</frameset>
</frameset>
</html>