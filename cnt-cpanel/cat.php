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
if(check_log() == true && check_level() >= 2 && $_POST['type'] == 1) {
    if($_GET['type'] == 'add' && strlen($_POST['name']) >= 3 && $_POST['order']){
        @mysql_query("INSERT INTO cnt_cats (cat_name, cat_name_ascii, cat_info, cat_type, cat_order, cat_sub) VALUES ('".$_POST['name']."', '".ascii($_POST['name'])."', '".$_POST['desc']."', ".$_POST['type'].", ".$_POST['order'].", ".$_POST['sub'].")");
        header('Location: index.php?m=1&sm=2');
    }
    
    elseif($_GET['type'] == 'edit'){
        @mysql_query("UPDATE cnt_cats SET cat_name = '".$_POST['name']."', cat_info = '".$_POST['desc']."', cat_order = ".$_POST['order'].", cat_sub = ".$_POST['sub']." WHERE id = ".$_POST['id']);
        header('Location: index.php?m=1&sm=2');
    }
    
    elseif($_GET['type'] == 'del' && $_POST['action'] == 1 && $_POST['id']){
        $total = count($_POST['id']);
        for($i=0; $i<$total; $i++) {
            @mysql_query("DELETE FROM cnt_cats WHERE id = ".$_POST['id'][$i]);
        }
        header('Location: index.php?m=1&sm=2');
    }
    
    else header('Location: index.php?m=1&sm=2');
}

elseif(check_log() == true && check_level() >= 3 && $_POST['type'] == 2) {
    if($_GET['type'] == 'add' && strlen($_POST['name']) >= 3 && $_POST['order']){
        @mysql_query("INSERT INTO cnt_cats (cat_name, cat_name_ascii, cat_info, cat_type, cat_order, cat_sub) VALUES ('".$_POST['name']."', '".ascii($_POST['name'])."', '".$_POST['desc']."', ".$_POST['type'].", ".$_POST['order'].", ".$_POST['sub'].")");
        header('Location: index.php?m=3&sm=2');
    }
    
    elseif($_GET['type'] == 'edit'){
        @mysql_query("UPDATE cnt_cats SET cat_name = '".$_POST['name']."', cat_info = '".$_POST['desc']."', cat_order = ".$_POST['order'].", cat_sub = ".$_POST['sub']." WHERE id = ".$_POST['id']);
        header('Location: index.php?m=3&sm=2');
    }
    
    elseif($_GET['type'] == 'del' && $_POST['action'] == 1 && $_POST['id']){
        $total = count($_POST['id']);
        for($i=0; $i<$total; $i++) {
            @mysql_query("DELETE FROM cnt_cats WHERE id = ".$_POST['id'][$i]);
        }
        header('Location: index.php?m=3&sm=2');
    }
    
    else header('Location: index.php?m=3&sm=2');
}

else echo "Hacking attempt";


?>
