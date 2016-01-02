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
    if($_GET['type'] == 'add' & strlen($_POST['name']) >= 3 && strlen($_POST['url']) > 5){
        @mysql_query("INSERT INTO cnt_videos (video_name, video_url) VALUES ('".$_POST['name']."', '".$_POST['url']."')");
        header('Location: index.php?m=10&sm=3');
    }
    
    elseif($_GET['type'] == 'edit'){
        @mysql_query("UPDATE cnt_videos SET video_name = '".$_POST['name']."', video_url = '".$_POST['url']."' WHERE id = ".$_POST['id']);
        header('Location: index.php?m=10&sm=3');
    }
    
    elseif($_GET['type'] == 'del' && $_POST['action'] == 1 && $_POST['id']){
        $total = count($_POST['id']);
        for($i=0; $i<$total; $i++) {
            @mysql_query("DELETE FROM cnt_videos WHERE id = ".$_POST['id'][$i]);
        }
        header('Location: index.php?m=10&sm=3');
    }
    
    else header('Location: index.php?m=10&sm=3');
}

else echo "Hacking attempt";


?>
