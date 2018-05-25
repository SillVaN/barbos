<?php
session_start();
if ($_SESSION['auth_admin'] == 'yes_auth')
{
define('barbos-shop', true);

if (isset($_GET["logout"]))
{
	unset($_SESSION['auth_admin']);
	header("Location: login.php");
}
$_SESSION['urlpage'] = "<a href='index.php'>Главная</a>";

include("include/db_connect.php");
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="css/style.css" type="text/css" />

    <title>Панель Управления</title>
    </head>
    <body>
        <div id="block-body">
 <?php
 include("include/block-header.php");

 $query1 = mysql_query("SELECT * FROM orders",$link);
 $result1 = mysql_num_rows($query1);
 $query2 = mysql_query("SELECT * FROM products",$link);
 $result2 = mysql_num_rows($query2);    
 $query4 = mysql_query("SELECT * FROM Clients",$link);
 $result4 = mysql_num_rows($query4);
 ?>

        <div id="block-content">
        <div id="block-parameters">
        	<p id="title-page">Общая статистика</p>
        </div>
        <ul id="general-statistics">
<li><p>Всего заказов - <span><?php echo $result1; ?></span></p></li>
<li><p>Товаров - <span><?php echo $result2; ?></span></p></li>
<li><p>Клиенты - <span><?php echo $result4; ?></span></p></li>
</ul>
        <ul id="block-tovar">
        	
        </ul>
        </div>
        </div>

<script src="js/jquery-1.12.3.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
<?php
}else
{
	header("Location: login.php");
}
?>