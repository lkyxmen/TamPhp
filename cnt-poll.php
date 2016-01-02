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
if($_POST['id']) {
    @mysql_query("UPDATE cnt_polls SET poll_votes = poll_votes + 1 WHERE id = ".$_POST['id']);
    setcookie('poll', true);
    $this_poll = true;
}
$poll = @mysql_fetch_array(@mysql_query("SELECT id, poll_name FROM cnt_polls WHERE poll_pid = 0 and poll_active = 1 ORDER by id DESC LIMIT 1"));
$list_poll = @mysql_query("SELECT id, poll_name, poll_votes FROM cnt_polls WHERE poll_pid = ".$poll['id']." ORDER by poll_order ASC");
echo '<p style="padding-bottom: 10px;"><strong>'.$poll['poll_name'].'</strong></p>';
if($_COOKIE['poll'] || $this_poll){
    $color = array(
        '1' => 'red',
        '2' => 'blue',
        '3' => 'green',
        '4' => 'yellow',
        '5' => 'orange',
        '6' => 'olive',
        '7' => 'navy',
        '8' => 'purple',
        '9' => 'aqua',
        '10' => 'teal',
        );
    while ($lpoll = @mysql_fetch_array($list_poll)){
        $total += $lpoll['poll_votes'];
        $i ++;
        $p[$i] = $lpoll['poll_votes'];
        echo '<p style="color: '.$color[$i].';">'.$i.'. '.$lpoll['poll_name'].'</p>';
    }
    echo '<p><strong>Tổng phiếu: '.$total.'</strong></p><table>';
    for($j = 1; $j <= $i ;$j ++){
        $vote = round($p[$j]/$total*100, 1);
        echo '<p style="cursor: pointer; margin-top: 3px; line-height: 10px; background-color: '.$color[$j].'; width: '.($vote*1.5).'px;" title="'.$j.'. Có '.$p[$j].' phiếu, chiếm '.$vote.'%">&nbsp;</p>';
    }
    echo '</table>';
}
else {
    while ($lpoll = @mysql_fetch_array ($list_poll)){
        echo '<p><input type="radio" name="poll" value="'.$lpoll['id'].'" /> '.$lpoll['poll_name'].'</p>';
    }
    echo '<p style="text-align: center; padding-top: 10px;"><button class="bt poll">Biểu quyết</button></p>';
}

?>
