<?php

/*-----------------------------------*\
|           Copyright © CNT           | 
|         Phone: 0986.901.797         |
|         Y!m: banmai_xanhmai         |
|       Website: CongNgheTre.Vn       |
|  Email: ThietKeWeb@CongNgheTre.Vn   |
\*-----------------------------------*/

define('CNT',true);
if (!file_exists('cnt-install/install.lock')) die(header("Location: cnt-install/index.php"));
include('cnt-includes/config.php');
include('cnt-includes/functions.php');
include('cnt-includes/cnt.class.php');

$cnt = new CNT(false);

if ($cnt->not_found == true) {
    $cnt->tpl_start('404.html');
    $cnt->assign(
        array(
            'web_url' => get_option('url'),
            'web_tpl' => get_option('default_tpl'),
        ));
    $cnt->tpl_out();
}
elseif ($cnt->cache_check == false) {
    if (get_option('close') == 1) {
        $cnt->tpl_start('close.html');
        $cnt->assign(
            array(
                'web_url' => get_option('url'),
                'web_tpl' => get_option('default_tpl'),
                'web_title' => get_option('name'),
                'web_description' => get_option('description'),
                'web_keywords' => get_option('keywords'),
                'close_info' => get_option('close_info'),
            ));
        $cnt->tpl_out();
    }
    else {
        $cnt->tpl_start('main.html');
        
        $list_page = @mysql_query("SELECT post_name, post_name_ascii FROM cnt_posts WHERE post_type = 2 ORDER BY id ASC");
        while ($lpage = @mysql_fetch_array ($list_page)){
            $cnt->assign(
                array(
                    'lpage_name' => $lpage['post_name'],
                    'lpage_name_ascii' => $lpage['post_name_ascii'],
                ));
            $cnt->parse('list_page');
        }
        
        $list_cat = @mysql_query("SELECT cat_name, id FROM cnt_cats WHERE cat_type = 2 and cat_sub = 0 ORDER BY cat_order ASC");
        while ($lcat = @mysql_fetch_array ($list_cat)){
            $sub_cat = @mysql_query("SELECT * FROM cnt_cats WHERE cat_type = 2 and cat_sub = ".$lcat['id']." ORDER BY cat_order ASC");
            while ($listsub = @mysql_fetch_array ($sub_cat)){
                $cnt->assign(
                    array(
                        'scat_name' => $listsub['cat_name'],
                        'scat_name_ascii' => $listsub['cat_name_ascii'],
                    ));
                $cnt->parse('sub_cat');
            }
            $i ++;
            $cnt->assign('lcat_name', $lcat['cat_name']);
            if(!in_array($cnt->rewrite_menu, array('news','category','product')) && $i == 1) $cnt->assign('lcat_class', 'show');
            elseif($cnt->rewrite_menu == 'category') {
                list($subid) = @mysql_fetch_array(@mysql_query("SELECT cat_sub FROM cnt_cats WHERE cat_type = 2 and id = ".$cnt->rewrite_id));
                if($subid == $lcat['id']) $cnt->assign('lcat_class', 'show');
                elseif(!$subid && $i == 1) $cnt->assign('lcat_class', 'show');
                else $cnt->assign('lcat_class', 'hide');
            }
            elseif($cnt->rewrite_menu == 'product'){
                list($catid) = @mysql_fetch_array(@mysql_query("SELECT product_cat FROM cnt_products WHERE id = ".$cnt->rewrite_id));
                list($subid) = @mysql_fetch_array(@mysql_query("SELECT cat_sub FROM cnt_cats WHERE cat_type = 2 and id = ".$catid));
                if($subid == $lcat['id']) $cnt->assign('lcat_class', 'show');
                else $cnt->assign('lcat_class', 'hide');
            }
            elseif($cnt->rewrite_menu == 'news' && $i == 1)$cnt->assign('lcat_class', 'show');
            else $cnt->assign('lcat_class', 'hide');
            $cnt->parse('list_cat');
        }
        
        $list_ncat = @mysql_query("SELECT cat_name, id FROM cnt_cats WHERE cat_type = 1 and cat_sub = 0 ORDER BY cat_order ASC");
        while ($lncat = @mysql_fetch_array ($list_ncat)){
            $sub_ncat = @mysql_query("SELECT * FROM cnt_cats WHERE cat_type = 1 and cat_sub = ".$lncat['id']." ORDER BY cat_order ASC");
            while ($listnsub = @mysql_fetch_array ($sub_ncat)){
                $cnt->assign(
                    array(
                        'sncat_name' => $listnsub['cat_name'],
                        'sncat_name_ascii' => $listnsub['cat_name_ascii'],
                    ));
                $cnt->parse('sub_ncat');
            }
            $j ++;
            $cnt->assign('lncat_name', $lncat['cat_name']);
            $cnt->parse('list_ncat');
        }
        
        $list_support = @mysql_query("SELECT * FROM cnt_supports");
        while ($lsupport = @mysql_fetch_array ($list_support)){
            if($lsupport['support_skype'] != '') $cnt->parse('skype');
            if($lsupport['support_yahoo'] != '') $cnt->parse('yahoo');
            if($lsupport['support_mobile'] != '') $cnt->parse('mobile');
            $cnt->assign(
                array(
                    'support_name' => $lsupport['support_name'],
                    'support_yahoo' => $lsupport['support_yahoo'],
                    'support_skype' => $lsupport['support_skype'],
                    'support_mobile' => $lsupport['support_mobile'],
                ));
            $cnt->parse('list_support');
        }
        
        $list_adright = @mysql_query("SELECT * FROM cnt_ads WHERE ad_type = 1 ORDER BY id ASC");
        while ($ladright = @mysql_fetch_array ($list_adright)){
            $cnt->assign(
                array(
                    'ad_url' => $ladright['ad_link'],
                    'ad_img' => $ladright['ad_image'],
                    'ad_name' => $ladright['ad_name'],
                ));
            $cnt->parse('list_adright');
        }
        
        $list_adleft = @mysql_query("SELECT * FROM cnt_ads WHERE ad_type = 2 ORDER BY id ASC");
        while ($ladleft = @mysql_fetch_array ($list_adleft)){
            $cnt->assign(
                array(
                    'ad_url' => $ladleft['ad_link'],
                    'ad_img' => $ladleft['ad_image'],
                    'ad_name' => $ladleft['ad_name'],
                ));
            $cnt->parse('list_adleft');
        }
        
        $list_sleft = @mysql_query("SELECT * FROM cnt_ads WHERE ad_type = 4 ORDER BY id ASC LIMIT 5");
        while ($lsleft = @mysql_fetch_array ($list_sleft)){
            $cnt->assign(
                array(
                    'ad_url' => $lsleft['ad_link'],
                    'ad_img' => $lsleft['ad_image'],
                    'ad_name' => $lsleft['ad_name'],
                ));
            $cnt->parse('list_sleft');
        }
        
        $list_sright = @mysql_query("SELECT * FROM cnt_ads WHERE ad_type = 3 ORDER BY id ASC LIMIT 5");
        while ($lsright = @mysql_fetch_array ($list_sright)){
            $cnt->assign(
                array(
                    'ad_url' => $lsright['ad_link'],
                    'ad_img' => $lsright['ad_image'],
                    'ad_name' => $lsright['ad_name'],
                ));
            $cnt->parse('list_sright');
        }
        
        $slide_product = @mysql_query("SELECT product_name, product_image, product_fullimg, product_cat, product_name_ascii, product_price, product_free FROM cnt_products ORDER BY RAND() LIMIT 15");
        while ($lsp = @mysql_fetch_array ($slide_product)){
            list($cat) = @mysql_fetch_array(@mysql_query("SELECT cat_name_ascii FROM cnt_cats WHERE cat_type = 2 and id = ".$lsp['product_cat']));
            if($k == 5) {
                $cnt->parse('slide_product');
                $k = 0;
                $l = true;
            }
            $cnt->assign(
                array(
                    'product_img' => $lsp['product_fullimg'],
                    'product_thumb' => $lsp['product_image'],
                    'product_name' => $lsp['product_name'],
                    'product_name_ascii' => $lsp['product_name_ascii'],
                    'cat_name_ascii' => $cat,
                    'product_price' => ($lsp['product_free'] > 0)?number($lsp['product_free']):number($lsp['product_price']),
                ));
            $cnt->parse('product_item');
            $cnt->assign('slide_class', ($l)?'hide':'');
            $k ++;
        }
        $cnt->parse('slide_product');
        
        $list_free = @mysql_query("SELECT product_name, product_image, product_fullimg, product_cat, product_name_ascii, product_price, product_free FROM cnt_products WHERE product_free > 0 ORDER BY RAND() LIMIT 5");
        while ($lfree = @mysql_fetch_array ($list_free)){
            list($cat) = @mysql_fetch_array(@mysql_query("SELECT cat_name_ascii FROM cnt_cats WHERE cat_type = 2 and id = ".$lfree['product_cat']));
            $cnt->assign(
                array(
                    'product_img' => $lfree['product_fullimg'],
                    'product_thumb' => $lfree['product_image'],
                    'product_name' => $lfree['product_name'],
                    'product_name_ascii' => $lfree['product_name_ascii'],
                    'cat_name_ascii' => $cat,
                    'product_price' => number($lfree['product_price']),
                    'product_free' => number($lfree['product_free']),
                ));
            $cnt->parse('list_free');
        }
        
        $slide_news = @mysql_query("SELECT post_cat, post_name, post_time, post_name_ascii, post_image, post_quote FROM cnt_posts WHERE post_type = 1 ORDER BY id DESC LIMIT 0,5");
        while ($lsn = @mysql_fetch_array ($slide_news)){
            list($cat) = @mysql_fetch_array(@mysql_query("SELECT cat_name_ascii FROM cnt_cats WHERE cat_type = 1 and id = ".$lsn['post_cat']));
            $cnt->assign(
                array(
                    'news_name' => $lsn['post_name'],
                    'news_name_ascii' => $lsn['post_name_ascii'],
                    'cat_name_ascii' => $cat,
                    'news_time' => formatTime($lsn['post_time'],3),
                    'news_img' => $lsn['post_image'],
                    'news_quote' => $lsn['post_quote'],
                ));
            $cnt->assign('news_class', ($news_class)?'hide':'');
            $news_class = true;
            $cnt->parse('slide_news');
        } 
        
        if(($poll = @mysql_fetch_array(@mysql_query("SELECT id, poll_name FROM cnt_polls WHERE poll_pid = 0 and poll_active = 1 ORDER by id DESC LIMIT 1")))) {
            $cnt->parse('poll');
        }       
        
        switch($cnt->rewrite_menu){
            case 'home':
                $this_title = get_option('name');
                $list_home = @mysql_query("SELECT id, product_name, product_image, product_fullimg, product_descrip, product_total, product_cat, product_name_ascii, product_price, product_free FROM cnt_products ORDER BY product_view DESC LIMIT 5");
                while ($lhome = @mysql_fetch_array ($list_home)){
                    list($cat) = @mysql_fetch_array(@mysql_query("SELECT cat_name_ascii FROM cnt_cats WHERE cat_type = 2 and id = ".$lhome['product_cat']));
                    $cnt->assign(
                        array(
                            'product_id' => $lhome['id'],
                            'product_img' => $lhome['product_fullimg'],
                            'product_thumb' => $lhome['product_image'],
                            'product_name' => $lhome['product_name'],
                            'product_name_ascii' => $lhome['product_name_ascii'],
                            'cat_name_ascii' => $cat,
                            'product_info' => $lhome['product_descrip'],
                            'product_price' => number($lhome['product_price']),
                            'product_free' => number($lhome['product_free']),
                            'USD_price' => USD($lhome['product_price']),
                            'USD_free' => USD($lhome['product_free']),
                            'product_total' => number($lhome['product_total']),
                        ));
                        ($lhome['product_free'] == 0)?$cnt->parse('hview_price'):$cnt->parse('hview_free');
                        ($lhome['product_total'] > 0)?$cnt->parse('hview_addcart'):false;
                    $cnt->parse('hview_list');
                }
                
                $list_home = @mysql_query("SELECT id, product_name, product_image, product_fullimg, product_descrip, product_total, product_cat, product_name_ascii, product_price, product_free FROM cnt_products ORDER BY id DESC LIMIT 5");
                while ($lhome = @mysql_fetch_array ($list_home)){
                    list($cat) = @mysql_fetch_array(@mysql_query("SELECT cat_name_ascii FROM cnt_cats WHERE cat_type = 2 and id = ".$lhome['product_cat']));
                    $cnt->assign(
                        array(
                            'product_id' => $lhome['id'],
                            'product_img' => $lhome['product_fullimg'],
                            'product_thumb' => $lhome['product_image'],
                            'product_name' => $lhome['product_name'],
                            'product_name_ascii' => $lhome['product_name_ascii'],
                            'cat_name_ascii' => $cat,
                            'product_info' => $lhome['product_descrip'],
                            'product_price' => number($lhome['product_price']),
                            'product_free' => number($lhome['product_free']),
                            'USD_price' => USD($lhome['product_price']),
                            'USD_free' => USD($lhome['product_free']),
                            'product_total' => number($lhome['product_total']),
                        ));
                        ($lhome['product_free'] == 0)?$cnt->parse('hnew_price'):$cnt->parse('hnew_free');
                        ($lhome['product_total'] > 0)?$cnt->parse('hnew_addcart'):false;
                    $cnt->parse('hnew_list');
                }
                
                $list_home = @mysql_query("SELECT id, product_name, product_image, product_fullimg, product_descrip, product_total, product_cat, product_name_ascii, product_price, product_free FROM cnt_products WHERE product_free > 0 ORDER BY id DESC LIMIT 5");
                while ($lhome = @mysql_fetch_array ($list_home)){
                    list($cat) = @mysql_fetch_array(@mysql_query("SELECT cat_name_ascii FROM cnt_cats WHERE cat_type = 2 and id = ".$lhome['product_cat']));
                    $cnt->assign(
                        array(
                            'product_id' => $lhome['id'],
                            'product_img' => $lhome['product_fullimg'],
                            'product_thumb' => $lhome['product_image'],
                            'product_name' => $lhome['product_name'],
                            'product_name_ascii' => $lhome['product_name_ascii'],
                            'cat_name_ascii' => $cat,
                            'product_info' => $lhome['product_descrip'],
                            'product_price' => number($lhome['product_price']),
                            'product_free' => number($lhome['product_free']),
                            'USD_price' => USD($lhome['product_price']),
                            'USD_free' => USD($lhome['product_free']),
                            'product_total' => number($lhome['product_total']),
                        ));
                        ($lhome['product_total'] > 0)?$cnt->parse('hfree_addcart'):false;
                    $cnt->parse('hfree_list');
                }
                $cnt->parse('home');
                
                $random_cat = @mysql_query("SELECT id, cat_name, cat_name_ascii FROM cnt_cats WHERE cat_type = 2 and cat_home = 1 ORDER by id ASC");
                while ($rd_cat = @mysql_fetch_array ($random_cat)){
                    $rd_product = @mysql_query("SELECT id, product_name, product_image, product_fullimg, product_descrip, product_total, product_cat, product_name_ascii, product_price, product_free FROM cnt_products WHERE product_cat = ".$rd_cat['id']." ORDER BY id DESC LIMIT 6");
                    $i = 0;
                    while ($item = @mysql_fetch_array ($rd_product)){
                        if($i == 3){
                            $cnt->parse('random_icon');
                            $i = 0;
                        }
                        $i ++;
                        $cnt->assign(
                            array(
                                'product_id' => $item['id'],
                                'product_img' => $item['product_fullimg'],
                                'product_thumb' => $item['product_image'],
                                'product_name' => $item['product_name'],
                                'product_name_ascii' => $item['product_name_ascii'],
                                'cat_name_ascii' => $this_cat['cat_name_ascii'],
                                'product_price' => number($item['product_price']),
                                'product_free' => number($item['product_free']),
                                'USD_price' => USD($item['product_price']),
                                'USD_free' => USD($item['product_free']),
                            ));
                        ($item['product_free'] == 0)?$cnt->parse('tdr_price'):$cnt->parse('tdr_free');
                        ($item['product_total'] > 0)?$cnt->parse('tdr_addcart'):false;
                        $cnt->parse('random_td');
                    }
                    $cnt->parse('random_icon');
                    $cnt->assign(
                        array(
                            'cat_name' => $rd_cat['cat_name'],
                            'cat_name_ascii' => $rd_cat['cat_name_ascii'],
                        ));
                    $cnt->parse('random');
                }
                break;
                
            case 'category':
                $this_title = 'Danh mục';
                $p_start = ($cnt->rewrite_page -1) * get_option('paging');
                $this_cat = @mysql_fetch_array(@mysql_query("SELECT cat_name, cat_name_ascii, cat_type FROM cnt_cats WHERE id = ".$cnt->rewrite_id));
                if($this_cat['cat_type'] == 1){
                    $total_p = @mysql_num_rows(@mysql_query("SELECT id FROM cnt_posts WHERE post_type = 1 and post_cat = ".$cnt->rewrite_id));
                    $list_item = @mysql_query("SELECT post_name, post_name_ascii, post_quote, post_image, post_time FROM cnt_posts WHERE post_type = 1 and post_cat = ".$cnt->rewrite_id." ORDER BY id DESC LIMIT ".$p_start.",".get_option('paging'));
                    while ($item = @mysql_fetch_array ($list_item)){
                        $cnt->assign(
                            array(
                                'news_img' => $item['post_image'],
                                'cat_name_ascii' => $this_cat['cat_name_ascii'],
                                'news_name_ascii' => $item['post_name_ascii'],
                                'news_name' => $item['post_name'],
                                'news_time' => formatTime($item['post_time'],3),
                                'news_info' => $item['post_quote'],
                            ));
                        if($item['post_image'] != '') $cnt->parse('list_img');
                        $cnt->parse('list_news');
                    }
                    $cnt->assign('paging', paging(get_option('paging'),$cnt->rewrite_page, $total_p, $this_cat['cat_name_ascii'], '-page-' ,false));
                    $cnt->assign('this_cat', $this_cat['cat_name']);
                    $cnt->parse('news_list');
                }
                else {
                    $total_p = @mysql_num_rows(@mysql_query("SELECT id FROM cnt_products WHERE product_cat = ".$cnt->rewrite_id));
                    if($_COOKIE['order'] == 2) $order = 'product_price DESC';
                    elseif($_COOKIE['order'] == 1) $order = 'product_price ASC';
                    elseif($_COOKIE['order'] == 4) $order = 'product_view DESC';
                    else $order = 'id DESC';
                    
                    if($_COOKIE['list'] == 'icon') {
                        $cnt->assign('list_menu', '<a id="list-full">Chi tiết</a> | Dạng rút gọn');
                        $list_item = @mysql_query("SELECT id, product_name, product_name_ascii, product_price, product_free, product_total, product_image, product_fullimg FROM cnt_products WHERE product_cat = ".$cnt->rewrite_id." ORDER BY ".$order." LIMIT ".$p_start.",".get_option('paging'));
                        $i = 0;
                        while ($item = @mysql_fetch_array ($list_item)){
                            if($i == 3){
                                $cnt->parse('lproduct_icon');
                                $i = 0;
                            }
                            $i ++;
                            $cnt->assign(
                                array(
                                    'product_id' => $item['id'],
                                    'product_img' => $item['product_fullimg'],
                                    'product_thumb' => $item['product_image'],
                                    'product_name' => $item['product_name'],
                                    'product_name_ascii' => $item['product_name_ascii'],
                                    'cat_name_ascii' => $this_cat['cat_name_ascii'],
                                    'product_price' => number($item['product_price']),
                                    'product_free' => number($item['product_free']),
                                    'USD_price' => USD($item['product_price']),
                                    'USD_free' => USD($item['product_free']),
                                ));
                            ($item['product_free'] == 0)?$cnt->parse('td_price'):$cnt->parse('td_free');
                            ($item['product_total'] > 0)?$cnt->parse('td_addcart'):false;
                            $cnt->parse('lproduct_td');
                        }
                        $cnt->parse('lproduct_icon');
                    }
                    else{
                        $cnt->assign('list_menu', 'Chi tiết | <a id="list-icon">Dạng rút gọn</a>');
                        $list_item = @mysql_query("SELECT id, product_name, product_name_ascii, product_price, product_free, product_total, product_descrip, product_image, product_fullimg FROM cnt_products WHERE product_cat = ".$cnt->rewrite_id." ORDER BY ".$order." LIMIT ".$p_start.",".get_option('paging'));
                        while ($item = @mysql_fetch_array ($list_item)){
                            $cnt->assign(
                                array(
                                    'product_id' => $item['id'],
                                    'product_img' => $item['product_fullimg'],
                                    'product_thumb' => $item['product_image'],
                                    'product_name' => $item['product_name'],
                                    'product_name_ascii' => $item['product_name_ascii'],
                                    'cat_name_ascii' => $this_cat['cat_name_ascii'],
                                    'product_info' => $item['product_descrip'],
                                    'product_price' => number($item['product_price']),
                                    'product_free' => number($item['product_free']),
                                    'USD_price' => USD($item['product_price']),
                                    'USD_free' => USD($item['product_free']),
                                    'product_total' => number($item['product_total']),
                                ));
                            ($item['product_free'] == 0)?$cnt->parse('lproduct_price'):$cnt->parse('lproduct_free');
                            ($item['product_total'] > 0)?$cnt->parse('lproduct_addcart'):false;
                            $cnt->parse('lproduct_full');
                        }
                    }
                    
                    $cnt->assign('paging', paging(get_option('paging'),$cnt->rewrite_page, $total_p, $this_cat['cat_name_ascii'], '-page-' ,false));
                    $cnt->assign(
                        array(
                            'this_cat' => $this_cat['cat_name'],
                            'product_all' => $total_p,
                        ));
                    $cnt->parse('product_list');
                }
                $this_title .= ' | '.$this_cat['cat_name'].' Trang '.$cnt->rewrite_page;
                break;
                
            case 'search':
                $this_title = 'Tìm kiếm';                   
                $s_start = ($cnt->rewrite_page -1) * get_option('paging');
                $total_s = @mysql_num_rows(@mysql_query("SELECT id FROM cnt_products WHERE ".search_like('product_name', $cnt->rewrite_search)));
                if($_COOKIE['order'] == 2) $order = 'product_price DESC';
                elseif($_COOKIE['order'] == 1) $order = 'product_price ASC';
                elseif($_COOKIE['order'] == 4) $order = 'product_view DESC';
                else $order = 'id DESC';
                
                if($_COOKIE['list'] == 'icon') {
                    $cnt->assign('list_menu', '<a id="list-full">Chi tiết</a> | Dạng rút gọn');
                    $list_item = @mysql_query("SELECT id, product_name, product_name_ascii, product_price, product_free, product_total, product_image, product_fullimg, product_cat FROM cnt_products WHERE ".search_like('product_name', $cnt->rewrite_search)." ORDER BY ".$order." LIMIT ".$s_start.",".get_option('paging'));
                    $i = 0;
                    while ($item = @mysql_fetch_array ($list_item)){
                        if($i == 3){
                            $cnt->parse('lsearch_icon');
                            $i = 0;
                        }
                        $i ++;
                        list($cat) = @mysql_fetch_array(@mysql_query("SELECT cat_name_ascii FROM cnt_cats WHERE id = ".$item['product_cat']));                        
                        $cnt->assign(
                            array(
                                'product_id' => $item['id'],
                                'product_img' => $item['product_fullimg'],
                                'product_thumb' => $item['product_image'],
                                'product_name' => $item['product_name'],
                                'product_name_ascii' => $item['product_name_ascii'],
                                'cat_name_ascii' => $cat,
                                'product_price' => number($item['product_price']),
                                'product_free' => number($item['product_free']),
                                'USD_price' => USD($item['product_price']),
                                'USD_free' => USD($item['product_free']),
                            ));
                        ($item['product_free'] == 0)?$cnt->parse('tds_price'):$cnt->parse('tds_free');
                        ($item['product_total'] > 0)?$cnt->parse('tds_addcart'):false;
                        $cnt->parse('lsearch_td');
                    }
                    $cnt->parse('lsearch_icon');
                }
                else{
                    $cnt->assign('list_menu', 'Chi tiết | <a id="list-icon">Dạng rút gọn</a>');
                    $list_item = @mysql_query("SELECT id, product_name, product_name_ascii, product_price, product_free, product_total, product_descrip, product_image, product_fullimg, product_cat FROM cnt_products WHERE ".search_like('product_name', $cnt->rewrite_search)." ORDER BY ".$order." LIMIT ".$s_start.",".get_option('paging'));
                    while ($item = @mysql_fetch_array ($list_item)){
                        list($cat) = @mysql_fetch_array(@mysql_query("SELECT cat_name_ascii FROM cnt_cats WHERE id = ".$item['product_cat']));                        
                        $cnt->assign(
                            array(
                                'product_id' => $item['id'],
                                'product_img' => $item['product_fullimg'],
                                'product_thumb' => $item['product_image'],
                                'product_name' => $item['product_name'],
                                'product_name_ascii' => $item['product_name_ascii'],
                                'cat_name_ascii' => $cat,
                                'product_info' => $item['product_descrip'],
                                'product_price' => number($item['product_price']),
                                'product_free' => number($item['product_free']),
                                'USD_price' => USD($item['product_price']),
                                'USD_free' => USD($item['product_free']),
                                'product_total' => number($item['product_total']),
                            ));
                        ($item['product_free'] == 0)?$cnt->parse('lsearch_price'):$cnt->parse('lsearch_free');
                        ($item['product_total'] > 0)?$cnt->parse('lsearch_addcart'):false;
                        $cnt->parse('lsearch_full');
                    }
                }
                
                $cnt->assign('paging', paging(get_option('paging'),$cnt->rewrite_page, $total_s, $cnt->rewrite_search, '-page-' ,false));
                $cnt->assign(
                    array(
                        'this_key' => str_replace('-', ' ',$cnt->rewrite_search),
                        'product_all' => $total_s,
                    ));
                $cnt->parse('search');
                $this_title .= ' | '.str_replace('-', ' ',$cnt->rewrite_search.' Trang '.$cnt->rewrite_page);
                break;
                
            case 'product':
                @mysql_query("UPDATE cnt_products SET product_view = product_view + 1 WHERE id = ".$cnt->rewrite_id);            
                $this_product = @mysql_fetch_array(@mysql_query("SELECT * FROM cnt_products WHERE id = ".$cnt->rewrite_id));
                $cat = @mysql_fetch_array(@mysql_query("SELECT cat_name, cat_name_ascii FROM cnt_cats WHERE id = ".$this_product['product_cat']));
                $cnt->assign(
                    array(
                        'product_id' => $cnt->rewrite_id,
                        'product_name' => $this_product['product_name'],
                        'product_thumb' => $this_product['product_image'],
                        'product_img' => $this_product['product_fullimg'],
                        'product_quality' => $this_product['product_quality'],
                        'product_warranty' => ($this_product['product_warranty'] == 0)?'Không':$this_product['product_warranty'].' Tháng',
                        'product_price' => number($this_product['product_price']),
                        'USD_price' => USD($this_product['product_price']),
                        'product_free' => number($this_product['product_free']),
                        'USD_free' => USD($this_product['product_free']),
                        'product_total' => number($this_product['product_total']),
                        'product_info' => $this_product['product_info'],
                    ));
                $descrip = explode(' / ',$this_product['product_descrip']);
                foreach ($descrip as $item) {
                    $it = explode(': ',$item);
                    $cnt->assign(
                        array(
                            'descrip_name' => $it[0],
                            'descrip_val' => $it[1],
                    ));
                    $cnt->parse('product_descrip');
                }
                $list_in = @mysql_query("SELECT product_name, product_image, product_fullimg, product_cat, product_name_ascii, product_price, product_free FROM cnt_products WHERE product_cat = ".$this_product['product_cat']." and id != ".$cnt->rewrite_id." ORDER BY RAND() LIMIT 5");
                while ($in_cat = @mysql_fetch_array ($list_in)){
                    $cnt->assign(
                        array(
                            'in_cat_img' => $in_cat['product_fullimg'],
                            'in_cat_thumb' => $in_cat['product_image'],
                            'in_cat_name' => $in_cat['product_name'],
                            'in_cat_name_ascii' => $in_cat['product_name_ascii'],
                            'cat_name_ascii' => $cat['cat_name_ascii'],
                            'in_cat_price' => ($in_cat['product_free'] == 0)?number($in_cat['product_price']):number($in_cat['product_free']),
                        ));
                    $cnt->parse('in_cat');
                }
                $cnt->parse('view_product');
                $this_title = $cat['cat_name'].' | '.$this_product['product_name'];
                break;
                
            case 'news':
                $this_post = @mysql_fetch_array(@mysql_query("SELECT * FROM cnt_posts WHERE post_type = 1 and id = ".$cnt->rewrite_id));
                list($post_user) = @mysql_fetch_array(@mysql_query("SELECT user_nick FROM cnt_users WHERE id = ".$this_post['post_user']));
                $cat = @mysql_fetch_array(@mysql_query("SELECT cat_name, cat_name_ascii FROM cnt_cats WHERE id = ".$this_post['post_cat']));
                $cnt->assign(
                    array(
                        'post_title' => $this_post['post_name'],
                        'post_time' => formatTime($this_post['post_time'], 1),
                        'post_content' => $this_post['post_content'],
                        'post_user' => $post_user,
                    ));
                if(strlen($this_post['post_file']) > 10) {
                    $lfile = explode(',',$this_post['post_file']);
                    array_shift($lfile);
                    foreach($lfile as $files) {
                        $file = explode('|',$files);
                        $cnt->assign(
                            array(
                                'file_name' => $file[0],
                                'file_url' => $file[1],
                            ));
                        $cnt->parse('list_file');
                    }
                    $cnt->parse('files');
                }
                $list_news = @mysql_query("SELECT post_name, post_name_ascii, post_time FROM cnt_posts WHERE post_type = 1 and post_cat = ".$this_post['post_cat']." and id != ".$cnt->rewrite_id." LIMIT 0,5");
                while ($news = @mysql_fetch_array ($list_news)){
                    $cnt->assign(
                        array(
                            'news_ascii' => $news['post_name_ascii'],
                            'news_title' => $news['post_name'],
                            'news_time' => formatTime($news['post_time'],2),
                        ));
                    $cnt->parse('news');
                }
                $cnt->assign('cat_name_ascii', $cat['cat_name_ascii']);   
                $cnt->parse('view');
                if($this_post['post_comment'] == 1){
                    $list_com = @mysql_query("SELECT id, comment_content, comment_user, comment_time FROM cnt_comments WHERE comment_sid = 0 and comment_pid = ".$cnt->rewrite_id);
                    while ($com = @mysql_fetch_array ($list_com)){
                        list($com_user) = @mysql_fetch_array(@mysql_query("SELECT user_nick FROM cnt_users WHERE id = ".$com['comment_user']));
                        $cnt->assign(
                            array(
                                'com_user' => $com_user,
                                'com_time' => formatTime($com['comment_time'], 1),
                                'com_content' => $com['comment_content'],
                                'com_id' => $com['id'],
                            ));
                            $list_reply = @mysql_query("SELECT comment_content, comment_user, comment_time FROM cnt_comments WHERE comment_sid = ".$com['id']);
                            while ($reply = @mysql_fetch_array ($list_reply)){
                                list($reply_user) = @mysql_fetch_array(@mysql_query("SELECT user_nick FROM cnt_users WHERE id = ".$reply['comment_user']));
                                $cnt->assign(
                                    array(
                                        'reply_user' => $reply_user,
                                        'reply_time' => formatTime($reply['comment_time'], 1),
                                        'reply_content' => $reply['comment_content'],
                                    ));
                                $cnt->parse('reply_com');
                            }
                        if(check_level()>=3) $cnt->parse('reply_bt');
                        $cnt->parse('list_com');
                    }
                    if(check_log()){
                        $cnt->assign('com_post', $cnt->rewrite_id);
                        $cnt->parse('reply_form');
                    } 
                    $cnt->assign('total_com', @mysql_num_rows(@mysql_query("SELECT id FROM cnt_comments WHERE comment_pid = ".$cnt->rewrite_id)));
                    $cnt->parse('comment');
                }
                $this_title = $cat['cat_name'].' | '.$this_post['post_name'];
                break;
            
            case 'shopcart':
                $this_title = 'Giỏ hàng';
                if(!$_SESSION['shopcart']){
                    $cnt->assign(
                        array(
                            'cart_total' => 'không có sản phẩm nào',
                            'monney' => '0',
                            ));
                }
                else {
                    foreach($_SESSION['shopcart'] as $id => $total){
                        $tt ++;
                        $product = @mysql_fetch_array(@mysql_query("SELECT product_name, product_name_ascii, product_cat, product_price, product_free FROM cnt_products WHERE id = ".$id));
                        list($cat) = @mysql_fetch_array(@mysql_query("SELECT cat_name_ascii FROM cnt_cats WHERE id = ".$product['product_cat']));  
                        $this_monney = $product['product_price'] * $total;
                        $monney += $this_monney;
                        $cnt->assign(
                            array(
                                'cart_number' => $tt,
                                'product_id' => $id,
                                'product_name' => $product['product_name'],
                                'product_name_ascii' => $product['product_name_ascii'],
                                'cat_name_ascii' => $cat,
                                'product_price' => ($product['product_free'] == 0)?number($product['product_price']):number($product['product_free']),
                                'product_total' => $total,
                                'product_monney' => number($this_monney),
                            )); 
                        $cnt->assign('monney', number($monney));
                        $cnt->parse('cart_list');
                    }
                    $cnt->assign('cart_total', '');
                }
                $cnt->parse('shopcart');
                if(!$_SESSION['pay']) {
                    if($_SESSION['user']){
                        $pay_user = @mysql_fetch_array(@mysql_query("SELECT user_fullname, user_email FROM cnt_users WHERE id = ".$_SESSION['user']['id']));
                        $cnt->assign(
                            array(
                                'pay_name' => $pay_user['user_fullname'],
                                'pay_email' => $pay_user['user_email'],
                            ));
                    }
                    else {
                        $cnt->assign(
                            array(
                                'pay_name' => '',
                                'pay_email' => '',
                            ));
                    }
                    $cnt->parse('pay');
                }
                elseif($_SESSION['pay']){
                    unset($_SESSION['pay']);
                    $cnt->parse('pay_ok');
                }
                break;
                
            case 'page':
                $this_page = @mysql_fetch_array(@mysql_query("SELECT post_name, post_content FROM cnt_posts WHERE post_type = 2 and id = ".$cnt->rewrite_id));
                $cnt->assign(
                    array(
                        'page_title' => $this_page['post_name'],
                        'page_content' => $this_page['post_content'],
                    ));    
                $cnt->parse('page');
                $this_title = $this_page['post_name'];
                break;
                
            case 'faq':
                $list_faq = @mysql_query("SELECT * FROM cnt_faqs");
                while ($faq = @mysql_fetch_array ($list_faq)){
                    $cnt->assign(
                        array(
                            'faq_id' => $faq['id'],
                            'faq_title' => $faq['faq_name'],
                            'lfaq_id' => $faq['id'],
                            'lfaq_title' => $faq['faq_name'],
                            'lfaq_content' => $faq['faq_content'],
                        ));
                    $cnt->parse('faq_title');
                    $cnt->parse('faq_list');
                }
                $cnt->parse('faq');
                $this_title = 'Câu hỏi thường gặp';
                break;
                
            case 'contact':
                $cnt->parse('contact');
                $this_title = 'Liên hệ';
                break;
        }
        
        if(get_option('report') == 1 && !$_COOKIE['report']) $cnt->parse('report');
        
        online();
        $user_on = @mysql_num_rows(@mysql_query("SELECT id FROM cnt_onlines WHERE online_user > 0"));
        $guest_on = @mysql_num_rows(@mysql_query("SELECT id FROM cnt_onlines WHERE online_user <= 0"));
        list($total_visit) = @mysql_fetch_array(@mysql_query("SELECT MAX(id) FROM cnt_onlines"));
        $cnt->assign(
            array(
                'this_time' => formatTime(time(), 4),
                'this_url' => this_url(),
                'web_url' => get_option('url'),
                'web_title' => $this_title,
                'web_description' => get_option('description'),
                'web_keywords' => get_option('keywords'),
                'web_tpl' => get_option('default_tpl'),
                'total_product' => @mysql_num_rows(@mysql_query("SELECT id FROM cnt_products")),
                'total_visit' => $total_visit,
                'user_online' => $user_on,
                'guest_online' => $guest_on,
            ));
        $cnt->tpl_out();
    }
}

?>
