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
    if($_GET['type'] == 'add' && strlen($_POST['title']) >=3 && strlen($_POST['content']) >= 3){
        @mysql_query("INSERT INTO cnt_faqs (faq_name, faq_content) VALUES ('".$_POST['title']."', '".$_POST['content']."')");
        header('Location: index.php?m=10&sm=1');
    }
    
    elseif($_GET['type'] == 'edit'){
        @mysql_query("UPDATE cnt_faqs SET faq_name = '".$_POST['title']."', faq_content = '".$_POST['content']."' WHERE id = ".$_POST['id']);
        header('Location: index.php?m=10&sm=1');
    }
    
    elseif($_GET['type'] == 'del' && $_POST['action'] == 1 && $_POST['id']){
        $total = count($_POST['id']);
        for($i=0; $i<$total; $i++) {
            @mysql_query("DELETE FROM cnt_faqs WHERE id = ".$_POST['id'][$i]);
        }
        header('Location: index.php?m=10&sm=1');
    }
    
    else header('Location: index.php?m=10&sm=1');
}

else echo "Hacking attempt";


?>
