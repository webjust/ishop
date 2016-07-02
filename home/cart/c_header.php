<?php 
// var_dump($_SERVER);
require_once('../../comm/conn.php');
require_once('../../comm/comm.function.php');
// 读取SESSION
session_start();
// var_dump($_SESSION);
?>
<!DOCTYPE html>
<html>
<head>
	<title>iSHOP商城_GZ16_WangBo</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="../public/css.css" />
	<style type="text/css">
		<?php echo $displayNav; ?>
	</style>
</head>
<body>
<div id="con">
	<div id="c_header">
		<div id="top">
			<ul>
				<li><?php echo isset($_SESSION['buyer']['username'])?"欢迎 <font color='#f00;'>{$_SESSION['buyer']['username']}</font>":NULL; ?></li>
				
				<?php echo !checkuserLogin()?"<li><a href='../../login.php'>登录</a></li><li><a href='../../register.php'>注册</a></li>":NULL; ?>
				<?php echo checkuserLogin()?"<li><a href='../../logout.php'>注销</a></li>":NULL; ?>

				<li><a href="./cart.php">我的购物车</a></li>
				<li><a href="../user/order.php">我的订单</a></li>
				<li><a href="../../article_show.php?id=6">帮助中心</a></li>
			</ul>
		</div>

		<div class="head">
			<div class="logo">
				<a href="../../index.php"><img src="../images/logo.jpg" /></a>
			</div>
			<div class="head-search">
				<form action="../../search.php" method="get">
					<input type="text" name="keyword" size="50" class="ser_text" placeholder="搜索宝贝" value="<?php echo isset($_GET['keyword'])?$_GET['keyword']:NULL; ?>" /><input type="image" src="../images/search_btn.png" />
				</form>
				<div class="hot-search">
					<ul>
						<li><a href="../../search.php?keyword=连衣裙">连衣裙</a></li>
						<li><a href="../../search.php?keyword=短裙">短裙</a></li>
						<li><a href="../../search.php?keyword=凉鞋" class="hot">凉鞋</a></li>
						<li><a href="../../search.php?keyword=衬衫">衬衫</a></li>
						<li><a href="../../search.php?keyword=外套">外套</a></li>
						<li><a href="../../search.php?keyword=睡衣">睡衣</a></li>
						<li><a href="../../search.php?keyword=包" class="hot">双肩包</a></li>
						<li><a href="../../search.php?keyword=小白鞋">小白鞋</a></li>
						<li><a href="../../search.php?keyword=阔腿裤">阔腿裤</a></li>
					</ul>
				</div>
			</div>
		</div>

	</div>
	<!-- END 头部 -->