<?php 
session_start();
require_once('../../comm/conn.php');
$username = $_SESSION['admin']['username'];
$sql = "SELECT * FROM `shop_user` WHERE `username` = '{$username}'";
// echo $sql;
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);
// var_dump($row);
mysqli_free_result($res);
mysqli_close($conn);
$grade = array('超级管理员','管理员','普通会员','高级会员');
$grade = isset($grade[$row['grade']])?$grade[$row['grade']]:NULL;
?>
<!DOCTYPE html>
<html>
<head>
	<title>网页头部</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap Styles-->
    <link href="../style/css/bootstrap.css" rel="stylesheet">
    <link href="../style/css/style.css" rel="stylesheet">
    <!-- FontAwesome Styles-->
    <link href="../style/css/font-awesome.css" rel="stylesheet">
    <!-- Morris Chart Styles-->
   
    <!-- Custom Styles-->
    <link href="../style/css/custom-styles.css" rel="stylesheet">
    <!-- TABLE STYLES-->
    <link href="../style/js/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <style type="text/css">
        body{background-color: #09192A; padding: 0; margin: 0;}
        h1{font-size: 30px; line-height: 60px; padding: 0; margin: 0; padding-left: 20px;}
        .top_left{ float: left; }
        .top_right{ float: right; font-size: 13px;}
        .top_right a{ color: #fff; font-size: 13px; color: #999;}
        .top_right a:hover{ color: #fff; }
        ul{ line-height: 20px; padding-right: 20px; padding-top: 20px; color: #aaa;}
        ul li{ display: inline-block; border-right: 1px solid #666; padding:0 20px;}
        li.last{ border: none; }
        h1 a:hover{ text-decoration: none; color: #fff; }
    </style>
</head>
<body>
<div id="top">
    <div class="top_left"><h1><a href="./main.php" target="main">iSHOP电商后台</a></h1></div>
    <div class="top_right">
        <ul>
            <li><?php echo $username.", 你好！" ?></li>
            <li><?php echo '会员等级：<font style="color:#f00;">'.$grade.'</font>'; ?></li>
            <li><a href="../../index.php" target="_top">回到首页</a></li>
            <li class="last"><a href="../logout.php" target="_top">注销</a></li>
        </ul>
    </div>
</div>
</body>
</html>