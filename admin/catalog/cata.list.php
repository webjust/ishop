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
		// echo "<script>alert('您没有查看权限'); window.location.href='./cata.list.php';</script>";
		exit;		
	}
	
	// 获取当前分页
	$p = isset($_GET['p'])?$_GET['p']:1;

	// 翻页部分
	$sql = "SELECT COUNT(*) FROM `shop_catalog`";
	$total = mysqli_query($conn, $sql);
	$total_rows = mysqli_fetch_row($total)[0];

	$page_num = 10;
	$pages = ceil($total_rows/$page_num);

	if (!is_numeric($p)||$p<1) {
		$p=1;
	}

	if (!is_numeric($p)||$p>$pages) {
		$p=$pages;
	}


	// 查找当前分页的分类
	$sql = "SELECT * FROM `shop_catalog` ORDER BY CONCAT(`path`, `id`) LIMIT ".($p-1)*$page_num.", {$page_num}";
	$res = mysqli_query($conn, $sql);

	if ($res && !empty(mysqli_num_rows($res))) {
		while ($row = mysqli_fetch_assoc($res)) {
			$list[] = $row;
		}
	} else{
		echo "没有任何分类，请添加分类";
		die();
	}

	// var_dump($list);
	mysqli_free_result($res);
	mysqli_close($conn);

	$url = $_SERVER['PHP_SELF'];
	$url_parts = explode('/', $url);
	array_pop($url_parts);
	$url = join('/',$url_parts);
?>


<!DOCTYPE html>
<html>
<head>
	<title>分类列表 <?php echo "第".$p."页"; ?></title>
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
    <h1>分类列表<?php echo "<span class='small'>第".$p."页</span>"; ?></h1>
    <hr/>
    <div class="row">
        <div class="col-md-12" class="table-responsive user">
			<table class="table table-bordered">
				<tr>
					<th>ID</th>
					<th>父ID</th>
					<th>分类名称</th>
					<th>路径</th>
					<th>操作</th>

				</tr>
				<?php $i=1; foreach ($list as $data): ?>
				<?php 
					//substr_count 计算字串出现的次数
					// str_repeat  重复一个字符串
					$count = substr_count($data['path'], ',');
					$sub_str = str_repeat("+&nbsp;&nbsp;&nbsp;&nbsp;", $count-1);
				?>
					<tr <?php echo ($i%2==0)?"style='background-color:#eee'":NULL; ?>>
						<td><?php echo $data['id'] ?></td>
						<td><?php echo $data['pid'] ?></td>
						<td><a href="../../catalog.php?cid=<?php echo $data['id'] ?>"><?php echo $sub_str.$data['name'] ?></a></td>
						<td><?php echo $data['path'] ?></td>
						<td><label><a href="./cata.add.php?a=addcata<?php echo '&id='.$data['id'].'&pid='.$data['pid'].'&p='.$p ?>" class="btn btn-primary btn-xs">添加子分类</a></label>
						<label><a href="./cata.add.php?a=updatecata<?php echo '&id='.$data['id'].'&p='.$p ?>" class="btn btn-info btn-xs">更新</a></label>
						<label><a href="./cata.handle.php?a=delcata<?php echo '&id='.$data['id'].'&p='.$p ?>" class="btn btn-danger btn-xs">删除</a></label>
							</td>
					</tr>
				<?php $i++; endforeach; ?>
				<tr>
					<td colspan="13" align="center">
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
<script type="text/javascript">
function show_confirm()
{
var r=confirm("确认删除吗");
if (r==true)
  {
  window.location.href=<?php echo "'./user.del.handle.php?id="."{$data['id']}'" ?>
  }
}
</script>
</html>
