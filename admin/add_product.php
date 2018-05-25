<?php
session_start();

	define('barbos-shop', true);
       
       if (isset($_GET["logout"]))
    {
        unset($_SESSION['auth_admin']);
        header("Location: login.php");
    }

  $_SESSION['urlpage'] = "<a href='index.php' >Главная</a> \ <a href='tovar.php' >Товары</a> \ <a>Добавление товара</a>";

include("include/db_connect.php");

if ($_POST["submit_add"])
{
	$error = array();

	if (!$_POST["form_title"])
	{
		$error[] = "Укажите название товара";
	}
	if (!$_POST["form_price"])
	{
		$error[] = "Укажите цену";
	}
	if (!$_POST["form_kategory"])
	{
		$error[] = "Укажите категорию";
	}else
	{
		$result = mysql_query("SELECT * FROM products WHERE Kod_tov ='{$_POST["form_kategory"]}'",$link);
		$row = mysql_fetch_array($result);

	}
	
	if (!$_POST["chk_new"])
	{
	 $chk_new = "1";
	}else { $chk_new = "0"; }
	
	if (!$_POST["chk_leader"])
	{
	 $chk_leader = "1";
	}else { $chk_leader = "0"; }
	
	if (!$_POST["chk_sale"])
	{
	 $chk_sale = "1";
	}else { $chk_sale = "0"; }
	
	if(count($error))
	{
		$_SESSION['message'] = "<p id='form-error'>".implode('<br />',$error)."</p>";
	}else
       {
                           
              		mysql_query("INSERT INTO products(nazv,price,kategory,image,new,leader,sale)
						VALUES(						
                            '".$_POST["form_title"]."',
                            '".$_POST["form_price"]."',
                            '".$_POST["form_kategory"]."',
                            
                            '".$chk_new."',
                            '".$chk_leader."',
                            '".$chk_sale."',
                            '".$_POST["form_type"]."'
						)",$link);
                   
      $_SESSION['message'] = "<p id='form-success'>Товар успешно добавлен!</p>";
      header("Location: tovar.php");

      $id = mysql_insert_id();

       if (empty($_POST["img"]))
      {
      unset($_POST["img"]);
      }
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

    <link rel="stylesheet" href="css/style.css">

	<title>Панель Управления</title>
</head>
<body>
<div id="block-body">
<?php
	include("include/block-header.php");
?>
<div id="block-content">
<div id="block-parameters">
<p id="title-page" >Добавление товара</p>
</div>
<?php
if (isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';

		 if(isset($_SESSION['message']))
		{
		echo $_SESSION['message'];
		unset($_SESSION['message']);
		}
        
     if(isset($_SESSION['answer']))
		{
		echo $_SESSION['answer'];
		unset($_SESSION['answer']);
		} 
?>

<form enctype="multipart/form-data" method="post" class="form_style">
<ul id="edit-tovar">
<li>
<label>Название товара</label>
<input type="text" name="form_title" class="input_style">
</li>
<li>
<label>Цена</label>
<input type="text" name="form_price" class="input_style">
</li>
<li>
<label>Категория</label>
<select name="form_kategory" size="1" class="input_style">
<?php
$kategory = mysql_query("SELECT * FROM products",$link);
						
if (mysql_num_rows($kategory) > 0)
{
$result_kategory = mysql_fetch_array($kategory);
do
{
echo '
<option value="'.$result_kategory["kategory"].'">'.$result_kategory["kategory"].'</option>
';
}
while ($result_kategory = mysql_fetch_array($kategory));
}
?>

</select>

</ul> 
<label class="stylelabel" >Основная картинка</label>

<div id="baseimg-upload">
<input type="hidden" name="MAX_FILE_SIZE" value="50000000"/>
<input type="file" name="upload_image"/>

</div>
     
<h3 class="h3title">Настройки товара</h3>
<ul id="chkbox">
	<li><input type="checkbox" name="chk_new" id="chk_new" /><label for="chk_new" >Новый товар</label></li>
	<li><input type="checkbox" name="chk_leader" id="chk_leader" /><label for="chk_leader" >Популярный товар</label></li>
	<li><input type="checkbox" name="chk_sale" id="chk_sale" /><label for="chk_sale" >Товар со скидкой</label></li>
</ul>

   <p align="right" id="add-style"><input type="submit" id="submit_form" name="submit_add" value="Добавить товар"></p>
</form>

</div>
</div>
<script src="js/jquery-1.12.3.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
