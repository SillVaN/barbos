<?php
 session_start();
 define('barbos-shop', true);
 include("include/db_connect.php");
 
 
 if ($_POST["submit_enter"])
 {
 	
 	$login = $_POST["input_login"];
	$pass = $_POST["input_pass"];
	
	
	if ($login && $pass)
	{
		$result = mysql_query("SELECT * FROM reg_admin WHERE login = '$login' AND pass = '$pass'", $link);
		
		if (mysql_num_rows($result) > 0)
		{
			$row = mysql_fetch_array($result);
			
			$_SESSION['auth_admin'] = 'yes_auth';
			
			header("Location: index.php");
		}
		else
		{
			$msgerror = "Неверный Логин и(или) Пароль.";	
		}
	}
	else
	{
		$msgerror = "Заполните все поля!";	
	}
 }
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <link rel="stylesheet" href="css/style-login.css" type="text/css" />

    <title>Панель Управления - Вход</title>
</head>
<body>

<div id="block-pass-login">
<?php
     if ($msgerror)
	 {
	 	echo '<p id="msgerror" >'.$msgerror.'</p>';
	 }
?>
<form method="post" >
<ul id="pass-login">
<li><label>Логин</label><input type="text" name="input_login" /></li>
<li><label>Пароль</label><input type="password" name="input_pass" /></li>
</ul>
<p align="right"><input type="submit" name="submit_enter" id="submit_enter" value="Вход"/></p>
</form>
</div>

<script src="js/jquery-1.12.3.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>