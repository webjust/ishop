<?php 
	include('./home/public/m_header.php');
	require_once('./comm/conn.php');

	// 如果已经登录的用户，自动跳转到首页
	if (isset($_SESSION['buyer']['isLogin'])) {
		echo "<script>alert('你已经登录成功');window.location.href='../../index.php'</script>";
		exit();
	}

?>

<div id="m_content" class="register">
	<div class="sub-nav">
		<!-- 子分类 -->
		<div style="height:20px; display:block;"></div>
	</div>
	
	<div style="padding:30px 0">
		<!-- 左侧广告 -->
		<div style="float:left; padding-left:20px;">
			<img src="./home/images/ad_img.jpg" />
		</div>
		<!-- 左侧广告结束 -->
		<!-- 注册表单开始 -->
		<div class="form" style="padding-left:100px; float:left;">
			<h2>登录账户</h2>
			<form action="./comm/loginAction.php?a=login" method="post">
				<table border="0" cellspacing="10" class="reg">
					<tr>
						<td colspan="2">
							<font color='#f00'>
							<?php 
								$error = isset($_GET['error'])?$_GET['error']:NULL;

								switch ($error) {
									case '1':
										echo "用户名或密码不能为空";
										break;

									case '2':
										echo "不合法用户名";
										break;

									case '3':
										echo "密码位数在6-16位";
										break;

									case '4':
										echo "账号或密码错误";
										break;
									
								}


							?>
							</font>
						</td>
					</tr>
					<tr>
						<td>用户名：</td>
						<td><input type="text" name="username" class="form-reg"></td>
					</tr>
					<tr>
						<td>密码：</td>
						<td><input type="password" name="password" class="form-reg"></td>
					</tr>
					<tr>
						<td>验证码：</td>
						<td><input type="text" name="getcode" class="form-reg"></td>
					</tr>					<tr>
						<td>&nbsp;</td>
						<td><img src="./comm/code.php" onclick="this.src='./comm/code.php?test=' + Math.random();" /></td>
					</tr>

					<tr>
						<td></td>
						<td>
							<input type="submit" value="登录账号" class="btn_buy buynow regsiter">
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<span class="comment" style="color:#333;">如果您还未注册，请先<a href="./register.php">注册</a>一个账号！</span>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<!-- 注册表单结束 -->
		<div class="clear"></div>
	</div>
</div>

<?php 
	include('./home/public/m_footer.php');
?>