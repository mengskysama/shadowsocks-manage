<?php
	require "function.php";
	dbconn(true);

	$uid = getuid();
	$sql = "DELETE FROM `Cookie` WHERE `uid` = $uid";
	mysql_query($sql);
	
	setcookie('u2', '');
	header("Location: " . get_protocol_prefix() . "$BASEURL/login.php");
	mysql_close();
?>