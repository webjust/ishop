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

	$sql = "SELECT COUNT(*) FROM `shop_review`";

	$total = mysqli_query($conn, $sql);
	$total_rows = mysqli_fetch_row($total)[0];

	// 每页数量
	$page_num = 5;
	$pages = ceil($total_rows/$page_num);

	if (!is_numeric($p)||$p<1) {
		$p=1;
	}

	if (!is_numeric($p)||$p>$pages) {
		$p=$pages;
	}

	$sql = "SELECT * FROM `shop_review` ORDER BY `date_added` DESC LIMIT ".($p-1)*$page_num.", {$page_num}";

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
	$sql = '';

	/*
	遍历评价
	*/
	$sql2 = "SELECT * FROM `shop_review` ORDER BY `review_id` DESC";
	$review_list = array();
	$res2 = mysqli_query($conn, $sql2);
	while ($row2=mysqli_fetch_assoc($res2)) {
		$review_list[] = $row2;
	}

	mysqli_close($conn);

	// 用于URL传参，当前页码，上传更新后返回当前页
	$page = "&p=".$p;

	// 评价状态
	$review_status = array('0'=>'待审核', '1'=>'通过审核');

?>


<!DOCTYPE html>
<html>
<head>
	<title>评论列表 <?php echo "第".$p."页"; ?></title>
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
    <h1>用户评价<?php echo "<span class='small'>第".$p."页</span>"; ?></h1>
    <hr/>
    <div class="row">
        <div class="col-md-12" class="table-responsive user">
			<table class="table table-bordered">
				<tr>
					<th>ID</th>
					<th>产品ID</th>
					<th>客户ID</th>
					<th>用户名</th>
					<th>内容</th>
					<th>评分</th>
					<th>日期</th>
					<th>状态</th>
				</tr>

				<?php $i=1; foreach ($list as $data): ?>
						<!-- 用于显示评价的状态的按钮的样式属性 -->
					<?php $btn_info = ($data['status']==0)?"btn-warning":'btn-success'; ?>
					<tr <?php echo ($i%2==0)?"style='background-color:#eee'":NULL; ?>>
						<td><?php echo $data['review_id'] ?></td>
						<td><?php echo $data['product_id'] ?></td>
						<td><?php echo $data['customer_id'] ?></td>
						<td><?php echo $data['author'] ?></td>
						<td><?php echo $data['text'] ?></td>
						<td><?php echo $data['rating'] ?></td>
						<td><?php echo date('Y-m-d H:i:s', $data['date_added']) ?></td>
						<td><a href="./pro.handle.php?a=review_status&review_id=<?php echo $data['review_id'].'&status='.$data['status'] ?>&p=<?php echo $p; ?>" class="btn <?php echo $btn_info ?> btn-xs"><?php echo $review_status[$data['status']] ?></a></td>
					</tr>
				<?php $i++; endforeach; ?>
				<tr>
					<td colspan="8" align="center">
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