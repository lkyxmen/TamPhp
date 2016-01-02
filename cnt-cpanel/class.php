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
if(check_log() == true && check_level() == 9) {
    if($_GET['type'] == 'add' && strlen($_POST['name']) >=3){
        @mysql_query("INSERT INTO cnt_class (class_name) VALUES ('".$_POST['name']."')");
        header('Location: index.php?m=11&sm=2');
    }
    
    elseif($_GET['type'] == 'edit'){
        @mysql_query("UPDATE cnt_class SET class_name = '".$_POST['name']."' WHERE id = ".$_POST['id']);
        header('Location: index.php?m=11&sm=2');
    }
    
    elseif($_GET['type'] == 'del' && $_POST['action'] == 1 && $_POST['id']){
        $total = count($_POST['id']);
        for($i=0; $i<$total; $i++) {
            @mysql_query("DELETE FROM cnt_class WHERE id = ".$_POST['id'][$i]);
        }
        header('Location: index.php?m=11&sm=2');
    }
    
    else header('Location: index.php?m=11&sm=2');
}

else echo "Hacking attempt";


?>
