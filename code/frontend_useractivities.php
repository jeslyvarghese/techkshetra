<?php

	#FrontEnd 
	include_once('../lib/resetOps.php');
	include_once("../lib/eventBase.php");
	include_once('../lib/userController.php');
	function RegisterUser($jsonData)
		{
			$userArray = json_decode($jsonData,true);
			$userArray['FirstName'] = preg_replace("[^A-Za-z]","",$userArray['FirstName']);
			$userArray['LastName'] = preg_replace("[^A-Za-z]","",$userArray['LastName']);
			$userArray['College'] =  preg_replace("[^A-Za-z0-9]","",$userArray['College']);
			$userArray['Phone'] =  preg_replace("[^0-9]","",$userArray['Phone']);
			$userArray['Mail'] = filter_var($userArray['Mail'],FILTER_SANITIZE_EMAIL);
			if(!mailExist($userArray['Mail']))
				{
					addUser($userArray['Mail'],$userArray['FirstName'],$userArray['LastName'],$userArray['Phone'],$userArray['College']);
					resetPassword($userArray['Mail']);
					$jsonData = resetEntry($userArray['Mail']);
					$jsonData = json_decode($jsonData,true);
					$to= $userArray['Mail'];
					$from = "From:registration@techkshetra.com";
					$subject = "Reset Password URL";
					$link = "localhost/reg/inferno.php?action=resetpage&Mail=".$userArray['Mail']."&ResetKey=".$jsonData['ResetID'];
					$message = "Hi,<br/>This mail contains the activation URL for your techKshetra 2011 registration<br/>Kindly click on to activate your techKshetra 2011 account<br/>".$link."<p>Regards,</p><p>Registration Desk</p><p>techKshetra 2011</p>";
					mail($to,$subject,$message,$from);
					echo $link;
					#write the mailto function here along with the url construction;
					return 1;
				}
			else
				{
					return 0;
				}
		}
	function LoginUser($jsonData)
		{
			$userArray = json_decode($jsonData,true);
			$userArray['Mail'] = filter_var($userArray['Mail'],FILTER_SANITIZE_EMAIL);
			$userDetails = array();
			if(mailExist($userArray['Mail'])==1)
				{
					if(!entryExist($userArray['Mail']))
						{
							if(checkPassword($userArray['Mail'],$userArray['Password'])==1)
								{
									$userDetails['tkID'] = gettkID($userArray['Mail']);
									$userDetails['Report'] = 'SUCCESS';
							
								}
							else
								{
									$userDetails['Report'] = 'FAIL_PASSWORD';
								}
						}
				}
			else
				{
					$userDetails['Report'] = 'FAIL_MAIL';
				}
			$jsonOut =json_encode($userDetails);
			return $jsonOut;
		}
	function resetPasswordFrontend($jsonData)
		{
			$userArray = json_decode($jsonData,true);
			$userArray['Mail'] = filter_var($userArray['Mail'],FILTER_SANITIZE_EMAIL);
			if(mailExist($userArray['Mail'])==1)
				{
					if(entryExist($mail)==1)
						{
							removeResetEntry($mail);
						}
					resetPassword($userArray['Mail']);
					$jsonData = resetEntry($mail);
					$jsonData = json_decode($jsonData);
					$to=$mail;
					$from = "From:registration@techkshetra.com";
					$subject = "Reset Password URL";
					$link = "localhost/reg/inferno.php?action=resetpage&Mail=".$mail."&ResetKey=".$jsonData['ResetID'];
					$message = "Hi,<br/>This mail contains the Reset Password URL for your techKshetra 2011 registration<br/>Kindly click on th e link below to reset your password<br/>".$link."<p>Regards,</p><p>Registration Desk</p><p>techKshetra 2011</p>";
					mail($to,$subject,$message,$from);
					$jsonData['Report'] = 'PASSWORD_RESET_SUCCESS';
					return json_encode($jsonData);
				}
			else
				{
					$jsonData['Report'] = 'PASSWORD_RESET_FAIL';
					return json_encode($jsonData);
				}
		}
	function changeUserPassword($jsonData)
		{
			$userArray = json_decode($jsonData,true);
			$userArray['Mail'] = filter_var($userArray['Mail'],FILTER_SANITIZE_EMAIL);
			if(changePassword($userArray['Mail'],$userArray['OldPassword'],$userArray['NewPassword'])==1)
				{
					$userArray['Report']= "CHANGE_PASSWORD_SUCCESS";
				}
			else
				{
					$userArray['Report'] = "CHANGE_PASSWORD_FAIL";
				}
			return json_encode($userArray);
		}
	
	function forgotPasswordReset($jsonData)
		{
			$userArray = json_decode($jsonData,true);
			if(entryExist($userArray['Mail'])==1)
				{
					if(resetValidate($jsonData)==1)
						{
							removeResetEntry($userArray['Mail']);
							if(newPasswordUrl($userArray['Mail'],$userArray['Password']))
								{
									$userArray['Report'] = "RESET_PASSWORD_SUCCESS";
								}
							else
								{
									$userArray['Report'] = "RESET_PASSWORD_FAIL";
								}
						}
					else
						{
							$userArray['Report']= "RESET_PASSWORD_INVALID_KEY";
						}
				}
			else
				{
					$userArray['Report'] = "RESET_PASSWORD_INVALID_MAIL";
				}
			return json_encode($userArray);
		}
	function DetailUser($tkID)
		{
			return json_encode(getUserDetails($tkID));
		}
		
	function EventName($eventID)
		{
			$jsonData = getEventDetails($eventID);
			return $jsonData['EventName'];
		}
	
	?> 
