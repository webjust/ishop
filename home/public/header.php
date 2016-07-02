<?php 
// var_dump($_SERVER);
require_once('./comm/conn.php');
require_once('./comm/comm.function.php');
// 读取SESSION
session_start();
// var_dump($_SESSION);

// echo $_SERVER['REQUEST_URI'];

if ($_SERVER['REQUEST_URI']=='/'||$_SERVER['REQUEST_URI']=='/index.php') {
	$request_url = NULL;
} else{
	$request_url = 'onmouseover="displaySubMenu(this)" onmouseout="hideSubMenu(this)" ';
	$displayNav = '#nav{ display: none; } .sub_home{ background: url(./home/images/h_icon.jpg) no-repeat 60px center; }';
}

// 数据库操作，读取目录
// 一级分类
$sql = "SELECT * FROM `shop_catalog` WHERE `pid` = 0";
$res = mysqli_query($conn, $sql);
if ($res) {
	while($row = mysqli_fetch_assoc($res)){
		$cata1_list[] = $row;
	}
}
// var_dump($cata_list);
mysqli_free_result($res);

?>
<!DOCTYPE html>
<html>
<head>
	<title>iSHOP商城_GZ16_WangBo</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="./home/public/css.css" />
	<script type="text/javascript">
		function displaySubMenu(li){
			subMenu = document.getElementById("nav");
			subMenu.style.display = "block";
		}
		function hideSubMenu(li){
			subMenu = document.getElementById("nav");
			subMenu.style.display = "none";
		}		
	</script>
	<style type="text/css">
		<?php echo $displayNav; ?>
	</style>
</head>
<body>
<?php
?>
<div style="background-color:#f02b00">
	<div id="ad"> 
	   <img id="adcon" src="./home/ad/ad0618.jpg" width="1200" height="120"/> 
	</div>
</div>
<div id="con">
	<div id="header">
		<div id="top">
			<ul>
				<li><?php echo isset($_SESSION['buyer']['username'])?"欢迎 <font color='#f00;'>{$_SESSION['buyer']['username']}</font>":NULL; ?></li>
				
				
				
				<?php echo !checkuserLogin()?"<li><a href='./login.php'>登录</a></li><li><a href='./register.php'>注册</a></li>":NULL; ?>
				<?php echo checkuserLogin()?"<li><a href='./logout.php'>注销</a></li>":NULL; ?>

				<li><a href="./home/cart/cart.php">我的购物车</a></li>
				<li><a href="./home/user/order.php">我的订单</a></li>
				<li><a href="../../article_show.php?id=6">帮助中心</a></li>
			</ul>
		</div>

		<div class="head">
			<div class="logo">
				<a href="../../index.php"><img src="./home/images/logo.jpg" /></a>
			</div>
			<div class="head-search">
				<form action="./search.php" method="get">
					<input type="text" name="keyword" size="50" class="ser_text" placeholder="搜索宝贝" value="<?php echo isset($_GET['keyword'])?$_GET['keyword']:NULL; ?>" /><input type="image" src="./home/images/search_btn.png" />
				</form>
				<div class="hot-search">
					<ul>
						<li><a href="./search.php?keyword=连衣裙">连衣裙</a></li>
						<li><a href="./search.php?keyword=短裙">短裙</a></li>
						<li><a href="./search.php?keyword=凉鞋" class="hot">凉鞋</a></li>
						<li><a href="./search.php?keyword=衬衫">衬衫</a></li>
						<li><a href="./search.php?keyword=外套">外套</a></li>
						<li><a href="./search.php?keyword=睡衣">睡衣</a></li>
						<li><a href="./search.php?keyword=包" class="hot">双肩包</a></li>
						<li><a href="./search.php?keyword=小白鞋">小白鞋</a></li>
						<li><a href="./search.php?keyword=阔腿裤">阔腿裤</a></li>
					</ul>
				</div>
			</div>
		</div>

		<div id="t-top">
			<ul id="topnav">
				<li <?php echo $request_url; ?> class="home"><a class="sub_home" href="../../index.php">首页</a>
					<!-- 导航开始 -->
					<div id="nav">
						<div class="nav-main">
						<?php foreach($cata1_list as $val): ?>
							<div class="nav-head"><h3><?php echo $val['name'] ?></h3></div>
							<div class="nav-content">
								<?php 
									// 嵌套：遍历2级分类
									// 遍历父ID为上一级的ID的分类
									$sql2 = "SELECT * FROM `shop_catalog` WHERE `pid` = {$val['id']}";
									// echo $sql;
									$res2 = mysqli_query($conn, $sql2);
									$cata2_list = [];
									if ($res2) {
										while ($row2 = mysqli_fetch_assoc($res2)){
											$cata2_list[] = $row2;
										}
									}
									// echo "<pre>";
									// print_r($cata2_list);
									// echo "</pre>";
									foreach($cata2_list as $val2):
								?>
									<div class="c2"><span class="cata2"><?php echo $val2['name']; ?></span>

									<?php 
										// 嵌套：遍历3级分类
										$sql3 = "SELECT * FROM `shop_catalog` WHERE `pid` = {$val2['id']}";
										$res3 = mysqli_query($conn, $sql3);
										$cata3_list = [];
										if ($res3) {
											while ($row3 = mysqli_fetch_assoc($res3)){
												$cata3_list[] = $row3;
											}
										}
										// print_r($cata2_list);
										foreach($cata3_list as $val3):
									?>
										<a href="./catalog.php?cid=<?php echo $val3['id'] ?>" class="cata3"><?php echo $val3['name'] ?></a>
									<?php endforeach ?>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endforeach;?>
						</div>
					</div>
					<!-- 导航结束 -->
				</li>
				<li><a href="./bestseller.php">最热</a></li>
				<li><a href="../../catalog.php?cid=68">T恤</a></li>
				<li><a href="../../catalog.php?cid=69">衬衫</a></li>
				<li><a href="../../catalog.php?cid=73">连衣裙</a></li>
				<li><a href="../../catalog.php?cid=65">睫毛膏</a></li>
				<li><a href="../../catalog.php?cid=17">包包</a></li>
				<li><a href="#" class="hot">HI范儿</a></li>
				<li><a href="#" class="hot">韩国馆</a></li>
				<li><a href="#" class="hot">团购</a></li>
				<li><a href="#" class="hot">福利社</a></li>
				<li><a href="#" class="hot">更多</a></li>
			</ul>
		</div>

	</div>
	<!-- END 头部 -->