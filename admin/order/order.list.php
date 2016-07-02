<?php
	require_once('../../comm/conn.php');
	require_once('../../comm/comm.function.php');
	checkLogin('../login.php');	

	/*查询登录用户的等级*/
	$isLogin_admin = $_SESSION['admin']['username'];
	// 从数据库获取用户等级
	$sql = "SELECT * FROM `shop_user` WHERE `username` = '{$isLogin_admin}'";
	$res = mysqli_query($conn, $sql);
	$user_grade = mysqli_fetch_assoc($res)['grade'];
	// 如果是非管理员，提示没有权限
	if ($user_grade > 1 ) {
	echo "抱歉您没有权限查看";
	exit;   
	}

	// 翻页代码
	$p = isset($_GET['p'])?$_GET['p']:1;

	$sql = "SELECT COUNT(*) FROM `shop_order`";

	$total = mysqli_query($conn, $sql);
	$total_rows = mysqli_fetch_row($total)[0];

	// 每页产品数量
	$page_num = 10;
	$pages = ceil($total_rows/$page_num);

	if (!is_numeric($p)||$p<1) {
		$p=1;
	}

	if (!is_numeric($p)||$p>$pages) {
		$p=$pages;
	}

	$sql = "SELECT * FROM `shop_order` ORDER BY `id` DESC LIMIT ".($p-1)*$page_num.", {$page_num}";

	$res = mysqli_query($conn, $sql);

	$list = array();
	if ($res && !empty(mysqli_num_rows($res))) {
		while ($row = mysqli_fetch_assoc($res)) {
			$list[] = $row;
		}
		mysqli_free_result($res);
	}

	$url = $_SERVER['PHP_SELF'];
	$url_parts = explode('/', $url);
	array_pop($url_parts);
	$url = join('/',$url_parts);

	mysqli_close($conn);

	// 用于URL传参，当前页码，上传更新后返回当前页
	$page = "&p=".$p;

	// 订单状态
	$order_status = array('等待发货', '已发货', '已收货', '等待退货', '已退货', '完成订单');
?>


<!DOCTYPE html>
<html>
<head>
	<title>订单列表 <?php echo "第".$p."页"; ?></title>
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
      .order_update{ display: inline-block; background-color: #c00; border:1px solid #c00; border-radius: 3px; color: #fff; width: 60px; text-decoration: none; text-align: center; margin:0 auto; padding: 3px; }
      a.order_update:hover{ color: #fff; text-decoration: none; background-color: #f00; }
    </style>
</head>
<body>
  <div id="main">
    <h1>订单列表<?php echo "<span class='small'>第".$p."页</span>"; ?></h1>
    <hr/>
    <div class="row">
        <div class="col-md-12" class="table-responsive user">
			<table class="table table-bordered">
				<tr>
					<th>ID</th>
					<th>U-ID</th>
					<th>Username</th>
					<th>姓名</th>
					<th>电话</th>
					<th>地址</th>
					<th>留言</th>
					<th>订单号</th>
					<th>订单金额</th>
					<th>IP地址</th>
					<th>下单日期</th>
					<th>订单状态/操作</th>
				</tr>

				<?php $i=1; foreach ($list as $data): ?>

					<tr <?php echo ($i%2==0)?"style='background-color:#eee'":NULL; ?>>
						<td><?php echo $data['id'] ?></td>
						<td><?php echo $data['customer_id'] ?></td>
						<td><?php echo $data['username'] ?></td>
						<td><?php echo $data['fullname'] ?></td>
						<td><?php echo $data['telphone'] ?></td>
						<td><?php echo $data['address'] ?></td>
						<td><?php echo $data['comment'] ?></td>
						<td><a href="./order.details.php?order=<?php echo $data['order_num'] ?>"><?php echo $data['order_num'] ?></a></td>
						<td><?php echo $data['total'] ?></td>
						<td><?php echo $data['ip_address'] ?></td>
						<td><?php echo date('Y-m-d H:i:s', $data['dateadded']) ?></td>
						<td><?php echo $order_status[$data['order_status']]."&nbsp;&nbsp;&nbsp;&nbsp;"; checkOrderAdmin($data['order_status'], $data['order_num']) ?></td>
					</tr>
				<?php $i++; endforeach; ?>
				<tr>
					<td colspan="12" align="center">
						<div class="page_num">

						<span><?php echo "共".$pages."页" ?></span>						
						<span><?php echo "第".$p."页" ?></span>						
						<span><a href="<?php echo $_SERVER['PHP_SELF']."?p=1" ?>">首页</a></span>
						<span><a href="<?php echo $_SERVER['PHP_SELF']."?p=".($p-1) ?>">上一页</a></span>
						<?php 
							for ($i=1; $i <= $pages; $i++) {
								$active = ($i==$p)? 'active':'';

								$url = $_SERVER['PHP_SELF']."?p={$i}";

								$str = "<span class='num {$active}'>".'<a href="'.$url.'">';
								$str .= $i;
								$str .= "</a></span>";
								echo $str;
							}
						?>
						<span><a href="<?php echo $_SERVER['PHP_SELF']."?p=".($p+1) ?>">下一页</a></span>
						<span><a href="<?php echo $_SERVER['PHP_SELF']."?p=".$pages ?>">尾页</a></span>
						<span><?php echo "共".$total_rows."条" ?></span>
						</div>
					</td>
				</tr>
			</table>
        </div>
    </div>
  </div>
</body>
</html>
