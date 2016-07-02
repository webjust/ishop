<?php
	require_once('../../comm/conn.php');

	$id = $_GET['id'];
	$sql = "DELETE FROM `shop_articles` WHERE id = {$id}";

	if(mysqli_query($conn, $sql)){
		echo "<script>alert('删除成功');window.location.href='article.add.php';</script>";
	} else{
		echo "<script>alert('删除失败');window.location.href='article.add.php';</script>";
	}

	mysqli_close($conn);
?>