<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="../scripts/jquery.js"></script>
<script type="text/javascript" src="../scripts/adaptor.js"></script>
<title>Untitled Document</title>
</head>

<body>
	<form name="login">
    	<input type="text" name="mail"/>
        <input type="password" name="oldpassword" />
        <input type="password" name = "newpassword">
        <input type="button"  value="go!"onclick="ChangePassword(document.login.mail.value,document.login.oldpassword.value,document.login.newpassword.value)"/>
    </form>
</body>
</html>
