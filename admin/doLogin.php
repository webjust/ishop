<?php
  $username = isset($_POST['username'])?$_POST['username']:'';
  $password = isset($_POST['password'])?md5($_POST['password']):'';

  session_start();

  $code = strtolower(isset($_POST['code'])?$_POST['code']:NULL);
  $sessioncode = strtolower(isset($_SESSION['code'])?$_SESSION['code']:NULL);

  // var_dump($_SESSION);
  // echo $_SESSION['code'];

  // die();

  if ($code!=$sessioncode) {
    echo "<script>alert('验证码填写错误');
      window.location.href='./login.php'
    </script>";
    exit();
  }

  $link = mysqli_connect('localhost', 'root', '', 'ishop') or die('连接失败，错误信息：').mysqli_error();

  mysqli_set_charset($link, 'utf8');

  $sql = "SELECT * FROM `shop_user` WHERE username = '$username' AND password = '$password'";

  $res = mysqli_query($link, $sql);

  if ($res && mysqli_num_rows($res)==1) {
    session_start();
    $_SESSION['admin']['username'] = $username;
    $_SESSION['admin']['isLogin'] = 1;
    header("Location:index.php");
  } else{
    echo "<script>alert('用户名或者密码错误');
      window.location.href='./login.php'
    </script>";
  }

?>