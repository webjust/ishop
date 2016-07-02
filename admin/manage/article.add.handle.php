<?php 
	header('content-type:text/html;charset=utf-8');
	require_once('../../comm/conn.php');

	// var_dump($_POST);

	/*把传递过来的信息入库，入库前，最校验*/
	function articleexists($field){
		$fields = array(
			'title'=>'标题',
			'author'=>'作者',
			'description'=>'简介',
			'content'=>'内容',
		);
		if (!(isset($_POST["$field"])&&(!empty($_POST["$field"])))) {
			echo "<script>alert('{$fields["{$field}"]}不能为空'); window.location.href='article.add.php'</script>";
			exit;
		}
	}

	articleexists('title');
	articleexists('author');
	articleexists('description');
	articleexists('content');

	$title = $_POST['title'];
	$author = $_POST['author'];
	$description = $_POST['description'];
	$content = $_POST['content'];

	date_default_timezone_set('PRC');
	$dateline = time();

	$sql = "INSERT INTO `shop_articles` (`title`,`author`,`description`,`content`,`dateline`) VALUES('$title', '$author', '$description', '$content', $dateline)";

	if(mysqli_query($conn, $sql)){
		echo "<script>alert('发布成功'); window.location.href='./article.add.php'</script>";
	} else{
		echo "<script>alert('发布失败'); window.location.href='./article.add.php'</script>";
	}

	mysqli_close($conn);
?>