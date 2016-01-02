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
if(check_log() == true & check_level() >= 4) {
    @mysql_query("UPDATE cnt_cats SET cat_home = 0 WHERE cat_home = 1");
    foreach($_POST['show'] as $id) @mysql_query("UPDATE cnt_cats SET cat_home = 1 WHERE id = ".$id);
    header('Location: index.php?m=10&sm=4');
}

else echo "Hacking attempt";

?>
