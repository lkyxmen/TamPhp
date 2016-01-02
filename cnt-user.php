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

if(!$_SESSION['user']){
    echo '<form action="'.get_option('url').'/cnt-cpanel/login.php" method="post" onsubmit="$(\'#back\').val(window.location)">
    <input type="hidden" id="back" name="back" value="" />
    <input type="text" name="nick" value="Tên đăng nhập" onblur="if(this.value==\'\')this.value=\'Tên đăng nhập\'" onfocus="if(this.value==\'Tên đăng nhập\')this.value=\'\'" />
    <input type="password" name="pass" value="password" onblur="if(this.value==\'\')this.value=\'password\'" onfocus="if(this.value==\'password\')this.value=\'\'" />
    <input type="submit" value="" style="display: none;" />
    </form>';
}
else{
    list($user_log) = @mysql_fetch_array(@mysql_query("SELECT user_fullname FROM cnt_users WHERE id = ".$_SESSION['user']['id']));
    echo '<span style="color: #1C6297;">Chào</span> <a href="'.get_option('url').'/cnt-cpanel/index.php?m=13" target="_blank">'.$user_log.'!</a> |
    <a href="'.get_option('url').'/cnt-cpanel/index.php?m=15" target="_blank">Tin nhắn ('.@mysql_num_rows(@mysql_query("SELECT id FROM cnt_messages WHERE message_to = '".$_SESSION['user']['id']."' and message_read = 0")).')</a> | 
    <a href="'.get_option('url').'/cnt-logout.php">Thoát</a>';
}
?>
