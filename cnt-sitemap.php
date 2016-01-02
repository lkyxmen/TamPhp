<?php

/*-----------------------------------*\
|           Copyright © CNT           | 
|         Phone: 0986.901.797         |
|         Y!m: banmai_xanhmai         |
|       Website: CongNgheTre.Vn       |
|  Email: ThietKeWeb@CongNgheTre.Vn   |
\*-----------------------------------*/

define('CNT',true);
include('cnt-includes/config.php');
include('cnt-includes/functions.php');
$sitemap = '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="sitemap.xsl"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">  
    <url>
      <loc>'.get_option('url').'</loc>
      <changefreq>daily</changefreq>
      <priority>1.0</priority>
      <lastmod>'.gmstrftime('%Y-%m-%d',time()).'</lastmod>
   </url>   
';

$lcat = @mysql_query("SELECT cat_name_ascii FROM cnt_cats WHERE cat_sub != 0");
while ($cat = @mysql_fetch_array ($lcat)){
    $sitemap .= '    <url>
      <loc>'.get_option('url').'/category/'.$cat['cat_name_ascii'].'.html</loc>
      <changefreq>daily</changefreq>
      <priority>0.8</priority>
      <lastmod>'.gmstrftime('%Y-%m-%d',time()).'</lastmod>
   </url>
';
}

$news = @mysql_query("SELECT post_name_ascii, post_cat, post_time FROM cnt_posts WHERE post_type = 1");
while ($lnews = @mysql_fetch_array ($news)){
    list($cat_post) = @mysql_fetch_array (@mysql_query("SELECT cat_name_ascii FROM cnt_cats WHERE id = ".$lnews['post_cat']));
    $sitemap .= '    <url>
      <loc>'.get_option('url').'/news/'.$cat_post.'/'.$lnews['post_name_ascii'].'.html</loc>
      <changefreq>Always</changefreq>
      <priority>0.6</priority>
      <lastmod>'.gmstrftime('%Y-%m-%d',$lnews['post_time']).'</lastmod>
   </url>
';
}

$product = @mysql_query("SELECT product_name_ascii, product_cat FROM cnt_products");
while ($lproduct = @mysql_fetch_array ($product)){
    list($cat_product) = @mysql_fetch_array (@mysql_query("SELECT cat_name_ascii FROM cnt_cats WHERE id = ".$lproduct['product_cat']));
    $sitemap .= '    <url>
      <loc>'.get_option('url').'/product/'.$cat_product.'/'.$lproduct['product_name_ascii'].'.html</loc>
      <changefreq>Always</changefreq>
      <priority>0.6</priority>
      <lastmod>'.gmstrftime('%Y-%m-%d',time()).'</lastmod>
   </url>
';
}

$page = @mysql_query("SELECT post_name_ascii, post_cat, post_time FROM cnt_posts WHERE post_type = 2");
while ($lpage = @mysql_fetch_array ($page)){
    $sitemap .= '    <url>
      <loc>'.get_option('url').'/'.$lpage['post_name_ascii'].'.html</loc>
      <changefreq>weekly</changefreq>
      <priority>0.6</priority>
      <lastmod>'.gmstrftime('%Y-%m-%d',$lpage['post_time']).'</lastmod>
   </url>
';
}

$sitemap .= '   <url>
      <loc>'.get_option('url').'/faq.html</loc>
      <changefreq>weekly</changefreq>
      <priority>0.3</priority>
      <lastmod>'.gmstrftime('%Y-%m-%d',time()).'</lastmod>
   </url>
   <url>
      <loc>'.get_option('url').'/contact.html</loc>
      <changefreq>never</changefreq>
      <priority>0.3</priority>
   </url>
</urlset>';

$size = strlen($sitemap);
header('Content-type: text/xml; charset=UTF-8');
header("Content-Length: $size");
echo $sitemap;
exit();

?>
