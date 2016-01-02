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

if (check_log() & check_level() >= 9) {
	$match = @mysql_fetch_array(@mysql_query("SELECT VERSION()"));
	$match = explode('.', $match[0]);
	define('MYSQL_VERSION',(int) sprintf('%d%02d%02d', $match[0], $match[1], intval($match[2])));
	unset($match);
	
	define('NOW',gmmktime());
	if (MYSQL_VERSION >= 40102)	define('ENGINE_KEYWORD','ENGINE');
	else define('ENGINE_KEYWORD','TYPE');
	
	$q_tb = @mysql_query("SHOW TABLES LIKE 'cnt_%'");
	$sql = 
		"-- --------------------------------------------------------\n".
		"-- CNT DATABASE BACKUP\n".
		"-- DATE : ".date('d m Y',NOW)."\n".
		"-- --------------------------------------------------------\n\n";
	while ($r_tb = @mysql_fetch_array($q_tb)) {
		$table_name = $r_tb[0];
		
		$q_cl = @mysql_query("SHOW COLUMNS FROM `$table_name`");
		$str = 
			"-- --------------------------------------------------------\n".
			"-- TABLE $table_name\n".
			"-- --------------------------------------------------------\n\n";
		$str .= "DROP TABLE IF EXISTS `$table_name`;\n";
		$str .= "CREATE TABLE `$table_name` (\n";
		$pri_arr = array();
		$key_arr = array();
		$cl_name = '';
		$cl_size = @mysql_num_rows($q_cl);
		while ($r_cl = @mysql_fetch_array($q_cl)) {
			extract($r_cl);
			$str .= "  `". $Field ."` ". $Type;
			$cl_name .= "`". $Field ."`, ";
			if ($Null && !$Default) $str .= ' default NULL';
			elseif (isset($Default)) $str .= " NOT NULL default '". $Default ."'";
			elseif (!$Null) $str .= " NOT NULL";
			if ($Extra) $str .= " auto_increment";
			$str .= ",\n";
			if ($Key == 'PRI') $pri_arr[] = $Field;
			elseif ($Key == 'MUL') $key_arr[] = $Field;
		}
		unset($Field, $Type, $Null, $Default, $Extra);
		
		if (count($pri_arr)) {
			$str .= " PRIMARY KEY (";
			for ($i=0;$i<count($pri_arr);$i++)	$str .= "`$pri_arr[$i]`,";
			$str = substr($str,0,-1);
			$str .= "),\n";
		}
		if (count($key_arr)) for ($i=0;$i<count($key_arr);$i++)	$str .= " KEY `$key_arr[$i]` (`$key_arr[$i]`),\n";
		
		$str = substr($str,0,-2);
		$r_status = @mysql_fetch_array(@mysql_query("SHOW TABLE STATUS LIKE '$table_name'"));
		extract($r_status);
		if (ENGINE_KEYWORD == 'ENGINE') $Type = $Engine;
		$str .= "\n) ".ENGINE_KEYWORD."=".$Type;
		
		if (MYSQL_VERSION >= 40102) $str .= ' DEFAULT CHARSET=utf8';
		if ($Auto_increment) $str .= " AUTO_INCREMENT=".$Auto_increment;
		
		$str .= ";\n\n";
        
		$cl_name = substr($cl_name,0,-2);
		$query = @mysql_query("SELECT * FROM `$table_name`");
		if (@mysql_num_rows($query)) {
			$str .= 
				"-- --------------------------------------------------------\n".
				"-- TABLE $table_name's DATA\n".
				"-- --------------------------------------------------------\n\n";
			$si = "INSERT INTO `$table_name` ($cl_name) VALUES ";
			while ($r = @mysql_fetch_array($query)) {
				$si .= "(";
				for ($i=0;$i<$cl_size;$i++) $si .= "'".addslashes(stripslashes($r[$i]))."',";
				$si = substr($si,0,-1);
				$si .= "),";
			}
			$si = substr($si,0,-1);
			$si = str_replace(
				array("\n","\t","\r","'),('"),
				array("\\n","\\t","\\r","'),\n('"),
				$si);
			
			$si .= ";\n";
		}
		$str .= $si;
            
		$str .= "\n\n";
		$sql .= $str;
		unset($si,$str);
	}
	$sql = gzencode($sql,9);
	$size = strlen($sql);
	header("Content-disposition: attachment; filename=CNT_".date('d_m_y',NOW).".sql.gz");
	header('Content-type: application/gzip; charset=UTF-8');
	header("Content-Length: $size");
	echo $sql;
	exit();
}
else echo "Hacking attempt";
?>
