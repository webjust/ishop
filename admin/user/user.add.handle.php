<?php 
	require('../../comm/conn.php');
	require_once('../../comm/image.function.php');

	$phone =  isset($_POST['phone'])?$_POST['phone']:NULL;

	// 验证输入的用户名不能为空
	if (isset($_POST['username']) && !empty($_POST['username'])) {
		$username = $_POST['username'];
	} else{
		echo "<script>alert('用户名不能为空'); window.location.href='./user.add.php';</script>";
		exit();
	}

	// 验证用户名的格式是否符合规范
	$pattern = '/^[a-zA-Z_]\w{5,15}/';
	if(!preg_match($pattern, $_POST['username'])){
		echo "<script>alert('用户名必须由英文字母下划线组成，且不能以数字开头，必须满足6-16位'); window.location.href='./user.add.php';</script>";
		exit();		
	}

	// 获取注册用户
	$user_name = $username;
	// 查找数据库，该用户名是否有结果
	$sql = "SELECT * FROM `shop_user` WHERE `username` = '{$user_name}'";
	$res = mysqli_query($conn, $sql);
	$user_exist = mysqli_affected_rows($conn);
	// var_dump($user_exist);

	if ($user_exist==1) {
		echo "<script>alert('你要注册的用户已经存在，请重新选择'); window.location.href='./user.add.php';</script>";
		exit();			
	}

	// 验证密码的格式是否符合规范
	$pattern = '/^\w{6,16}/';
	if(!preg_match($pattern, $_POST['password'])){
		echo "<script>alert('密码需至少6位数'); window.location.href='./user.add.php';</script>";
		exit();		
	}

	// 验证密码是否一致，且不能为空
	if (isset($_POST['password']) && !empty($_POST['password'])) {
		$password = $_POST['password'];
		if (isset($_POST['repassword']) && !empty($_POST['repassword'])) {
			$repassword = $_POST['repassword'];
			if ($password!==$repassword) {
				echo "<script>alert('输入的确认密码错误！两次密码不一致'); window.location.href='./user.add.php';</script>";
			}else{
				$password = md5($_POST['password']);
			}
		} else{
		echo "<script>alert('请输入确认密码，不能为空'); window.location.href='./user.add.php';</script>";
		}
	} else{
		echo "<script>alert('请输入密码'); window.location.href='./user.add.php';</script>";
		exit();
	}

	// 判断名字不能为空
	if (isset($_POST['fullname']) && !empty($_POST['fullname'])) {
		$fullname = $_POST['fullname'];
	} else{
		echo "<script>alert('用户名称(全名)不能为空'); window.location.href='./user.add.php';</script>";
		exit();
	}


	$sex = isset($_POST['sex'])?$_POST['sex']:2;
	
	$jobtitle = $_POST['jobtitle'];
	$department = $_POST['department'];
	$grade = $_POST['grade'];

	// 电话号码验证
	$pattern = '/^1[3|5|6|7|8]{1}\d{9}$/';

	if(!preg_match($pattern, $phone)){
		echo "<script>alert('电话号码填写错误'); window.location.href='./user.add.php';</script>";
		exit();		
	} else{
		$phone = $phone;
	}

	// 邮箱格式验证
	$pattern = '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/';
	if(!preg_match($pattern, $_POST['email'])){
		echo "<script>alert('邮箱错误'); window.location.href='./user.add.php';</script>";
		exit();		
	} else{
		$email = $_POST['email'];
	}


	$status = $_POST['status'];

	$fileInfo=$_FILES['image'];
	$allowExt=array('jpeg','jpg','png','gif');
	$savePath = '../public/upload';
	$newName=uploadFile($fileInfo,$savePath,false,$allowExt);
	$addtime = time();

	// 判断图片是否上传
	if ($_FILES['image']['error']==4) {
		// 未上传，则选择默认图片
		$image = 'default.jpg';
	} else{
		$img_source = $newName;
		$zoomWidth = 100;
		$zoomHeight = 125;
		$zoomImage = zoomImg($img_source, $savePath, $zoomWidth, $zoomHeight);
		
		// 上传，则把上传函数返回的值赋给变量
		$image = basename($zoomImage);
	}


	$sql = "INSERT INTO `shop_user` (`username`, `fullname`, `password`, `sex`, `jobtitle`, `department`, `grade`, `phone`, `email`, `status`, `image`, `addtime`) VALUES('$username', '$fullname', '$password', '$sex', '$jobtitle', '$department', $grade, '$phone', '$email', $status, '$image', $addtime)";

	$res = mysqli_query($conn, $sql);

	if ($res) {
		echo "<script>alert('添加成功'); window.location.href='./user.list.php';</script>";
	} else{
		echo "<script>alert('添加失败，请重新添加'); window.location.href='./user.add.php';</script>";
	}

	mysqli_close($conn);