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
    if($_GET['type'] == 'add' && strlen($_POST['name']) >= 3){
        @mysql_query("INSERT INTO cnt_polls (poll_name, poll_pid, poll_active, poll_order) VALUES ('".$_POST['name']."', ".$_POST['pid'].", ".$_POST['active'].", ".$_POST['order'].")");
        header('Location: index.php?m=10&sm=2');
    }
    
    elseif($_GET['type'] == 'edit'){
        @mysql_query("UPDATE cnt_polls SET poll_name = '".$_POST['name']."', poll_pid = ".$_POST['pid'].", poll_active = ".$_POST['active'].", poll_order = ".$_POST['order']." WHERE id = ".$_POST['id']);
        header('Location: index.php?m=10&sm=2');
    }
    
    elseif($_GET['type'] == 'del' && $_POST['action'] == 1 & $_POST['id']){
        $total = count($_POST['id']);
        for($i=0; $i<$total; $i++) {
            @mysql_query("DELETE FROM cnt_polls WHERE id = ".$_POST['id'][$i]);
            @mysql_query("DELETE FROM cnt_polls WHERE poll_pid = ".$_POST['id'][$i]);
        }
        header('Location: index.php?m=10&sm=2');
    }
    
    else header('Location: index.php?m=10&sm=2');
}

else echo "Hacking attempt";


?>
