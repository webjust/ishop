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
  
  /*
  遍历分类
  */
  $sql = "SELECT * FROM `shop_catalog` order by CONCAT(`path`, `id`)";
  $res = mysqli_query($conn, $sql);
  while ($row=mysqli_fetch_assoc($res)) {
    $list_cata[] = $row;
    $list_catapid[] = $row['pid'];
  }
  mysqli_free_result($res);
  
  /*
  遍历制造商
  */
  $sql = "SELECT * FROM `shop_manufacturer` ORDER BY `id`";
  $res = mysqli_query($conn, $sql);
  while ($row=mysqli_fetch_assoc($res)) {
    $list_manufac[] = $row;
  }

  // var_dump($list_manufac);
  // die();

  mysqli_free_result($res);
  mysqli_close($conn);

?>
<!DOCTYPE html>
<html>
<head>
	<title>添加产品</title>
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
      option.disabled{ background-color: #ccc; }
    </style>
</head>
<body>
  <div id="main">
    <h1>添加产品</h1>
    <hr/>
    <div class="row">
        <div class="col-md-11">
          <form action="./pro.handle.php?a=add_product" method="post" enctype="multipart/form-data">
            <table border="0" width="80%">
              <tr>
                <td width="100" align="right">所属分类</td>
                <td><select name="cata_id" class="form-control" style="width:200px;">
                <option value="0">---选择所属的分类---</option>
                <?php 
                  foreach ($list_cata as $key => $val) {
                    $path = $val['path'];
                    $num = substr_count($path, ',');
                    $str_blank = str_repeat('+&nbsp;&nbsp;&nbsp;&nbsp;', $num-1);
                    $value_id = " value='".$val['id']."'";
                    $disabled = NULL;
                    if (in_array($val['id'], array_unique($list_catapid))) {
                      $value_id = null;
                      $disabled = " disabled class='disabled'";
                    }
                    echo "<option{$value_id}{$disabled}>{$str_blank}{$val['name']}</option>";
                  }
                ?>
                </select></td>
              </tr>
              <tr>
                <td width="100" align="right">编号</td>
                <td><input type="text" name="sku" class="form-control" placeholder="编号" style="width:200px;" /></td>
              </tr>
              <tr>
                <td width="100" align="right">数量（库存）</td>
                <td><input type="text" name="quantity" class="form-control" placeholder="数量" style="width:200px;" /></td>
              </tr>
              <tr>
                <td width="100" align="right">价格</td>
                <td><input type="text" name="price" class="form-control" placeholder="价格" style="width:200px;" /></td>
              </tr>
              <tr>
                <td width="100" align="right">品牌</td>
                <td>
                  <select name="manufacturer" class="form-control" style="width:200px;">
                  <option value="0">选择制造商</option>
                  <?php
                    foreach($list_manufac as $val){
                      $value_id = $val['id'];
                      $value_id = " value='{$value_id}'";
                      echo "<option{$value_id}>{$val['name']}</option>";
                    }
                  ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td width="100" align="right">重量</td>
                <td><input type="text" name="weight" class="form-control" placeholder="单位为g" style="width:200px;" /></td>
              </tr>
              <tr>
                <td width="100" align="right">状态</td>
                <td><select name="status" class="form-control" style="width:200px;">
                  <option value="0">新品</option>
                  <option value="1">上线</option>
                  <option value="2">下架</option>
                </select></td>
              </tr>
              <tr>
                <td width="100" align="right">排序</td>
                <td><input type="text" name="sort_order" class="form-control" placeholder="数字越大，优先级越高" style="width:200px;" /></td>
              </tr>
              <tr>
                <td width="100" align="right">图片</td>
                <td><input type="file" name="myimage"/></td>
              </tr>
              <tr>
                <td width="100" align="right">产品名：</td>
                <td><input type="text" name="name" class="form-control" placeholder="产品名" /></td>
              </tr>

              <tr>
                <td width="100" align="right">产品描述：</td>
                <td>
                <textarea class="form-control" name="description" placeholder="输入产品描述" rows="6"></textarea>
                </td>
              </tr>

              <tr>
                <td></td>
                <td><button type="submit" class="btn btn-primary">确认</button></td>
              </tr>
            </table>
          </form>

          
        </div>
        <div class="col-md-1"></div>
    </div>
  </div>
</body>
</html>