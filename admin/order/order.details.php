<?php
	require_once('../../comm/conn.php');
	require_once('../../comm/comm.function.php');
	checkLogin('../login.php');

	// 获取订单编号
	$order_nums = $_GET['order'];

	$sql = "SELECT * FROM `shop_orderdetails` WHERE `order_nums` = '{$order_nums}' ORDER BY `id` DESC";

	$res = mysqli_query($conn, $sql);

	$list = array();
	if ($res && !empty(mysqli_num_rows($res))) {
		while ($row = mysqli_fetch_assoc($res)) {
			$list[] = $row;
		}
		mysqli_free_result($res);
	}

	// 获取订单详情信息
	$sql = "SELECT * FROM `shop_order` WHERE `order_num` = '{$order_nums}'";
	$res = mysqli_query($conn, $sql);
	$order_info = mysqli_fetch_assoc($res);

	mysqli_close($conn);

	// 订单状态数组
	$order_status = array('等待发货', '已发货', '已收货', '等待退货', '已退货', '完成订单');
?>


<!DOCTYPE html>
<html>
<head>
	<title>订单详情</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap Styles-->
    <link href="../style/css/bootstrap.css" rel="stylesheet">
    <!-- FontAwesome Styles-->
    <link href="../style/css/font-awesome.css" rel="stylesheet">
    <link href="../style/css/style.css" rel="stylesheet">
    <!-- Morris Chart Styles-->
   
    <!-- Custom Styles-->
    <link href="../style/css/custom-styles.css" rel="stylesheet">
    <!-- Google Fonts
    <link href="http://fonts.useso.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
    -->
    <!-- TABLE STYLES-->
    <link href="../style/js/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <style type="text/css">
      /*td{ padding: 10px; }*/
      th{ background-color: #ffa; }
    </style>
</head>
<body>
  <div id="main">
    <h1>订单详情</h1>
    <hr/>
    <div class="row">
        <div class="col-md-12" class="table-responsive user">
        	订单编号：<b style="color:#c00"><?php echo $order_nums; ?></b><br>
			日期：<?php echo date("Y-m-d H:i:s", $order_info['dateadded']); ?><br>
			订单状态：<?php echo $order_status[$order_info['order_status']] ?><br>
			<table class="table table-bordered">
				<tr>
					<th>ID</th>
					<th>产品名称</th>
					<th>产品价格</th>
					<th>购买数量</th>
				</tr>

				<?php $i=1; foreach ($list as $data): ?>

					<tr <?php echo ($i%2==0)?"style='background-color:#eee'":NULL; ?>>
						<td><?php echo $data['id'] ?></td>
						<td><a href="../../product.php?id=<?php echo $data['product_id'] ?>" target="_blank"><?php echo $data['product_name'] ?></a></td>
						<td><?php echo $data['product_price'] ?></td>
						<td><?php echo $data['product_nums'] ?></td>
					</tr>
				<?php $i++; endforeach; ?>
				<tr>
					<td align="center">收货人详情</td>
					<td colspan="4">
						用户：<?php echo $order_info['username']; ?><br>
						姓名：<?php echo $order_info['fullname']; ?><br>
						手机：<?php echo $order_info['telphone']; ?><br>
						地址：<?php echo $order_info['address']; ?><br>
						订单金额：<?php echo $order_info['total'] ?><br>
					</td>
				</tr>
			</table>
			IP：<?php echo $order_info['ip_address']; ?>
        </div>
    </div>
  </div>
</body>
</html>
