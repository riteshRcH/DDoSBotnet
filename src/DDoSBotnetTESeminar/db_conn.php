<?php
	$dbConn = new mysqli("localhost", "BotnetStatusFeed", "VESITDDoSBotnetProjTE12589", "ddos_bot_te_seminar", 3306);
	if($dbConn->errno>0)
		die("DB connection couldnt be made")
?>