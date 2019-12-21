<?php
	
	if(isset($_SESSION["LoggedIN"]) && $_SESSION["LoggedIN"]==true)
	{
		if(isset($_SESSION["sessionExpirationTime"]))
			if($_SESSION["sessionExpirationTime"]<time())					//if current time elapsed beyond expiration Time then destroy session
			{
				session_unset();
				session_destroy();
			}else
				header("Location: DisplayStatusReports.php");
	}else
	{
		echo '<!DOCTYPE html>
		<html>
			<head>
			<title>Login</title>
			<meta http-equiv="cache-control" content="no-cache">
			<link rel="stylesheet" type="text/css" href="visualAuth/_style/patternlock.css"/>
		    <script src="visualAuth/_script/patternlock.js"></script>
			</head>
			<body>
				<br />
		        <br />
				<form name="LoginForm" method="post" onsubmit="return submitform()" action="LoginHandler.php">
		        <div>
		            <input type="password" id="patternLockCode" name="patternLockCode" class="patternlock" />
		            Password: <input type="password" name="pw" />
		        </div>
		        <br />
		        <br />
		        <input type="button" value="Take Control!" onclick="LoginForm.submit()" />
		    </form>
			</body>
		</html>';
	}
?>