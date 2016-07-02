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

?>
<!DOCTYPE html>
<html>
<head>
	<title>用户添加</title>
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
    <h1>用户添加</h1>
    <hr/>
    <div class="row">
        <div class="col-md-6">
          <form action="./user.add.handle.php" method="post" enctype="multipart/form-data">
            <table border="0" width="500">
              <tr>
                <td width="100" align="right">用户名</td>
                <td><input type="text" name="username" class="form-control" placeholder="用户名6-16位，不能数字开头" /></td>
              </tr>
              <tr>
                <td width="100" align="right">密码</td>
                <td><input type="password" name="password" class="form-control" placeholder="密码至少6位数，最大16位数" /></td>
              </tr>
              <tr>
                <td width="100" align="right">确认密码</td>
                <td><input type="password" name="repassword" class="form-control" placeholder="再次输入密码" /></td>
              </tr>
              <tr>
                <td width="100" align="right">全名</td>
                <td><input type="text" name="fullname" class="form-control" placeholder="输入全名" /></td>
              </tr>
              <tr>
                <td width="100" align="right">头像</td>
                <td><input type="file" name="image"/></td>
              </tr>
              <tr>
                <td width="100" align="right">性别</td>
                <td>
                <label class="radio-inline"><input type="radio" name="sex" value="1" />男</label>
                <label class="radio-inline"><input type="radio" name="sex" value="0" />女</label>
                <label class="radio-inline"><input type="radio" name="sex" value="2" />保密</label></td>
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
                    <option checked value="1">管理员</option>
                    <option value="2">普通会员</option>
                    <option value="3">高级会员</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td width="100" align="right">电话</td>
                <td><input type="text" name="phone" class="form-control" placeholder="输入手机号" /></td>
              </tr>
              <tr>
                <td width="100" align="right">邮箱</td>
                <td><input type="email" name="email" class="form-control" placeholder="输入email地址" /></td>
              </tr>
              <tr>
                <td width="100" align="right">状态</td>
                <td>
                    <select name="status" class="form-control">
                      <option selected value="0">禁用</option>
                      <option value="1">启用</option>
                    </select>
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