<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<?php $mail = $_GET['Mail'];
	$resetkey = $_GET['ResetKey'];
	?>
   <form action="../frontend/inferno.php" name="forgot_password" method="get">
   <input type="hidden" name = "action" value="resetpage"/>
   <input type="hidden" name = "Mail" value=<?php echo $mail?> />
   <input type="hidden" name = "Key" value=<?php echo  $resetkey?> />
   <input type="text" name="Password" />
   <button type="submit"/>
   </form>	
<body>
</body>
</html>