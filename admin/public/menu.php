<!DOCTYPE html>
<html>
<head>
	<title>菜单部分</title>
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
        body{background-color: #09192A;}
    </style>
</head>
<body>
<div id="menu">
    <div class="list-group">
      <a href="#" class="list-group-item active">
        控制面板
      </a>
      <a href="#" class="list-group-item">+ 用户管理 +</a>
        <a href="../user/user.list.php" target="main" class="list-group-item sub-item">用户列表</a>
        <a href="../user/user.add.php" target="main" class="list-group-item sub-item">用户添加</a>
      <a href="#" class="list-group-item">+ 商品管理 +</a>
        <a href="../product/pro.list.php" target="main" class="list-group-item sub-item">产品列表</a>
        <a href="../product/pro.add.php" target="main" class="list-group-item sub-item">产品添加</a>
        <a href="../product/pro.manufacturer.php" target="main" class="list-group-item sub-item">添加品牌商</a>
        <a href="../product/review.php" target="main" class="list-group-item sub-item">评论列表</a>
      <a href="#" class="list-group-item">+ 分类管理 +</a>
        <a href="../catalog/cata.list.php" target="main" class="list-group-item sub-item">分类列表</a>
        <a href="../catalog/cata.add.php" target="main" class="list-group-item sub-item">添加顶级分类</a>
      <a href="#" class="list-group-item">+ 订单管理 +</a>
        <a href="../order/order.list.php" target="main" class="list-group-item sub-item">订单列表</a>
      <a href="#" class="list-group-item">+ 系统管理 +</a>
        <a href="../manage/manage.links.php" target="main" class="list-group-item sub-item">友情链接</a>
        <a href="../manage/article.add.php" target="main" class="list-group-item sub-item">文章发布</a>
    </div>
</div>
</body>
</html>