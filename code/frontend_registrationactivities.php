<?php
	#This file deals with the front end for all registration activities
	include_once('../lib/eventBase.php');
	include_once('../lib/teamEvents.php');
	include_once('../lib/singleEvents.php');
	
	function getRegistrationStatSingleEvent($jsonData)
		{
			$userArray = json_decode($jsonData,true);
			$tkID = $userArray['tkID'];
			$eventID = $userArray['EventID'];
			if(eventExist($tkID,$eventID)==1)
				{
					$userArray['Status']="REGISTERED";
				}
			else
				{
					$userArray['Status']="UNREGISTERED";
				}
			return json_encode($userArray);
		}
	function toggleEventStatusSingle($jsonData)
		{
			$userArray = json_decode(getRegistrationStatSingleEvent($jsonData),true);
			
			if($userArray['Status']=="REGISTERED")
				{
					
					removeEvent($userArray['tkID'],$userArray['EventID']);
					$userArray['Status'] = "UNREGISTERED";
				}
			else
				{
					addEvent($userArray['tkID'],$userArray['EventID']);
				}
			return getRegistrationStatSingleEvent($jsonData);
			
		}
	function getAllEvents($jsonData)
		{
			$userArray = json_decode($jsonData,true);
			$userArray['SingleEvents'] = listEvents($userArray['tkID']);
			$userArray['TeamEvents'] = listTeamEvents($userArray['tkID']);
			return json_encode($userArray);
		}
	function getRegistrationStatTeamEvent($jsonData)
		{
			$userArray = json_decode($jsonData,true);
			$tkID = $userArray['tkID'];
			$eventID = $userArray['EventID'];
			if(teamEventExist($tkID,$eventID)==1)
				{
					$userArray['Status']="REGISTERED";
				}
			else
				{
					$userArray['Status']="UNREGISTERED";
				}
			return json_encode($userArray);
		}
			
	function toggleEventStatusTeam($jsonData)
	
		{
			$userArray = json_decode(getRegistrationStatTeamEvent($jsonData),true);
			
			if($userArray['Status']=="REGISTERED")
				{
					removeTeamEvent($userArray['tkID'],$userArray['EventID']);
				}
			else
				{
					addTeamEvent($userArray['tkID'],$userArray['EventID'],$userArray['TeamID']);
				}
			return getRegistrationStatTeamEvent($jsonData);
			
		}
	
	function createTeam($jsonData)
		{
			$userArray = json_decode($jsonData,true);
			$tkID = $userArray['tkID'];
			$eventID = $userArray['EventID'];
			if(!teamEventExist($userArray['tkID'],$userArray['EventID']))
			{
				$teamID = generateTeamID($tkID,$eventID);
				if(addTeamEvent($tkID,$eventID,$teamID))
					{
						$userArray['TeamID'] = $teamID;
						$userArray['Report']="TEAM_CREATE_SUCCESS";
					}
				else
					{
						$userArray['Report']="TEAM_CREATE_FAIL";
					}
				return json_encode($userArray);
			}
			else
					{
						$userArray['Report']="TEAM_CREATE_FAIL";
					}
			return json_encode($userArray);
		}
	function getTeam($jsonData)
		{
			
			$userArray = json_decode($jsonData,true);
			$userArray['Team'] = listTeam($userArray['EventID'],$userArray['TeamID']);
			return json_encode($userArray);
		}
	
	?>			

