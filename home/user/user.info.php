<?php
	require_once('../../comm/conn.php');
	require_once('../../comm/comm.function.php');

	session_start();
	// var_dump($_SESSION);
	// die();

	// 判断是否登录成功
	if (!checkuserLogin()) {
		echo "<script>alert('您没有登录');window.location.href='../../index.php';</script>";
		exit();
	}

	$username = $_SESSION['buyer']['username'];

	// 根据用户名，查找个人信息
	$sql = "SELECT * FROM shop_user WHERE `username` = '{$username}'";
	$res = mysqli_query($conn, $sql);
	if ($res) {
		while($row = mysqli_fetch_assoc($res)){
			$userinfo = $row;
		}
	}
	// var_dump($userinfo);
	mysqli_free_result($res);

	// 根据用户名，查找订单
	$sql = "SELECT * FROM shop_order WHERE `username` = '{$username}' ORDER BY `id` DESC";
	$res = mysqli_query($conn, $sql);
	if ($res) {
		while($row = mysqli_fetch_assoc($res)){
			$orderlist = $row;
		}
	}
	// var_dump($orderlist);
	mysqli_free_result($res);
	mysqli_close($conn);

?>
<!DOCTYPE html>
<html>
<head>
	<title>用户订单中心</title>
	<meta charset="utf-8" />
</head>
<style type="text/css">
	*{ padding: 0; margin: 0; font-size: 13px;}
	table{ text-align: center; }
	th{ background-color: #fea; }
	h3{ font-size: 14px; }
	img{ border: none; }
	ul li{ list-style-type: none; display: inline-block; line-height: 52px; padding: 0 20px; text-align: right; }
	.nav ul li a{ color: #000; text-decoration: none; }
	.nav ul li a:hover{ color: #c00; text-decoration: none; }
	.con{ width: 960px; margin:0 auto; }
	.con table{ border: 1px solid #ddd; border-bottom: none;}
	.con table td, .con table th{ border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; padding: 5px 10px;}

	.con .c_block{ margin-bottom: 20px; }
	.con H3{ line-height: 30px; border-bottom: 1px solid #ddd; margin-bottom: 10px; }
</style>
<body>
<div>
	<div style="background-color:#ddd; padding:20px;">
		<div style="width:960px; margin:0 auto; height:52px;">
			<div style="float:left;"><a href="../../index.php"><img src="../images/logo.png" width="204"></a></div>

			<div style="float:right;" class="nav">
				<ul>
					<li><a href="./order.php">首页</a></li>
					<li><a href="./user.info.php">个人信息</a></li>
					<li><a href="../../logout.php">退出登录</a></li>
				</ul>
			</div>

		</div>
	</div>
	<!-- <div>
		<ul>
			<li><a href="#">我的订单列表</a></li>
			<li><a href="#">我的注册信息</a></li>
		</ul>
	</div> -->
	<div class="con">
	<div class="c_block">
		<h3>个人信息</h3>
		<table width="100%" cellspacing="0" style="text-align:left;">
			<?php if(!empty($orderlist)): ?>
				<tr>
					<td>用户名</td>
					<td><?php echo $orderlist['username']; ?></td>
				</tr>
				<tr>
					<td>姓名</td>
					<td><?php echo $orderlist['fullname']; ?></td>
				</tr>
				<tr>
					<td>地址</td>
					<td><?php echo $orderlist['address']; ?></td>
				</tr>
				<tr>
					<td>电话</td>
					<td><?php echo $orderlist['telphone']; ?></td>
				</tr>
				<tr>
					<td>注册时间</td>
					<td><?php echo date('Y-m-d H:i:s', $userinfo['addtime']); ?></td>
				</tr>
			<?php else: ?>
				<tr>
					<td colspan="2">
						<p style="color:#c00; text-align:center;">
							没有订单信息，暂无个人信息
						</p>
					</td>
				</tr>
			<?php endif; ?>
		</table>
	</div>
 
	</div>

	<!-- 尾部开始 -->
	<div style="text-align:center;">
		<p>版权所有 &copy; iSHOP.COM</p>
	</div>
	<!-- 尾部结束 -->
</div>
</body>
</html>