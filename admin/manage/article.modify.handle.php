<?php 
	require('../../comm/conn.php');

	$title = $_POST['title'];
	$author = $_POST['author'];
	$description = $_POST['description'];
	$content = $_POST['content'];
	$id = $_POST['id'];

	$sql = "UPDATE `shop_articles` SET title = '$title', author = '$author', description = '$description', content = '$content' WHERE id = $id";

	if(mysqli_query($conn, $sql)){
		echo "<script>alert('修改成功'); window.location.href='article.add.php'</script>";
	} else{
		echo "<script>alert('修改失败'); window.location.href='article.add.php'</script>";
	}


?>