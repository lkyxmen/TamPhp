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
if(check_log() == true && check_level() >= 4) {
    if($_GET['type'] == 'reply' && strlen($_POST['content']) >= 3){
        @mail($_POST['email'],$_POST['title'],$_POST['content'].'<br />-------------------------------------------------------<br />'.get_option('name').'<br />Email: '.get_option('email').'<br />Website: '.get_option('url'),"From: ".get_option('email')."\r\nReply-To: ".get_option('email')."\r\nContent-type:text/html; charset=UTF-8\r\n\n\ ");
        header('Location: index.php?m=9');
    }
    
    elseif($_GET['type'] == 'add' && strlen($_POST['name']) > 4 && strlen($_POST['email']) > 9 && strlen($_POST['phone']) > 9  && strlen($_POST['add']) > 9  && strlen($_POST['title']) > 9  && strlen($_POST['mess']) > 9  && $_POST['captcha'] == $_SESSION['captcha']){
        @mysql_query("INSERT INTO cnt_contacts (contact_name, contact_email, contact_phone, contact_fax, contact_add, contact_title, contact_content, contact_time) VALUES ('".$_POST['name']."', '".$_POST['email']."', '".$_POST['phone']."', '".$_POST['fax']."', '".$_POST['add']."', '".$_POST['title']."', '".$_POST['mess']."', ".time().")");
        $_SESSION['contact'] = 'ok';
        header('Location: '.$_POST['back']);
    }
        
    elseif($_POST['back']) {
        $_SESSION['contact'] = 'error';
        header('Location: '.$_POST['back']);
    }
    
    elseif($_GET['type'] == 'del' && $_POST['action'] == 1 && $_POST['id']){
        $total = count($_POST['id']);
        for($i=0; $i<$total; $i++) {
            @mysql_query("DELETE FROM cnt_contacts WHERE id = ".$_POST['id'][$i]);
        }
        header('Location: index.php?m=9');
    }
    
    else {
        header('Location: index.php?m=9');
    }
}
    
elseif($_GET['type'] == 'add' && strlen($_POST['name']) > 4 && strlen($_POST['email']) > 9 && strlen($_POST['phone']) > 9  && strlen($_POST['add']) > 9  && strlen($_POST['title']) > 9  && strlen($_POST['mess']) > 9  && $_POST['captcha'] == $_SESSION['captcha']){
    @mysql_query("INSERT INTO cnt_contacts (contact_name, contact_email, contact_phone, contact_fax, contact_add, contact_title, contact_content, contact_time) VALUES ('".$_POST['name']."', '".$_POST['email']."', '".$_POST['phone']."', '".$_POST['fax']."', '".$_POST['add']."', '".$_POST['title']."', '".$_POST['content']."', ".time().")");
    $_SESSION['contact'] = 'ok';
    header('Location: '.$_POST['back']);
}
    
elseif($_POST['back']) {
    $_SESSION['contact'] = 'error';
    header('Location: '.$_POST['back']);
}

else echo "Hacking attempt";

?>
