<?php
  $id = $_GET['id'];
  require_once('../../comm/conn.php');

  $sql = "SELECT * FROM `shop_articles` WHERE id=".$id;
  $result = mysqli_query($conn, $sql);

  $row = mysqli_fetch_assoc($result);

  mysqli_free_result($result);
  mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>文章修改</title>
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
    <h1>文章修改</h1>
    <hr/>
    <div class="row">
        <div class="col-md-12">
            <form action="./article.modify.handle.php" method="POST">
              <table cellpadding="10" width="1000">
              <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                <tr>
                  <td>标题</td>
                  <td><input type="text" name="title" class="form-control" style="width:500px;" value="<?php echo $row['title'] ?>"></td>
                </tr>
                <tr>
                  <td>作者</td>
                  <td><input type="text" name="author" class="form-control" style="width:200px;" value="<?php echo $row['author'] ?>"></td>
                </tr>
                <tr>
                  <td>简介</td>
                  <td>
                    <textarea name="description" cols="60" rows="3" class="form-control"><?php echo $row['description'] ?></textarea>
                  </td>
                </tr>
                <tr>
                  <td>内容</td>
                  <td>
                    <textarea name="content" cols="60" rows="15" class="form-control"><?php echo $row['content'] ?></textarea>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" align="center">
                    <input type="submit" class="btn btn-primary">
                  </td>
                </tr>
              </table>
            </form>
        </div>
    </div>
  </div>
</body>
</html>