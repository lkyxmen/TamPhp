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
if(check_log() == true) {
    if($_GET['type'] == 'add' && check_level() == 9 && strlen($_POST['nick']) > 3 && strlen($_POST['pass']) > 5 && $_POST['pass'] == $_POST['repass'] && strlen($_POST['name']) > 4 && strlen($_POST['email']) > 7){
        @mysql_query("INSERT INTO cnt_users (user_nick, user_password, user_email, user_sex, user_fullname, user_birthday, user_info, user_class, user_level, user_regdate, user_lastvisit) VALUES ('".$_POST['nick']."', '".md5($_POST['pass'])."', '".$_POST['email']."', ".$_POST['sex'].", '".$_POST['name']."', '".$_POST['dd']."-".$_POST['mm']."-".$_POST['yyyy']."', '".$_POST['info']."', ".$_POST['class'].", ".$_POST['level'].", ".time().", ".time().")");
        $info_user = '<strong>Chào mừng bạn '.$_POST['name'].' đến với '.get_option('name').'<strong><br />Thông tin tài khoản:<br />Tên đăng nhập: '.$_POST['nick'].'<br />Mật khẩu: '.$_POST['pass'];
        @mail($_POST['email'],get_option('name').' | Thông tin tài khoản',$info_user.'<br />-------------------------------------------------------<br />'.get_option('name').'<br />Email: '.get_option('email').'<br />Website: '.get_option('url'),"From: ".get_option('email')."\r\nReply-To: ".get_option('email')."\r\nContent-type:text/html; charset=UTF-8\r\n\n\ ");
        header('Location: index.php?m=11');
    }
    
    elseif($_GET['type'] == 'edit' && check_level() == 9 && strlen($_POST['name']) > 4 && strlen($_POST['email']) > 7){
        @mysql_query("UPDATE cnt_users SET user_nick = '".$_POST['nick']."', user_fullname = '".$_POST['name']."', user_email = '".$_POST['email']."', user_info = '".$_POST['info']."', user_birthday = '".$_POST['dd']."-".$_POST['mm']."-".$_POST['yyyy']."', user_sex = ".$_POST['sex'].", user_class = ".$_POST['class'].", user_level = ".$_POST['level']." WHERE id = ".$_POST['id']);
        if(strlen($_POST['pass']) > 5 & $_POST['pass'] == $_POST['repass']) @mysql_query("UPDATE cnt_users SET user_password  = '".md5($_POST['pass'])."' WHERE id = ".$_POST['id']);
        header('Location: index.php?m=11');
    }
    
    elseif($_GET['type'] == 'my' && strlen($_POST['name']) > 4 && strlen($_POST['email']) > 7){
        @mysql_query("UPDATE cnt_users SET user_fullname = '".$_POST['name']."', user_email = '".$_POST['email']."', user_info = '".$_POST['info']."', user_birthday = '".$_POST['dd']."-".$_POST['mm']."-".$_POST['yyyy']."', user_sex = ".$_POST['sex'].", user_class = ".$_POST['class']." WHERE id = ".$_SESSION['user']['id']);
        if(strlen($_POST['pass']) > 5 & $_POST['pass'] == $_POST['repass']) @mysql_query("UPDATE cnt_users SET user_password  = '".md5($_POST['pass'])."' WHERE id = ".$_SESSION['user']['id']);
        header('Location: index.php?m=13');
    }
    
    elseif($_GET['type'] == 'del' && check_level() == 9){
        $total = count($_POST['id']);
        for($i=0; $i<$total; $i++) {
            @mysql_query("DELETE FROM cnt_users WHERE id = ".$_POST['id'][$i]);
        }
        header('Location: index.php?m=11');
    }
    
    else echo "Hacking attempt";
}

else {
    if($_GET['type'] == 'reg' && strlen($_POST['nick']) > 3 && strlen($_POST['pass']) > 5 && $_POST['pass'] == $_POST['repass'] && strlen($_POST['name']) > 4 && strlen($_POST['email']) > 7 && $_POST['captcha'] == $_SESSION['captcha']){
        list($check) = @mysql_fetch_array(@mysql_query("SELECT id FROM cnt_users WHERE user_nick = '".$_POST['nick']."' or user_email = '".$_POST['email']."'"));
        if($check) header('Location: ../cnt-register.php?check=error');
        else {
            @mysql_query("INSERT INTO cnt_users (user_nick, user_password, user_email, user_sex, user_fullname, user_birthday, user_info, user_class, user_regdate, user_lastvisit) VALUES ('".$_POST['nick']."', '".md5($_POST['pass'])."', '".$_POST['email']."', ".$_POST['sex'].", '".$_POST['name']."', '".$_POST['dd']."-".$_POST['mm']."-".$_POST['yyyy']."', '".$_POST['info']."', ".$_POST['class'].", ".time().", ".time().")");
            $info_user = '<strong>Chào mừng bạn '.$_POST['name'].' đến với '.get_option('name').'<strong><br />Thông tin tài khoản:<br />Tên đăng nhập: '.$_POST['nick'].'<br />Mật khẩu: '.$_POST['pass'];
            @mail($_POST['email'],get_option('name').' | Thông tin tài khoản',$info_user.'<br />-------------------------------------------------------<br />'.get_option('name').'<br />Email: '.get_option('email').'<br />Website: '.get_option('url'),"From: ".get_option('email')."\r\nReply-To: ".get_option('email')."\r\nContent-type:text/html; charset=UTF-8\r\n\n\ ");
            header('Location: ../cnt-login.php?nick='.$_POST['nick']);
        }        
    }
    
    else header('Location: ../cnt-register.php');
    
}


?>
