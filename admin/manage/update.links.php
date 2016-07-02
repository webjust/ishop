<?php
  header('content-type:text/html;charset=utf-8');
  require_once('../../comm/conn.php');
  require_once('../../comm/comm.function.php');

  checkLogin('../login.php');

  // 获取修改的id
  $id = $_GET['id'];

  // 数据库操作
  $sql = "SELECT * FROM `shop_friendlink` WHERE `id` = ".$id;

  $res = mysqli_query($conn, $sql);
  $frined_link = mysqli_fetch_assoc($res);

  // 关闭连接
  mysqli_free_result($res);
  mysqli_close($conn);

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
    <h1>修改链接</h1>
    <hr/>
    <div class="row">
        <div class="col-md-6">
          <form action="./manage.action.php?a=updatelink&id=<?php echo $frined_link['id']; ?>" method="post">
            <table border="0" width="500">
              <tr>
                <td width="100" align="right">网站</td>
                <td><input type="text" name="website" class="form-control" value="<?php echo $frined_link['website'] ?>" /></td>
              </tr>
              <tr>
                <td width="100" align="right">网址</td>
                <td><input type="text" name="webaddress" class="form-control" value="<?php echo $frined_link['webaddress'] ?>" /></td>
              </tr>
              <tr>
                <td width="100" align="right">排序</td>
                <td><input type="text" name="sort" class="form-control" value="<?php echo $frined_link['sort'] ?>" /></td>
              </tr>
              <tr>
                <td></td>
                <td><button type="submit" class="btn btn-primary">确认修改</button></td>
              </tr>
            </table>
          </form>        
        </div>
        <div class="col-md-6"></div>
    </div>
  </div>
</body>
</html>