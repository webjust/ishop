<?php
	header('content-type:text/html;charset=utf-8');
	require_once('../../comm/conn.php');

	$a = isset($_GET['a'])?$_GET['a']:NULL;

	/*查询登录用户的等级*/
	session_start();
	$isLogin_admin = $_SESSION['admin']['username'];
	// 从数据库获取用户等级
	$sql = "SELECT * FROM `shop_user` WHERE `username` = '{$isLogin_admin}'";
	$res = mysqli_query($conn, $sql);
	$user_grade = mysqli_fetch_assoc($res)['grade'];

	// 判断如果不属于管理员，没有修改用户状态
	if ($user_grade > 1 ) {
		echo "<script>alert('您没有修改用户状态，请联系超级管理员'); window.location.href='./user.list.php?p={$p}';</script>";
		exit;		
	}

	switch ($a) {
		case 'addcata':
			$name = $_POST['name'];
			$title = $_POST['title'];
			$descrption = $_POST['description'];
			$pid = $_POST['pid'];
			$path = $_POST['path'];
			$p = isset($_GET['p'])?$_GET['p']:NULL;
			$p = isset($p)?"?p={$p}":NULL;

			$sql = "INSERT INTO `shop_catalog` (`pid`, `name`, `title`, `description`, `path`) VALUES ('$pid', '$name', '$title', '$descrption', '$path')";

			// echo $sql;
			// die();

			$res = mysqli_query($conn, $sql);

			if ($res && mysqli_affected_rows($conn)>0) {
				echo "<script>alert('分类添加成功'); window.location.href='./cata.list.php".$p."';</script>";
			} else{
				echo "<script>alert('分类添加失败'); window.location.href='./cata.add.php';</script>";
			}
			mysqli_close($conn);
			break;

		case 'delcata':
			$id= $_GET['id'];
			$p = $_GET['p'];

			/*查询登录用户的等级*/
			$isLogin_admin = $_SESSION['admin']['username'];
			// 从数据库获取用户等级
			$sql = "SELECT * FROM `shop_user` WHERE `username` = '{$isLogin_admin}'";
			$res = mysqli_query($conn, $sql);
			$user_grade = mysqli_fetch_assoc($res)['grade'];
			// 如果是非管理员，提示没有权限
			if ($user_grade >= 1 ) {
				echo "<script>alert('您没有删除分类的权限');window.location.href='./cata.list.php?p={$p}'</script>";
				exit;   
			}

			// 遍历父ID
			$sql = "SELECT * FROM `shop_catalog`";
			$res = mysqli_query($conn, $sql);
			if ($res) {
				while ($row = mysqli_fetch_assoc($res)) {
					$pid[] = $row['pid'];
				}
			}
			$pid = array_unique($pid);

			// 删除目录前，首先查找该分类的ID是否是父ID
			// 如果要删除的分类id存在于父id中，就返回true
			$res = in_array($id, $pid);

			if ($res) {
				echo "<script>alert('您删除的分类存在子分类，请先删除子分类');window.location.href='./cata.list.php?p={$p}'</script>";
				exit();
			} else{
				// 检查您要删除的分类id下是否有产品，首先遍历产品所属的分类id
				$sql = "SELECT * FROM `shop_product` WHERE `cata_id` = {$id}";
				$res = mysqli_query($conn, $sql);
				$nums = mysqli_affected_rows($conn);

				// 如果该分类下没有产品，则可以删除该分类
				if ($nums==0) {
					// 删除分类
					$sql = "DELETE FROM `shop_catalog` WHERE `id` = {$id}";
					if (mysqli_query($conn, $sql)) {
						echo "<script>alert('删除成功');window.location.href='./cata.list.php?p={$p}'</script>";
					} else{
						echo "<script>alert('删除失败');window.location.href='./cata.list.php?p={$p}'</script>";
					}

				} else{
					echo "<script>alert('先删除该分类下所有产品后，才能删除该分类');window.location.href='./cata.list.php?p={$p}'</script>";
				}
			}

			break;

		case 'updatecata':
			$name = $_POST['name'];
			$title = $_POST['title'];
			$description = $_POST['description'];
			$p = $_GET['p'];
			$p = isset($p)?"?p={$p}":NULL;
			$id = $_GET['id'];
			$sql = "UPDATE `shop_catalog` SET `name` = '{$name}', `title` = '{$title}', `description` = '{$description}' WHERE `id` = ".$id;

			$res = mysqli_query($conn, $sql);

			if ($res) {
				echo "<script>alert('分类修改成功'); window.location.href='./cata.list.php".$p."';</script>";
			} else{
				echo "<script>alert('分类修改失败'); window.location.href='./cata.list.php".$p."';</script>";
			}
			mysqli_close($conn);
			// die();
			break;

	}


	// 取得结果集中行的数目
	// echo mysqli_num_rows($res);
	
	// 释放资源
	