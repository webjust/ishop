<?php 
	include('./home/public/header.php');
	require_once('./comm/conn.php');

	// 购买数量
	$nums = 1;
	$nums = isset($_GET['nums'])?$_GET['nums']:1;
	if ($nums<1) {
		$nums = 1;
	}

	// 传入当前分类的id
	// print_r($_GET);

	// 遍历随机产品信息
	$sql = "SELECT * FROM `shop_product`";
	$id_list = mysqli_query($conn, $sql);
	if ($id_list) {
		while ($row = mysqli_fetch_assoc($id_list)) {
			$id_lists[] = $row['id'];
			$product_all[] = $row;
		}
	}
	// var_dump($id_lists);
	$counts = count($id_lists);

	$product_rand = array();
	for ($i=0; $i <= 4; $i++) { 
		$j = mt_rand(0, $counts-1);
		$product_rand[] = $product_all[$j];
	}

	// var_dump($product_rand);

	// 遍历当前ID的产品信息
	$id = isset($_GET['id'])?($_GET['id']+0):NULL;
	if (!$id) {
		echo "<script>alert('非法访问');window.location.href='./index.php';</script>";
		exit();
	}
	$sql = "SELECT * FROM `shop_product` WHERE `id` = {$id}";
	$res = mysqli_query($conn, $sql);
	$product = @mysqli_fetch_assoc($res);
	// var_dump($product);

	// 判断当购买数量大于库存数，购买数量就是库存数量
	$nums = ($nums>$product['quantity'])?$product['quantity']:$nums;

	// 判断最小数量不能为1
	// $nums = ()

	// 读取评论内容
	$sql = "SELECT * FROM `shop_review` WHERE `product_id` = {$id} AND `status` = 1 ORDER BY `review_id` DESC";
	$res = mysqli_query($conn, $sql);
	$review_list = array();
	if($res && mysqli_affected_rows($conn)>0){
		while($row = mysqli_fetch_assoc($res)){
			$review_list[] = $row;
		}
	}
	// var_dump($review_list);
	mysqli_free_result($res);
?>	

<div id="content">
	<div style="height:20px;"></div>
	<div class="product">
		<div class="l_image">
			<?php 
				$pic = "./comm/p400_image/{$product['image']}";
				if(file_exists($pic)){
					$pic = $pic;					
				} else{
					$pic = "./comm/p_image/{$product['image']}";
				}


			?>
			<img src="<?php echo $pic; ?>" width="400" height="600" title="<?php echo $product['name'] ?>" alt="<?php echo $product['name'] ?>">
		</div>
		<div class="r_description">
			<div class="r_content">
				<H1><?php echo $product['name'] ?></H1>
				<p>订单编号：<?php echo $product['sku'] ?></p>
				<div class="ppp">
					<div class="pro_block">
						<div class="pro_tit">价格：</div>
						<div class="p_price"><span>&yen <b><?php echo $product['price'] ?></b></span></div>
					</div>

					<div>
						<div class="pro_tit">已销售：</div>
						<div class="nums"><span><i><?php echo $product['solded'] ?></i>个</span></div>
					</div>

					<div>
						<div class="pro_tit">库存：</div>
						<div class="nums"><span><i><?php echo $product['quantity'] ?></i>个</span></div>
					</div>
				<!-- 提交到购物车开始 -->
				<form action="./home/cart/cart.php?a=addcart" method="post">
					<div>
						<div class="pro_tit">购买数量：</div>
						<div class="nums_quality">
							<a class="nums_block reduce_nums" href="./product.php?id=<?php echo $product['id'] ?>&nums=<?php echo $nums-1 ?>"></a>
							<input type="text" name="nums_buy" value="<?php echo $nums ?>" class="nums_input">
							<a class="nums_block add_nums" href="./product.php?id=<?php echo $product['id'] ?>&nums=<?php echo $nums+1 ?>"></a>
						</div>
					</div>
					
				</div>
				<div class="clear"></div>

				<?php 
					// 获取产品的信息
					$id = $product['id'];
					$name = $product['name'];
					$image = $product['image'];
					$s_image = $product['s_image'];
					$quantity = $product['quantity'];
					$price = $product['price'];
					$sku = $product['sku'];
				?>
					<input type="hidden" name="id" value="<?php echo $id ?>">
					<input type="hidden" name="name" value="<?php echo $name ?>">
					<input type="hidden" name="image" value="<?php echo $image ?>">
					<input type="hidden" name="s_image" value="<?php echo $s_image ?>">
					<input type="hidden" name="quantity" value="<?php echo $quantity ?>">
					<input type="hidden" name="price" value="<?php echo $price ?>">
					<input type="hidden" name="sku" value="<?php echo $sku ?>">

				<div>
					<input type="submit" value="立即购买" class="buynow btn_buy">
					<input type="submit" value="加入购物车" class="addcart btn_buy">
				</div>
				</form>
				<!-- 提交到购物车结束 -->

				<div>
					<div class="pro_block">
						<div class="pro_tit">服务承诺：</div>
						<div>7天无理由退货</div>
					</div>
					<div class="pro_block">
						<div class="pro_tit">支付方式：</div>
						<div class="upload_icon pay"></div>
					</div>
				</div>

			</div>
		</div>
		<div class="clear"></div>
		<div class="pro_description p_block">
			<h2>商品详情</h2>
			<div><?php echo $product['description'] ?></div>
		</div>
		<div class="pro_review p_block">
			<h2>用户评价</h2>
			<?php if(!empty($review_list)): ?>
			<?php foreach ($review_list as $key => $val): ?>
				<div style="color:#666;"><b>用户</b>：<?php echo $val['author']?>&nbsp;&nbsp;&nbsp;&nbsp;<b>评分</b>：
						<?php
							for($i=0; $i<$val['rating']; $i++){
								echo "<img src='./home/images/icon_start.png' />";
							} 
						?>
				</div>
				<div style="color:#666;"><b>内容</b>：<?php echo $val['text'] ?></div>
				<div style="color:#999;"><b>时间</b>：<?php echo date('Y-m-d H:i:s', $val['date_added']) ?></div>
				<hr>
			<?php endforeach; ?>
			<?php else: ?>
				<div>暂无评价</div>
			<?php endif; ?>
			<div>
				<form action="./review.php" method="post">
					<h3>写评价</h3>
					<table cellpadding="5">
						<tr>
							<td>作者：</td>
							<td><input type="text" placeholder="输入用户名" name="author" style="width:100px;"></td>
						</tr>
						<tr>
							<td>内容：</td>
							<td><textarea placeholder="内容不少于10个字" cols="100" name="review_text" rows="5"></textarea></td>
						</tr>
						<tr>
							<td>评分：</td>
							<td>
								<input type="radio" name="rating" value="1">1
								<input type="radio" name="rating" value="2">2
								<input type="radio" name="rating" value="3">3
								<input type="radio" name="rating" value="4">4
								<input type="radio" name="rating" value="5">5
							</td>
						</tr>
						<input type="hidden" name="product_id" value="<?php echo $id?>">
						<tr>
							<td colspan="2">
								<input type="submit" value="提交评价">
								<input type="reset" value="重写">
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<div class="rand_product p_block">
			<h2>随机推荐</h2>
			<div class="pro-list">
				<ul>
					<?php $i=1; foreach($product_rand as $val): ?>
					<!-- 路径p_image下，如果图片不存在就去p400_image路径寻找 -->
					<?php
						$picurl = "./comm/p_image/{$val['image']}";
						// echo $picurl;
						if (file_exists($picurl)) {
							$picurl = $picurl;
						} else{
							$picurl = "./comm/p400_image/{$val['image']}";
						}
					?>					
					<li<?php echo ($i%5==0)?" class='last'":NULL ?>>
						<div class="p-img">
							<a href="./product.php?id=<?php echo $val['id'] ?>"><img src="<?php echo $picurl ?>" alt="<?php echo $val['name'] ?>" title="<?php echo $val['name'] ?>" height="340" width="224"></a>
						</div>
						<div class="p-price">
							<span class="price">￥ <?php echo $val['price'] ?></span>
						</div>
						<div class="p-name"><a href="./product.php?id=<?php echo $val['id'] ?>"><?php echo $val['name'] ?></a></div>
					</li>
					<?php $i++; endforeach; ?>
					<div class="clear"></div>
				</ul>
			</div>
		</div>
	</div>

</div>

<?php 
	include('./home/public/footer.php');
?>