<!-- 提交订单后返回成功页面 -->
<?php 
	// 获取之前的访问路径
	$history_url = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:NULL;

	// 不能直接访问该页面
	if(basename($history_url)!='sub_order.php'){
		echo "<script>alert('非法访问');window.location.href='./index.php';</script>";
		exit();
	}

	include('./home/public/header.php');

	// session_start();
	unset($_SESSION['buy_product']);

?>
<!-- BEGIN 首页 -->
<div id="content">
<h2 style="color:#c00">恭喜，您的订单成功了！</h2>
<p>订单编号：<?php echo $_SESSION['order']['order_num']; unset($_SESSION['order_num']); ?></p>
</div>
<!-- END 首页 -->
<?php 
	include('./home/public/footer.php');
?>