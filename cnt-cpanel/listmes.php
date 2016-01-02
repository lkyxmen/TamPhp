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
if(check_log()){
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
    <script type="text/javascript" src="../cnt-data/javascripts/jquery-1.4.2.min.js" ></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.to').click(function(){
                parent.$('#to').val($(this).text());
                parent.$.akModalRemove();
            });
            
        });
    </script>
    <style>
        table {
            margin-top: 20px;
            padding: 10px;
        }
        td {
            border-bottom: #E4E4E4 solid 1px;
        }
        a {
            color: black;
            font-weight: bold;
            text-decoration: none;
        }
        a:hover {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div style="width: 100%; background-color: white; position: fixed;"><a onclick="parent.$.akModalRemove();">Thoát</a></div>
    <table cellpadding="0" cellspacing="0" width="100%">
<?php
    if($HTTP_GET_VARS['class'] != null) {
        $u_where = 'WHERE user_class = '.$HTTP_GET_VARS['class'];
    }
    else {
        $u_where = '';
    }
    $user_list = @mysql_query("SELECT user_nick, user_class FROM cnt_users ".$u_where." ORDER BY id DESC");
    while ($luser = @mysql_fetch_array ($user_list)){
        list($u_class) = @mysql_fetch_array(@mysql_query("SELECT class_name FROM cnt_class WHERE id = ".$luser['user_class']));
?>
        <tr><td style="width: 150px;"><a class="to"><?php echo $luser['user_nick'] ?></a></td><td><a href="listmes.php?class=<?php echo $luser['user_class']; ?>"><?php echo ($u_class)?$u_class:'Không có'; ?></a></td></tr>  
<?php    
    }
}
else echo "Hacking attempt";

?>
    </table>

</body>
</html>
