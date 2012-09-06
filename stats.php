<?php

	header('Content-type: text/html; charset=utf-8');
	include("lib/mysql.php");

	$status = explode('  ', mysql_stat($sql));
	print_r($status);
?>
