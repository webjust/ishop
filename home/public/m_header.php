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
?>
<!DOCTYPE html>
<html>
<head>
	<title>iSHOP商城</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="./home/public/css.css" />
	<style type="text/css">
		#m_content, #footer .ffooter{ width: 960px; margin: 0 auto; }

	</style>
</head>
<body>
<div id="con">
	<div id="m_header">
		<div class="m_head">
			<div class="logo">
				<a href="../../index.php"><img src="./home/images/logo.jpg" /></a>
			</div>
			<div class="u-promise">
				
			</div>
		</div>

	</div>

<!-- END 头部 -->