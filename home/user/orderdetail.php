<?php
	require_once('../../comm/conn.php');
	require_once('../../comm/comm.function.php');

	session_start();

	// 判断是否登录成功
	if (!checkuserLogin()) {
		echo "<script>alert('非法访问');window.location.href='../../index.php';</script>";
		exit();
	}

	$username = $_SESSION['buyer']['username'];
	$order_nums = isset($_GET['order'])?$_GET['order']:NULL;

	if (empty($order_nums)) {
		echo "<script>alert('非法访问');window.location.href='./order.php';</script>";
		exit();
	}

	// 根据订单编号，查找订单详情
	// $sql = "SELECT * FROM `shop_orderdetails` WHERE `order_nums` = '{$order_nums}' ORDER BY `id`";
	// 多表查询，订单详情表a, 产品表
	$sql = "SELECT a.id, a.order_nums, a.product_name, a.product_id, a.product_price, a.product_nums, b.s_image FROM `shop_orderdetails` AS a, `shop_product` AS b WHERE a.product_id = b.id AND `order_nums` = '{$order_nums}'";
	$orderdetails = array();
	$res = mysqli_query($conn, $sql);
	if ($res) {
		while($row = mysqli_fetch_assoc($res)){
			$orderdetails[] = $row;
		}
	}

	mysqli_free_result($res);

	// 根据订单编号查询订单总金额等信息
	$sql = "SELECT * FROM `shop_order` WHERE `order_num` = '{$order_nums}'";
	$res = mysqli_query($conn, $sql);
	$order_info = mysqli_fetch_assoc($res);

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
		<h3>订单详情</h3>
		<table width="100%" cellspacing="0" style="border-right:none;">
			<caption style="height:30px; margin-bottm:10px;">
				<span style="float:left;">订单编号：<FONT style='color:#c00;'><?php echo $orderdetails[0]['order_nums'] ?></FONT></span>
				<span style="float:right;">订单日期：<?php echo date('Y-m-d H:i:s', $order_info['dateadded']) ?></span>
			</caption>
			<tr>
				<th>ID</th>
				<th>产品名称</th>
				<th>产品图片</th>
				<th>产品数量</th>
				<th>产品价格</th>
			</tr>
			<?php foreach ($orderdetails as $data): ?>
				<tr>
					<td><?php echo $data['id'] ?></td>				
					<td><?php echo $data['product_name'] ?></td>				
					<td><img src="../../comm/s_image/<?php echo $data['s_image'] ?>"></td>				
					<td><?php echo $data['product_nums'] ?></td>				
					<td>&yen; <?php echo $data['product_price'] ?></td>				
				</tr>
			<?php endforeach; ?>
				<tr>
					<td>收件人详情</td>
					<td colspan="4" align="left" style="padding:40px 20px;">
						<div><b>姓名：</b><?php echo $order_info['fullname']; ?></div>
						<div><b>电话：</b><?php echo $order_info['telphone']; ?></div>
						<div><b>收货地址：</b><?php echo $order_info['address']; ?></div>
					</td>
				</tr>
				<tr>
					<td colspan="5" align="right">
						订单总金额：&yen; <span style="font-size:30px; color:#c00;"><?php echo $order_info['total'] ?></span>
					</td>
				</tr>
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