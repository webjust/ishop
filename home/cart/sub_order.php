<?php
	require_once('../../comm/conn.php');
	require_once('../../comm/comm.function.php');


	// var_dump($_POST);
	session_start();
	// var_dump($_SESSION);

	// 先验证信息，获取收货人的信息
  	$fullname = isset($_POST['fullname'])?$_POST['fullname']:NULL;
  	$address = isset($_POST['address'])?$_POST['address']:NULL;
  	$telphone = isset($_POST['telphone'])?$_POST['telphone']:NULL;
  	$comment = isset($_POST['comment'])?$_POST['comment']:'';


  	// 用户必填选项不能为空
  	if (empty($fullname)||empty($address)||empty($telphone)) {
  		echo "<script>alert('收货信息不能为空');window.location.href='./cart2.php';</script>";
  		exit();
  	}

  	// 正则判断电话号码是否为11位
  	$pattern = '/^1[3|5|6|7|8]{1}\d{9}$/';
  	if (!preg_match($pattern, $telphone)){
  		echo "<script>alert('请输入正确的手机号');window.location.href='./cart2.php';</script>";
  		exit();
  	}

	// 获取用户名
	$username = $_SESSION['buyer']['username'];

	// 获取用户ID
	$sql = "SELECT id FROM `shop_user` WHERE `username` = '{$username}'";
	// echo $sql;
	$res = mysqli_query($conn, $sql);
	$customer_id = mysqli_fetch_assoc($res)['id'];
	// echo $customer_id;

	// 把SESSION里保存的产品信息赋值给一个变量
	$orders = $_SESSION['buy_product'];
	// var_dump($orders);

	$dateadded = time();

	// 通过SESSION获取订单编号，订单总金额
	$total = $_SESSION['order']['total'];
	$order_num = $_SESSION['order']['order_num'];

	// 获取用户的IP
	$ip_address = getIP();

  	// 生成订单的sql语句
 	 $sql_order = "INSERT INTO `shop_order` (`customer_id`, `username`, `fullname`, `telphone`, `address`, `comment`, `order_num`, `total`, `order_status`, `ip_address`, `dateadded`) VALUES($customer_id, '{$username}', '{$fullname}', '{$telphone}', '{$address}', '{$comment}', '{$order_num}', '{$total}', 0, '{$ip_address}', '{$dateadded}')";


 	// 将订单插入数据库
 	$res = mysqli_query($conn, $sql_order);
 	if (!$res) {
  		echo "<script>alert('订单提交失败，请重新提交');window.location.href='./cart2.php';</script>";
 		exit();		
 	}


	// 数组遍历产品信息
	foreach ($orders as $key => $val) {
	  // 产品ID
	  $id = $val['id'];
	  // 产品名称
      $name = $val['name'];
      // 产品缩略图
      $image = $val['s_image'];
      // 产品销售价格
      $price = $val['price'];
      // 产品编号
      $sku = $val['sku'];
      // 产品购买数量
      $nums_buy = $val['nums_buy'];

      // 生成订单详情的sql语句
      $sql = "INSERT INTO `shop_orderdetails` (`order_nums`, `product_name`, `product_id`, `product_price`, `product_nums`) VALUES('{$order_num}', '{$name}', $id, '{$price}', '{$nums_buy}')";

      // echo $sql."<br>";

      mysqli_query($conn, $sql);
	}

	echo "<script>alert('订单提交成功');window.location.href='../../success.php';</script>";

?>