<?php 
/*
	封装验证码函数
	2016-5-20
*/

function createCode($width, $height, $fontsize, $length){
// 验证码：随机颜色，居中，编码类型
// 1、创建画布
	$width = $width;
	$height = $height;
	$fontsize = $fontsize;
	$length = $length;
	$fontfile = "./font/simhei.ttf";
	$x = ($width-$fontsize*$length)/2-$fontsize;
	$y = ($height - $fontsize)/2 + $fontsize;

	$list1 = range(0, 9);
	$list2 = range('a', 'z');
	$list3 = range('A', 'Z');

	$list = array_merge($list1,$list2,$list3);
	shuffle($list);
	// var_dump($list);

	$code = array_slice($list, 0, $length);

	$img = imagecreatetruecolor($width, $height);


// 2、绘制图像：取色，填充
	$bgcolor = imagecolorresolve($img, mt_rand(150,255), mt_rand(150,255), mt_rand(150,255));

	imagefill($img, 0, 0, $bgcolor);

	for ($i=0; $i < 30; $i++) {
		$pixcolor = imagecolorresolve($img, mt_rand(100,255), mt_rand(100,255), mt_rand(100,255));
		$x1 = mt_rand(0, $width);
		$y1 = mt_rand(0, $height);
		$x2 = mt_rand(0, $width);
		$y2 = mt_rand(0, $height);
		imageline($img, $x1, $y1, $x2, $y2, $pixcolor);
	}

	for ($i=0; $i < $length; $i++) { 
		$angle = mt_rand(-45,45);
		$txtcolor = imagecolorresolve($img, mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
		$x += $fontsize;
		imagettftext($img, $fontsize, $angle, $x, $y, $txtcolor, $fontfile, $code[$i]);
		// $codetxt .= $code[$i];
	}


	// 3、显示，保存
	header('content-type:image/png');
	imagepng($img);

	// 4、释放资源
	imagedestroy($img);

	return $code;
}

$code = createCode(150,50,30,4);

$code = implode($code);

session_start();

$_SESSION['code'] = $code;

?>