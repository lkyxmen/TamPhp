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
include('../cnt-includes/cp.class.php');
include('version.php');
if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6')!=0) {
    echo 'Dung trinh duyet khac';
}

elseif(check_log()) {
    $tpl = new Template('main.html');
    $menu = isset($_GET['m'])?$_GET['m']:'0';
    $sub_menu = isset($_GET['sm'])?$_GET['sm']:'0';
    switch($menu) {
        // Bảng tiền khởi
        case '0':
            list($totalvisit) = @mysql_fetch_array(@mysql_query("SELECT MAX(id) FROM cnt_onlines"));
            list($temp) = @mysql_fetch_array(@mysql_query("SELECT tpl_name FROM cnt_templates WHERE tpl_active = 1"));
            list($lang) = @mysql_fetch_array(@mysql_query("SELECT language_name FROM cnt_languages WHERE language_active = 1"));
            $comment = @mysql_fetch_array(@mysql_query("SELECT * FROM cnt_comments WHERE comment_sid = 0 ORDER id DESC LIMIT 0,1"));
            $comment_from = @mysql_fetch_array(@mysql_query("SELECT post_name, post_name_ascii FROM cnt_posts WHERE id = ".$comment['comment_pid']));
            list($comment_by) = @mysql_fetch_array(@mysql_query("SELECT user_nick FROM cnt_users WHERE id = ".$comment['comment_user']));
            $tpl->assign(
                array(
                    'start_comment' => ($_COOKIE['comment'])?$_COOKIE['comment']:'show',
                    'start_quick' => ($_COOKIE['quick'])?$_COOKIE['quick']:'show',
                    'start_info' => ($_COOKIE['info'])?$_COOKIE['info']:'show',
                    'total_post' => @mysql_num_rows(@mysql_query("SELECT id FROM cnt_posts WHERE post_type = 1")),
                    'total_comment' => @mysql_num_rows(@mysql_query("SELECT id FROM cnt_comments")),
                    'total_admin' => @mysql_num_rows(@mysql_query("SELECT id FROM cnt_users WHERE user_level = 9")),
                    'total_online' => @mysql_num_rows(@mysql_query("SELECT id FROM cnt_onlines")),
                    'total_visit' => $totalvisit,
                    'curent_tpl' => $temp,
                    'curent_language' => $lang,
                    'comment_new_from' => $comment_from['post_name'],
                    'comment_new_link' => get_option('url').'/news/'.$comment_from['post_name_ascii'].'.html',
                    'comment_new_content' => $comment['comment_content'],
                    'comment_new_id' => $comment['id'],
                    'comment_new_by' => $comment_by,
                ));
            $cats = @mysql_query("SELECT id, cat_name FROM cnt_cats WHERE cat_sub = 0 and cat_type = 1 ORDER BY cat_order ASC");    
            while ($listcat = @mysql_fetch_array ($cats)){
                $sub_cat = @mysql_query("SELECT id, cat_name FROM cnt_cats WHERE cat_sub = ".$listcat['id']." ORDER BY cat_order ASC");
                while ($listsub = @mysql_fetch_array ($sub_cat)){
                    $tpl->assign(
                        array(
                            'cat_id_sub' => $listsub['id'],
                            'cat_name_sub' => $listsub['cat_name'],
                        ));
                    $tpl->parse('quick_cat_sub');
                }
                $tpl->assign(
                    array(
                        'cat_name' => $listcat['cat_name'],
                    ));
                $tpl->parse('quick_cat');
            }
            $this_menu = '| Bảng tiền khởi';
            break;
            
        case '1':
            $this_menu = '| Bài viết';
            switch($sub_menu) {
                case '0':
                    $current_page = ($_GET['page'])?$_GET['page']:1;
                    if($_GET['user']) {
                        $modpage = '&user='.$_GET['user'];
                        $p_where = 'and post_user = '.$_GET['user'];
                    }
                    elseif($_GET['cat']) {
                        $modpage = '&cat='.$_GET['cat'];
                        $p_where = 'and post_cat = '.$_GET['cat'];
                    }
                    else {
                        $modpage = '';
                        $p_where = '';
                    }
                    $p_start = ($current_page -1) * get_option('paging');
                    $total_p = @mysql_num_rows(@mysql_query("SELECT id FROM cnt_posts WHERE post_type = 1 ".$p_where.""));
                    $post_list = @mysql_query("SELECT id, post_name, post_cat, post_user, post_time FROM cnt_posts WHERE post_type = 1 ".$p_where." ORDER BY id DESC LIMIT ".$p_start.",".get_option('paging'));
                    while ($lpost = @mysql_fetch_array ($post_list)){
                        list($p_user) = @mysql_fetch_array(@mysql_query("SELECT user_nick FROM cnt_users WHERE id = ".$lpost['post_user']));
                        list($p_cat) = @mysql_fetch_array(@mysql_query("SELECT cat_name FROM cnt_cats WHERE id = ".$lpost['post_cat']));
                        $tpl->assign(
                            array(
                                'lpost_id' => $lpost['id'],
                                'lpost_name' => $lpost['post_name'],
                                'lpost_user' => $p_user,
                                'lpost_cat' => $p_cat,
                                'pu_id' => $lpost['post_user'],
                                'pc_id' => $lpost['post_cat'],
                                'lpost_comment' => @mysql_num_rows(@mysql_query("SELECT id FROM cnt_comments WHERE comment_pid = ".$lpost['id'])),
                                'lpost_time' => formatTime($lpost['post_time'], 1),
                            ));
                        $tpl->parse('post_list');
                    }
                    $tpl->assign('lp_paging',paging(get_option('paging'),$current_page, $total_p, 'index.php?m=1',$modpage.'&page=' ,false));
                    $this_menu .= ' | Danh sách bài';
                    break;
                
                case '1':
                    if($_GET['id'] > 0){
                        $post = @mysql_fetch_array(@mysql_query("SELECT id, post_name, post_quote, post_content, post_image, post_file, post_comment FROM cnt_posts WHERE post_type = 1 and id = ".$_GET['id']));
                        $file = explode(',',$post['post_file']);
                        array_shift($file);
                        $lfile = '';
                        foreach ($file as $item) {
                            $i ++;
                            $it = explode('|',$item);
                            $lfile .= '<p id="file'.$i.'">->'.$it[0].'<a onclick="$(\'#file'.$i.'\').remove();$(\'#filecontent > input\').val($(\'#filecontent > input\').val().replace(\','.$it[0].'|'.$it[1].'\',\'\'));" style="color: red; cursor: pointer;">X</a></p>';
                        }
                        $tpl->assign(
                            array(
                                'epost_action' => 'edit',
                                'epost_id' => $post['id'],
                                'epost_title' => $post['post_name'],
                                'epost_quote' => $post['post_quote'],
                                'epost_content' => $post['post_content'],
                                'epost_img' => $post['post_image'],
                                'epost_lfile' => $lfile,
                                'epost_file' => $post['post_file'],
                                'epost_comment' => ($post['post_comment']==1)?'checked=""':'',
                                'epost_bt' => 'Sửa',
                            ));
                    }
                    else {
                        $tpl->assign(
                            array(
                                'epost_action' => 'add',
                                'epost_id' => '',
                                'epost_title' => 'Gõ tiêu đề vào đây" onfocus="if(this.value==\'Gõ tiêu đề vào đây\')this.value=\'\'" onblur="if(this.value==\'\')this.value=\'Gõ tiêu đề vào đây\'',
                                'epost_quote' => '',
                                'epost_content' => '',
                                'epost_img' => '',
                                'epost_lfile' => '',
                                'epost_file' => '',
                                'epost_comment' => '',
                                'epost_bt' => 'Đăng bài',
                            ));
                    }
                
                
                    $cats = @mysql_query("SELECT id, cat_name FROM cnt_cats WHERE cat_sub = 0 and cat_type = 1 ORDER BY cat_order ASC");    
                    while ($listcat = @mysql_fetch_array ($cats)){
                        $sub_cat = @mysql_query("SELECT id, cat_name FROM cnt_cats WHERE cat_sub = ".$listcat['id']." ORDER BY cat_order ASC");
                        while ($listsub = @mysql_fetch_array ($sub_cat)){
                            $tpl->assign(
                                array(
                                    'cat_id_sub' => $listsub['id'],
                                    'cat_name_sub' => $listsub['cat_name'],
                                    'cat_check' => ($listsub['id'] == $post['post_cat'])?'selected=""':'',
                                ));
                            $tpl->parse('p_cat_sub');
                        }
                        $tpl->assign(
                            array(
                                'cat_id' => $listcat['id'],
                                'cat_name' => $listcat['cat_name'],
                            ));
                        $tpl->parse('p_cat');
                    }
                    $this_menu .= ' | Bài mới';
                    break;
                
                    
                case '2':
            
                    if($_GET['id'] > 0){
                        $cat = @mysql_fetch_array(@mysql_query("SELECT id, cat_name, cat_info, cat_order, cat_sub FROM cnt_cats WHERE cat_type = 1 and id = ".$_GET['id']));
                        $tpl->assign(
                            array(
                                'ecat_action' => 'edit',
                                'ecat_id' => $cat['id'],
                                'ecat_name' => $cat['cat_name'],
                                'ecat_desc' => $cat['cat_info'],
                                'ecat_order' => $cat['cat_order'],
                                'ecat_bt' => 'Sửa',
                            ));
                    }
                    else {
                        $tpl->assign(
                            array(
                                'ecat_action' => 'add',
                                'ecat_id' => '',
                                'ecat_name' => '',
                                'ecat_desc' => '',
                                'ecat_order' => '',
                                'ecat_bt' => 'Thêm danh mục',
                            ));
                    }
                    
                    $cat_list = @mysql_query("SELECT id, cat_name, cat_info FROM cnt_cats WHERE cat_sub = 0 and cat_type = 1 ORDER BY cat_order ASC");    
                    while ($lcat = @mysql_fetch_array ($cat_list)){
                        if($_GET['id'] != $lcat['id']) {
                            $tpl->assign(
                                array(
                                    'cat_id' => $lcat['id'],
                                    'cat_name' => $lcat['cat_name'],
                                    'ecat_check' => ($lcat['id'] == $cat['cat_sub'])?'selected=""':'',
                                ));
                            $tpl->parse('add_cat');
                        }
                        $sub_cat = @mysql_query("SELECT id, cat_name, cat_info FROM cnt_cats WHERE cat_sub = ".$lcat['id']." ORDER BY cat_order ASC");
                        while ($listsub = @mysql_fetch_array ($sub_cat)){
                            $tpl->assign(
                                array(
                                    'lscat_id' => $listsub['id'],
                                    'lscat_name' => $listsub['cat_name'],
                                    'lscat_desc' => $listsub['cat_info'],
                                    'lscat_post' => @mysql_num_rows(@mysql_query("SELECT id FROM cnt_posts WHERE post_cat = ".$listsub['id'])),
                                ));
                            $tpl->parse('list_cat_sub');
                        }
                        $tpl->assign(
                            array(
                                'lcat_id' => $lcat['id'],
                                'lcat_name' => $lcat['cat_name'],
                                'lcat_desc' => $lcat['cat_info'],
                            ));
                        $tpl->parse('list_cat');
                    }  
                    $this_menu .= ' | Danh mục';
                    break;
            }
            break;
            
        case '2':
            $this_menu = '| Bình luận';
            switch($sub_menu) {
                case '0':
                    $current_page = ($_GET['page'])?$_GET['page']:1;
                    if($_GET['user']) {
                        $modpage = '&user='.$_GET['user'];
                        $c_where = 'WHERE comment_user = '.$_GET['user'];
                    }
                    else {
                        $modpage = '';
                        $c_where = '';
                    }
                    $c_start = ($current_page -1) * get_option('paging');
                    $total_c = @mysql_num_rows(@mysql_query("SELECT id FROM cnt_comments ".$c_where.""));
                    $com_list = @mysql_query("SELECT * FROM cnt_comments ".$c_where." ORDER BY id DESC LIMIT ".$c_start.",".get_option('paging'));
                    while ($lcom = @mysql_fetch_array ($com_list)){
                        list($c_user) = @mysql_fetch_array(@mysql_query("SELECT user_nick FROM cnt_users WHERE id = ".$lcom['comment_user']));
                        $c_post = @mysql_fetch_array(@mysql_query("SELECT post_name, post_name_ascii FROM cnt_posts WHERE id = ".$lcom['comment_pid']));
                        $tpl->assign(
                            array(
                                'lcom_id' => $lcom['id'],
                                'lcom_iduser' => $lcom['comment_user'],
                                'lcom_user' => $c_user,
                                'lcom_time' => formatTime($lcom['comment_time'], 1),
                                'lcom_content' => $lcom['comment_content'],
                                'lcom_linkpost' => get_option('url').'/news/'.$c_post['post_name_ascii'].'.html',
                                'lcom_post' => $c_post['post_name'],
                            ));
                        if($lcom['comment_sid'] == 0) $tpl->parse('com_reply');
                        $tpl->parse('com_list');
                    }
                    $tpl->assign('lc_paging',paging(get_option('paging'),$current_page, $total_c, 'index.php?m=2',$modpage.'&page=' ,false));
                    $this_menu .= ' | Danh sách';
                    break;
                    
                case '1':
                    if($_GET['edit'] > 0){
                        list($ecom) = @mysql_fetch_array(@mysql_query("SELECT comment_content FROM cnt_comments WHERE id = ".$_GET['edit']));
                        $tpl->assign(
                            array(
                                'ecom_action' => 'edit',
                                'ecom_id' => $_GET['edit'],
                                'ecom_pid' => '',
                                'ecom_content' => $ecom,
                                'ecom_bt' => 'Sửa',
                            ));
                    $this_menu .= ' | Sửa';
                    }
                    elseif($_GET['reply'] > 0){
                        list($pid) = @mysql_fetch_array(@mysql_query("SELECT comment_pid FROM cnt_comments WHERE id = ".$_GET['reply']));
                        $tpl->assign(
                            array(
                                'ecom_action' => 'reply',
                                'ecom_id' => $_GET['reply'],
                                'ecom_pid' => $pid,
                                'ecom_content' => '',
                                'ecom_bt' => 'Trả lời',
                            ));
                    $this_menu .= ' | Trả lời';
                    }
                    break;
            }
            break;
            
        case '3':
            $this_menu = '| Sản phẩm';
            switch($sub_menu){
                case '0':
                    $current_page = ($_GET['page'])?$_GET['page']:1;
                    if($_GET['cat']) {
                        $modpage = '&cat='.$_GET['cat'];
                        $pd_where = 'WHERE product_cat = '.$_GET['cat'];
                    }
                    else {
                        $modpage = '';
                        $pd_where = '';
                    }
                    $pd_start = ($current_page -1) * get_option('paging');
                    $total_pd = @mysql_num_rows(@mysql_query("SELECT id FROM cnt_products ".$pd_where.""));
                    $product_list = @mysql_query("SELECT id, product_name, product_code, product_image, product_cat, product_price, product_free, product_total FROM cnt_products ".$pd_where." ORDER BY id DESC LIMIT ".$pd_start.",".get_option('paging'));
                    while ($lproduct = @mysql_fetch_array ($product_list)){
                        list($pd_cat) = @mysql_fetch_array(@mysql_query("SELECT cat_name FROM cnt_cats WHERE id = ".$lproduct['product_cat']));
                        $tpl->assign(
                            array(
                                'lproduct_id' => $lproduct['id'],
                                'lproduct_name' => $lproduct['product_name'],
                                'lproduct_code' => $lproduct['product_code'],
                                'lproduct_price' => number($lproduct['product_price']),
                                'lproduct_free' => ($lproduct['product_free'])?number($lproduct['product_free']).' VNĐ':'Không',
                                'lproduct_total' => number($lproduct['product_total']),
                                'lproduct_cat' => $pd_cat,
                                'pdc_id' => $lproduct['product_cat'],
                            ));
                        $tpl->parse('product_list');
                    }
                    $tpl->assign('lpd_paging',paging(get_option('paging'),$current_page, $total_pd, 'index.php?m=3',$modpage.'&page=' ,false));
                    $this_menu .= ' | Danh sách';
                    break;
                
                case '1':
                    if($_GET['id'] > 0){
                        $product = @mysql_fetch_array(@mysql_query("SELECT * FROM cnt_products WHERE id = ".$_GET['id']));
                        $descrip = explode(' / ',$product['product_descrip']);
                        $dr[1] = array(
                            'key' => '',
                            'val' => '',
                        );
                        $dr[2] = array(
                            'show' => 'display: none;',
                            'key' => '',
                            'val' => '',
                        );
                        $dr[3] = array(
                            'show' => 'display: none;',
                            'key' => '',
                            'val' => '',
                        );
                        $dr[4] = array(
                            'show' => 'display: none;',
                            'key' => '',
                            'val' => '',
                        );
                        $dr[5] = array(
                            'show' => 'display: none;',
                            'key' => '',
                            'val' => '',
                        );
                        $dr[6] = array(
                            'show' => 'display: none;',
                            'key' => '',
                            'val' => '',
                        );
                        $dr[7] = array(
                            'show' => 'display: none;',
                            'key' => '',
                            'val' => '',
                        );
                        $dr[8] = array(
                            'show' => 'display: none;',
                            'key' => '',
                            'val' => '',
                        );
                        $dr[9] = array(
                            'show' => 'display: none;',
                            'key' => '',
                            'val' => '',
                        );
                        $dr[10] = array(
                            'show' => 'display: none;',
                            'key' => '',
                            'val' => '',
                        );
                        if(!$descrip)$dr_total = 1;
                        else {
                            foreach ($descrip as $item) {
                                $dr_total ++;
                                $it = explode(': ',$item);
                                $dr[$dr_total] = array(
                                    'show' => '',
                                    'key' => $it[0],
                                    'val' => $it[1],
                                );
                            }
                        }
                        $tpl->assign(
                            array(
                                'eproduct_action' => 'edit',
                                'eproduct_id' => $product['id'],
                                'eproduct_title' => $product['product_name'],
                                'eproduct_content' => $product['product_info'],
                                'eproduct_code' => $product['product_code'],
                                'eproduct_price' => $product['product_price'],
                                'eproduct_free' => $product['product_free'],
                                'eproduct_total' => $product['product_total'],
                                'eproduct_quality' => $product['product_quality'],
                                'eproduct_warranty' => $product['product_warranty'],
                                'eproduct_img' => $product['product_image'],
                                'descrip_total' => $dr_total,
                                'dr1_a' => $dr[1]['key'],
                                'dr1_b' => $dr[1]['val'],
                                'dr2_d' => $dr[2]['show'],
                                'dr2_a' => $dr[2]['key'],
                                'dr2_b' => $dr[2]['val'],
                                'dr3_d' => $dr[3]['show'],
                                'dr3_a' => $dr[3]['key'],
                                'dr3_b' => $dr[3]['val'],
                                'dr4_d' => $dr[4]['show'],
                                'dr4_a' => $dr[4]['key'],
                                'dr4_b' => $dr[4]['val'],
                                'dr5_d' => $dr[5]['show'],
                                'dr5_a' => $dr[5]['key'],
                                'dr5_b' => $dr[5]['val'],
                                'dr6_d' => $dr[6]['show'],
                                'dr6_a' => $dr[6]['key'],
                                'dr6_b' => $dr[6]['val'],
                                'dr7_d' => $dr[7]['show'],
                                'dr7_a' => $dr[7]['key'],
                                'dr7_b' => $dr[7]['val'],
                                'dr8_d' => $dr[8]['show'],
                                'dr8_a' => $dr[8]['key'],
                                'dr8_b' => $dr[8]['val'],
                                'dr9_d' => $dr[9]['show'],
                                'dr9_a' => $dr[9]['key'],
                                'dr9_b' => $dr[9]['val'],
                                'dr10_d' => $dr[10]['show'],
                                'dr10_a' => $dr[10]['key'],
                                'dr10_b' => $dr[10]['val'],
                                'eproduct_bt' => 'Cập nhật',
                            ));
                    }
                    else {
                        $tpl->assign(
                            array(
                                'eproduct_action' => 'add',
                                'eproduct_id' => '',
                                'eproduct_title' => 'Gõ tên SP vào đây" onfocus="if(this.value==\'Gõ tên SP vào đây\')this.value=\'\'" onblur="if(this.value==\'\')this.value=\'Gõ tên SP vào đây\'',
                                'eproduct_content' => ' ',
                                'eproduct_code' => '',
                                'eproduct_price' => '',
                                'eproduct_free' => '',
                                'eproduct_total' => '',
                                'eproduct_quality' => 'Mới',
                                'eproduct_warranty' => '12',
                                'eproduct_img' => '',
                                'descrip_total' => '1',
                                'dr1_a' => '',
                                'dr1_b' => '',
                                'dr2_d' => 'display: none;',
                                'dr2_a' => '',
                                'dr2_b' => '',
                                'dr3_d' => 'display: none;',
                                'dr3_a' => '',
                                'dr3_b' => '',
                                'dr4_d' => 'display: none;',
                                'dr4_a' => '',
                                'dr4_b' => '',
                                'dr5_d' => 'display: none;',
                                'dr5_a' => '',
                                'dr5_b' => '',
                                'dr6_d' => 'display: none;',
                                'dr6_a' => '',
                                'dr6_b' => '',
                                'dr7_d' => 'display: none;',
                                'dr7_a' => '',
                                'dr7_b' => '',
                                'dr8_d' => 'display: none;',
                                'dr8_a' => '',
                                'dr8_b' => '',
                                'dr9_d' => 'display: none;',
                                'dr9_a' => '',
                                'dr9_b' => '',
                                'dr10_d' => 'display: none;',
                                'dr10_a' => '',
                                'dr10_b' => '',
                                'eproduct_bt' => 'Thêm sản phẩm',
                            ));
                    }
                
                
                    $cats = @mysql_query("SELECT id, cat_name FROM cnt_cats WHERE cat_sub = 0 and cat_type = 2 ORDER BY cat_order ASC");    
                    while ($listcat = @mysql_fetch_array ($cats)){
                        $sub_cat = @mysql_query("SELECT id, cat_name FROM cnt_cats WHERE cat_sub = ".$listcat['id']." ORDER BY cat_order ASC");
                        while ($listsub = @mysql_fetch_array ($sub_cat)){
                            $tpl->assign(
                                array(
                                    'cat_id_sub' => $listsub['id'],
                                    'cat_name_sub' => $listsub['cat_name'],
                                    'cat_check' => ($listsub['id'] == $product['product_cat'])?'selected=""':'',
                                ));
                            $tpl->parse('pd_cat_sub');
                        }
                        $tpl->assign(
                            array(
                                'cat_id' => $listcat['id'],
                                'cat_name' => $listcat['cat_name'],
                            ));
                        $tpl->parse('pd_cat');
                    }
                    $this_menu .= ' | Thêm sản phẩm';
                    break;
                    
                case '2':
                    $this_menu .= ' | Danh mục';
                    if($_GET['id'] > 0){
                        $cat = @mysql_fetch_array(@mysql_query("SELECT id, cat_name, cat_info, cat_order, cat_sub FROM cnt_cats WHERE cat_type = 2 and id = ".$_GET['id']));
                        $tpl->assign(
                            array(
                                'ecat1_action' => 'edit',
                                'ecat1_id' => $cat['id'],
                                'ecat1_name' => $cat['cat_name'],
                                'ecat1_desc' => $cat['cat_info'],
                                'ecat1_order' => $cat['cat_order'],
                                'ecat1_bt' => 'Sửa',
                            ));
                        $this_menu .= ' | Sửa';
                    }
                    else {
                        $tpl->assign(
                            array(
                                'ecat1_action' => 'add',
                                'ecat1_id' => '',
                                'ecat1_name' => '',
                                'ecat1_desc' => '',
                                'ecat1_order' => '',
                                'ecat1_bt' => 'Thêm danh mục',
                            ));
                    }
                    
                    $cat_list = @mysql_query("SELECT id, cat_name, cat_info FROM cnt_cats WHERE cat_sub = 0 and cat_type = 2 ORDER BY cat_order ASC");    
                    while ($lcat = @mysql_fetch_array ($cat_list)){
                        if($_GET['id'] != $lcat['id']) {
                            $tpl->assign(
                                array(
                                    'cat1_id' => $lcat['id'],
                                    'cat1_name' => $lcat['cat_name'],
                                    'ecat1_check' => ($lcat['id'] == $cat['cat_sub'])?'selected=""':'',
                                ));
                            $tpl->parse('add_cat1');
                        }
                        $sub_cat = @mysql_query("SELECT id, cat_name, cat_info FROM cnt_cats WHERE cat_sub = ".$lcat['id']." ORDER BY cat_order ASC");
                        while ($listsub = @mysql_fetch_array ($sub_cat)){
                            $tpl->assign(
                                array(
                                    'lscat1_id' => $listsub['id'],
                                    'lscat1_name' => $listsub['cat_name'],
                                    'lscat1_desc' => $listsub['cat_info'],
                                    'lscat1_post' => @mysql_num_rows(@mysql_query("SELECT id FROM cnt_products WHERE product_cat = ".$listsub['id'])),
                                ));
                            $tpl->parse('list_cat1_sub');
                        }
                        $tpl->assign(
                            array(
                                'lcat1_id' => $lcat['id'],
                                'lcat1_name' => $lcat['cat_name'],
                                'lcat1_desc' => $lcat['cat_info'],
                            ));
                        $tpl->parse('list_cat1');
                    }  
                    break;
                
                case '3':
                    $this_menu .= ' | Cập nhật sản phẩm từ Excel';
                    if($_GET['update'] == 'error') $tpl->parse('update_error');
                    elseif($_GET['update'] == 'success') {
                        $tpl->assign('total_ok', $_GET['total']);
                        $tpl->parse('update_ok');
                    }
                    else $tpl->parse('update');
                    break;
            }
            break;
            
        case '4':
            $this_menu = '| Hóa đơn';
            switch($sub_menu){
                case '0':
                    $this_menu .= ' | Chưa thanh toán';
                    $current_page = ($_GET['page'])?$_GET['page']:1;
                    $b_start = ($current_page -1) * get_option('paging');
                    $total_b = @mysql_num_rows(@mysql_query("SELECT id FROM cnt_bills WHERE bill_pay = 0"));
                    $bill_list = @mysql_query("SELECT id, bill_content, bill_name, bill_time FROM cnt_bills WHERE bill_pay = 0 ORDER BY id DESC LIMIT ".$b_start.",".get_option('paging'));
                    while ($lbill = @mysql_fetch_array ($bill_list)){
                        $data = explode(',',$lbill['bill_content']);
                        $pd_monney = 0;
                        $pd_total = 0;
                        foreach($data as $item){
                            $item = explode(':',$item);
                            list($price) = @mysql_fetch_array(@mysql_query("SELECT product_price FROM cnt_products WHERE id = ".$item[0]));
                            $pd_monney += $price*$item[1];
                            $pd_total += $item[1];
                        }
                        $tpl->assign(
                            array(
                                'lbill_id' => $lbill['id'],
                                'lbill_name' => $lbill['bill_name'],
                                'lbill_monney' => number($pd_monney),
                                'lbill_total' => number($pd_total),
                                'lbill_time' => formatTime($lbill['bill_time'], 1),
                            ));
                        $tpl->parse('bill_list');
                    }
                    $tpl->assign('lb_paging',paging(get_option('paging'),$current_page, $total_b, 'index.php?m=4',$modpage.'&page=' ,false));
                    
                    break;
                
                case '1':
                    $this_menu .= ' | Đã thanh toán';
                    $current_page = ($_GET['page'])?$_GET['page']:1;
                    $b_start = ($current_page -1) * get_option('paging');
                    $total_b = @mysql_num_rows(@mysql_query("SELECT id FROM cnt_bills WHERE bill_pay = 1"));
                    $bill_list = @mysql_query("SELECT id, bill_content, bill_name, bill_time FROM cnt_bills WHERE bill_pay = 1 ORDER BY id DESC LIMIT ".$b_start.",".get_option('paging'));
                    while ($lbill = @mysql_fetch_array ($bill_list)){
                        $data = explode(',',$lbill['bill_content']);
                        $pd_monney = 0;
                        $pd_total = 0;
                        foreach($data as $item){
                            $item = explode(':',$item);
                            list($price) = @mysql_fetch_array(@mysql_query("SELECT product_price FROM cnt_products WHERE id = ".$item[0]));
                            $pd_monney += $price*$item[1];
                            $pd_total += $item[1];
                        }
                        $tpl->assign(
                            array(
                                'lbill_id' => $lbill['id'],
                                'lbill_name' => $lbill['bill_name'],
                                'lbill_monney' => number($pd_monney),
                                'lbill_total' => number($pd_total),
                                'lbill_time' => formatTime($lbill['bill_time'], 1),
                            ));
                        $tpl->parse('bill1_list');
                    }
                    $tpl->assign('lb_paging',paging(get_option('paging'),$current_page, $total_b, 'index.php?m=4',$modpage.'&page=' ,false));
                    
                    break;
                
                case '2':
                    $bill = @mysql_fetch_array(@mysql_query("SELECT bill_name, bill_phone, bill_fax, bill_email, bill_add, bill_content, bill_time FROM cnt_bills WHERE id = ".$_GET['id']));
                    
                    $data = explode(',',$bill['bill_content']);
                    $monney = 0;
                    foreach($data as $item){
                        $item = explode(':',$item);
                        $product = @mysql_fetch_array(@mysql_query("SELECT product_code, product_name, product_price FROM cnt_products WHERE id = ".$item[0]));
                        $p_monney = $product['product_price']*$item[1];
                        $monney += $p_monney;
                        $tpl->assign(
                            array(
                                'product_name' => $product['product_name'],
                                'product_code' => $product['product_code'],
                                'product_price' => number($product['product_price']),
                                'product_total' => number($item[1]),
                                'monney' => number($p_monney),
                            ));
                        $tpl->parse('bill_product');
                    }
                    $tpl->assign(
                        array(
                            'monney_total' => number($monney),
                            'bill_id' => $_GET['id'],
                            'bill_name' => $bill['bill_name'],
                            'bill_phone' => $bill['bill_phone'],
                            'bill_fax' => ($bill['bill_fax'])?$bill['bill_fax']:'Không có',
                            'bill_email' => $bill['bill_email'],
                            'bill_add' => $bill['bill_add'],
                            'bill_time' => formatTime($bill['bill_time'], 2),
                        ));
                    
                    break;
            }
            break;
        
        case '5':
            $this_menu = '| File đính kèm';
            switch($sub_menu){
                case '0':
                    $this_menu .= ' | Danh sách';
                    $current_page = ($_GET['page'])?$_GET['page']:1;
                    if($_GET['type'] == 'media') {
                        $modpage = '&type=media';
                        $d_where = 'WHERE data_type = 2';
                        $tpl->assign('media_curent','font-weight: bold;');
                        $this_menu .= ' | Media';
                    }
                    elseif($_GET['type'] == 'other') {
                        $modpage = '&type=other';
                        $d_where = 'WHERE data_type = 3';
                        $tpl->assign('other_curent','font-weight: bold;');
                        $this_menu .= ' | Other';
                    }
                    else {
                        $modpage = '';
                        $d_where = 'WHERE data_type = 1';
                        $tpl->assign('img_curent','font-weight: bold;');
                        $this_menu .= ' | Ảnh';
                    }
                    $tpl->assign(
                        array(
                            'img_total' => @mysql_num_rows(@mysql_query("SELECT id FROM cnt_datas WHERE data_type = 1")),
                            'media_total' => @mysql_num_rows(@mysql_query("SELECT id FROM cnt_datas WHERE data_type = 2")),
                            'other_total' => @mysql_num_rows(@mysql_query("SELECT id FROM cnt_datas WHERE data_type = 3")),
                        ));
                    $d_start = ($current_page -1) * get_option('paging');
                    $total_d = @mysql_num_rows(@mysql_query("SELECT id FROM cnt_datas ".$d_where.""));
                    $data_list = @mysql_query("SELECT * FROM cnt_datas ".$d_where." ORDER BY id DESC LIMIT ".$d_start.",".get_option('paging'));
                    while ($ldata = @mysql_fetch_array ($data_list)){
                         $icon = ($ldata['data_type'] == 1)?$ldata['data_thumb']:'../cnt-data/javascripts/editor/icons/'.type($ldata['data_url']).'.png';
                        $tpl->assign(
                            array(
                                'file_id' => $ldata['id'],
                                'file_name' => $ldata['data_name'],
                                'file_icon' => $icon,
                                'file_desc' => $ldata['data_info'],
                                'file_time' => formatTime($ldata['data_time'], 1),
                            ));
                        $tpl->parse('file_list');
                    }
                    $tpl->assign('ld_paging',paging(get_option('paging'),$current_page, $total_d, 'index.php?m=5',$modpage.'&page=' ,false));
                    break;
                    
                case '1':
                    $edata = @mysql_fetch_array(@mysql_query("SELECT data_name, data_info FROM cnt_datas WHERE id = ".$_GET['id']));
                    $tpl->assign(
                        array(
                            'edata_id' => $_GET['id'],
                            'edata_name' => $edata['data_name'],
                            'edata_desc' => $edata['data_info'],
                        ));
                    $this_menu .= ' | Sửa thông tin';
                    break;
            }
            break;
            
        case '6':
            $this_menu = '| Liên kết';
            if($_GET['id'] > 0){
                $ad = @mysql_fetch_array(@mysql_query("SELECT * FROM cnt_ads WHERE id = ".$_GET['id']));
                $tpl->assign(
                    array(
                        'ead_action' => 'edit',
                        'ead_id' => $ad['id'],
                        'ead_name' => $ad['ad_name'],
                        'ead_img' => $ad['ad_image'],
                        'ead_url' => $ad['ad_link'],
                        'ead_type1' => ($ad['ad_type'] == 1)?'selected=""':'',
                        'ead_type2' => ($ad['ad_type'] == 2)?'selected=""':'',
                        'ead_type3' => ($ad['ad_type'] == 3)?'selected=""':'',
                        'ead_type4' => ($ad['ad_type'] == 4)?'selected=""':'',
                        'ead_type5' => ($ad['ad_type'] == 5)?'selected=""':'',
                        'ead_bt' => 'Sửa',
                    ));
                $this_menu .= ' | Sửa';
            }
            else {
                $tpl->assign(
                    array(
                        'ead_action' => 'add',
                        'ead_id' => '',
                        'ead_name' => '',
                        'ead_img' => '',
                        'ead_url' => 'http://',
                        'ead_type1' => '',
                        'ead_type2' => '',
                        'ead_type3' => '',
                        'ead_type4' => '',
                        'ead_type5' => '',
                        'ead_bt' => 'Thêm',
                    ));
            }
            
            
            $ad_list = @mysql_query("SELECT * FROM cnt_ads ORDER BY id DESC");
            while ($lad = @mysql_fetch_array ($ad_list)){
                switch($lad['ad_type']){
                    case '1':
                        $type = 'Logo phải';
                        break;
                    case '2':
                        $type = 'Logo trái';
                        break;
                    case '3':
                        $type = 'Trượt phải';
                        break;
                    case '4':
                        $type = 'Trượt trái';
                        break;
                    case '5':
                        $type = 'Cuối trang';
                        break;
                }
                $tpl->assign(
                    array(
                        'lad_id' => $lad['id'],
                        'lad_name' => $lad['ad_name'],
                        'lad_img' => $lad['ad_image'],
                        'lad_url' => $lad['ad_link'],
                        'lad_type' => $type,
                    ));
                $tpl->parse('list_ad');
            }
            break;
            
        case '7':
            $this_menu = '| Trang phụ';
            if($_GET['id'] > 0){
                $page = @mysql_fetch_array(@mysql_query("SELECT post_name, post_content FROM cnt_posts WHERE post_type = 2 and id = ".$_GET['id']));
                $tpl->assign(
                    array(
                        'epage_action' => 'edit',
                        'epage_id' => $_GET['id'],
                        'epage_title' => $page['post_name'],
                        'epage_content' => $page['post_content'],
                        'epage_bt' => 'Sửa',
                    ));
                $this_menu .= ' | Sửa';
            }
            else {
                $tpl->assign(
                    array(
                        'epage_action' => 'add',
                        'epage_id' => '',
                        'epage_title' => 'Gõ tiêu đề vào đây" onfocus="if(this.value==\'Gõ tiêu đề vào đây\')this.value=\'\'" onblur="if(this.value==\'\')this.value=\'Gõ tiêu đề vào đây\'',
                        'epage_content' => '',
                        'epage_bt' => 'Thêm',
                    ));
            }
            
            
            $page_list = @mysql_query("SELECT id, post_name, post_time FROM cnt_posts WHERE post_type = 2 ORDER BY id DESC");
            while ($lpage = @mysql_fetch_array ($page_list)){
                $tpl->assign(
                    array(
                        'lpage_id' => $lpage['id'],
                        'lpage_title' => $lpage['post_name'],
                        'lpage_time' => formatTime($lpage['post_time'], 1),
                    ));
                $tpl->parse('list_page');
            }
            
            break;
            
        case '8':
            $this_menu = '| Hỗ trợ online';
            if($_GET['id'] > 0){
                $support = @mysql_fetch_array(@mysql_query("SELECT * FROM cnt_supports WHERE id = ".$_GET['id']));
                $tpl->assign(
                    array(
                        'esupport_action' => 'edit',
                        'esupport_id' => $support['id'],
                        'esupport_name' => $support['support_name'],
                        'esupport_mobile' => $support['support_mobile'],
                        'esupport_yahoo' => $support['support_yahoo'],
                        'esupport_skype' => $support['support_skype'],
                        'esupport_email' => $support['support_email'],
                        'esupport_bt' => 'Sửa',
                    ));
                $this_menu .= ' | Sửa';
            }
            else {
                $tpl->assign(
                    array(
                        'esupport_action' => 'add',
                        'esupport_id' => '',
                        'esupport_name' => '',
                        'esupport_mobile' => '',
                        'esupport_yahoo' => '',
                        'esupport_skype' => '',
                        'esupport_email' => '',
                        'esupport_bt' => 'Thêm',
                    ));
            }
            
            
            $support_list = @mysql_query("SELECT id, support_name, support_mobile, support_yahoo FROM cnt_supports ORDER BY id DESC");
            while ($lsupport = @mysql_fetch_array ($support_list)){
                $tpl->assign(
                    array(
                        'lsupport_id' => $lsupport['id'],
                        'lsupport_name' => $lsupport['support_name'],
                        'lsupport_mobile' => $lsupport['support_mobile'],
                        'lsupport_yahoo' => $lsupport['support_yahoo'],
                    ));
                $tpl->parse('list_support');
            }
            break;
            
        case '9':
            $this_menu = '| Liên hệ';
            switch($sub_menu){
                case '0':
                    $contact_list = @mysql_query("SELECT id, contact_name, contact_title, contact_read, contact_time FROM cnt_contacts ORDER BY id DESC");
                    while ($lcontact = @mysql_fetch_array ($contact_list)){
                        $tpl->assign(
                            array(
                                'lcontact_id' => $lcontact['id'],
                                'lcontact_name' => $lcontact['contact_name'],
                                'lcontact_title' => $lcontact['contact_title'],
                                'lcontact_read' => ($lcontact['contact_read'] == 1)?'':'font-weight: bold;',
                                'lcontact_time' => formatTime($lcontact['contact_time'], 1),
                            ));
                        $tpl->parse('list_contact');
                    }
                    $this_menu .= ' | Danh sách';
                    break;
                    
                case '1':
                    $contact = @mysql_fetch_array(@mysql_query("SELECT contact_name, contact_title, contact_phone, contact_fax, contact_email, contact_add, contact_content, contact_time FROM cnt_contacts WHERE id = ".$_GET['id']));
                    $tpl->assign(
                        array(
                            'contact_id' => $_GET['id'],
                            'contact_title' => $contact['contact_title'],
                            'contact_name' => $contact['contact_name'],
                            'contact_phone' => $contact['contact_phone'],
                            'contact_fax' => ($contact['contact_fax'])?$contact['contact_fax']:'Không có',
                            'contact_email' => $contact['contact_email'],
                            'contact_add' => $contact['contact_add'],
                            'contact_content' => $contact['contact_content'],
                            'contact_time' => formatTime($contact['contact_time'], 2),
                        ));
                    break;
                    
                case '2':
                    $contact = @mysql_fetch_array(@mysql_query("SELECT contact_name, contact_title, contact_phone, contact_fax, contact_email, contact_add, contact_content, contact_time FROM cnt_contacts WHERE id = ".$_GET['id']));
                    $tpl->assign(
                        array(
                            'contact_title' => $contact['contact_title'],
                            'contact_name' => $contact['contact_name'],
                            'contact_email' => $contact['contact_email'],
                        ));
                    $this_menu .= ' | Trả lời';
                    break;
            }
            break;
            
        case '10':
            $this_menu = '| Ứng dụng thêm';
            switch($sub_menu){
                case '0':
                    $this_menu .= ' | Slide';
                    if($_GET['id'] > 0){
                        $slide = @mysql_fetch_array(@mysql_query("SELECT * FROM cnt_slides WHERE id = ".$_GET['id']));
                        $tpl->assign(
                            array(
                                'eslide_action' => 'edit',
                                'eslide_id' => $slide['id'],
                                'eslide_name' => $slide['slide_name'],
                                'eslide_img' => $slide['slide_img'],
                                'eslide_url' => $slide['slide_url'],
                                'eslide_bt' => 'Sửa',
                            ));
                        $this_menu .= ' | Sửa';
                    }
                    else {
                        $tpl->assign(
                            array(
                                'eslide_action' => 'add',
                                'eslide_id' => '',
                                'eslide_name' => '',
                                'eslide_img' => '',
                                'eslide_url' => 'http://',
                                'eslide_bt' => 'Thêm',
                            ));
                    }
                    
                    $s_list = @mysql_query("SELECT * FROM cnt_slides ORDER BY id DESC");
                    while ($lslide = @mysql_fetch_array ($s_list)){
                        $tpl->assign(
                            array(
                                'lslide_id' => $lslide['id'],
                                'lslide_name' => $lslide['slide_name'],
                                'lslide_img' => $lslide['slide_img'],
                                'lslide_url' => $lslide['slide_url'],
                            ));
                        $tpl->parse('list_slide');
                    }
                    
                    break;
            
                case '1':
                    $this_menu .= ' | Câu hỏi thường gặp';
                    if($_GET['id'] > 0){
                        $faq = @mysql_fetch_array(@mysql_query("SELECT faq_name, faq_content FROM cnt_faqs WHERE id = ".$_GET['id']));
                        $tpl->assign(
                            array(
                                'efaq_action' => 'edit',
                                'efaq_id' => $_GET['id'],
                                'efaq_title' => $faq['faq_name'],
                                'efaq_content' => $faq['faq_content'],
                                'efaq_bt' => 'Sửa',
                            ));
                        $this_menu .= ' | Sửa';
                    }
                    else {
                        $tpl->assign(
                            array(
                                'efaq_action' => 'add',
                                'efaq_id' => '',
                                'efaq_title' => 'Gõ câu hỏi vào đây" onfocus="if(this.value==\'Gõ câu hỏi vào đây\')this.value=\'\'" onblur="if(this.value==\'\')this.value=\'Gõ câu hỏi vào đây\'',
                                'efaq_content' => '',
                                'efaq_bt' => 'Thêm',
                            ));
                    }
                    
                    
                    $faq_list = @mysql_query("SELECT id, faq_name FROM cnt_faqs ORDER BY id ASC");
                    while ($lfaq = @mysql_fetch_array ($faq_list)){
                        $tpl->assign(
                            array(
                                'lfaq_id' => $lfaq['id'],
                                'lfaq_title' => $lfaq['faq_name'],
                            ));
                        $tpl->parse('list_faq');
                    }
                    
                    break;
                    
                case '2':
                    $this_menu .= ' | Thăm dò ý kiến';
                    if($_GET['id'] > 0){
                        $poll = @mysql_fetch_array(@mysql_query("SELECT id, poll_name, poll_order, poll_pid, poll_active FROM cnt_polls WHERE id = ".$_GET['id']));
                        $tpl->assign(
                            array(
                                'epoll_action' => 'edit',
                                'epoll_id' => $poll['id'],
                                'epoll_name' => $poll['poll_name'],
                                'epoll_order' => $poll['poll_order'],
                                'poll_active1' => ($poll['poll_active'] == 1)?'checked=""':'',
                                'poll_active0' => ($poll['poll_active'] == 0)?'checked=""':'',
                                'epoll_bt' => 'Sửa',
                            ));
                        $this_menu .= ' | Sửa';
                    }
                    else {
                        $tpl->assign(
                            array(
                                'epoll_action' => 'add',
                                'epoll_id' => '',
                                'epoll_name' => '',
                                'epoll_order' => '',
                                'poll_active1' => 'checked=""',
                                'poll_active0' => '',
                                'epoll_bt' => 'Thêm',
                            ));
                    }
                    
                    $poll_list = @mysql_query("SELECT id, poll_name FROM cnt_polls WHERE poll_pid = 0 ORDER BY poll_order ASC");    
                    while ($lpoll = @mysql_fetch_array ($poll_list)){
                        if($_GET['id'] != $lpoll['id']) {
                            $tpl->assign(
                                array(
                                    'poll_id' => $lpoll['id'],
                                    'poll_name' => $lpoll['poll_name'],
                                    'epoll_check' => ($lpoll['id'] == $poll['poll_pid'])?'selected=""':'',
                                ));
                            $tpl->parse('add_poll');
                        }
                        list($total_poll) = @mysql_fetch_array(@mysql_query("SELECT SUM(poll_votes) FROM cnt_polls WHERE poll_pid = ".$lpoll['id']));
                        $sub_poll = @mysql_query("SELECT id, poll_name, poll_votes FROM cnt_polls WHERE poll_pid = ".$lpoll['id']." ORDER BY poll_order ASC");
                        while ($listsub = @mysql_fetch_array($sub_poll)){
                            $tpl->assign(
                                array(
                                    'lspoll_id' => $listsub['id'],
                                    'lspoll_name' => $listsub['poll_name'],
                                    'lspoll_pc' => round($listsub['poll_votes']/$total_poll*100, 1).'%',
                                ));
                            $tpl->parse('list_poll_sub');
                        }
                        $tpl->assign(
                            array(
                                'lpoll_id' => $lpoll['id'],
                                'lpoll_name' => $lpoll['poll_name'],
                                'lpoll_total' => $total_poll,
                            ));
                        $tpl->parse('list_poll');
                    }  
                    break;
                    
                case '3':
                    $this_menu .= ' | Video';
                    if($_GET['id'] > 0){
                        $video = @mysql_fetch_array(@mysql_query("SELECT * FROM cnt_videos WHERE id = ".$_GET['id']));
                        $tpl->assign(
                            array(
                                'evideo_action' => 'edit',
                                'evideo_id' => $video['id'],
                                'evideo_name' => $video['video_name'],
                                'evideo_url' => $video['video_url'],
                                'evideo_bt' => 'Sửa',
                            ));
                        $this_menu .= ' | Sửa';
                    }
                    else {
                        $tpl->assign(
                            array(
                                'evideo_action' => 'add',
                                'evideo_id' => '',
                                'evideo_name' => '',
                                'evideo_url' => 'http://',
                                'evideo_bt' => 'Thêm',
                            ));
                    }
                    
                    $video_list = @mysql_query("SELECT * FROM cnt_videos ORDER BY id ASC");
                    while ($lvideo = @mysql_fetch_array ($video_list)){
                        $tpl->assign(
                            array(
                                'lvideo_id' => $lvideo['id'],
                                'lvideo_name' => $lvideo['video_name'],
                                'lvideo_url' => $lvideo['video_url'],
                            ));
                        $tpl->parse('list_video');
                    }
                    
                    break;
                    
                case '4':
                    $this_menu .= ' | Danh mục hiển thị tại trang chủ';
                    $home_hide = @mysql_query("SELECT id, cat_name FROM cnt_cats WHERE cat_type = 2 and cat_sub != 0 and cat_home = 0");
                    while ($hide = @mysql_fetch_array ($home_hide)){
                        $tpl->assign(
                            array(
                                'cat_id' => $hide['id'],
                                'cat_name' => $hide['cat_name'],
                            ));
                        $tpl->parse('home_hide');
                    }
                    $home_show = @mysql_query("SELECT id, cat_name FROM cnt_cats WHERE cat_type = 2 and cat_sub != 0 and cat_home = 1");
                    while ($show = @mysql_fetch_array ($home_show)){
                        $tpl->assign(
                            array(
                                'cat_id' => $show['id'],
                                'cat_name' => $show['cat_name'],
                            ));
                        $tpl->parse('home_show');
                    }
                    
                    break;
            }
            break;
            
        case '11':
            $this_menu = '| Thành viên';
            switch($sub_menu) {
                case '0':
                    $current_page = ($_GET['page'])?$_GET['page']:1;
                    if($_GET['class'] != null) {
                        $modpage = '&class='.$_GET['class'];
                        $u_where = 'WHERE user_class = '.$_GET['class'];
                    }
                    else {
                        $modpage = '';
                        $u_where = '';
                    }
                    $u_start = ($current_page -1) * get_option('paging');
                    $total_u = @mysql_num_rows(@mysql_query("SELECT id FROM cnt_users ".$u_where.""));
                    $user_list = @mysql_query("SELECT id, user_nick, user_email, user_fullname, user_class, user_level FROM cnt_users ".$u_where." ORDER BY id DESC LIMIT ".$u_start.",".get_option('paging'));
                    while ($luser = @mysql_fetch_array ($user_list)){
                        list($u_class) = @mysql_fetch_array(@mysql_query("SELECT class_name FROM cnt_class WHERE id = ".$luser['user_class']));
                        if($luser['user_level'] <= 1) $tpl->parse('not_userid');
                        $tpl->assign(
                            array(
                                'luser_id' => $luser['id'],
                                'luser_nick' => $luser['user_nick'],
                                'luser_name' => $luser['user_fullname'],
                                'luser_email' => $luser['user_email'],
                                'luser_classid' => $luser['user_class'],
                                'luser_class' => ($u_class)?$u_class:'Không có',
                                'luser_level' => level($luser['user_level']),
                            ));
                        $tpl->parse('list_user');
                    }
                    $tpl->assign('lu_paging',paging(get_option('paging'),$current_page, $total_u, 'index.php?m=10',$modpage.'&page=' ,false));
                    $this_menu .= ' | Danh sách';
                    break;
                    
                case '1':
                        
                    for($i = 1; $i <= 31; $i ++){
                        $tpl->assign(
                            array(
                                'dd' => $i,
                            ));
                        $tpl->parse('list_dd2');
                    }    
                    for($i = 1; $i <= 12; $i ++){
                        $tpl->assign(
                            array(
                                'mm' => $i,
                            ));
                        $tpl->parse('list_mm2');
                    }    
                    for($i = 1940; $i <= 2010; $i ++){
                        $tpl->assign(
                            array(
                                'yyyy' => $i,
                            ));
                        $tpl->parse('list_yyyy2');
                    }
                    $class_list = @mysql_query("SELECT * FROM cnt_class ORDER BY id DESC");
                    while ($lclass = @mysql_fetch_array ($class_list)){
                        $tpl->assign(
                            array(
                                'lclass_id' => $lclass['id'],
                                'lclass_name' => $lclass['class_name'],
                            ));
                        $tpl->parse('list_class2');
                    }
                    $this_menu .= ' | Thêm thành viên';
                    break;
                    
                case '2':
                    $this_menu .= ' | Nhóm';
                    if($_GET['id'] > 0){
                        $class = @mysql_fetch_array(@mysql_query("SELECT * FROM cnt_class WHERE id = ".$_GET['id']));
                        $tpl->assign(
                            array(
                                'eclass_action' => 'edit',
                                'eclass_id' => $class['id'],
                                'eclass_name' => $class['class_name'],
                                'eclass_bt' => 'Sửa',
                            ));
                        $this_menu .= ' | Sửa';
                    }
                    else {
                        $tpl->assign(
                            array(
                                'eclass_action' => 'add',
                                'eclass_id' => '',
                                'eclass_name' => '',
                                'eclass_bt' => 'Thêm',
                            ));
                    }
                    
                    
                    $class_list = @mysql_query("SELECT * FROM cnt_class ORDER BY id DESC");
                    while ($lclass = @mysql_fetch_array ($class_list)){
                        $tpl->assign(
                            array(
                                'lclass_id' => $lclass['id'],
                                'lclass_name' => $lclass['class_name'],
                                'lclass_user' => @mysql_num_rows(@mysql_query("SELECT id FROM cnt_users WHERE user_class = ".$lclass['id'])),
                            ));
                        $tpl->parse('list_class3');
                    }
                    break;
                    
                case '3':
                    $euser = @mysql_fetch_array(@mysql_query("SELECT * FROM cnt_users WHERE id = ".$_GET['id']));
                    $tpl->assign(
                        array(
                            'my_id' => $_GET['id'],
                            'my_nick' => $euser['user_nick'],
                            'my_name' => $euser['user_fullname'],
                            'my_email' => $euser['user_email'],
                            'my_sex1' => ($euser['user_sex'] == 1)?'selected=""':'',
                            'my_sex2' => ($euser['user_sex'] == 2)?'selected=""':'',
                            'my_info' => $euser['user_info'],
                        ));
                    $birthday = birthday($euser['user_birthday']);
                    for($i = 1; $i <= 31; $i ++){
                        $tpl->assign(
                            array(
                                'dd' => $i,
                                'my_dd' => ($i == $birthday['d'])?'selected=""':'',
                            ));
                        $tpl->parse('list_dd4');
                    }    
                    for($i = 1; $i <= 12; $i ++){
                        $tpl->assign(
                            array(
                                'mm' => $i,
                                'my_mm' => ($i == $birthday['m'])?'selected=""':'',
                            ));
                        $tpl->parse('list_mm4');
                    }    
                    for($i = 1940; $i <= 2010; $i ++){
                        $tpl->assign(
                            array(
                                'yyyy' => $i,
                                'my_yyyy' => ($i == $birthday['y'])?'selected=""':'',
                            ));
                        $tpl->parse('list_yyyy4');
                    }
                    $class_list = @mysql_query("SELECT * FROM cnt_class ORDER BY id DESC");
                    while ($lclass = @mysql_fetch_array ($class_list)){
                        $tpl->assign(
                            array(
                                'lclass_id' => $lclass['id'],
                                'lclass_name' => $lclass['class_name'],
                                'my_class' => ($euser['user_class'] == $lclass['id'])?'selected=""':'',
                            ));
                        $tpl->parse('list_class4');
                    }    
                    for($i = 0; $i <= 9; $i ++){
                        if($i == 5) $i = 9;
                        $tpl->assign(
                            array(
                                'level_id' => $i,
                                'level_name' => level($i),
                                'my_level' => ($i == $euser['user_level'])?'selected=""':'',
                            ));
                        $tpl->parse('list_level');
                    }
                    
                    break;
            }
            break;
            
        case '12':
            $this_menu = '| Cấu hình';
            switch($sub_menu){
                case '0':
                    $tpl->assign(
                        array(
                            'option_name' => get_option('name'),
                            'option_email' => get_option('email'),
                            'option_desc' => get_option('description'),
                            'option_key' => get_option('keywords'),
                            'option_paging' => get_option('paging'),
                        ));
                    $this_menu .= ' | Cấu hình chung';
                    break;
                    
                case '1':
                    $tpl->assign(
                        array(
                            'report_check1' => (get_option('report') == 1)?'checked=""':'',
                            'report_check0' => (get_option('report') == 0)?'checked=""':'',
                            'report_info' => get_option('report_info'),
                        ));
                    $this_menu .= ' | Thông báo';
                    break;
                    
                case '2':
                    $tpl->assign(
                        array(
                            'close_check1' => (get_option('close') == 1)?'checked=""':'',
                            'close_check0' => (get_option('close') == 0)?'checked=""':'',
                            'close_info' => get_option('close_info'),
                        ));
                    $this_menu .= ' | Đóng cửa';
                    break;
            }
            
            break;
            
        case '13':
            $my = @mysql_fetch_array(@mysql_query("SELECT user_nick, user_fullname, user_email, user_sex, user_info, user_birthday, user_class FROM cnt_users WHERE id = ".$_SESSION['user']['id']));
            $tpl->assign(
                array(
                    'my_nick' => $my['user_nick'],
                    'my_name' => $my['user_fullname'],
                    'my_email' => $my['user_email'],
                    'my_sex1' => ($my['user_sex'] == 1)?'selected=""':'',
                    'my_sex2' => ($my['user_sex'] == 2)?'selected=""':'',
                    'my_info' => $my['user_info'],
                ));
                
            $birthday = birthday($my['user_birthday']);
                
            for($i = 1; $i <= 31; $i ++){
                $tpl->assign(
                    array(
                        'dd' => $i,
                        'my_dd' => ($i == $birthday['d'])?'selected=""':'',
                    ));
                $tpl->parse('list_dd');
            }    
            for($i = 1; $i <= 12; $i ++){
                $tpl->assign(
                    array(
                        'mm' => $i,
                        'my_mm' => ($i == $birthday['m'])?'selected=""':'',
                    ));
                $tpl->parse('list_mm');
            }    
            for($i = 1940; $i <= 2010; $i ++){
                $tpl->assign(
                    array(
                        'yyyy' => $i,
                        'my_yyyy' => ($i == $birthday['y'])?'selected=""':'',
                    ));
                $tpl->parse('list_yyyy');
            }
            $class_list = @mysql_query("SELECT * FROM cnt_class ORDER BY id DESC");
            while ($lclass = @mysql_fetch_array ($class_list)){
                $tpl->assign(
                    array(
                        'lclass_id' => $lclass['id'],
                        'lclass_name' => $lclass['class_name'],
                        'my_class' => ($my['user_class'] == $lclass['id'])?'selected=""':'',
                    ));
                $tpl->parse('list_class');
            }
            $this_menu = '| Thông tin của tôi';
            break;
            
        case '14':
            $this_menu = '| Giỏ hàng';
            switch($sub_menu){
                case '0':
                    $this_menu .= ' | Chưa thanh toán';
                    $current_page = ($_GET['page'])?$_GET['page']:1;
                    $b_start = ($current_page -1) * get_option('paging');
                    $total_b = @mysql_num_rows(@mysql_query("SELECT id FROM cnt_bills WHERE bill_pay = 0 and bill_user = ".$_SESSION['user']['id']));
                    $bill_list = @mysql_query("SELECT id, bill_content, bill_name, bill_time FROM cnt_bills WHERE bill_pay = 0 and bill_user = ".$_SESSION['user']['id']." ORDER BY id DESC LIMIT ".$b_start.",".get_option('paging'));
                    while ($lbill = @mysql_fetch_array ($bill_list)){
                        $data = explode(',',$lbill['bill_content']);
                        $pd_monney = 0;
                        $pd_total = 0;
                        foreach($data as $item){
                            $item = explode(':',$item);
                            list($price) = @mysql_fetch_array(@mysql_query("SELECT product_price FROM cnt_products WHERE id = ".$item[0]));
                            $pd_monney += $price*$item[1];
                            $pd_total += $item[1];
                        }
                        $tpl->assign(
                            array(
                                'lbill_id' => $lbill['id'],
                                'lbill_monney' => number($pd_monney),
                                'lbill_total' => number($pd_total),
                                'lbill_time' => formatTime($lbill['bill_time'], 1),
                            ));
                        $tpl->parse('cart_list');
                    }
                    $tpl->assign('lb_paging',paging(get_option('paging'),$current_page, $total_b, 'index.php?m=14',$modpage.'&page=' ,false));
                    
                    break;
                
                case '1':
                    $this_menu .= ' | Đã thanh toán';
                    $current_page = ($_GET['page'])?$_GET['page']:1;
                    $b_start = ($current_page -1) * get_option('paging');
                    $total_b = @mysql_num_rows(@mysql_query("SELECT id FROM cnt_bills WHERE bill_pay = 1"));
                    $bill_list = @mysql_query("SELECT id, bill_content, bill_name, bill_time FROM cnt_bills WHERE bill_pay = 1 ORDER BY id DESC LIMIT ".$b_start.",".get_option('paging'));
                    while ($lbill = @mysql_fetch_array ($bill_list)){
                        $data = explode(',',$lbill['bill_content']);
                        $pd_monney = 0;
                        $pd_total = 0;
                        foreach($data as $item){
                            $item = explode(':',$item);
                            list($price) = @mysql_fetch_array(@mysql_query("SELECT product_price FROM cnt_products WHERE id = ".$item[0]));
                            $pd_monney += $price*$item[1];
                            $pd_total += $item[1];
                        }
                        $tpl->assign(
                            array(
                                'lbill_id' => $lbill['id'],
                                'lbill_monney' => number($pd_monney),
                                'lbill_total' => number($pd_total),
                                'lbill_time' => formatTime($lbill['bill_time'], 1),
                            ));
                        $tpl->parse('cart1_list');
                    }
                    $tpl->assign('lb_paging',paging(get_option('paging'),$current_page, $total_b, 'index.php?m=14&sm=1',$modpage.'&page=' ,false));
                    
                    break;
                
                case '2':
                    $bill = @mysql_fetch_array(@mysql_query("SELECT bill_name, bill_phone, bill_fax, bill_email, bill_add, bill_content, bill_time FROM cnt_bills WHERE id = ".$_GET['id']));
                    
                    $data = explode(',',$bill['bill_content']);
                    $monney = 0;
                    foreach($data as $item){
                        $item = explode(':',$item);
                        $product = @mysql_fetch_array(@mysql_query("SELECT product_code, product_name, product_price FROM cnt_products WHERE id = ".$item[0]));
                        $p_monney = $product['product_price']*$item[1];
                        $monney += $p_monney;
                        $tpl->assign(
                            array(
                                'product_name' => $product['product_name'],
                                'product_code' => $product['product_code'],
                                'product_price' => number($product['product_price']),
                                'product_total' => number($item[1]),
                                'monney' => number($p_monney),
                            ));
                        $tpl->parse('cart_product');
                    }
                    $tpl->assign(
                        array(
                            'monney_total' => number($monney),
                            'bill_id' => $_GET['id'],
                            'bill_name' => $bill['bill_name'],
                            'bill_phone' => $bill['bill_phone'],
                            'bill_fax' => ($bill['bill_fax'])?$bill['bill_fax']:'Không có',
                            'bill_email' => $bill['bill_email'],
                            'bill_add' => $bill['bill_add'],
                            'bill_time' => formatTime($bill['bill_time'], 2),
                        ));
                    
                    break;
            }
            break;
            
        case '15':
            $this_menu = '| Tin nhắn';
            switch($sub_menu){
                case '0':
                    $inbox_list = @mysql_query("SELECT id, message_from, message_title, message_read, message_time FROM cnt_messages WHERE message_to = ".$_SESSION['user']['id']." ORDER BY id DESC");
                    while ($linbox = @mysql_fetch_array ($inbox_list)){
                        list($m_user) = @mysql_fetch_array(@mysql_query("SELECT user_nick FROM cnt_users WHERE id = ".$linbox['message_from']));
                        $tpl->assign(
                            array(
                                'lmes_id' => $linbox['id'],
                                'lmes_from' => $m_user,
                                'lmes_title' => $linbox['message_title'],
                                'lmes_read' => ($linbox['message_read'] == 1)?'':'font-weight: bold;',
                                'lmes_time' => formatTime($linbox['message_time'], 1),
                            ));
                        $tpl->parse('list_inbox');
                    }
                    $this_menu .= ' | Tin nhắn đến';
                    break;
                    
                case '1':
                    $outbox_list = @mysql_query("SELECT id, message_to, message_title, message_read, message_time FROM cnt_messages WHERE message_from = ".$_SESSION['user']['id']." ORDER BY id DESC");
                    while ($loutbox = @mysql_fetch_array ($outbox_list)){
                        list($m_user) = @mysql_fetch_array(@mysql_query("SELECT user_nick FROM cnt_users WHERE id = ".$loutbox['message_to']));
                        $tpl->assign(
                            array(
                                'lmes_id' => $loutbox['id'],
                                'lmes_to' => $m_user,
                                'lmes_title' => $loutbox['message_title'],
                                'lmes_read' => ($loutbox['message_read'] == 1)?'':'font-weight: bold;',
                                'lmes_time' => formatTime($loutbox['message_time'], 1),
                            ));
                        $tpl->parse('list_outbox');
                    }
                    $this_menu .= ' | Tin nhắn đi';
                    break;
                    
                case '2':
                    $tpl->assign(
                        array(
                            'mes_title' => ($_GET['title'])?$_GET['title']:'Gõ tiêu đề vào đây" onfocus="if(this.value==\'Gõ tiêu đề vào đây\')this.value=\'\'" onblur="if(this.value==\'\')this.value=\'Gõ tiêu đề vào đây\'',
                            'mes_to' => ($_GET['to'])?$_GET['to']:'Người nhận" onfocus="if(this.value==\'Người nhận\')this.value=\'\'" onblur="if(this.value==\'\')this.value=\'Người nhận\'',
                        ));
                    $this_menu .= ' | Viết tin nhắn';
                    break;
                    
                case '3':
                    $this_menu .= ' | Đọc tin';
                    if($_GET['inbox']){
                        $mes =@mysql_fetch_array(@mysql_query("SELECT message_to, message_title, message_content, message_time FROM cnt_messages WHERE id = ".$_GET['inbox']));
                        list($m_user) = @mysql_fetch_array(@mysql_query("SELECT user_nick FROM cnt_users WHERE id = ".$mes['message_to']));
                        @mysql_query("UPDATE cnt_messages SET message_read = 1 WHERE id = ".$_GET['inbox']);
                        $tpl->assign(
                            array(
                                'smes_user' => $m_user.' gửi tới tôi',
                                'smes_to' => $m_user,
                            ));
                        $tpl->parse('inbox_reply');
                    }
                    else {
                        $mes =@mysql_fetch_array(@mysql_query("SELECT message_from, message_title, message_content, message_time FROM cnt_messages WHERE id = ".$_GET['outbox']));
                        list($m_user) = @mysql_fetch_array(@mysql_query("SELECT user_nick FROM cnt_users WHERE id = ".$mes['message_from']));
                        $tpl->assign('smes_user','Gửi tới '.$m_user);
                    }
                    $tpl->assign(
                        array(
                            'smes_title' => $mes['message_title'],
                            'smes_content' => $mes['message_content'],
                            'smes_time' => formatTime($mes['message_time'], 1),
                        ));
                    $this_menu .= ' | '.$mes['message_title'];
                    break;
            }
            break;
        
        case '16':
            $this_menu = '| Hướng dẫn';
            break;
            
            
    }
    if(check_level() >= 2 && !in_array($menu, array('4', '5', '6', '7', '8', '9', '10', '11', '12'))) {
        $tpl->parse('cp_'.$menu.'_'.$sub_menu);
    }
    elseif(check_level() >= 3 && !in_array($menu, array('6', '7', '8', '9', '10', '11', '12'))) {
        $tpl->parse('cp_'.$menu.'_'.$sub_menu);
    }
    elseif(check_level() >= 4 && !in_array($menu, array('11', '12'))) {
        $tpl->parse('cp_'.$menu.'_'.$sub_menu);
    }
    elseif(check_level() >= 9) {
        $tpl->parse('cp_'.$menu.'_'.$sub_menu);
    }
    elseif(in_array($menu, array('13', '14', '15', '16'))) {
        $tpl->parse('cp_'.$menu.'_'.$sub_menu);
    }
    $menu_level = '';
    if(check_level() >= 2) $menu_level .= @file_get_contents('templates/level_2.html');
    if(check_level() >= 3) $menu_level .= @file_get_contents('templates/level_3.html');
    if(check_level() >= 4) $menu_level .= @file_get_contents('templates/level_4.html');
    if(check_level() >= 9) $menu_level .= @file_get_contents('templates/level_9.html');
    $tpl->assign(
        array(
            'menu_level' => $menu_level,
            'version' => $version['name'].' '.$version['value'],
            'this_menu' => $this_menu,
            'messages_new' => @mysql_num_rows(@mysql_query("SELECT id FROM cnt_messages WHERE message_to = '".$_SESSION['user']['id']."' and message_read = 0")),
            'total_user' => @mysql_num_rows(@mysql_query("SELECT id FROM cnt_users")),
            'menu' => $menu,
            'sub_menu' => $sub_menu,
        ));
    $tpl->tpl_out();
}

else header('Location: ../cnt-login.php');

?>
