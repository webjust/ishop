<?php
/*
上传图片处理函数
*/

// $fileInfo=$_FILES['image'];
// $allowExt=array('jpeg','jpg','png','gif');
// $savePath = '../public/upload';
// $newName=uploadFile($fileInfo,$savePath,false,$allowExt);

function uploadFile($fileInfo, $uploadPath = 'uploads',$flag=true,$allowExt=array('jpeg','jpg','gif','png'),$maxSize = 2097152){

	// 判断错误号
	if ($fileInfo ['error'] > 0) {
		switch ($fileInfo ['error']) {
			case 1 :
				$mes = '上传文件超过了PHP配置文件中upload_max_filesize选项的值';
				break;
			case 2 :
				$mes = '超过了表单MAX_FILE_SIZE限制的大小';
				break;
			case 3 :
				$mes = '文件部分被上传';
				break;
			case 4 :
				$mes = '没有选择上传文件';
				break;
			case 6 :
				$mes = '没有找到临时目录';
				break;
			case 7 :
			case 8 :
				$mes = '系统错误';
				break;
		}
		// echo ( $mes );
		return false;
	}
	$ext = pathinfo ( $fileInfo ['name'], PATHINFO_EXTENSION );

// 	$allowExt = array (
// 			'jpeg',
// 			'jpg',
// 			'png',
// 			'gif' 
// 	);
	if(!is_array($allowExt)){
		exit('系统错误');
	}
	// 检测上传文件的类型
	if (! in_array ( $ext, $allowExt )) {
		// var_dump($ext);
		exit ( '非法文件类型' );
	}
	//$maxSize = 2097152; // 2M
	                  // 检测上传文件大小是否符合规范
	if ($fileInfo ['size'] > $maxSize) {
		exit ( '上传文件过大' );
	}
	//检测图片是否为真实的图片类型
	//$flag=true;	
	if($flag){
		if(!getimagesize($fileInfo['tmp_name'])){
			exit('不是真实图片类型');
		}
	}
	// 检测文件是否是通过HTTP POST方式上传上来
	if (! is_uploaded_file ( $fileInfo ['tmp_name'] )) {
		exit ( '文件不是通过HTTP POST方式上传上来的' );
	}
	//$uploadPath = 'uploads';
	if (! file_exists ( $uploadPath )) {
		mkdir ( $uploadPath, 0777, true );
		chmod ( $uploadPath, 0777 );
	}
	$uniName = md5 ( uniqid ( microtime ( true ), true ) ) . '.' . $ext;
	$destination = $uploadPath . '/' . $uniName;
	if (! @move_uploaded_file ( $fileInfo ['tmp_name'], $destination )) {
		exit ( '文件移动失败' );
	}
	
	//echo '文件上传成功';
// 	return array(
// 		'newName'=>$destination,
// 		'size'=>$fileInfo['size'],
// 		'type'=>$fileInfo['type']
// 	);
	return $destination;
}


/*
	动态的计算缩放的大小
*/
function zoomImg($img_source, $savePath, $zoomWidth, $zoomHeight=0){
	$info = getimagesize($img_source);
	$savePath = rtrim($savePath).'/';

	$imageWidth = $info[0];
	$imageHeight = $info[1];

	$suffix = explode('/', $info['mime']);

	if ($zoomHeight == 0) {
		$zoomWidth = $zoomWidth;
		$zoomHeight = ($zoomWidth * $imageHeight)/$imageWidth;
	}
	
	// 打开图像，根据变量动态的创建函数
	$openImage = 'imagecreatefrom'.$suffix[1];
	$img = $openImage($img_source);
	$canvas = imagecreatetruecolor($zoomWidth, $zoomHeight);

	// 如果没有保存目录，则创建
	if (!file_exists($savePath)) {
		mkdir($savePath, 0777, true);
		chmod($savePath, 0777);
	}


	// 绘制
	imagecopyresampled($canvas, $img, 0, 0, 0, 0, $zoomWidth, $zoomHeight, $imageWidth, $imageHeight);

	// 输出
	// header('content-type:'.$info['mime']);
	$showimg = 'image'.$suffix[1];
	$filename = $savePath.'s_'.md5(time().mt_rand(0,9999)).'.'.$suffix[1];
	$showimg($canvas, $filename);

	// 释放
	imagedestroy($canvas);
	imagedestroy($img);

	return $filename;
}

