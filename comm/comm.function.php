<?php 
	/*
		检查后台是否登录
	*/
	function checkLogin($url){
		session_start();
		$isLogin = @$_SESSION['admin']['isLogin'];

		if ($isLogin) {
			return true;
		} else{
			echo "<H1 style='color:#f00; font-size:60px; text-align:center; padding-top:90px;'>您需要，先登录！</H1>";
			echo "<p style='text-align:center; font-size:24px;'>3秒后自动跳转到登录页！</p>";
			echo "<meta http-equiv='refresh' content='3; url={$url}' />";
			exit();
		}
	}

	/*
		检查前台是否登录
	*/
	function checkuserLogin(){
		$isLogin = isset($_SESSION['buyer']['isLogin'])?$_SESSION['buyer']['isLogin']:NULL;
		
		if ($isLogin) {
			return true;
		} else{
			return NULL;
		}
	}

	/*
		获取客户的ip
	*/

	function getIP()
	{
	global $ip;
	if (getenv("HTTP_CLIENT_IP"))
	$ip = getenv("HTTP_CLIENT_IP");
	else if(getenv("HTTP_X_FORWARDED_FOR"))
	$ip = getenv("HTTP_X_FORWARDED_FOR");
	else if(getenv("REMOTE_ADDR"))
	$ip = getenv("REMOTE_ADDR");
	else $ip = "Unknow";
	return $ip;
	}

	/*
	  				  客户端        后台
	0   等待发货      				确认发货
	1	已发货		  确认收货
	2	已收货        [申请退货]
	3	等待退货                    同意退货
	4	已退货                      确认退货
	5	完成订单
	
	封装一个函数，用于操作订单的状态
	*/

	// 客户端：修改订单状态
	function checkOrderClient($status, $order_num){
		switch($status){
			case '0':
				echo "";
				break;

			case '1':
				echo "<a class='order_update' href='../../comm/order.update.php?order={$order_num}&status={$status}'>确认收货</a>";
				break;

			case '2':
				echo "<a class='order_update' href='../../comm/order.update.php?order={$order_num}&status={$status}'>申请退货</a>";
				break;

			case '3':
				echo "";
				break;

			case '4':
				echo "";
				break;

			case '5':
				echo "";
				break;
		}

	}

	// 后台：修改订单状态
	function checkOrderAdmin($status, $order_num){
		switch($status){
			case '0':
				echo "<a class='order_update' href='../../comm/order.update.php?order={$order_num}&status={$status}'>确认发货</a>";
				break;

			case '1':
				echo "";
				break;

			case '2':
				echo "";
				break;

			case '3':
				echo "<a class='order_update' href='../../comm/order.update.php?order={$order_num}&status={$status}'>同意退货</a>";
				break;

			case '4':
				echo "<a class='order_update' href='../../comm/order.update.php?order={$order_num}&status={$status}'>确认退货</a>";
				break;

			case '5':
				echo "";
				break;
		}

	}


	/*
		获取用户的权限
	*/
	// 获取用户的权限
	function findUserGrade(){
		session_start();
		$isLogin_admin = $_SESSION['admin']['username'];
		// 从数据库获取用户等级
		$sql = "SELECT * FROM `shop_user` WHERE `username` = '{$isLogin_admin}'";
		$res = mysqli_query($conn, $sql);
		$user_grade = mysqli_fetch_assoc($res)['grade'];

		echo '111';

		// 返回值
		if ($user_grade==0||$user_grade==1) {
			return TRUE;
		} else{
			return FALSE;
		}
	}