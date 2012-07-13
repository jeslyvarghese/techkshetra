<?php
	include_once('../code/frontend_useractivities.php');
	
	if(isset($_GET['tkID']))
		{
			$tkID = $_GET['tkID'];
			$jsonData = json_decode(DetailUser($tkID),true);
			echo $jsonData['FirstName']." ".$jsonData['LastName'];
		}
	if(isset($_GET['EventID']))
		{
			$EventID = $_GET['EventID'];
			echo EventName($EventID);
		}
	?>