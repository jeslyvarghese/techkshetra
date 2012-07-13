<?php
	#This file contains all actions necessary for the techKshetra Login and Registrations end_us
	session_start();
	include_once('../code/frontend_useractivities.php');
	include_once('../code/frontend_registrationactivities.php');
	include_once('../lib/sanitizer.php');
	$action = $_GET['action'];
	
	switch($action)
		{
			case "login":
				echo  Login();
				break;
			case "register":
				echo  UserRegistration();
				break;
			case "changepassword":
				echo  ChangPassword();
				break;
			case "reset":
				echo  RequestResetPassword();
				break;
			case "resetpage":
				echo  ResetPasswordLink();
				break;
			case "registration":
				echo  ToggleRegistration();
				break;
			case "events":
				echo  GetMyEvents();
				break;
			case "team":
				echo  GetMyTeam();
				break;
			case "create":
				echo  CreateTeamFrontend();
				break;
			case "detail":
				echo Detail();
				break;
			default:
				#error message	
		}
	
	function Login()
		{
		#Returns 1 on successful login
		#		 2 on wrong password
		#		 3 on wrong username 
		$Mail = $_GET['Mail'];
		$Password = $_GET['Password'];
		
		if(isset($Mail)&&isset($Password))
			{
				$jsonData['Mail'] =  sanitizeMail($Mail);
				$jsonData['Password'] = $Password;
				$jsonData = json_decode(LoginUser(json_encode($jsonData)),true);
				if($jsonData['Report']=="SUCCESS")
					{
						$_SESSION['tkID'] = $jsonData['tkID'];
						return 1;
					}
				else
					{
						if($jsonData['Report']=="FAIL_PASSWORD")
							return 2;
						else
							return 3;
					}
				}
		}
	function UserRegistration()
		{
			#Returns 1 on Suceess
			#Return 0 coz already have email in database
			$jsonData['Mail'] = $_GET['Mail'];
			$jsonData['FirstName'] = $_GET['FirstName'];
			$jsonData['LastName'] = $_GET['LastName'];
			$jsonData['College'] = $_GET['College'];
			$jsonData['Phone'] = $_GET['Phone'];
			$jsonData = json_encode($jsonData);
			if(RegisterUser($jsonData))
				{
					return 1;
				}
			else
				{
					return 0;
				}
		}
	function ChangPassword()
		{	#return 0 on Fail
			#return 1 on Success
			$jsonData['Mail'] = sanitizeMail($_GET['Mail']);
			$jsonData['OldPassword'] = $_GET['OldPassword'];
			$jsonData['NewPassword'] = $_GET['NewPassword'];
			$jsonData = json_decode(changeUserPassword(json_encode($jsonData)),true);
			if($jsonData['Report']=="CHANGE_PASSWORD")
				{
					return 1;
				}
			else
				{
					return 0;
				}
		}
	function RequestResetPassword()
		{
			#return 0 On Fail
			#return 1 on Success
			$jsonData['Mail'] = sanitizeMail($_GET['Mail']);
			$jsonData = json_decode(resetPasswordFrontend(json_encode($jsonData)));
			if($jsonData['Report']=="PASSWORD_RESET_SUCCESS")
				{
					return 1;
				}
			else
				{
					return 0;
				}
		}
	function ResetPasswordLink()
		{
			#returns a message
			
			
			$jsonData['Mail']=sanitizeMail($_GET['Mail']);
			
			$jsonData['Key'] = sanitizeText($_GET['Key']);
			$jsonData['Password']= $_GET['Password'];
			$jsonData['ResetKey']= sanitizeText($_GET['Key']);
			$jsonData = json_decode(forgotPasswordReset(json_encode($jsonData)),true);
			if($jsonData['Report']=="RESET_PASSWORD_SUCCESS")
				{
					return "Password Changed Successfully!";
				}
			else if($jsonData['Report']=="RESET_PASSWORD_FAIL")
				{
					return "Password Reset Failed";
				}
			else if($jsonData["Report"]=="RESET_PASSWORD_INVALID_KEY")
				{
					return "Expired or Invalid Reset URL";
				}
			else if($jsonData["Report"]=="RESET_PASSWORD_INVALID_MAIL")
				{
					return "Invalide Mail ID Found!";
				}
		}
	
	function ToggleRegistration()
			{
				$jsonData['tkID'] = $_SESSION['tkID'];
				$jsonData['EventID'] = sanitizeText($_GET['EventID']);
				if($_GET['EventType']=="SINGLE")
					{
						$jsonData = json_decode(toggleEventStatusSingle(json_encode($jsonData)),true);
					}
				else
					{
						$jsonData['TeamID'] = sanitizeText($_GET['TeamID']);
						$jsonData = json_decode(toggleEventStatusTeam(json_encode($jsonData)),true);
					}
				
				if($jsonData['Status']=="REGISTERED")
					{
						
						return "Participating";
					}
				else
					{
						return "Participate";
					}
			}
		function GetMyEvents()
			{	#return jSON
				$jsonData['tkID'] = $_SESSION['tkID'];
				$jsonData = getAllEvents(json_encode($jsonData));
				return $jsonData;
			}
		function GetMyTeam()
			{
				#return jSON
				$jsonData['tkID'] = $_SESSION['tkID'];
				$jsonData['TeamID'] = sanitizeText($_GET['TeamID']);
				$jsonData['EventID'] = sanitizeText($_GET['EventID']);
				return getTeam(json_encode($jsonData));
			}
		function CreateTeamFrontend()
			{
				$jsonData['tkID'] = $_SESSION['tkID'];
				$jsonData['EventID'] = sanitizeText($_GET['EventID']);
				$jsonData = json_decode(createTeam(json_encode($jsonData)));
				if($jsonData['Report']=="TEAM_CREATE_SUCCESS")
					{
						return json_encode($jsonData);
					}
				else
					{
						return 0;
					}
			}
		function Detail()
			{
				$tkID = $_SESSION['tkID'];
				return DetailUser($tkID);
			}
	?>
	
