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
if(check_log() == true & check_level() == 9) {
    if($_GET['type'] == 'all'){
        @mysql_query("UPDATE cnt_options SET option_value = '".$_POST['name']."' WHERE option_key = 'name'");
        @mysql_query("UPDATE cnt_options SET option_value = '".$_POST['email']."' WHERE option_key = 'email'");
        @mysql_query("UPDATE cnt_options SET option_value = '".$_POST['desc']."' WHERE option_key = 'description'");
        @mysql_query("UPDATE cnt_options SET option_value = '".$_POST['key']."' WHERE option_key = 'keywords'");
        @mysql_query("UPDATE cnt_options SET option_value = '".$_POST['paging']."' WHERE option_key = 'paging'");
        header('Location: index.php?m=12');
    }
    
    elseif($_GET['type'] == 'report'){
        @mysql_query("UPDATE cnt_options SET option_value = '".$_POST['report']."' WHERE option_key = 'report'");
        @mysql_query("UPDATE cnt_options SET option_value = '".$_POST['content']."' WHERE option_key = 'report_info'");
        header('Location: index.php?m=12&sm=1');
    }
    
    elseif($_GET['type'] == 'close'){
        @mysql_query("UPDATE cnt_options SET option_value = '".$_POST['close']."' WHERE option_key = 'close'");
        @mysql_query("UPDATE cnt_options SET option_value = '".$_POST['content']."' WHERE option_key = 'close_info'");
        header('Location: index.php?m=12&sm=2');
    }
    
    else header('Location: index.php');
}

else echo "Hacking attempt";


?>
