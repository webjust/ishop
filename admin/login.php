<?php 
session_start();
$check_login = isset($_SESSION['admin']['isLogin'])?$_SESSION['admin']['isLogin']:NULL;
if ($check_login) {
  header('location:./index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>iSHOP后台登陆</title>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style/css/bootstrap.css" rel="stylesheet">
    <link href="./style/css/font-awesome.css" rel="stylesheet">
    <link href="./style/css/style.css" rel="stylesheet">
    <link href="./style/css/custom-styles.css" rel="stylesheet">
    <link href="./style/js/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <style type="text/css">
    h1{ font-size: 30px; padding: 40px; text-align: center; }
    body{ background-color: rgb(<?php echo mt_rand(100,255)?>,<?php echo mt_rand(100,255)?>,<?php echo mt_rand(100,255)?>);}
    </style>
</head>
<body>
<div class="row" style="padding:0; margin:0;">
<div class="col-xs-3"></div>
<div class="col-xs-6">
<h1>iSHOP后台登录</h1>
<form class="form-horizontal" action="doLogin.php" method="POST">
  <div class="form-group">
    <label class="col-sm-2 control-label">用户名</label>
    <div class="col-sm-10">
      <input type="text" name="username" class="form-control" placeholder="用户名">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">密码</label>
    <div class="col-sm-10">
      <input type="password" name="password" class="form-control" placeholder="密码">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">验证码</label>
    <div class="col-sm-10">
      <input type="text" name="code" class="form-control" placeholder="验证码">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
     <img src="../comm/code.php" onclick="this.src='../comm/code.php?test=' + Math.random();" />
    </div>
  </div>
<!--   <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <input type="checkbox"> 记住我
        </label>
      </div>
    </div>
  </div> -->
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-info">登录</bu
    </div>
  </div>
</form>
<p style="text-align:center"><a href="http://ishop.com/index.php" style="color:#333; font-size:12px; text-decoration:underline;">回到网站首页</a></p>
</div>
<div class="col-xs-3"></div>
</div>
<div style="text-align:center; font-size:13px; color:#666; clear:both;">&copy iSHOP 2016.6 By [XDL PHPGZ-16] WangBo</div>
</body>
</html>