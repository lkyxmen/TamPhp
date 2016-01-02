<?php

/*-----------------------------------*\
|           Copyright © CNT           | 
|         Phone: 0986.901.797         |
|         Y!m: banmai_xanhmai         |
|       Website: CongNgheTre.Vn       |
|     Email: PeakOfMusic@Gmail.Com    |
\*-----------------------------------*/

define('CNT',true);
include('cnt-includes/config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Trung hieu" />
	<meta name="copyright" content="CNT" />
    <link rel="shortcut icon" href="cnt-data/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="cnt-cpanel/templates/css/style.css" />
    <title>Đăng nhập</title>
</head>
<body>
    <div style="width: 100%; height: 50px; background-color: silver;">
        <p style="padding: 10px;"><strong><a href="<?php if($_GET['url']) echo $_GET['url'];else echo 'home.html'; ?>">← Quay lại</a></strong></p>
    </div>
    <div style="padding: 50px;">
        <div class="info-mod radius-top radius-bottom" style="width: 300px; margin: auto;">
            <h2 align="center">Đăng nhập</h2>
            <br />
            <p style="color: red;" align="center"><?php if($_GET['url']) echo 'Tài khoản hoặc mật khẩu không đúng'  ?></p>
            <form action="cnt-cpanel/login.php" method="post">
            <table cellspacing="15px">
                <tr><td width="150px">Username</td><td><input type="text" name="nick" style="width: 150px;" value="<?php echo $_GET['nick']; ?>" /></td></tr>
                <tr><td valign="top">Mật khẩu</td><td><p style="margin-bottom: 5px;"><input type="password" name="pass" style="width: 150px;" /></p></td></tr>
                <input type="hidden" name="back" value="<?php echo $_GET['url']; ?>" />
            </table>
            <p align="center"><input type="submit" value="Đăng nhập" /></p>
            <p style="padding: 10px;" align="center"><a href="cnt-fogotpass.php">Quên mật khẩu!</a> | <a href="cnt-register.php">Đăng ký!</a></p>
            </form>
        </div>
    </div>
</body>
</html>
