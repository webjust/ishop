<?php 
	include('./home/public/m_header.php');
	require_once('./comm/conn.php');
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
			<h2>注册用户</h2>
			<form action="./comm/loginAction.php?a=register" method="post">
				<table border="0" cellspacing="5" class="reg">
					<tr>
						<td colspan="2">
						<span style="color:red;">
						<?php 
							$error = isset($_GET['error'])?$_GET['error']:NULL;
							switch ($error) {
								case '1':
									echo "用户名不能为空";
									break;
								
								case '2':
									echo "用户密码不能为空";
									break;
								
								case '3':
									echo "重复密码不能为空";
									break;
								
								case '4':
									echo "用户名错误";
									break;
								
								case '5':
									echo "用户密码错误";
									break;
								
								case '6':
									echo "重复密码错误";
									break;

								case '7':
									echo "{$_GET['user']}已经被注册";
									break;

								case '8':
									echo "密码不一致";
									break;

								case '9':
									echo "注册失败";
									break;

							}
						?>
						</span>
						</td>
					</tr>
					<tr>
						<td>用户名：</td>
						<td><input type="text" name="username" class="form-reg"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><span class="comment">字母数字下划线，6-16位数组成，首字母不能为数字</span></td>
					</tr>
					<tr>
						<td>密码：</td>
						<td><input type="password" name="password" class="form-reg"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><span class="comment">密码必须由6-16位的字符组成，不含空格</span></td>
					</tr>
					<tr>
						<td>确认密码：</td>
						<td><input type="password" name="repassword" class="form-reg"></td>
					</tr>
					<tr style="padding-top:10px;">
						<td></td>
						<td>
							<input type="submit" value="注册账号" class="btn_buy buynow regsiter">
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<span class="comment" style="color:#333;">如果您已经注册，请直接<a href="./login.php">登录</a>账号！</span>
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