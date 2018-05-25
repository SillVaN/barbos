<?php
session_start();
if ($_SESSION['auth_admin'] == "yes_auth")
{
    define('barbos-shop', true);
        
       if (isset($_GET["logout"]))
    {
        unset($_SESSION['auth_admin']);
        header("Location: login.php");
    }
 
  $_SESSION['urlpage'] = "<a href='index.php' >Главная</a> \ <a href='orders.php' >Заказы</a>";
   
  include("include/db_connect.php");
    
   $sort = $_GET["sort"];
   switch ($sort) {
 
        case 'all-orders':
 
        $sort = "order_id DESC";
        $sort_name = 'От А до Я';
 
        break;
 
        case 'confirmed':
 
        $sort = "order_confirmed = 'yes' DESC";
        $sort_name = 'Обработаные';
 
        break;
 
        case 'no-confirmed':
 
        $sort = "order_confirmed = 'no' DESC";
        $sort_name = 'Не обработаные';
 
        break;
         
        default:
         
        $sort = "order_id DESC";
        $sort_name = 'От А до Я';
         
        break;
    }    
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <script src="js/jquery-1.12.3.min.js"></script>
    <script src="js/script.js"></script>  
     
    <title>Панель Управления - Заказы</title>
</head>
<body>
<div id="block-body">
<?php
 include("include/block-header.php");
     
 $all_count = mysql_query("SELECT * FROM orders",$link);
 $all_count_result = mysql_num_rows($all_count);
 
 $buy_count = mysql_query("SELECT * FROM orders WHERE order_confirmed = 'yes'",$link);
 $buy_count_result = mysql_num_rows($buy_count);
 
 $no_buy_count = mysql_query("SELECT * FROM orders WHERE order_confirmed = 'no'",$link);
 $no_buy_count_result = mysql_num_rows($no_buy_count);
?>

<div id="block-content">
<div>
<ul id="review-info-count">
<li>Всего заказов - <strong><? echo $all_count_result; ?></strong></li>
<li>Обработаных - <strong><? echo $buy_count_result; ?></strong></li>
<li>Не обработаных - <strong><? echo $no_buy_count_result; ?></strong></li>
 
</ul>
</div>
<?php
    $result = mysql_query("SELECT * FROM orders ORDER BY $sort",$link);
  
 If (mysql_num_rows($result) > 0)
{
$row = mysql_fetch_array($result);
do
{
if ($row["order_confirmed"] == 'yes')
{
    $status = '<span class="green">Обработан</span>';
} else
{
    $status = '<span class="red">Не обработан</span>';    
}
   
 echo '
 <div class="block-order">
  <p class="order-datetime" >'.$row["order_datetime"].'</p>
  <p class="order-number" >Заказ № '.$row["order_id"].' - '.$status.'</p>
  <p class="order-link" ><a class="more_info" href="view_order.php?id='.$row["order_id"].'" >Подробнее</a></p>
 </div>
 ';   
     
} while ($row = mysql_fetch_array($result));
}
?>
</div>
</div>
</body>
</html>
<?php
}else
{
    header("Location: login.php");
}
?>