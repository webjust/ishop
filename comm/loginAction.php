<?php 
	require_once("./conn.php");

	// 接收操作
	$a = $_GET['a'];

	switch ($a) {
		case 'register':
			// 接收数据
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);
			$repassword = trim($_POST['repassword']);

			// 验证数据，是否为空
			if (empty($username)) {
				header('location:../../register.php?error=1');
				exit();
			}

			// 验证数据，用户名
			$pattern = '/^[a-zA-Z_]\w{5,15}/';
			if (!preg_match($pattern, $username)) {
				header('location:../../register.php?error=4');
				exit();		
			}

			// 验证数据，密码不能为空
			if (empty($password)) {
				header('location:../../register.php?error=2');
				exit();
			}

			// 验证数据，密码规范
			$pattern = '/\w{6,16}/';
			if (!preg_match($pattern, $password)) {
				header('location:../../register.php?error=5');
				exit();
			}

			// 验证数据，重复密码不能为空
			if (empty($repassword)) {
				header('location:../../register.php?error=3');
				exit();
			}

			// 验证数据，重复密码规范
			$pattern = '/\w{6,16}/';
			if (!preg_match($pattern, $repassword)) {
				header('location:../../register.php?error=6');
				exit();
			}

			// 密码是否一致
			if ($password!=$repassword) {
				header('location:../../register.php?error=8');
				exit();
			}

			// 验证账户名是否已经注册
			// $username = 'admin';
			$sql = "SELECT * FROM `shop_user` WHERE `username` = '{$username}'";
			// echo $sql;
			$res = mysqli_query($conn, $sql);
			$nums = mysqli_num_rows($res);
			mysqli_free_result($res);
			
			if ($nums==1) {
				header('location:../../register.php?user='.$username.'&error=7');	
				exit();
			}

			// 对密码进行加密
			$password = md5($password);

			// 写入数据库
			$sql = "INSERT INTO `shop_user` (`username`, `password`, `addtime`) VALUES('$username', '$password', UNIX_TIMESTAMP())";

			$res = mysqli_query($conn, $sql);
			
			if ($res) {
				echo "<script>alert('恭喜您，注册成功！');window.location.href='../../index.php'</script>";
			} else{
				header('location:../../register.php?error=9');
				exit();
			}

			// session_start();
			// $_SESSION['username'] = $username;
			break;

		case 'login':
			// var_dump($_POST);
			// 接收用户提交数据
			$username = $_POST['username'];
			$password = md5($_POST['password']);
			$getcode = strtolower($_POST['getcode']);
			session_start();
			$code = strtolower($_SESSION['code']);

			// 数据验证，不能为空
			if (empty($username)||empty($password)) {
				header('location:../../login.php?error=1');
				exit();
			}

			// 验证数据，用户名
			$pattern = '/^[a-zA-Z_]\w{5,15}/';
			if (!preg_match($pattern, $username)) {
				header('location:../../login.php?error=2');
				exit();		
			}

			// 校验验证码
			if ($code!=$getcode) {
				echo "<script>alert('验证码错误');window.location.href='../login.php'</script>";
				exit;
			}

			// 验证数据，密码规范
			$pattern = '/\w{6,16}/';
			if (!preg_match($pattern, $password)) {
				header('location:../../login.php?error=3');
				exit();
			}


			// 查找数据库
			$sql = "SELECT * FROM `shop_user` WHERE `username` = '{$username}' AND `password` = '{$password}'";

			$res = mysqli_query($conn, $sql);
			$nums = mysqli_num_rows($res);

			if ($nums == 1) {
				// 获取登录前的页面路径，如果没有则返回空
				$history_url = isset($_SESSION['history_url'])?$_SESSION['history_url']:NULL;

				// 如果之前的路径为空，登录后直接跳转至首页
				if(empty($history_url)){
					echo "<script>alert('登录成功');window.location.href='../../index.php'</script>";
				} else{
					// 登录成功后返回之前的路径
					echo "<script>alert('登录成功');window.location.href='".$history_url."'</script>";
					unset($_SESSION[history_url]);
				}

				$_SESSION['buyer']['username'] = $username;
				$_SESSION['buyer']['isLogin'] = 1;
			} else{
				header('location:../../login.php?error=4');
			}

			break;
	}