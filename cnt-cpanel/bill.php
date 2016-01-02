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
if(check_log() == true) {
    if($_GET['type'] == 'my'){
        if($_POST['action'] == 1 && $_POST['id']){
            $total = count($_POST['id']);
            for($i=0; $i<$total; $i++) {
                @mysql_query("DELETE FROM cnt_bills WHERE bill_user = ".$_SESSION['user']['id']." and id = ".$_POST['id'][$i]);
            }
            header('Location: index.php?m=14');
        }
        else header('Location: index.php?m=14');
    }
    elseif(check_level() >= 3) {
        if($_POST['action'] == 1 && $_POST['id']){
            $total = count($_POST['id']);
            for($i=0; $i<$total; $i++) {
                @mysql_query("DELETE FROM cnt_bills WHERE id = ".$_POST['id'][$i]);
            }
            header('Location: index.php?m=4');
        }
        elseif($_POST['action'] == 2 && $_POST['id']){
            $total = count($_POST['id']);
            for($i=0; $i<$total; $i++) {
                @mysql_query("UPDATE cnt_bills SET bill_pay = 1 WHERE id = ".$_POST['id'][$i]);
                $bill = @mysql_fetch_array(@mysql_query("SELECT bill_name, bill_phone, bill_fax, bill_email, bill_add, bill_content, bill_time FROM cnt_bills WHERE id = ".$_POST['id'][$i]));
                $mail = '<div>
    <p>
        <strong>Đơn đặt hàng (Đã thanh toán)</strong> <em>('.format_time($bill['bill_time'], 2).')</em>
    </p>
    <p>Tên: '.$bill['bill_name'].'</p>
    <p>Điện thoại: '.$bill['bill_phone'].'</p>
    <p>Fax: '.$bill['bill_fax'].'</p>
    <p>Email: '.$bill['bill_email'].'</p>
    <p>Địa chỉ: '.$bill['bill_add'].'</p>
    <br />
    <hr />
    <p><strong>Nội dung:</strong></p>
    <br />';
                $data = explode(',',$bill['bill_content']);
                foreach($data as $item){
                    $item = explode(':',$item);
                    $product = @mysql_fetch_array(@mysql_query("SELECT product_code, product_name, product_price, product_total FROM cnt_products WHERE id = ".$item[0]));
                    if($item[1] <= $product['product_total']) @mysql_query("UPDATE cnt_products SET product_total = (product_total - ".$item[1].") WHERE id = ".$item[0]);
                    else @mysql_query("UPDATE cnt_products SET product_total = 0 WHERE id = ".$item[0]);
                    $p_monney = $product['product_price']*$item[1];
                    $monney += $p_monney;
                    $mail .= '<p>'.$product['product_name'].'<em>('.$product['product_code'].')</em>: '.number($product['product_price']).' VNĐ x '.number($item[1]).' = '.number($p_monney).' VNĐ</p>';
                }
                $mail .= '<p>--------------------------------</p>
    <p><strong>Tổng cộng: '.number($monney).' VNĐ</strong></p>
</div>';
                @mail($bill['bill_email'],get_option('name')." | Đơn đặt hàng đã thanh toán tại Website: ".get_option('url'),$mail."<br />Cảm ơn bạn đã mua hàng tại công ty của chúng tôi.<br />-------------------------------------------------------<br />".get_option('name')."<br />Email: ".get_option('email')."<br />Website: ".get_option('url'),"From: ".get_option('email')."\r\nReply-To: ".get_option('email')."\r\nContent-type:text/html; charset=UTF-8\r\n\n\ ");
            }
            header('Location: index.php?m=4');
        }
        else header('Location: index.php?m=4');
    }
    
    else echo "Hacking attempt";
}

else echo "Hacking attempt";


?>
