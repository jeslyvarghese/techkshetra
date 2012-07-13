<?php

#this file contains function necessary to operate on Team events
	
	include_once('../cult/phobia.php');
	include_once('connectTo.php');
	include_once('eventBase.php');
	
	function generateTeamID($tkID,$eventID)
		{
			$teamID = "TKT" .(time()%1000).rand(0,99);
			return $teamID;
		}
		
	function addTeamEvent($tkID,$eventID,$teamID)
		{
			$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];
			$cxn = connect($dbname,$dbuname,$dbpwd);
			$sql = "SELECT * FROM team_events WHERE Team_ID = '$teamID'";
			$resultset = mysqli_query($cxn,$sql)or die(mysqli_error($cxn));
			$EventDetails = getEventDetails($eventID);
			if(mysqli_num_rows($resultset)<$EventDetails['Participants']&&!teamEventExist($tkID,$teamID))
				{
					$sql = "INSERT INTO team_events(Event_ID,tK_ID,Team_ID) VALUES('$eventID','$tkID','$teamID')";
					mysqli_query($cxn,$sql) or die(mysqli_error($cxn));
					endConnection($cxn);
					return 1;
				}
			else
				{
					endConnection($cxn);
					return 0;
				}
			
		}
		
	function removeTeamEvent($tkID,$eventID)
		{
			$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];
			$cxn = connect($dbname,$dbuname,$dbpwd);
			$sql = "DELETE FROM team_events WHERE tk_ID='$tkID' AND Event_ID = '$eventID'";
			mysqli_query($cxn,$sql);
			endConnection($cxn);
		}
	function listTeamEvents($tkID)
		{
			$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];
			$cxn = connect($dbname,$dbuname,$dbpwd);
			$sql = "SELECT Event_ID FROM team_events WHERE tk_ID='$tkID'";
			$resultset = mysqli_query($cxn,$sql);
			$eventList = array();
			while($resultarray = mysqli_fetch_assoc($resultset))
				{
					$eventList[] = $resultarray['Event_ID'];
				}
			endConnection($cxn);
			return $eventList;
		}
	function listTeam($eventID,$teamID)
		{
			$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];
			$cxn = connect($dbname,$dbuname,$dbpwd);
			$sql = "SELECT tK_ID FROM team_events WHERE Event_ID='$eventID' AND Team_ID='$teamID'";
			$resultset = mysqli_query($cxn,$sql);
			$teamList = array();
			while($result = mysqli_fetch_assoc($resultset))
				{
					$teamList[] = $result['tK_ID'];
				}
			endConnection($cxn);
			return $teamList;
		}
	function teamEventExist($tkID,$eventID)
		{
			$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];
			$cxn = connect($dbname,$dbuname,$dbpwd);
			$sql = "SELECT * FROM team_events WHERE tk_ID='$tkID' AND Event_ID='$eventID'";
			$resultset = mysqli_query($cxn,$sql) or die(mysqli_error($cxn));
			endConnection($cxn);
			if(mysqli_num_rows($resultset)>0)
					{
						return 1;
					}
			else
				{
					return 0;
	
	                 }
                 }

?>