<?php
	require_once('../../comm/conn.php');
	require_once('../../comm/comm.function.php');

	session_start();
	// var_dump($_SESSION);
	// die();

	// 判断是否登录成功
	if (!checkuserLogin()) {
		echo "<script>alert('请先登录');window.location.href='../../index.php';</script>";
		exit();
	}

	$username = $_SESSION['buyer']['username'];

	// 根据用户名，查找个人信息
	$sql = "SELECT * FROM shop_user WHERE `username` = '{$username}'";
	$userinfo = array();
	$res = mysqli_query($conn, $sql);
	if ($res) {
		while($row = mysqli_fetch_assoc($res)){
			$userinfo[] = $row;
		}
	}
	// var_dump($userinfo);
	mysqli_free_result($res);

	// 根据用户名，查找订单
	$sql = "SELECT * FROM shop_order WHERE `username` = '{$username}' ORDER BY `id` DESC";
	$orderlist = array();
	$res = mysqli_query($conn, $sql);
	if ($res) {
		while($row = mysqli_fetch_assoc($res)){
			$orderlist[] = $row;
		}
	}
	// var_dump($orderlist);
	mysqli_free_result($res);
	mysqli_close($conn);

	// 订单状态
	$order_status = array('等待发货', '已发货', '已收货', '等待退货', '已退货', '完成订单');

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
	.con table{ border: 1px solid #ddd; border-bottom: none; border-right: none;}
	.con table td, .con table th{ border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; padding: 5px 10px;}

	.con .c_block{ margin-bottom: 20px; }
	.con H3{ line-height: 30px; border-bottom: 1px solid #ddd; margin-bottom: 10px; }
	.order_update{ display: inline-block; background-color: #c00; border:1px solid #c00; border-radius: 3px; color: #fff; width: 60px; text-decoration: none; text-align: center; margin:0 auto; padding: 3px; }
	a.order_update:hover{ color: #fff; text-decoration: none; background-color: #f00; }
	.hover1, .hover2, .hover3, .hover4, .hover5{ font-weight: bold; }
	.hover5{ color: green; }
	.hover2{ color: blue; }
	.hover4{ color: red; }
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
		<table width="100%" cellspacing="0">
			<tr>
				<th>ID</th>
				<th>username</th>
				<th>注册时间</th>
			</tr>
			<?php foreach ($userinfo as $data): ?>
				
				<tr>
					<td><?php echo $data['id'] ?></td>				
					<td><?php echo $data['username'] ?></td>				
					<td><?php echo date('Y-m-d H:i:s', $data['addtime']) ?></td>				
				</tr>
				

			<?php endforeach; ?>
		</table>
	</div>
	<div class="c_block">
		<h3>订单信息</h3>
		<table width="100%" cellspacing="0">
			<tr>
				<th>ID</th>
				<th>订单编号</th>
				<th>订单金额</th>
				<th>订单日期</th>
				<th>订单状态/操作</th>
			</tr>
			<?php if(!empty($orderlist)): ?>
			<?php foreach ($orderlist as $data): ?>
				<tr>
					<td><?php echo $data['id'] ?></td>
					<td><a href="./orderdetail.php?order=<?php echo $data['order_num'] ?>"><?php echo $data['order_num'] ?></a></td>
					<td>&yen; <?php echo $data['total'] ?></td>
					<td><?php echo date('Y-m-d H:i:s', $data['dateadded']) ?></td>
					<td><?php 
						echo "<span class='hover{$data['order_status']}'>".$order_status[$data['order_status']]."</span>"."&nbsp;&nbsp;&nbsp;&nbsp;";
						checkOrderClient($data['order_status'], $data['order_num']);
						?>

					</td>
				</tr>
			<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="5"><span style="color:#c00;">没有订单信息</span></td>
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