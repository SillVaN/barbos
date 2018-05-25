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
 
  $_SESSION['urlpage'] = "<a href='index.php' >Главная</a> \ <a href='view_order.php' >Просмотр заказов</a>";
   
  include("include/db_connect.php");

  
  $id = $_GET["id"];
  $action = $_GET["action"];
   
  if (isset($action))
{
   switch ($action) {
 
        case 'accept':

        $update = mysql_query("UPDATE orders SET order_confirmed='yes' WHERE order_id = '$id'",$link);

        break;
         
        case 'delete':

        $delete = mysql_query("DELETE FROM orders WHERE order_id = '$id'",$link);
        header("Location: orders.php");
        break;
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
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <script src="js/jquery-1.12.3.min.js"></script>
    <script src="js/script.js"></script> 
     
    <title>Панель Управления - Просмотр заказов</title>
</head>
<body>
<div id="block-body">
<?php
    include("include/block-header.php");
?>

<div id="block-content">
<div id="block-parameters">
<p id="title-page" >Просмотр заказа</p>
</div>

<?php
if (isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';

$result = mysql_query("SELECT * FROM orders WHERE order_id = '$id'",$link);
  
if (mysql_num_rows($result) > 0)
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
  <p class="view-order-link" ><a class="green" href="view_order.php?id='.$row["order_id"].'&action=accept" >Подтвердить заказ</a>  |  <a class="red delete" href="view_order.php?id='.$row["order_id"].'&action=delete" >Удалить заказ</a></p>
  <p class="order-datetime" >'.$row["order_datetime"].'</p>
  <p class="order-number" >Заказ № '.$row["order_id"].' - '.$status.'</p>
 
<TABLE align="center" CELLPADDING="10" WIDTH="100%">
<TR>
<TH>№</TH>
<TH>Наименование товара</TH>
<TH>Цена</TH>
<TH>Количество</TH>
</TR>
';
$query_product = mysql_query("SELECT * FROM buy_products,products WHERE buy_products.buy_id_order = '$id' AND products.Kod_tov = buy_products.buy_id_product",$link);
  
$result_query = mysql_fetch_array($query_product);
do
{
$price = $price + ($result_query["price"] * $result_query["buy_count_product"]);    
$index_count =  $index_count + 1; 
echo '
<TR>
<TD  align="CENTER" >'.$index_count.'</TD>
<TD  align="CENTER" >'.$result_query["nazv"].'</TD>
<TD  align="CENTER" >'.$result_query["price"].' руб</TD>
<TD  align="CENTER" >'.$result_query["buy_count_product"].'</TD>
</TR>
';
} while ($result_query = mysql_fetch_array($query_product));
 
 
if ($row["order_pay"] == "accepted")
{
    $statpay = '<span class="green">Оплачено</span>';
}else
{
    $statpay = '<span class="red">Не оплачено</span>';
}
 
echo '
</TABLE>
<ul id="info-order">
<li>Общая цена - <span>'.$price.'</span> руб</li>
<li>Способ доставки - <span>'.$row["order_dostavka"].'</span></li>
</ul>
 
<TABLE align="center" CELLPADDING="10" WIDTH="100%">
<TR>
<TH>ФИО</TH>
<TH>Адрес</TH>
<TH>Телефон</TH>
<TH>Примечание</TH>
</TR>
 
<TR>
<TD  align="CENTER" >'.$row["order_fio"].'</TD>
<TD  align="CENTER" >'.$row["order_address"].'</TD>
<TD  align="CENTER" >'.$row["order_phone"].'</TD>
<TD  align="CENTER" >'.$row["order_note"].'</TD>
</TR>
</TABLE>
 
 ';   
     
} while ($row = mysql_fetch_array($result));
}

} 
?>
</div>
</div>
</body>
</html>
