<?php

/**
 * @author Trung Hieu
 * @copyright 2010
 */
define('CNT',true);
include('cnt-includes/functions.php');
if($_POST['search'] && $_POST['search'] != ' '){
    header('Location: search/'.ascii($_POST['search']).'.html');
}
else echo 'Hacking attempt';


?>
