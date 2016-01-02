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
include('../cnt-includes/functions.php');
if(check_log() == true) {
    if($_GET['type'] == 'add' && strlen($_POST['content']) >= 10 && $_POST['captcha'] == $_SESSION['captcha']){
        @mysql_query("INSERT INTO cnt_comments (comment_content, comment_pid, comment_user, comment_time) VALUES ('".br($_POST['content'])."', ".$_POST['pid'].", ".$_SESSION['user']['id'].", ".time().")");
        header('Location: '.$_POST['back']);
    }
    
    elseif($_GET['type'] == 'reply' && check_level() >= 2){
        @mysql_query("INSERT INTO cnt_comments (comment_content, comment_pid, comment_sid, comment_user, comment_time) VALUES ('".br($_POST['content'])."', ".$_POST['pid'].", ".$_POST['id'].", ".$_SESSION['user']['id'].", ".time().")");
        header('Location: index.php?m=2');
    }
    
    elseif($_GET['type'] == 'edit' && check_level() >= 2){
        @mysql_query("UPDATE cnt_comments SET comment_content = '".br($_POST['content'])."' WHERE id = ".$_POST['id']);
        header('Location: index.php?m=2');
    }
    
    elseif($_GET['type'] == 'del' && $_POST['action'] == 1 && $_POST['id'] && check_level() >= 2){
        $total = count($_POST['id']);
        for($i=0; $i<$total; $i++) {
            @mysql_query("DELETE FROM cnt_comments WHERE id = ".$_POST['id'][$i]);
        }
        header('Location: index.php?m=2');
    }
    
    else echo "Hacking attempt";
}

else echo "Hacking attempt";


?>
