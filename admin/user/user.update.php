<?php
  $id = $_GET['id'];
  //echo $id;
  $p = $_GET['p'];
  require_once('../../comm/conn.php');
  $page = "?p={$p}";

  /*查询登录用户的等级*/
  session_start();
  $isLogin_admin = $_SESSION['admin']['username'];
  // 从数据库获取用户等级
  $sql = "SELECT * FROM `shop_user` WHERE `username` = '{$isLogin_admin}'";
  $res = mysqli_query($conn, $sql);
  $user_grade = mysqli_fetch_assoc($res)['grade'];

  if ($user_grade>1) {
    echo "<script>alert('您没有更新用户的权限'); window.location.href='./user.list.php{$page}';</script>";
    exit;
  }

  $sql = "SELECT * FROM `shop_user` WHERE id=".$id;
  $res = mysqli_query($conn, $sql);

  if ($res && !empty(mysqli_num_rows($res))) {
    while ($row = mysqli_fetch_assoc($res)) {
      $list = $row;
    }
  } else{
    echo "没有任何用户信息，请添加用户";
    die();
  }

  //var_dump($list);
  mysqli_free_result($res);
  mysqli_close($conn);

  $sex = array('女','男','保密');

  $grade = $list['grade'];
  //echo $grade;

?>
<!DOCTYPE html>
<html>
<head>
	<title>用户资料更新</title>
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
    <h1>用户资料更新</h1>
    <hr/>
    <div class="row">
        <div class="col-md-6">
          <form action="./user.update.handle.php?id=<?php echo $id.'&p='.$p ?>" method="post" enctype="multipart/form-data">
            <table border="0" width="500">
              <tr>
                <td width="100" align="right">用户名</td>
                <td><?php echo $list['username'] ?></td>
              </tr>
              <tr>
                <td width="100" align="right">密码</td>
                <td><input type="password" name="password" class="form-control" value="" placeholder="密码至少6位数" /></td>
              </tr>
              <tr>
                <td width="100" align="right">确认密码</td>
                <td><input type="password" name="repassword" class="form-control" value="" placeholder="再次输入密码" /></td>
              </tr>
              <tr>
                <td width="100" align="right">全名</td>
                <td><?php echo $list['fullname'] ?></td>
              </tr>
              <tr>
                <td width="100" align="right">头像</td>
                <td>
                  <img width='100' src="../public/upload/<?php echo $list['image'] ?>" ">
                </td>
              </tr>
              <tr>
                <td width="100" align="right">性别</td>
                <td>
                <?php echo $sex[ "{$list['sex']}" ] ?>
                </td>
              </tr>
              <tr>
                <td width="100" align="right">职位</td>
                <td>
                <select name="jobtitle" class="form-control">
                  <option selected="selected">普通员工</option>
                  <option>小组组长</option>
                  <option>部门经理</option>
                  <option>总经理</option>
                  <option>董事长</option>
                </select>
              </tr>
              <tr>
                <td width="100" align="right">部门</td>
                <td>
                <select name="department" class="form-control">
                  <option selected="selected">产品研发</option>
                  <option>产品设计</option>
                  <option>市场推广</option>
                  <option>董事长</option>
                </select>
              </tr>
              <tr>
                <td width="100" align="right">等级</td>
                <td>
                  <select class="form-control" name="grade">
                    <option value="1" <?php echo (($grade==1)?'checked':'') ?>>管理员</option>
                    <option value="2" <?php echo (($grade==2)?'checked':'') ?>>普通会员</option>
                    <option value="3" <?php echo (($grade==3)?'checked':'') ?>>高级会员</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td width="100" align="right">电话</td>
                <td><input type="text" name="phone" class="form-control" value="<?php echo $list['phone'] ?>" placeholder="输入手机号" /></td>
              </tr>
              <tr>
                <td width="100" align="right">邮箱</td>
                <td><input type="email" name="email" class="form-control" value="<?php echo $list['email'] ?>" placeholder="输入email地址" /></td>
              </tr>
              <tr>
                <td></td>
                <td><button type="submit" class="btn btn-primary">修改用户信息</button></td>
              </tr>
            </table>
          </form>

          
        </div>
        <div class="col-md-6"></div>
    </div>
  </div>
</body>
</html>