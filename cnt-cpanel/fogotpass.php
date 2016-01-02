<?php

/*-----------------------------------*\
|           Copyright © CNT           | 
|         Phone: 0986.901.797         |
|         Y!m: banmai_xanhmai         |
|       Website: CongNgheTre.Vn       |
|     Email: PeakOfMusic@Gmail.Com    |
\*-----------------------------------*/

define('CNT',true);
include('../cnt-includes/config.php');

if(strlen($_POST['nick']) > 3 && strlen($_POST['email']) > 7 && $_POST['captcha'] == $_SESSION['captcha']){
    list($check) = @mysql_fetch_array(@mysql_query("SELECT user_password FROM cnt_users WHERE user_nick = '".$_POST['nick']."' and user_email = '".$_POST['email']."'"));
    if($check >= 1) {
        
        $link = get_option('url').'/cnt-fogotpass.php?nick='.$_POST['nick'].'&key='.$check;
        @mail($_POST['email'],get_option('name').' | Lấy lại mật khẩu','Vui lòng click vào link sau để tiếp tục quá trình:<br /><a href="'.$link .'" target="_blank">'.$link .'</a><br />-------------------------------------------------------<br />'.get_option('name').'<br />Email: '.get_option('email').'<br />Website: '.get_option('url'),"From: ".get_option('email')."\r\nReply-To: ".get_option('email')."\r\nContent-type:text/html; charset=UTF-8\r\n\n\ ");
        header('Location: ../cnt-fogotpass.php?check=success');
    }
    else header('Location: ../cnt-fogotpass.php?check=error');
}

elseif(strlen($_POST['pass']) > 5 && $_POST['pass'] == $_POST['againpass'] && $_POST['captcha'] == $_SESSION['captcha']){
    @mail($_POST['email'],get_option('name').' | Mật khẩu mới','Chào'.$_POST['nick'].'!<br />Mật khẩu mới: '.$_POST['pass'].'<br />-------------------------------------------------------<br />'.get_option('name').'<br />Email: '.get_option('email').'<br />Website: '.get_option('url'),"From: ".get_option('email')."\r\nReply-To: ".get_option('email')."\r\nContent-type:text/html; charset=UTF-8\r\n\n\ ");
    @mysql_query("UPDATE cnt_users SET user_password = '".md5($_POST['pass'])."' WHERE user_nick = '".$_POST['nick']."'");
    header('Location: ../cnt-login.php?nick='.$_POST['nick']);
}
else echo header('Location: ../cnt-fogotpass.php');

?>
