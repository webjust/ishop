<?php
	header('content-type:text/html;charset=utf-8');
	require_once('../../comm/conn.php');

	// 通过url传参
	$a = $_GET['a'];

	switch ($a) {
		// 添加供应商
		case 'add_manufacturer':
			$name = trim($_POST['name']);			
			$addtime = time();
			$sql = "INSERT INTO `shop_manufacturer` VALUES (NULL, '{$name}', {$addtime})";
			$res = mysqli_query($conn, $sql);
			if (mysqli_affected_rows($conn)) {
				echo "<script>alert('添加成功');window.location.href='./pro.manufacturer.php';</script>";
			}

			break;

		// 更新产品信息
		case 'update_product':

			$cata_id = $_POST['cata_id'];
			$sku = $_POST['sku'];
			$quantity = $_POST['quantity'];
			$price = $_POST['price'];
			$manufacturer = $_POST['manufacturer'];
			$weight = $_POST['weight'];
			$status = $_POST['status'];
			$sort_order = $_POST['sort_order'];
			$image = $_POST['re_myimage'];
			$name = $_POST['name'];
			$description = $_POST['description'];
			$id = $_POST['id'];
			$p = isset($_GET['p'])?$_GET['p']:1;

			// 如果没有上传产品，产品路径不变
			if ($_FILES['myimage']['error'] == 4) {
				$image = $image;
				// 缩放图片的SQL语句为空
				$zoom_image = "";
			} else{
				// 导入图片上传和压缩处理函数
				require_once('../../comm/image.function.php');
				// 上传图片
				$allowExt=array('jpeg','jpg','gif','png');

				$fileInfo=$_FILES['myimage'];
				$savePath = '../../comm/p_image';		

				if($fileInfo['error']==0){
				$uploadimage = basename(uploadFile($fileInfo, $savePath, 1, $allowExt));

				// 缩放图片大小至宽度400
				$zoomWidth = 400;
				$savePath = '../../comm/p400_image';
				$img_source = '../../comm/p_image/'.$uploadimage;
				$s_image = zoomImg($img_source, $savePath, $zoomWidth, $zoomHeight=0);
				// 上传后的大图片的保存路径：文件名
				$image = basename($s_image);
				unlink($img_source);

				// $image = $uploadimage;

				} else{
					$image = $image;
					$s_image = $s_image;
				}

				// 缩放图片
				$zoomWidth = 50;
				$savePath = '../../comm/s_image';
				$img_source = '../../comm/p400_image/'.$image;
				$s_image = zoomImg($img_source, $savePath, $zoomWidth, $zoomHeight=0);
				$s_image = basename($s_image);
				$zoom_image = " `s_image` = '{$s_image}',";				
			}

			$sql = "UPDATE `shop_product` SET `cata_id` = '{$cata_id}', `sku` = '{$sku}', `quantity` = '{$quantity}', `price` = '{$price}', `manufacturer` = '{$manufacturer}', `weight` = '{$weight}', `status` = '{$status}', `sort_order` = '{$sort_order}', `image` = '{$image}',{$zoom_image} `name` = '{$name}', `description` = '{$description}' WHERE id = '{$id}'";

			// 操作数据库
			$res = mysqli_query($conn, $sql);
			if ($res) {
				echo "<script>alert('更新成功');window.location.href='./pro.list.php?p={$p}';</script>";
			} else{
				echo "<script>alert('更新失败');window.location.href='./pro.list.php?p={$p}';</script>";
			}

			mysqli_close($conn);


			break;

		case 'add_product':
			// 数据接收
			$cata_id = $_POST['cata_id'];
			$sku = strtoupper(trim($_POST['sku']));
			$quantity = trim($_POST['quantity']);
			$price = trim($_POST['price']);
			$manufacturer = $_POST['manufacturer'];
			$weight = trim($_POST['weight']);
			$status = $_POST['status'];
			$sort_order = trim($_POST['sort_order']);
			$name = trim($_POST['name']);
			$description = trim($_POST['description']);

			/*数据校验*/
			// 所属分类
			$pattern = '/\d/';
			if ($cata_id) {
				if (!preg_match($pattern, $cata_id)) {
					echo "<script>alert('非法选择分类');window.location.href='./pro.add.php';</script>";
					exit();
				}
			} else{
				echo "<script>alert('分类不能为空');window.location.href='./pro.add.php';</script>";
				exit();
			}

			// 编号
			if (empty($sku)) {
				echo "<script>alert('SKU不能为空');window.location.href='./pro.add.php';</script>";
				exit();				
			}	

			// 数量
			if (!empty($quantity)) {
				if (!is_numeric($quantity)) {
				echo "<script>alert('请填入数值');window.location.href='./pro.add.php';</script>";
				exit();				
				}
			} else{
				echo "<script>alert('库存数量不能为空');window.location.href='./pro.add.php';</script>";
				exit();				
			}

			// 导入图片上传和压缩处理函数
			require_once('../../comm/image.function.php');
			// 上传图片
			$allowExt=array('jpeg','jpg','gif','png');

			$fileInfo=$_FILES['myimage'];
			$savePath = '../../comm/p_image';		

			if($fileInfo['error']==0){
				$uploadimage = basename(uploadFile($fileInfo, $savePath, 1, $allowExt));
				$image = $uploadimage;
			} else{
				$image = 'default.jpg';
			}

			// 缩放图片大小至宽度400
			$zoomWidth = 400;
			$savePath = '../../comm/p400_image';
			$img_source = '../../comm/p_image/'.$uploadimage;
			$s_image = zoomImg($img_source, $savePath, $zoomWidth, $zoomHeight=0);
			// 上传后的大图片的保存路径：文件名
			$image = basename($s_image);
			unlink($img_source);

			// 缩放图片
			$zoomWidth = 50;
			$savePath = '../../comm/s_image';
			$img_source = '../../comm/p400_image/'.$image;
			$s_image = zoomImg($img_source, $savePath, $zoomWidth, $zoomHeight=0);

			$date_added = time();

			// SQL语句
			$sql = "INSERT INTO `shop_product` (`cata_id`, `sku`, `quantity`, `price`, `manufacturer`, `weight`, `status`, `sort_order`, `name`, `description`, `image`, `s_image`, `date_added`) VALUES ($cata_id, '$sku', '$quantity', '$price', '$manufacturer', '$weight', '$status', '$sort_order', '$name', '$description', '$image', '$s_image', $date_added)";

			$res = mysqli_query($conn, $sql);

			if ($res) {
				echo "<script>alert('添加成功');window.location.href='./pro.add.php';</script>";

			} else{
				echo "<script>alert('添加失败');window.location.href='./pro.add.php';</script>";
			}

			mysqli_close($conn);

			break;

		case 'del_product':
			// 数据接收
			$id = $_GET['id'];
			$p = $_GET['p'];

			/*查询登录用户的等级*/
			session_start();
			$isLogin_admin = $_SESSION['admin']['username'];
			// 从数据库获取用户等级
			$sql = "SELECT * FROM `shop_user` WHERE `username` = '{$isLogin_admin}'";
			$res = mysqli_query($conn, $sql);
			$user_grade = mysqli_fetch_assoc($res)['grade'];
			// 如果是非管理员，提示没有权限
			if ($user_grade >= 1 ) {
				echo "<script>alert('您没有删除权限');window.location.href='./pro.list.php?p={$p}';</script>";
				exit;   
			}


			// 删除产品操作
			$sql = "DELETE FROM `shop_product` WHERE id = {$id}";
			$res = mysqli_query($conn, $sql);
			if ($res) {
				echo "<script>alert('操作成功');window.location.href='./pro.list.php?p={$p}';</script>";
			} else{
				echo "<script>alert('操作失败');window.location.href='./pro.list.php?p={$p}';</script>";
			}
			mysqli_close($conn);

		// 修改评论状态
		case 'review_status':
			$id = $_GET['review_id'];
			$p = $_GET['p'];
			$status = $_GET['status'];

			// 修改状态值
			$status += 1;
			$status = $status%2;

			// 操作数据库
			$sql = "UPDATE `shop_review` SET `status` = $status WHERE `review_id` = $id";
			$res = mysqli_query($conn, $sql);
			if ($res && mysqli_affected_rows($conn)>0) {
				echo "<script>alert('操作成功');window.location.href='./review.php?p={$p}';</script>";
			} else{
				echo "<script>alert('操作失败');window.location.href='./review.php?p={$p}';</script>";
				die;
			}

			mysqli_close($conn);
			break;
	}