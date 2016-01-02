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
    if($_GET['type'] == 'add' && strlen($_POST['name']) >=3 && strlen($_POST['img']) > 1){
        @mysql_query("INSERT INTO cnt_ads (ad_name, ad_image, ad_link, ad_type) VALUES ('".$_POST['name']."', '".$_POST['img']."', '".$_POST['url']."', ".$_POST['type'].")");
        header('Location: index.php?m=6');
    }
    
    elseif($_GET['type'] == 'edit'){
        @mysql_query("UPDATE cnt_ads SET ad_name = '".$_POST['name']."', ad_image = '".$_POST['img']."', ad_link = '".$_POST['url']."', ad_type = ".$_POST['type']." WHERE id = ".$_POST['id']);
        header('Location: index.php?m=6');
    }
    
    elseif($_GET['type'] == 'del' && $_POST['action'] == 1 && $_POST['id']){
        $total = count($_POST['id']);
        for($i=0; $i<$total; $i++) {
            @mysql_query("DELETE FROM cnt_ads WHERE id = ".$_POST['id'][$i]);
        }
        header('Location: index.php?m=6');
    }
    
    else header('Location: index.php?m=6');
}

else echo "Hacking attempt";


?>
