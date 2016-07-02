<?php 
	// print_r($_GET);
	$id = $_GET['id'];
	session_start();

	// 删除购物车产品
	unset($_SESSION['buy_product'][$id]);
	header('location:./cart.php');


?>