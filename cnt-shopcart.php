<?php

/*-----------------------------------*\
|           Copyright © CNT           | 
|         Phone: 0986.901.797         |
|         Y!m: banmai_xanhmai         |
|       Website: CongNgheTre.Vn       |
|     Email: PeakOfMusic@Gmail.Com    |
\*-----------------------------------*/

define('CNT',true);
include('cnt-includes/config.php');
include('cnt-includes/functions.php');
if($_POST['id']) $_SESSION['shopcart'][$_POST['id']] ++;
if(!$_SESSION['shopcart']) echo '<p><strong>Chưa có sản phẩm</strong></p>';
else {
    foreach($_SESSION['shopcart'] as $id => $total){
        $product = @mysql_fetch_array(@mysql_query("SELECT product_name, product_price FROM cnt_products WHERE id = ".$id));
        $monney += $product['product_price'] * $total;        
        $sl += $total;
    }
    echo '<p style="font-size: 11px;"><strong>Số sản phẩm: '.$sl.'<strong></p>';
    echo '<p style="font-size: 11px;"><strong>Tổng tiền: '.number($monney).' VND<strong></p>';
    echo '<p align="center"><strong><a href="'.get_option('url').'/shopcart.html">Xem giỏ hàng</a></strong></p>';
}

?>
