<?php
	#this file contains operation performed on table userbase
	include_once('connectTo.php');
	include_once('../cult/phobia.php');
	function addUser($mail,$firstName,$lastName,$phone,$college)
		{
			$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];
			$cxn = connect($dbname,$dbuname,$dbpwd);
			$sql = "INSERT INTO userbase(Mail,FirstName,LastName,Password,Phone,College) VALUES('$mail','$firstName','$lastName','Semper Addictus','$phone','$college')";
			mysqli_query($cxn,$sql);
			$sql = "SELECT ID FROM userbase WHERE Mail='$mail'";
			$resultset = mysqli_query($cxn,$sql);
			$resultarray = mysqli_fetch_assoc($resultset);
			$id = $resultarray['ID'];
			$timestamp = time(); 
			$tkID = 'TK'.($timestamp).$id;
			$sql = 	"UPDATE userbase SET tK_ID = '$tkID' WHERE Mail = '$mail'";
			mysqli_query($cxn,$sql)or die("Error!".mysqli_error($cxn));
			$pwd = getCrypted('Semper Addictus',$mail);
			$sql = 	"UPDATE userbase SET Password = '$pwd' WHERE Mail = '$mail'";
			mysqli_query($cxn,$sql)or die("Error!".mysqli_error($cxn));
			endConnection($cxn);
		}
	
	function getCrypted($password,$Mail)
		{
			$tkID = gettkID($Mail);
			return crypt(crypt($password,$tkID),$tkID);
		}
	function changePassword($mail,$oldpassword,$newpassword)
		{	$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];
			$cxn = connect($dbname,$dbuname,$dbpwd);
			$sql = "SELECT Password FROM userbase WHERE Mail='$mail'";
			$resultset = mysqli_query($cxn,$sql) or die("Select error:".mysqli_error($cxn));
			$resultarray = mysqli_fetch_assoc($resultset);
			$oldOriginalPassword = $resultarray['Password'];
			if(getCrypted($oldpassword,$mail)==$oldOriginalPassword)
				{
					$newpassword = getCrypted($newpassword,$mail);
					$sql = "UPDATE userbase SET Password = '$newpassword'  WHERE Mail='$mail'";
					mysqli_query($cxn,$sql)or die("Update error:".mysqli_error($cxn));
					endConnection($cxn);
					return 1;
				}
			else
				{
					endConnection($cxn);
					return 0;
				}
		}
				
		
	
	function checkPassword($mail,$password)
		{	$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];
			$cxn = connect($dbname,$dbuname,$dbpwd);
			$sql = "SELECT Password FROM userbase WHERE Mail='$mail'";
			$resultset = mysqli_query($cxn,$sql);
			$resultarray = mysqli_fetch_assoc($resultset);
			$originalPassword = $resultarray['Password'];
			if(getCrypted($password,$mail)==$originalPassword)
				{
					endConnection($cxn);
					return 1;
				}
			else
				{
					endConnection($cxn);
					return 0;
				}
		}
	function gettkID($mail)
		{
			$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];
			$cxn = connect($dbname,$dbuname,$dbpwd);
			$sql = "SELECT tK_ID FROM userbase WHERE Mail='$mail'";
			$resultset = mysqli_query($cxn,$sql)or die(mysqli_error($cxn));
			$resultarray = mysqli_fetch_assoc($resultset);
			$tkID = $resultarray['tK_ID'];
			endConnection($cxn);
			return $tkID;
		}
	function mailExist($mail)
		{
			$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];
			$cxn = connect($dbname,$dbuname,$dbpwd);
			$sql = "SELECT Mail FROM userbase WHERE Mail='$mail'";
			$resultset = mysqli_query($cxn,$sql);
			if(mysqli_num_rows($resultset)>0)
				{
					endConnection($cxn);
					return 1;
				}
			else
				{
					endConnection($cxn);
					return 0;
				}
		}
	function resetPassword($mail)
		{
			$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];
			$cxn = connect($dbname,$dbuname,$dbpwd);
			$temp_pwd = getCrypted('Semper Addictus',$mail);
			$sql = "UPDATE userbase SET Password = '$temp_pwd' WHERE Mail='$mail'";
			$resultset = mysqli_query($cxn,$sql);
			endConnection($cxn);
		}
	
	function newPasswordUrl($mail,$newPassword)
		{	$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];
			$cxn = connect($dbname,$dbuname,$dbpwd);
			$sql = "SELECT Password FROM userbase WHERE Mail='$mail'";
			$resultset = mysqli_query($cxn,$sql);
			$resultarray = mysqli_fetch_assoc($resultset);
			$password = $resultarray['Password'];
			if($password == getCrypted('Semper Addictus',$mail))
				{
					if(changePassword($mail,'Semper Addictus',$newPassword))
						{
						endConnection($cxn);
						return 1;
						}
					else
						{
						endConnection($cxn);
						return 0;
						}
				}
			else
				{
					endConnection($cxn);
					return 0;
				}
		
		}
		
	function getUserDetails($tkID)
		{	$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];
			$cxn = connect($dbname,$dbuname,$dbpwd);
			$sql = "SELECT * FROM userbase WHERE tK_ID='$tkID'";
			$resultset = mysqli_query($cxn,$sql);
			if(mysqli_num_rows($resultset)>0)
				{
					$resultarray = mysqli_fetch_assoc($resultset);
					$userDetails = array();
					$userDetails['FirstName'] = $resultarray['FirstName'];
					$userDetails['LastName'] = $resultarray['LastName'];
					$userDetails['College'] = $resultarray['College'];
					$userDetails['Phone'] = $resultarray['Phone'];
					endConnection($cxn);
					return $userDetails;
				}
			else
				{
					return 0;
				}
		}
	
	
	
	?>
