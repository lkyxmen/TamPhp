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

$report = '<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="'.get_option('url').'/cnt-templates/'.get_option('default_tpl').'/css/report.css" type="text/css" />
<div>'.get_option('report_info').'</div>
<button onclick="parent.$.akModalRemove();" class="hide">Tắt thông báo</button>';

if(get_option('report')) echo $report;

?>
