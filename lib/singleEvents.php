<?php

#this file contains function necessary to operate on single events

	include_once('../cult/phobia.php');
	include_once('connectTo.php');
	
	function addEvent($tkID,$eventID)
		{
			$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];
			$cxn = connect($dbname,$dbuname,$dbpwd);
			$sql = "INSERT INTO events(Event_ID,tk_ID) VALUES('$eventID','$tkID')";
			mysqli_query($cxn,$sql)or die(mysqli_error($cxn));
			endConnection($cxn);
		}
	function removeEvent($tkID,$eventID)
		{	$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];
			$cxn = connect($dbname,$dbuname,$dbpwd);
			$sql = "DELETE FROM events WHERE tk_ID='$tkID' AND Event_ID = '$eventID'";
			mysqli_query($cxn,$sql);
			endConnection($cxn);
		}
	function listEvents($tkID)
		{	$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];
			$cxn = connect($dbname,$dbuname,$dbpwd);
			$sql = "SELECT Event_ID FROM events WHERE tk_ID='$tkID'";
			$resultset = mysqli_query($cxn,$sql);
			$eventList = array();
			while($resultarray = mysqli_fetch_assoc($resultset))
				{
					$eventList[] = $resultarray['Event_ID'];
				}
			endConnection($cxn);
			return $eventList;
			
		}
		
	function eventExist($tkID,$eventID)
		{
			$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];
			$cxn = connect($dbname,$dbuname,$dbpwd);
			$sql = "SELECT * FROM events WHERE tk_ID='$tkID' AND Event_ID='$eventID'";
			$resultset = mysqli_query($cxn,$sql);
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
