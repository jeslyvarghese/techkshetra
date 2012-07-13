<?php
	#This library establishes a connection to the database and returns the handler
	
	function connect($database,$username,$password)
		{
			$connection = mysqli_connect("localhost",$username,$password);
			selectDatabase($connection,$database);
			return $connection;
		}
	function selectDatabase($cxn,$dbname)
		{
			mysqli_select_db($cxn,$dbname);
		}
	function endConnection($cxn)
		{
			mysqli_close($cxn);
		}
		
?>

