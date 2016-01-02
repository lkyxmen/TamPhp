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
    if($_GET['type'] == 'add' && strlen($_POST['name']) >=3){
        @mysql_query("INSERT INTO cnt_supports (support_name, support_mobile, support_yahoo, support_skype, support_email) VALUES ('".$_POST['name']."', '".$_POST['mobile']."', '".$_POST['yahoo']."', '".$_POST['skype']."', '".$_POST['email']."')");
        header('Location: index.php?m=8');
    }
    
    elseif($_GET['type'] == 'edit'){
        @mysql_query("UPDATE cnt_supports SET support_name = '".$_POST['name']."', support_mobile = '".$_POST['mobile']."', support_yahoo = '".$_POST['yahoo']."', support_skype = '".$_POST['skype']."', support_email = '".$_POST['email']."' WHERE id = ".$_POST['id']);
        header('Location: index.php?m=8');
    }
    
    elseif($_GET['type'] == 'del' && $_POST['action'] == 1 && $_POST['id']){
        $total = count($_POST['id']);
        for($i=0; $i<$total; $i++) {
            @mysql_query("DELETE FROM cnt_supports WHERE id = ".$_POST['id'][$i]);
        }
        header('Location: index.php?m=8');
    }
    
    else header('Location: index.php?m=8');
}

else echo "Hacking attempt";


?>
