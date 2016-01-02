<?php

define('CNT',true);
include('cnt-includes/config.php');
if($_SESSION['user']['id']) header('Location: home.html');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Trung hieu" />
	<meta name="copyright" content="CNT" />
    <script type="text/javascript" src="cnt-data/javascripts/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="cnt-data/javascripts/avim.js" ></script>
    <script type="text/javascript" src="cnt-data/javascripts/validation.js" ></script>
    <link rel="shortcut icon" href="cnt-data/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="cnt-cpanel/templates/css/style.css" />
    <title>Đăng ký thành viên</title>
</head>
<body>
    <div style="width: 100%; height: 50px; background-color: silver;">
         <p style="padding: 10px;"><strong><a href="home.html">← Trang chủ</a></strong></p>
    </div>
    <div style="padding: 20px;">
        <div class="info-mod radius-top radius-bottom" style="width: 600px; margin: auto;">
            <h2 align="center">Đăng ký thành viên</h2>
            <br />
            <p style="color: red;" align="center"><?php if($_GET['check'] == 'error') echo 'Username hoặc Email đã tồn tại!'; ?></p>
            <form action="cnt-cpanel/user.php?type=reg" method="post">
            <table cellspacing="15px">
                <tr><td width="150px">Username</td><td><input type="text" id="nick" name="nick" style="width: 250px;" /> <span id="nickInfo"></span></td></tr>
                <tr><td valign="top">Mật khẩu</td><td><p style="margin-bottom: 5px;"><input type="password" id="pass1" name="pass" style="width: 150px;" /> <span id="pass1Info"></span></p><p><input type="password" id="pass2" name="repass" style="width: 150px;" /> <span id="pass2Info"></span></p></td></tr>
                <tr><td>Họ tên</td><td><input type="text" id="name" name="name" style="width: 250px;" /> <span id="nameInfo"></span></td></tr>
                <tr><td>Email</td><td><input type="text" id="email" name="email" style="width: 250px;" /> <span id="emailInfo"></span></td></tr>
                <tr>
                    <td>Ngày sinh</td>
                    <td>
                        <select name="dd">
                            <?php for($i=1;$i<=31;$i++){ ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                        <select name="mm">
                            <?php for($i=1;$i<=12;$i++){ ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                        <select name="yyyy">
                            <?php for($i=1940;$i<=2010;$i++){ ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Giới tính</td>
                    <td>
                        <select name="sex">
                            <option value="1">Nam</option>
                            <option value="2">Nữ</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Lớp</td>
                    <td>
                        <select name="class">
                            <option value="0">Không có</option>
                            <?php
                                $class_list = @mysql_query("SELECT * FROM cnt_class ORDER BY id DESC");
                                while ($lclass = @mysql_fetch_array ($class_list)){
                            ?>
                            <option value="<?php echo $lclass['id']; ?>"><?php echo $lclass['class_name']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr><td valign="top">Thông tin</td><td><textarea name="info" style="width: 400px; height: 100px;"></textarea></td></tr>
                <tr><td>Mã kiểm tra</td><td><table><tr><td width="110px"><input type="text" id="email" name="captcha" style="width: 100px;" /></td><td><img src="cnt-modules/captcha/index.php" /> <a onclick="$(this).prev().attr('src', 'cnt-modules/captcha/index.php?' + Math.random());"><img src="cnt-templates/<?php echo get_option('default_tpl'); ?>/images/refresh.png" alt="Reload" /></a></td></tr></table></td></tr>
            </table>
            <p style="padding-left: 20px;"><input type="submit" value="Đăng ký" /></p>
            </form>
        </div>
    </div>
</body>
</html>
