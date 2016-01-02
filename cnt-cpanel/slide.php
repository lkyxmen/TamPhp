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
    if($_GET['type'] == 'add' & strlen($_POST['name']) >=3 && strlen($_POST['img']) > 1){
        @mysql_query("INSERT INTO cnt_slides (slide_name, slide_img, slide_url) VALUES ('".$_POST['name']."', '".$_POST['img']."', '".$_POST['url']."')");
        header('Location: index.php?m=10');
    }
    
    elseif($_GET['type'] == 'edit'){
        @mysql_query("UPDATE cnt_slides SET slide_name = '".$_POST['name']."', slide_img = '".$_POST['img']."', slide_url = '".$_POST['url']."' WHERE id = ".$_POST['id']);
        header('Location: index.php?m=10');
    }
    
    elseif($_GET['type'] == 'del' && $_POST['action'] == 1 && $_POST['id']){
        $total = count($_POST['id']);
        for($i=0; $i<$total; $i++) {
            @mysql_query("DELETE FROM cnt_slides WHERE id = ".$_POST['id'][$i]);
        }
        header('Location: index.php?m=10');
    }
    
    else header('Location: index.php?m=10');
}

else echo "Hacking attempt";


?>
