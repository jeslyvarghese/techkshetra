<?php
	#this file retrieves event details
	
	include_once('../cult/phobia.php');
	include_once('connectTo.php');
	
	function getEventDetails($eventID)
		{    
			$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];
			$cxn = connect($dbname,$dbuname,$dbpwd);
			$sql = "SELECT * FROM eventbase WHERE EventID = '$eventID'";
			$resultset = mysqli_query($cxn,$sql);
			$resultarray = mysqli_fetch_assoc($resultset);
			endConnection($cxn);
			$EventDetails = array();
			$EventDetails['EventName'] = $resultarray['EventName'];
			$EventDetails['Participants'] = $resultarray['Participants'];
			return $EventDetails;
		}
	?>
