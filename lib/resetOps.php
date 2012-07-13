<?php
	#Reset password operations happens here
	include_once('../cult/phobia.php');
	include_once('connectTo.php');
	include_once('userController.php');
	function resetEntry($mail)
		{		
				$dbname = $GLOBALS['dbname'];
				$dbuname = $GLOBALS['dbuname'];
				$dbpwd = $GLOBALS['dbpwd'];
				$tkID = gettkID($mail);
				$cxn = connect($dbname,$dbuname,$dbpwd);
				$time = time();
				$resetid = $tkID.(($tkID|$time)&rand(999,9999));
				$sql = "INSERT INTO resetpassword(tkID,Mail,ResetKey) VALUES ('$tkID','$mail','$resetid')";
				mysqli_query($cxn,$sql);
				endConnection($cxn);
				$jsonData['Mail'] = $mail;
				$jsonData['ResetID'] = $resetid;
				return json_encode($jsonData);
		}
	function resetValidate($jsonData)
		{	
			$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];
			$recievedData = json_decode($jsonData,true);
		    $cxn = connect($dbname,$dbuname,$dbpwd);
			$mail = $recievedData['Mail'];
			$sql = "SELECT ResetKey FROM resetpassword WHERE Mail = '$mail'";
			$resultset = mysqli_query($cxn,$sql);
			$resultarray = mysqli_fetch_assoc($resultset);
			endConnection($cxn);
			if($recievedData['ResetKey']==$resultarray['ResetKey'])
				{
					return 1;
				}
			else
				{
					return 0;
				}
		}
	function removeResetEntry($mail)
		{
			$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];
			$cxn = connect($dbname,$dbuname,$dbpwd);
			$sql = "DELETE FROM resetpassword WHERE Mail='$mail'";
			mysqli_query($cxn,$sql)or die(mysqli_error($cxn));
			endConnection($cxn);
		}
	function entryExist($mail)
		{
			
			$dbname = $GLOBALS['dbname'];
			$dbuname = $GLOBALS['dbuname'];
			$dbpwd = $GLOBALS['dbpwd'];		
			$cxn = connect($dbname,$dbuname,$dbpwd);
			$sql = "SELECT * FROM resetpassword WHERE Mail = '$mail'";
			$resultset = mysqli_query($cxn,$sql)or die(mysqli_error($cxn));
			
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
