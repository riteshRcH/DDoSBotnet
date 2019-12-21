<?php
	function DispError()
	{
		echo "You arent authorized to view this page!";
	}
	
	if(isset($_REQUEST["patternLockCode"]) && isset($_REQUEST["pw"]))
	{
		if($_REQUEST["pw"]=="ScanonFarchad12593#!" && $_REQUEST["patternLockCode"]=="7584269586247")
		{
			session_start();
			$_SESSION["LoggedIN"] = true;
			$_SESSION["sessionExpirationTime"] = time()+240;		//set session expiration time by 4 mins
			header("Location: DisplayStatusReports.php");
		}else 
			DispError();
	}else
		DispError();
?>