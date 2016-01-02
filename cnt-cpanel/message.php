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
    if($_GET['type'] == 'add' && strlen($_POST['content']) >= 3 && strlen($_POST['title']) >= 3 && check_user($_POST['to'])){
        @mysql_query("INSERT INTO cnt_messages (message_title, message_content, message_from, message_to, message_time) VALUES ('".$_POST['title']."', '".$_POST['content']."', ".$_SESSION['user']['id'].", ".check_user($_POST['to']).", ".time().")");
        header('Location: index.php?m=15&sm=1');
    }
    
    elseif($_GET['type'] == 'del'){
        $total = count($_POST['id']);
        for($i=0; $i<$total; $i++) {
            @mysql_query("DELETE FROM cnt_messages WHERE id = ".$_POST['id'][$i]);
        }
        header('Location: index.php?m=15');
    }
    
    else echo header('Location: index.php?m=15');
}

else echo "Hacking attempt";


?>
