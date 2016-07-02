<?php
	session_start();
	unset($_SESSION['buyer']);
	unset($_SESSION['buy_product']);

	// session_destroy();

	// 如果注销登录，返回之前的路径
	// var_dump($_SERVER);
	$history_url = $_SERVER['HTTP_REFERER'];

	header("location:{$history_url}");
	exit();
?>