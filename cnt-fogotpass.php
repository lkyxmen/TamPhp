<?php

/*-----------------------------------*\
|           Copyright © CNT           | 
|         Phone: 0986.901.737         |
|         Y!m: banmai_xanhmai         |
|       Website: TamDesigns     |
|     Email: PeakOfMusic@Gmail.Com    |
\*-----------------------------------*/

define('CNT',true);
include('cnt-includes/config.php');
if($_SESSION['user']) header('Location: home.html');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Trung hieu" />
	<meta name="copyright" content="CNT" />
    <link rel="shortcut icon" href="cnt-data/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="cnt-cpanel/templates/css/style.css" />
    <script type="text/javascript" src="cnt-data/javascripts/jquery-1.4.2.min.js"></script>
    <title>Đăng nhập</title>
</head>
<body>
    <div style="width: 100%; height: 50px; background-color: silver;">
        <p style="padding: 10px;"><strong><a href="home.html">← Trang chủ</a></strong></p>
    </div>
    <div style="padding: 50px;">
        <div class="info-mod radius-top radius-bottom" style="width: 400px; margin: auto;">
            <h2 align="center">Lấy lại mật khẩu</h2>
            <br />
            <?php if(!$_GET['nick'] && !$_GET['key']){ ?>
            <p style="color: red;" align="center"><?php if($_GET['check'] == 'error') echo 'Các thông tin chưa đúng!'; elseif($_GET['check'] == 'success') echo 'Một email đã được gửi tới bạn! Vui lòng đăng nhập vào email để tiếp tục quá trình!'; ?></p>
            <form action="cnt-cpanel/fogotpass.php" method="post">
            <table cellspacing="15px">
                <tr><td width="100px">Username</td><td><input type="text" name="nick" style="width: 150px;" /></td></tr>
                <tr><td valign="top">Email</td><td><p style="margin-bottom: 5px;"><input type="text" name="email" style="width: 200px;" /></p></td></tr>
                <tr><td>Mã kiểm tra</td><td><table><tr><td width="110px"><input type="text" id="email" name="captcha" style="width: 100px;" /></td><td><img src="cnt-modules/captcha/index.php" /> <a onclick="$(this).prev().attr('src', 'cnt-modules/captcha/index.php?' + Math.random());"><img src="cnt-templates/<?php echo get_option('default_tpl'); ?>/images/refresh.png" alt="Reload" /></a></td></tr></table></td></tr>
            </table>
            <p align="center"><input type="submit" value="Gửi" /></p>
            <p style="padding: 10px;" align="center"><a href="cnt-login.php">Đăng nhập!</a> | <a href="cnt-register.php">Đăng ký!</a></p>
            </form>
            <?php 
                } 
                else {
                    
                list($check) = @mysql_fetch_array(@mysql_query("SELECT user_email FROM cnt_users WHERE user_nick = '".$_GET['nick']."' and user_password = '".$_GET['key']."'"));
                if($check){
            ?>
            <p style="color: red;" align="center">Tài khoản: <?php echo $_GET['nick']; ?></p>
            <form action="cnt-cpanel/fogotpass.php" method="post">
            <table cellspacing="15px">
                <input type="hidden" name="nick" value="<?php echo $_GET['nick']; ?>" />
                <input type="hidden" name="email" value="<?php echo $check; ?>" />
                <tr><td valign="top">Mật khẩu mới</td><td><p style="margin-bottom: 5px;"><input type="password" name="pass" style="width: 150px;" /></p></td></tr>
                <tr><td valign="top">Nhập lại mật khẩu</td><td><p style="margin-bottom: 5px;"><input type="password" name="againpass" style="width: 150px;" /></p></td></tr>
                <tr><td>Mã kiểm tra</td><td><table><tr><td width="110px"><input type="text" id="email" name="captcha" style="width: 100px;" /></td><td><img src="cnt-modules/captcha/index.php" /> <a onclick="$(this).prev().attr('src', 'cnt-modules/captcha/index.php?' + Math.random());"><img src="cnt-templates/<?php echo get_option('default_tpl'); ?>/images/refresh.png" alt="Reload" /></a></td></tr></table></td></tr>
            </table>
            <p align="center"><input type="submit" value="Tạo mật khẩu" /></p>
            </form>
            <?php }} ?>
        </div>
    </div>
</body>
</html>
