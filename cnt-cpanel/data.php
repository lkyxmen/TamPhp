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
    if($_GET['type'] == 'del' && $_POST['action'] == 1 && $_POST['id']){
        $total = count($_POST['id']);
        for($i=0; $i<$total; $i++) {
            $data = @mysql_fetch_array(@mysql_query("SELECT data_url, data_thumb FROM cnt_datas WHERE id = ".$_POST['id'][$i]));
            $url = @str_replace(get_option('url'), "..", $data['data_url']);
            $thumb = @str_replace(get_option('url'), "..", $data['data_thumb']);
            @unlink($url);
            @unlink($thumb);
            @mysql_query("DELETE FROM cnt_datas WHERE id = ".$_POST['id'][$i]);
        }
        header('Location: index.php?m=5');
    }
    
    elseif($_GET['type'] == 'edit'){
        @mysql_query("UPDATE cnt_datas SET data_name = '".$_POST['name']."', data_info = '".$_POST['desc']."' WHERE id = ".$_POST['id']);
        header('Location: index.php?m=5');
    }
    
    else header('Location: index.php?m=5');
}

else echo "Hacking attempt";


?>
