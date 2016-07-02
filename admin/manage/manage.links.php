<?php
  header('content-type:text/html;charset=utf-8');
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

  // 翻页
  $p = isset($_GET['p'])?$_GET['p']:1;
  $sql = "SELECT COUNT(*) FROM `shop_friendlink`";
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

  $sql = "SELECT * FROM `shop_friendlink` ORDER BY `sort` DESC LIMIT ".($p-1)*$page_num.", {$page_num}";
  $res = mysqli_query($conn, $sql);

  if ($res && !empty(mysqli_num_rows($res))) {
    while ($row = mysqli_fetch_assoc($res)) {
      $list[] = $row;
    }
  } else{
    // echo "<script>alert('没有任何信息，请联系管理员添加')</script>";
    // die();
  }

  // @var_dump($list);
  @mysqli_free_result($res);
  @mysqli_close($conn);

?>
<!DOCTYPE html>
<html>
<head>
	<title>友情链接</title>
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

    <!-- TABLE STYLES-->
    <link href="../style/js/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <style type="text/css">
      td{ padding: 10px; }
    </style>
</head>
<body>
  <div id="main">
    <h1>友情链接</h1>
    <hr/>
    <div class="row">
        <div class="col-md-6">
          <form action="./manage.action.php?a=links" method="post" enctype="multipart/form-data">
            <table border="0" width="500">
              <tr>
                <td width="100" align="right">网站</td>
                <td><input type="text" name="website" class="form-control" placeholder="添加网站名称" /></td>
              </tr>
              <tr>
                <td width="100" align="right">网址</td>
                <td><input type="text" name="webaddress" class="form-control" placeholder="添加网站链接" /></td>
              </tr>
              <tr>
                <td width="100" align="right">排序</td>
                <td><input type="text" name="sort" class="form-control" placeholder="排序，数字越大优先级越大" /></td>
              </tr>
              <tr>
                <td></td>
                <td><button type="submit" class="btn btn-primary">确认</button></td>
              </tr>
            </table>
          </form>

          
        </div>
        <div class="col-md-6"></div>
    </div>
    <div class="row">
        <div class="col-md-6">
        <table class="table table-bordered">
          <caption><h4>友情链接</h4></caption>
          <tr>
            <th>ID</th>
            <th>网站</th>
            <th>网址</th>
            <th>排序</th>
            <th>操作</th>
          </tr>
          <?php $i=1; foreach($list as $val): ?>
              <tr <?php echo ($i%2==0)?"style='background-color:#eee'":NULL; ?>>
                <td><?php echo $val['id']; ?></td>
                <td><?php echo $val['website']; ?></td>
                <td><a href="<?php echo $val['webaddress']; ?>" target="_blank"><?php echo $val['webaddress']; ?></a></td>
                <td><?php echo $val['sort']; ?></td>
                <td>
                  <label><a href="<?php echo './update.links.php?id='.$val['id'] ?>" class="btn btn-info btn-xs">更新</a></label>
   
                  <label><a href="<?php echo './manage.action.php?a=dellink&id='.$val['id'] ?>" class="btn btn-danger btn-xs">删除</a></label>
                </td>
              </tr>
          <?php $i++; endforeach; ?>
              <tr align="center">
                <td colspan="5">
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