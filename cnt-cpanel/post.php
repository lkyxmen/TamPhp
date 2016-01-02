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
if(check_log() == true & check_level() >= 2) {
    if($_GET['type'] == 'qadd' && strlen($_POST['title']) >= 3 && strlen($_POST['content']) >= 3){
        @mysql_query("INSERT INTO cnt_posts (post_name, post_name_ascii, post_content, post_cat, post_time, post_user) VALUES ('".$_POST['title']."', '".ascii($_POST['title'])."', '".$_POST['content']."', '".$_POST['cat']."', ".time().", ".$_SESSION['user']['id'].")");
        header('Location: index.php?m=1');
    }
    
    elseif($_GET['type'] == 'add' && strlen($_POST['title']) >= 3 && strlen($_POST['content']) >= 3){
        $_POST['comment'] = ($_POST['comment'])?$_POST['comment']:0;
        @mysql_query("INSERT INTO cnt_posts (post_name, post_name_ascii, post_quote, post_content, post_cat, post_comment, post_image, post_file, post_time, post_user) VALUES ('".$_POST['title']."', '".ascii($_POST['title'])."', '".$_POST['quote']."', '".$_POST['content']."', ".$_POST['cat'].", ".$_POST['comment'].", '".$_POST['img']."', '".$_POST['file']."', ".time().", ".$_SESSION['user']['id'].")");
        header('Location: index.php?m=1');
    }
    
    elseif($_GET['type'] == 'edit'){
        $_POST['comment'] = ($_POST['comment'])?$_POST['comment']:0;
        @mysql_query("UPDATE cnt_posts SET post_name = '".$_POST['title']."', post_quote = '".$_POST['quote']."', post_content = '".$_POST['content']."', post_cat = ".$_POST['cat'].", post_comment = ".$_POST['comment'].", post_image = '".$_POST['img']."', post_file = '".$_POST['file']."' WHERE id = ".$_POST['id']);
        header('Location: index.php?m=1');
    }
    
    elseif($_GET['type'] == 'del' && $_POST['action'] == 1 && $_POST['id']){
        $total = count($_POST['id']);
        for($i=0; $i<$total; $i++) {
            @mysql_query("DELETE FROM cnt_posts WHERE id = ".$_POST['id'][$i]);
        }
        header('Location: index.php?m=1');
    }
    
    else header('Location: index.php?m=1');
}

else echo "Hacking attempt";


?>
