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

  $p = isset($_GET['p'])?$_GET['p']:1;

  $sql = "SELECT COUNT(*) FROM `shop_manufacturer`";
  $total = mysqli_query($conn, $sql);
  $total_rows = mysqli_fetch_row($total)[0];

  $page_num = 15;
  $pages = ceil($total_rows/$page_num);

  if (!is_numeric($p)||$p<1) {
    $p=1;
  }

  if (!is_numeric($p)||$p>$pages) {
    $p=$pages;
  }



  $sql = "SELECT * FROM `shop_manufacturer` ORDER BY `id` DESC LIMIT ".($p-1)*$page_num.", {$page_num}";
  $res = mysqli_query($conn, $sql);

  if ($res && !empty(mysqli_num_rows($res))) {
    while ($row = mysqli_fetch_assoc($res)) {
      $list[] = $row;
    }
  } else{
    echo "<script>alert('没有任何信息，请联系管理员添加')</script>";
    die();
  }

  // @var_dump($list);
  @mysqli_free_result($res);
  @mysqli_close($conn);


?>
<!DOCTYPE html>
<html>
<head>
	<title>添加制造商品牌</title>
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
    th{ background-color: #ffa; }
    </style>
</head>
<body>
  <div id="main">
    <h1>添加制造商品牌</h1>
    <hr/>
    <div class="row">
        <div class="col-md-12">
          <form class="form-inline" action="./pro.handle.php?a=add_manufacturer" method="post">
            <div class="form-group">
              <label>制造商名称：</label>
              <input type="text" name="name" class="form-control" placeholder="输入品牌制造商" />
            </div>
            <button type="submit" class="btn btn-info" value="提交">提交</button>
          </form>
        </div>
        <hr />
    </div>
    <div class="row">
        <div class="col-md-5">
        <table class="table table-bordered">
          <caption><h4>制造商品牌</h4></caption>
          <tr>
            <th>ID</th>
            <th>制造商</th>
            <th>添加时间</th>
          </tr>
          <?php $i=1; foreach($list as $val): ?>
              <tr <?php echo ($i%2==0)?"style='background-color:#eee'":NULL; ?>>
                <td><?php echo $val['id']; ?></td>
                <td><?php echo $val['name']; ?></td>
                <td><?php echo date('Y-m-d H:i:s', $val['addtime']); ?></td>
              </tr>
          <?php $i++; endforeach; ?>
              <tr>
                <td colspan="3">
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