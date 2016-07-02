<?php
	require('../../comm/conn.php');

	$id = $_GET['id'];
	$p = $_GET['p'];
/*Array
(
    [password] => 
    [repassword] => 
    [jobtitle] => 普通员工
    [department] => 产品研发
    [grade] => 1
    [phone] => 19000000000
    [email] => 1@12.com
    [status] => 0
)

*/
	$password = $_POST['password'];
	echo "<br>";

	// var_dump(empty($_POST['password']));

	if(!empty($_POST['password'])&&!empty($_POST['repassword'])){
		// 验证密码的格式是否符合规范
		$pattern = '/^\w{6,16}/';
		if(!preg_match($pattern, $_POST['password'])){
			echo "<script>alert('密码需至少6位数'); window.location.href='./user.list.php';</script>";
			exit();		
		}
		// 验证密码是否一致，且不能为空
		if (isset($_POST['password']) && !empty($_POST['password'])) {
			$password = $_POST['password'];
			if (isset($_POST['repassword']) && !empty($_POST['repassword'])) {
				$repassword = $_POST['repassword'];
				if ($password!==$repassword) {
					echo "<script>alert('输入的确认密码错误！两次密码不一致'); window.location.href='./user.list.php?p={$p}';</script>";
				}else{
					$password = md5($_POST['password']);
				}
			} else{
			echo "<script>alert('请输入确认密码，不能为空'); window.location.href='./user.list.php?p={$p}';</script>";
			}
		} else{
			echo "<script>alert('请输入密码'); window.location.href='./user.list.php?p={$p}';</script>";
			exit();
		}
		$_POST['password'] = md5($_POST['password']);
		unset($_POST['repassword']);
	} else{
		array_shift($_POST);
		array_shift($_POST);
	}



	$str = '';
	foreach ($_POST as $key => $value) {
		$str .= "`{$key}` = "."'{$value}', ";
	}
	$addtime = time();
	$str .= "`addtime` = {$addtime}";


	$fields = "`".implode("`,`", array_keys($_POST))."`";
	$values = "'".implode("','", array_values($_POST))."'";
	$sql = "UPDATE `shop_user` SET {$str} WHERE id=".$id;

	// echo $image;

	// echo $sql;
	// die();

	$res = mysqli_query($conn, $sql);

	if ($res) {
		echo "<script>alert('修改成功'); window.location.href='./user.list.php?p={$p}';</script>";
	} else{
		echo "<script>alert('修改失败，请重新修改'); window.location.href='./user.list.php?p={$p}';</script>";
	}

	mysqli_close($conn);