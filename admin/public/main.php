<?php 
    require_once('../../comm/conn.php');

    /*最新用户信息*/
    $sql = "SELECT * FROM `shop_user` ORDER BY `id` DESC LIMIT 5";
    $user_list = [];
    $res = mysqli_query($conn, $sql);
    if ($res && mysqli_affected_rows($conn) > 0) {
        while($row = mysqli_fetch_assoc($res)){
            $user_list[] = $row;
        }
    }
    // 释放资源
    mysqli_free_result($res);

    // 总用户数
    $sql = "SELECT COUNT(*) as count FROM `shop_user`";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    $user_nums = $row['count'];
    mysqli_free_result($res);

    /*最新订单信息*/
    $sql = "SELECT * FROM `shop_order` ORDER BY `id` DESC LIMIT 5";
    $order_list = [];
    $res = mysqli_query($conn, $sql);
    if ($res && mysqli_affected_rows($conn) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $order_list[] = $row;
        }
    }
    mysqli_free_result($res);

    // 总订单数
    $sql = "SELECT COUNT(*) as count FROM `shop_order`";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    $order_nums = $row['count'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>内容主体</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap Styles-->
    <link href="../style/css/bootstrap.css" rel="stylesheet">
    <!-- FontAwesome Styles-->
    <link href="../style/css/font-awesome.css" rel="stylesheet">
    <link href="../style/css/style.css" rel="stylesheet">
    <link href="../style/jq/jquery-ui.css" rel="stylesheet">
    <!-- Morris Chart Styles-->
   
    <!-- Custom Styles-->
    <link href="../style/css/custom-styles.css" rel="stylesheet">
    <!-- TABLE STYLES-->
    <link href="../style/js/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <style type="text/css">
        .notes{ color: #c00; }
        .table a{ color: #1c94c4; }
        h1 a:hover{ text-decoration: none; color: #fff; }
        .ui-widget-header{ background-color: #fafafa; border-color: #ccc; }
        .ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited{ color: #333; border-color: #ccc; }
        .ui-widget-content{ background-color: #fafafa; }
    </style>
</head>
<body>
  <div id="main">
    <h1>后台首页</h1>
    <hr/>
    <div class="row">
        <div class="col-md-12">
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">会员</a></li>
                <li><a href="#tabs-2">订单</a></li>
                <li><a href="#tabs-3">信息</a></li>
            </ul>
            <div id="tabs-1">
                <table class="table table-bordered">
                    <caption><h4>新注册用户</h4></caption>
                    <tr>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>注册时间</th>
                    </tr>
                    <?php foreach($user_list as $val): ?>
                        <tr>
                            <td><?php echo $val['id'] ?></td>
                            <td><?php echo $val['username'] ?></td>
                            <td><?php echo date('Y-m-d H:i:s', $val['addtime']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr><td colspan="3">网站总注册用户数：<span class="notes"><?php echo $user_nums; ?></span></td></tr>
                </table>
            </div>
            <div id="tabs-2">
                <table class="table table-bordered">
                    <caption><h4>最新订单信息</h4></caption>
                    <tr>
                        <th>ID</th>
                        <th>用户</th>
                        <th>姓名</th>
                        <th>订单编号</th>
                        <th>订单金额</th>
                        <th>日期</th>
                    </tr>
                    <?php foreach($order_list as $val): ?>
                        <tr>
                            <td><?php echo $val['id'] ?></td>
                            <td><?php echo $val['username'] ?></td>
                            <td><?php echo $val['fullname'] ?></td>
                            <td><a href="../order/order.details.php?order=<?php echo $val['order_num'] ?>"><?php echo $val['order_num'] ?></a></td>
                            <td><?php echo $val['total'] ?></td>
                            <td><?php echo date('Y-m-d H:i:s', $val['dateadded']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="6">总订单数：<span class="notes"><?php echo $order_nums; ?></span></td>
                    </tr>
                </table>
            </div>
            <div id="tabs-3">
                <table class="table table-bordered">
                    <caption><h4>其他信息</h4></caption>
                    <tr>
                        <td colspan="2" align="center" bgcolor="#cff">服务器信息</td>
                    </tr>
                    <tr>
                        <td>运行环境</td>
                        <td><?php echo $_SERVER['SERVER_SOFTWARE'] ?></td>                        
                    </tr>
                    <tr>
                        <td colspan="2" align="center" bgcolor="#cff">网站维护</td>
                    </tr>
                    <tr>
                        <td>手机</td>
                        <td>13500000000</td>
                    </tr>
                </table>
            </div>
        </div>            
        </div>
    </div>
  </div>
<script src="../style/jq/ext/jquery.js"></script>
<script src="../style/jq/jquery-ui.js"></script>
<script>

$( "#tabs" ).tabs();
</script>
</body>
</html>