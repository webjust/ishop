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

	$p = isset($_GET['p'])?$_GET['p']:1;

	$sql = "SELECT COUNT(*) FROM `shop_user`";
	$total = mysqli_query($conn, $sql);
	$total_rows = mysqli_fetch_row($total)[0];

	$page_num = 5;
	$pages = ceil($total_rows/$page_num);

	if (!is_numeric($p)||$p<1) {
		$p=1;
	}

	if (!is_numeric($p)||$p>$pages) {
		$p=$pages;
	}



	$sql = "SELECT * FROM `shop_user` ORDER BY `id` DESC LIMIT ".($p-1)*$page_num.", {$page_num}";
	$res = mysqli_query($conn, $sql);

	if ($res && !empty(mysqli_num_rows($res))) {
		while ($row = mysqli_fetch_assoc($res)) {
			$list[] = $row;
		}
	} else{
		echo "没有任何用户信息，请添加用户";
		die();
	}

	// var_dump($list);
	mysqli_free_result($res);
	mysqli_close($conn);

	$url = $_SERVER['PHP_SELF'];
	$url_parts = explode('/', $url);
	array_pop($url_parts);
	$url = join('/',$url_parts);

	$sex = array('女','男','保密');
	$grade = array('超级管理员','管理员','普通会员','高级会员');
	$status = array('禁用','启用');
?>


<!DOCTYPE html>
<html>
<head>
	<title>用户列表 <?php echo "第".$p."页"; ?></title>
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
    <h1>用户列表<?php echo "<span class='small'>第".$p."页</span>"; ?></h1>
    <hr/>
    <div class="row">
        <div class="col-md-12" class="table-responsive user">
			<table class="table table-bordered">
				<tr>
					<th>ID</th>
					<th>用户名</th>
					<th>全名</th>
					<th>图片</th>
					<th>性别</th>
					<th>职位</th>
					<th>部门</th>
					<th>等级</th>
					<th>电话</th>
					<th>邮箱</th>
					<th>状态</th>
					<th>时间</th>
					<th>操作</th>
				</tr>
				<?php $i=1; foreach ($list as $data): ?>
					<tr <?php echo ($i%2==0)?"style='background-color:#eee'":NULL; ?>>
						<td><?php echo $data['id'] ?></td>
						<td><?php echo $data['username'] ?></td>
						<td><?php echo $data['fullname'] ?></td>
						<td><?php echo "<img src='../public/upload/".$data['image']."' width='60' height='75' />" ?></td>
						<td><?php echo $sex["{$data['sex']}"]; ?></td>
						<td><?php echo $data['jobtitle'] ?></td>
						<td><?php echo $data['department'] ?></td>
						<td><?php echo $grade["{$data['grade']}"]; ?></td>
						<td><?php echo $data['phone'] ?></td>
						<td><?php echo $data['email'] ?></td>
						<td>
							<a href="./user.action.php?a=status&id=<?php echo $data['id'] ?>&status=<?php echo $data['status'] ?>&p=<?php echo $p; ?>"><?php echo $status["{$data['status']}"] ?></a>
						</td>
						<td><?php echo date('Y-m-d H:i:s', $data['addtime']) ?></td>
						<td><label><a href="<?php echo $url."/user.update.php?id="."{$data['id']}&p={$p}" ?>" class="btn btn-info btn-xs">更新</a></label><br>
<!-- 							<label><a onclick="show_confirm()" href="#" class="btn btn-danger btn-xs">删除</a></label>
 -->							<label><a href="<?php echo $url."/user.del.handle.php?id="."{$data['id']}&p=" ?><?php echo $p; ?>" class="btn btn-danger btn-xs">删除</a></label>
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
