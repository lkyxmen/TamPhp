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
if(check_log() == true & check_level() >= 3) {
    function number($str){
        $str = preg_replace('|[^0-9]?|U', '', $str);
        return $str;
    }
    $data = @file_get_contents($_FILES['file']['tmp_name']);
    if($data != null){
        $total = 0;
        $start = 0;        
        preg_match_all('/<Row>(.*?)<\/Row>/is', $data, $rows);
        foreach($rows[1] as $row){
            if($start >= $_POST['start']){
                preg_match_all('/<Data ss:Type="[A-Za-z]+?">(.*?)<\/Data>/is', $row, $cell);
                if($_POST['total']) @mysql_query("UPDATE cnt_products SET product_total = ".number($cell[1][$_POST['total']])." WHERE product_code = '".$cell[1][$_POST['code']]."'");
                if($_POST['price']) @mysql_query("UPDATE cnt_products SET product_price = ".number($cell[1][$_POST['price']])." WHERE product_code = '".$cell[1][$_POST['code']]."'");
                if($_POST['free']) @mysql_query("UPDATE cnt_products SET product_free = ".number($cell[1][$_POST['free']])." WHERE product_code = '".$cell[1][$_POST['code']]."'");
                $total ++;
            }
            $start ++;
        }
        header('Location: index.php?m=3&sm=3&update=success&total='.$total);
        echo $total;
    }
    else header('Location: index.php?m=3&sm=3&update=error');
}

else echo "Hacking attempt";

?>
