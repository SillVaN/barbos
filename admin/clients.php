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

   $_SESSION['urlpage'] = "<a href='index.php' >Главная</a> \ <a href='clients.php' >Клиенты</a>";
  
include("include/db_connect.php");             
$id = $_GET["id"];
$action = $_GET["action"];
if (isset($action))
{
   switch ($action) {
        
        case 'delete':
      //if ($_SESSION['delete_clients'] == '1')
      //{

         $delete = mysql_query("DELETE FROM Clients WHERE kod_k = '$id'",$link);      
              
      //}//else
      //{
        // $msgerror = 'У вас нет прав на удаление клиентов!';
      //}
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
    <title>Барбоскины</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div id="block-body">
<?php
	include("include/block-header.php");
    $all_client = mysql_query("SELECT * FROM Clients",$link);
    $result_count = mysql_num_rows($all_client);
   
?>
<div id="block-content">
<div id="block-parameters">
<p id="count-client" >Клиенты - <strong><?php echo $result_count; ?></strong></p
</div>
<?php
if (isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';

//if ($_SESSION['view_clients'] == '1')
//{  

$count = mysql_query("SELECT COUNT(*) FROM Clients",$link);
$temp = mysql_fetch_array($count);
$post = $temp[0];
if ($temp[0] > 0)   
{ 
$result = mysql_query("SELECT * FROM Clients ORDER BY kod_k DESC",$link);
 
 If (mysql_num_rows($result) > 0)
{
$row = mysql_fetch_array($result);
do
{
 
 echo '
 <div class="block-clients">
 
 <ul>
 <li><strong>Имя</strong> - '.$row["name"].'</li>
 <li><strong>Телефон</strong> - '.$row["phone"].'</li>
 </ul>
 <p class="client-links" ><a class="delete" href="clients.php?id='.$row["kod_k"].'&action=delete" >Удалить</a></p>

 
 </div>
 ';   
    
} while ($row = mysql_fetch_array($result));
}   



}
    
//}//else
//{
 // echo '<p id="form-error" align="center">У вас нет прав на просмотр данной страницы!</p>';
//}
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