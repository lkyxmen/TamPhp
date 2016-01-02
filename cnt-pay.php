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
if($_POST['update']){
    foreach($_POST['total'] as $id => $tol){
        if($_POST['del'][$id]) unset($_SESSION['shopcart'][$id]);
        else $_SESSION['shopcart'][$id] = $tol;
    }
    header('Location: shopcart.html');
}
elseif($_POST['continue']){
    foreach($_POST['total'] as $id => $tol){
        if($_POST['del'][$id]) unset($_SESSION['shopcart'][$id]);
        else $_SESSION['shopcart'][$id] = $tol;
    }
    header('Location: home.html');
}
elseif($_POST['del']){
    unset($_SESSION['shopcart']);
    header('Location: home.html');
}
elseif($_POST['ok']) {
    if(strlen($_POST['name']) > 4 && strlen($_POST['email']) > 9 && strlen($_POST['phone']) > 9  && strlen($_POST['add']) > 9  && $_POST['captcha'] == $_SESSION['captcha']){
        $mail = '<div>
    <p>
        <strong>Đơn đặt hàng</strong> <em>('.format_time(time(), 2).')</em>
    </p>
    <p>Tên: '.$_POST['name'].'</p>
    <p>Điện thoại: '.$_POST['phone'].'</p>
    <p>Fax: '.$_POST['fax'].'</p>
    <p>Email: '.$_POST['email'].'</p>
    <p>Địa chỉ: '.$_POST['add'].'</p>
    <br />
    <hr />
    <p><strong>Nội dung:</strong></p>
    <br />';
        foreach($_SESSION['shopcart'] as $id => $tol){
            $product = @mysql_fetch_array(@mysql_query("SELECT product_code, product_name, product_price FROM cnt_products WHERE id = ".$id));
            $p_monney = $product['product_price']*$tol;
            $monney += $p_monney;
            if($i < 1) $content = $id.':'.$tol;
            else $content .= ','.$id.':'.$tol;
            $i ++;
            $mail .= '<p>'.$product['product_name'].'<em>('.$product['product_code'].')</em>: '.number($product['product_price']).' VNĐ x '.number($tol).' = '.number($p_monney).' VNĐ</p>';
        }
    $mail .= '<p>--------------------------------</p>
    <p><strong>Tổng cộng: '.number($monney).' VNĐ</strong></p>
</div>';
        @mysql_query("INSERT INTO cnt_bills (bill_name, bill_email, bill_phone, bill_fax, bill_add, bill_content, bill_user, bill_time) VALUES ('".$_POST['name']."', '".$_POST['email']."', '".$_POST['phone']."', '".$_POST['fax']."', '".$_POST['add']."', '".$content."', ".(($_SESSION['user']['id'])?$_SESSION['user']['id']:0).", ".time().")");
        $_SESSION['pay'] = true;
        unset($_SESSION['shopcart']);
        @mail($_POST['email'],get_option('name')." | Đơn đặt hàng tại Website: ".get_option('url'),$mail."<br />Vui lòng thanh toán để nhận được hàng sớm nhất.<br />-------------------------------------------------------<br />".get_option('name')."<br />Email: ".get_option('email')."<br />Website: ".get_option('url'),"From: ".get_option('email')."\r\nReply-To: ".get_option('email')."\r\nContent-type:text/html; charset=UTF-8\r\n\n\ ");
        header('Location: shopcart.html');
    }
    else header('Location: shopcart.html');
    
}
else echo "Hacking attempt";
?>
