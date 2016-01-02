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
include('../cnt-includes/functions.php');
if(check_log() == true & check_level() >= 3) {
    if($_GET['type'] == 'add' && strlen($_POST['name']) >= 3 && strlen($_POST['code']) >= 1){
        $descrip = '';
        for($i = 0; $i < 10; $i ++){
            if($_POST['a'][$i] && $_POST['b'][$i]){
                if($descrip == '') $descrip = $_POST['a'][$i].': '.$_POST['b'][$i];
                else $descrip .= ' / '.$_POST['a'][$i].': '.$_POST['b'][$i];
            }
        }
        @mysql_query("INSERT INTO cnt_products (product_name, product_name_ascii, product_code, product_price, product_free, product_total, product_quality, product_warranty, product_image, product_fullimg, product_descrip, product_info, product_cat) VALUES ('".$_POST['name']."', '".ascii($_POST['name'])."', '".$_POST['code']."', ".$_POST['price'].", ".(($_POST['free'])?$_POST['free']:0).", ".$_POST['total'].", '".$_POST['quality']."', ".(($_POST['warranty'])?$_POST['warranty']:0).", '".$_POST['img']."', '".str_replace('thumbs-','',$_POST['img'])."', '".$descrip."', '".$_POST['content']."', ".$_POST['cat'].")");
        header('Location: index.php?m=3');
    }
    
    elseif($_GET['type'] == 'edit' && strlen($_POST['name']) >= 3 && strlen($_POST['code']) >= 1){
        $descrip = '';
        for($i = 0; $i < 10; $i ++){
            if($_POST['a'][$i] && $_POST['b'][$i]){
                if($descrip == '') $descrip = $_POST['a'][$i].': '.$_POST['b'][$i];
                else $descrip .= ' / '.$_POST['a'][$i].': '.$_POST['b'][$i];
            }
        }
        @mysql_query("UPDATE cnt_products SET product_name = '".$_POST['name']."', product_code = '".$_POST['code']."', product_price = ".$_POST['price'].", product_free = ".$_POST['free'].", product_cat = ".$_POST['cat'].", product_total = ".$_POST['total'].", product_warranty = ".$_POST['warranty'].", product_quality = '".$_POST['quality']."', product_image = '".$_POST['img']."', product_fullimg =  '".str_replace('thumbs-','',$_POST['img'])."', product_descrip = '".$descrip."', product_info = '".$_POST['content']."' WHERE id = ".$_POST['id']);
        header('Location: index.php?m=3');
    }
    
    elseif($_GET['type'] == 'del' && $_POST['action'] == 1 && $_POST['id']){
        $total = count($_POST['id']);
        for($i=0; $i<$total; $i++) {
            @mysql_query("DELETE FROM cnt_products WHERE id = ".$_POST['id'][$i]);
        }
        header('Location: index.php?m=3');
    }
    
    else header('Location: index.php?m=3');
}

else echo "Hacking attempt";


?>
