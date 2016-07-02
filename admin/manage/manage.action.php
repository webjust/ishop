<?php
	header('content-type:text/html;charset=utf-8');
	require_once('../../comm/conn.php');
	require_once('../../comm/comm.function.php');

	$a = $_GET['a'];

	switch($a){
		case 'links':
			// print_r($_POST);

			// 接受表单提交的值
			$website = $_POST['website'];
			$webaddress = $_POST['webaddress'];
			$sort = !empty($_POST['sort'])?$_POST['sort']:0;


			// 验证输入数据
			if (empty($website)||empty($webaddress)) {
				echo "<script>alert('请不要输入空值');window.location.href='./manage.links.php';</script>";
				exit();
			}

			// 网站名称

			// 网址
			$pattern = "/[a-zA-z]+:\/\/[^\s]/";
			if (!preg_match($pattern, $webaddress)) {
				echo "<script>alert('您输入的网址错误，请重新输入');window.location.href='./manage.links.php'</script>";
				exit();
			}


			// 添加友情链接数据操作
			$sql = "INSERT INTO `shop_friendlink` (`website`, `webaddress`, `sort`) VALUES('$website', '$webaddress', '$sort')";

			$res = mysqli_query($conn, $sql);

			// var_dump(mysqli_affected_rows($conn));

			if (mysqli_affected_rows($conn)==1) {
				echo "<script>alert('添加成功'); window.location.href='./manage.links.php';</script>";
			} else{
				echo "<script>alert('添加失败'); window.location.href='./manage.links.php';</script>";
			}

			mysqli_close($conn);

			break;

		case 'updatelink':
			// 赋值
			$website = $_POST['website'];
			$webaddress = $_POST['webaddress'];
			$sort = $_POST['sort'];
			$id = $_GET['id'];

			// 验证
			if (empty($website)||empty($webaddress)||empty($sort)) {
				echo "<script>alert('不能有空值，请重新提交');window.location.href='./manage.links.php';</script>";
				exit();
			}

			// 验证输入的是网址
			$pattern = "/[a-zA-z]+:\/\/[^\s]/";
			if (!preg_match($pattern, $webaddress)) {
				echo "<script>alert('您输入的网址错误，请重新操作');window.location.href='./manage.links.php'</script>";
				exit();
			}

			// 更新操作
			$sql = "UPDATE `shop_friendlink` SET `website` = '$website', `webaddress` = '$webaddress', `sort` = '$sort' WHERE `id` = ".$id;

			$res = mysqli_query($conn, $sql);

			if($res){
				echo "<script>alert('更新成功');window.location.href='./manage.links.php'</script>";
			} else{
				echo "<script>alert('操作失败');window.location.href='./manage.links.php'</script>";
			}

			break;

		case 'dellink':
			$id = $_GET['id'];

			// 删除操作
			$sql = "DELETE FROM `shop_friendlink` WHERE id = ".$id;

			// echo "<script>confirm('确定删除吗?')</script>";
			$res = mysqli_query($conn, $sql);
			var_dump($res);
			var_dump(mysqli_affected_rows($conn));
			if ($res && mysqli_affected_rows($conn)) {
				echo "<script>alert('删除成功'); window.location.href='./manage.links.php';</script>";
			} else{
				echo "<script>alert('删除失败'); window.location.href='./manage.links.php';</script>";
			}

			break;
	}

