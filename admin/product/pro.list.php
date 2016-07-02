<?php
	require_once('../../comm/conn.php');
	require_once('../../comm/comm.function.php');
	checkLogin('../login.php');	

	// 翻页代码
	$p = isset($_GET['p'])?$_GET['p']:1;

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

	// 处理搜索

	$choose = isset($_GET['choose'])?$_GET['choose']:NULL;

	// var_dump($choose);

	switch ($choose) {
		case 'id':
			$where = isset($_GET['search'])?" WHERE `id` = '{$_GET['search']}'":NULL;
			$where_page = isset($_GET['search'])?"&id={$_GET['search']}":NULL;
			break;

		case 'name':
			$where = isset($_GET['search'])?" WHERE `name` LIKE '%{$_GET['search']}%'":NULL;
			$where_page = isset($_GET['search'])?"&search={$_GET['search']}":NULL;
			break;

		default:
			$where = isset($_GET['search'])?" WHERE `name` LIKE '%{$_GET['search']}%'":NULL;
			$where_page = isset($_GET['search'])?"&search={$_GET['search']}":NULL;
			break;	
	}

	$sql = "SELECT COUNT(*) FROM `shop_product`{$where}";
	// echo "<p>".$sql."</p>";
	// echo $sql."<br>";
	// echo $where_page."<br>";
	// die();

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

	// $sql = "SELECT * FROM `shop_manufacturer` ORDER BY CONCAT(`path`, `id`) LIMIT ".($p-1)*$page_num.", {$page_num}";

	$sql = "SELECT * FROM `shop_product`{$where} ORDER BY `id` DESC LIMIT ".($p-1)*$page_num.", {$page_num}";

	$res = mysqli_query($conn, $sql);

	$list = array();
	if ($res && !empty(mysqli_num_rows($res))) {
		while ($row = mysqli_fetch_assoc($res)) {
			$list[] = $row;
		}
		mysqli_free_result($res);
	}

	// var_dump($list);
	// die();
	

	$url = $_SERVER['PHP_SELF'];
	$url_parts = explode('/', $url);
	array_pop($url_parts);
	$url = join('/',$url_parts);

	$status = array('新品','在售','下架');

	/*
	遍历品牌
	*/
	$sql = "SELECT * FROM `shop_manufacturer` ORDER BY `id`";
	$res = mysqli_query($conn, $sql);
	while ($row=mysqli_fetch_assoc($res)) {
		$manufacturers[] = $row;
	}

	for ($i=0; $i<count($manufacturers); $i++) {
		$manufacturers_list[$manufacturers[$i]['id']] = $manufacturers[$i]['name'];
	}
	// echo "<pre>";
	// print_r($manufacturers_list);
	// echo "</pre>";

	// die();	

	/*
	遍历分类
	*/
	$sql = "SELECT * FROM `shop_catalog` ORDER BY `id`";
	$res = mysqli_query($conn, $sql);
	while ($row=mysqli_fetch_assoc($res)) {
		$calalog[] = $row;
	}

	for ($i=0; $i<count($calalog); $i++) {
		$catalog_list[$calalog[$i]['id']] = $calalog[$i]['name'];
	}
	// echo "<pre>";
	// print_r($catalog_list);
	// echo "</pre>";

	// die();

	mysqli_close($conn);

	// 用于URL传参，当前页码，上传更新后返回当前页
	$page = "&p=".$p;


?>


<!DOCTYPE html>
<html>
<head>
	<title>产品列表 <?php echo "第".$p."页"; ?></title>
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
    <h1>产品列表<?php echo "<span class='small'>第".$p."页</span>"; ?></h1>
    <hr/>
    <div class="row">
    	<div class="col-md-12 form-group form-group-sm">
    		<form action="./pro.list.php" method="get" class="form-inline">
    			<select class="form-control input-sm choose" name="choose">
    				<option>请选择</option>
    				<option value="name">产品名称</option>
    				<option value="id">ID</option>
    			</select>
    			<input type="text" name="search" class="input-sm form-control">
    			<input type="submit" value="搜索" placeholder="输入搜索关键字" class="input-sm btn btn-info btn-sm form-control">
    		</form>
    	</div>
        <div class="col-md-12" class="table-responsive user">
			<table class="table table-bordered">
				<tr>
					<td colspan="15" align="center">
						<div class="page_num">

						<span><?php echo "共".$pages."页" ?></span>						
						<span><?php echo "第".$p."页" ?></span>						
						<span><a href="<?php echo $_SERVER['PHP_SELF']."?p=1{$where_page}" ?>">首页</a></span>
						<span><a href="<?php echo $_SERVER['PHP_SELF']."?p=".($p-1).$where_page ?>">上一页</a></span>
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
						<span><a href="<?php echo $_SERVER['PHP_SELF']."?p=".($p+1).$where_page ?>">下一页</a></span>
						<span><a href="<?php echo $_SERVER['PHP_SELF']."?p=".$pages.$where_page ?>">尾页</a></span>
						<span><?php echo "共".$total_rows."条" ?></span>
						</div>
					</td>
				</tr>			
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>分类ID</th>
					<th>图片</th>
					<th>SKU</th>
					<th>库存数量</th>
					<th>价格</th>
					<th>品牌</th>
					<th>重量</th>
					<th>状态</th>
					<th>浏览数</th>
					<th>销售</th>
					<th>排序</th>
					<th>日期</th>
					<th>操作</th>


				</tr>

				<?php $i=1; foreach ($list as $data): ?>

					<tr <?php echo ($i%2==0)?"style='background-color:#eee'":NULL; ?>>
						<td><?php echo $data['id'] ?></td>
						<td><?php echo $data['name'] ?></td>
						<td><?php echo $catalog_list["{$data['cata_id']}"] ?></td>
						<td><img width="50" src="<?php echo ($data['s_image']=='default.jpg')?('../../comm/p_image/'.$data['image']):('../../comm/s_image/'.$data['s_image']) ?>"></td>
						<td><?php echo $data['sku'] ?></td>
						<td><?php echo $data['quantity'] ?></td>
						<td><?php echo '￥'.$data['price'].'元' ?></td>
						<td><?php echo $manufacturers_list["{$data['manufacturer']}"] ?></td>
						<td><?php echo $data['weight'] ?></td>
						<td><?php echo $status["{$data['status']}"] ?></td>
						<td><?php echo $data['viewed'] ?></td>
						<td><?php echo $data['solded'] ?></td>
						<td><?php echo $data['sort_order'] ?></td>
						<td><?php echo date('Y-m-d H:i:s', $data['date_added']) ?></td>
						<td>
							<label><a href="./pro.update.php?id=<?php echo $data['id'].$page; ?>" class="btn btn-info btn-xs">更新</a></label>
							<label><a href="./pro.handle.php?a=del_product&id=<?php echo $data['id'].$page; ?>" class="btn btn-danger btn-xs">删除</a></label>
						</td>

					</tr>
				<?php $i++; endforeach; ?>
				<tr>
					<td colspan="15" align="center">
						<div class="page_num">

						<span><?php echo "共".$pages."页" ?></span>						
						<span><?php echo "第".$p."页" ?></span>						
						<span><a href="<?php echo $_SERVER['PHP_SELF']."?p=1{$where_page}" ?>">首页</a></span>
						<span><a href="<?php echo $_SERVER['PHP_SELF']."?p=".($p-1).$where_page ?>">上一页</a></span>
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
						<span><a href="<?php echo $_SERVER['PHP_SELF']."?p=".($p+1).$where_page ?>">下一页</a></span>
						<span><a href="<?php echo $_SERVER['PHP_SELF']."?p=".$pages.$where_page ?>">尾页</a></span>
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
