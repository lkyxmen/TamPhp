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

if($_POST['nick']){
    list($check) = @mysql_fetch_array(@mysql_query("SELECT id FROM cnt_users WHERE user_level > 0 and user_nick = '".$_POST['nick']."' and user_password = '".md5($_POST['pass'])."'"));
    if($check >= 1) {
        $_SESSION['user']['id'] = $check;
        $_SESSION['user']['pass'] = md5($_POST['pass']);
        if($_POST['back']) header('Location: '.$_POST['back']);
        else header('Location: ../home.html');
    }
    else header('Location: ../cnt-login.php?url='.$_POST['back'].'&nick='.$_POST['nick']);
}
else echo 'Hacking attempt';

?>
