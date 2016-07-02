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
    echo "抱歉您没有权限添加";
    exit;   
  }

  $pid = '0';
  $path = $pid.',';

  $a = isset($_GET['a'])?$_GET['a']:NULL;
  $p = isset($_GET['p'])?$_GET['p']:NULL;

  if ($a=='addcata') {
      $p = isset($p)?"&p={$p}":NULL;
      $id = $_GET['id'];

      $sql = "SELECT * FROM `shop_catalog` WHERE id={$id}";
      $res = mysqli_query($conn, $sql);

      // var_dump($res);

      if ($res && mysqli_affected_rows($conn) > 0) {
        $row = mysqli_fetch_assoc($res);
        $name = $row['name'];
        $path = $row['path'].$id.',';
        $pid = $id;
      }
      $id = isset($id)?"&id={$id}":NULL;
  }

  if ($a=='updatecata') {
      $id = $_GET['id'];
      $sql = "SELECT * FROM `shop_catalog` WHERE id = ".$id;
      $p = isset($p)?"&p={$p}":NULL;
      $res = mysqli_query($conn, $sql);

      // var_dump($res);

      if ($res && mysqli_affected_rows($conn) > 0) {
        $row = mysqli_fetch_assoc($res);
        $name = $row['name'];
        $title = $row['title'];
        $description = $row['description'];
      }
      $id = isset($id)?"&id={$id}":NULL;
  }

?>
<!DOCTYPE html>
<html>
<head>
	<title>添加顶级分类</title>
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
    <h1>添加顶级分类</h1>
    <h4><?php
          if ($a=='addcata'&&isset($name)) {
            echo "给上一级分类：<span style='color:#f00;'>{$name}</span>，添加子分类";
          }
          if ($a=='updatecata'&&isset($name)) {
            echo "修改当前分类：<span style='color:#f00;'>{$name}</span>的名称";
          }

    ?></h4>
    <hr/>
    <div class="row">
        <div class="col-md-6">
          <form action="./cata.handle.php<?php echo !empty($a)?"?a=".$a.$id.$p:'?a=addcata' ?>" method="post">
            <table border="0" width="800">
              <input type="hidden" name="path" value="<?php echo $path; ?>">
              <input type="hidden" name="pid" value="<?php echo $pid; ?>">
              <tr>
                <td width="100" align="right">分类名 Name：</td>
                <td><input type="text" name="name" class="form-control" placeholder="分类名" value="<?php echo ($a=='updatecata')?$name:NULL ?>" /></td>
              </tr>
              <tr>
                <td width="100" align="right">标题 Title：</td>
                <td><input type="text" name="title" class="form-control" placeholder="分类名" value="<?php echo ($a=='updatecata')?$title:NULL ?>" /></td>
              </tr>
              <tr>
                <td width="100" align="right">分类描述 Description：</td>
                <td>
                <textarea class="form-control" name="description" placeholder="分类描述" rows="6"><?php echo ($a=='updatecata')?$description:NULL ?></textarea>
                </td>
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
  </div>
</body>
</html>