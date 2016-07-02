<?php
	require_once("/../config/configs.php");
/*	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASSWORD', '');
	define('DB_DBNAME', 'ishop');*/
	date_default_timezone_set('PRC');

	/*
		数据库的连接与设置字符集
	*/

	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DBNAME) or die("数据库连接错误！<br>错误信息：".mysqli_connect_error());


	// $conn = mysqli_connect('localhost', 'root', '', 'ishop') or die("数据库连接错误！<br>错误信息：".mysqli_connect_error());

	mysqli_set_charset($conn, 'utf8');