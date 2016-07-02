<?php 
	include('./c_header.php');
	require_once('../../comm/conn.php');

	// var_dump($_POST);
	// var_dump($_SERVER);
	// var_dump($_SESSION);

	// 获取跳转前的地址，保存到SESSION中，登录成功后，再返回该地址
	$history_url = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:NULL;
	$_SESSION['history_url'] = $history_url;

	// 获取SESSION登录状态，如果未登录则跳转至登录页面
	if (!isset($_SESSION['buyer']['isLogin'])) {
		echo "<script>alert('请先登录');window.location.href='../../login.php'</script>";
		exit();
	}

	$a = isset($_GET['a'])?$_GET['a']:NULL;
	switch ($a) {
		case 'addcart':
			// var_dump($_POST);
			$id = isset($_POST['id'])?$_POST['id']:NULL;


			if (!empty($_SESSION['buy_product']["{$id}"]['nums_buy'])) {
				$nums_buy = $_SESSION['buy_product']["{$id}"]['nums_buy'];
				$nums_buy = isset($_POST['nums_buy'])?$_POST['nums_buy']+$nums_buy:NULL;
			} else{
				$nums_buy = isset($_POST['nums_buy'])?$_POST['nums_buy']:NULL;
			}

			// 表单中输入的购物数量
			$nums_buy = isset($_POST['nums_buy'])?$_POST['nums_buy']:1;
			if ($nums_buy<1) {
				echo "<script>alert('非法个数，默认为1')</script>";
				$nums_buy = 1;
			}

			$name = isset($_POST['name'])?$_POST['name']:NULL;
			$image = isset($_POST['image'])?$_POST['image']:NULL;
			$s_image = isset($_POST['s_image'])?$_POST['s_image']:'default.jpg';
			$price = isset($_POST['price'])?$_POST['price']:NULL;
			$sku = isset($_POST['sku'])?$_POST['sku']:NULL;

			// 库存数量
			$quantity = isset($_POST['quantity'])?$_POST['quantity']:NULL;

			if($nums_buy > $quantity){
				$nums_buy = $quantity;
				echo "<script>alert('库存不足，最多数量为{$quantity}个')</script>";
			}

			if (!empty($id)) {
				$_SESSION['buy_product']["{$id}"]['id'] = $id;
				$_SESSION['buy_product']["{$id}"]['name'] = $name;
				$_SESSION['buy_product']["{$id}"]['image'] = $image;
				$_SESSION['buy_product']["{$id}"]['s_image'] = $s_image;
				$_SESSION['buy_product']["{$id}"]['price'] = $price;
				$_SESSION['buy_product']["{$id}"]['sku'] = $sku;
				$_SESSION['buy_product']["{$id}"]['nums_buy'] = $nums_buy;
			}

			// var_dump($_SESSION);
			break;
	}

	/*
		购物车注意事项：
			添加购物车，判断是否登录，跳转到登录页，登陆后返回当前页
			SESSION保存购物车信息
			重复添加产品时，SESSION保存前产品数量做累加
			删除产品，UNSET
			清空产品信息
	*/
	// var_dump($_SESSION);


	// 订单金额初始值为0
	$total_price = 0;

	// 生成唯一订单号(大写，当月英文首字符，当周英文首字符，当天时间年月日时分秒，微秒)
	$order_id = strtoupper(substr(getdate()['month'], 0, 1).substr(getdate()['weekday'], 0, 1).date('YmdHis', time()).substr(microtime(), 2,5));

	// 清空购物车
	$clear_cart = isset($_GET['a'])?$_GET['a']:NUll;
	if ($clear_cart=='clear') {
		unset($_SESSION['buy_product']);
	}
?>	

<div id="c_content">
	<H2>我的购物车</H2>
	<div class="order_status">
		<span class="c_title">订单号：</span>
		<span><?php echo $order_id; ?></span>
		<span style="text-align:right; float:right;">
			<span style="color:#c00;">第一步：加入购物车</span>&nbsp;&nbsp;&nbsp;&nbsp;
			<span style="color:#aaa;">第二步：填写收货信息</span>&nbsp;&nbsp;&nbsp;&nbsp;
			<span style="color:#aaa;">第三步：确认订单</span>&nbsp;&nbsp;
		</span>		
	</div>
	<div class="mycart">
	<form action="./cart2.php" method="post">
	<table width="100%" cellspacing="0" cellpadding="10">
		<tr>
			<th width="10%">商品图片</th>
			<th width="30%">商品名称</th>
			<th width="5%">价格</th>
			<th width="10%">数量</th>
			<th width="5%">合计</th>
			<th width="10%">操作</th>
		</tr>
		<!-- 判断购物车是否为空，不为空则遍历产品 -->
		<?php if(!empty($_SESSION['buy_product'])): ?>
		<?php foreach($_SESSION['buy_product'] as $key => $val): ?>
			<tr>
				<td align="center"><a href="../../product.php?id=<?php echo $val['id'] ?>"><img src="../../comm/s_image/<?php echo $val['s_image'] ?>" width="50"></a></td>
				<td><p><a href="../../product.php?id=<?php echo $val['id'] ?>"><?php echo $val['name'] ?></a></p></td>
				<td align="center">&yen; <?php echo $val['price'] ?></td>
				<td align="center">
					<div></div>
					<input type="text" disabled name="" class="control" value="<?php echo $val['nums_buy'] ?>" style="text-align:center; width:40px;">
					<div></div>
				</td>
				<td align="center">&yen; <?php echo $val['price']*$val['nums_buy'] ?></td>
				<td align="center"><a href="./cart_action.php?id=<?php echo $val['id'] ?>">删除</a></td>
				<!-- 订单金额累加 -->
				<?php $total_price += $val['price']*$val['nums_buy'];?>
			</tr>
		<?php endforeach; ?>
			<tr>
				<td colspan="3" align="left"><span style="color:#c00">
				<a href="./cart.php?a=clear" class="clear_cart">清空购物车</a><br><br>
				提示：修改产品数量请进入产品页进行添加，添加错误请先删除产品，再重新添加</span></td>
				<td colspan="3" align="right">
				<?php echo '商品总金额：'.'<span class="p_price">&yen;'.$total_price.'</span>'; ?>
				</td>
			</tr>
			
		<!-- 假如购物车为空，则提示购物车没有商品 -->
		<?php else: ?>
			<tr><td colspan="6" align="center"><p style="color:#f00;">购物车不能为空，请先添加商品</p></td></tr>
		<?php endif; ?>
		<tr>
			<td colspan="6" align="right">
				<div style="float:right;"><input type="submit" value="提交订单" class="buynow btn_buy" style="margin:0;" /></div>
			</td>
		</tr>			
	</table>
			<?php 
				// 通过SESSION存储订单总金额
				$_SESSION['order']['total'] = $total_price;

				// 提交SESSION存储订单编号
				$_SESSION['order']['order_num'] = $order_id;
			?>
	</form>
	</div>
</div>

<?php 
	include('./c_footer.php');
?>