<?php 
	include('./c_header.php');
	// 加入购物车为空，则返回购物车
	if (empty($_SESSION['buy_product'])) {
		echo "<script>alert('你的购物车为空，请先添加商品！');window.location.href='./cart.php';</script>";
		exit();
	}

	require_once('../../comm/conn.php');

?>	

<div id="c_content">
	<H2>我的购物车</H2>
	<hr>
	<div class="order_status">
		<span class="c_title">订单号：</span>
		<span><?php echo $_SESSION['order']['order_num'] ?></span>
		<span style="text-align:right; float:right;">
			<span style="color:#aaa;">第一步：加入购物车</span>&nbsp;&nbsp;&nbsp;&nbsp;
			<span style="color:#c00;">第二步：填写收货信息</span>&nbsp;&nbsp;&nbsp;&nbsp;
			<span style="color:#aaa;">第三步：确认订单</span>&nbsp;&nbsp;
		</span>
	</div>
	<div class="mycart">
	<form action="./sub_order.php" method="post">
	<table bcellspacing="0" cellpadding="10" width="100%">
		<tr>
			<td align="center">收货人信息</td>
			<td>
				<table border="0" cellpadding="10" cellspacing="0">
					<tr>
						<td>姓名：</td>
						<td><input type="text" name="fullname" class="control" style="width:100px;"><span class="required">必填</span></td>
					</tr>
					<tr>
						<td>地址：</td>
						<td><input type="text" name="address" class="control" style="width:500px;"><span class="required">必填</span></td>
					</tr>
					<tr>
						<td>电话：</td>
						<td><input type="text" name="telphone" class="control"><span class="required">必填</span></td>
					</tr>
					<tr>
						<td>留言：</td>
						<td>
							<textarea cols="50" rows="5" class="control" name="comment"></textarea>
						</td>
					</tr>
				</table>

			</td>
		</tr>
		<tr>
			<td>货运说明</td>
			<td>本站支持：四大快递，运费信息请查看说明</td>
		</tr>
		<tr>
			<td>支付方式</td>
			<td>本站支持：支付宝，微信，网银</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<div style="float:right; padding-bottom:10px; line-height:28px;">
					<div class="total_price">商品总价：&yen; 199.99</div>
					<div class="total_price">运费：&yen; 10.00</div>
					<div class="total_price"><b>订单总价：</b><span class="p_price">&yen; 199.99</span></div>
				</div>
				<br/>
				<div class="clear"></div>
				<div style="float:right;"><input type="submit" value="提交订单" class="buynow btn_buy" style="margin:0;" /></div>
			</td>
		</tr>
	</table>
	<hr>
	</form>
	</div>
</div>

<?php 
	include('./c_footer.php');
?>