<?php
    defined('barbos-shop') or die ('Доступ запрещен!');
?>

<div id="block-header">
	
<div id="block-header1" >
<h3>Панель Управления</h3>
<p id="link-nav" ><?php echo $_SESSION['urlpage']; ?></p>	
</div>	
	
<div id="block-header2" >
<p align="right"><a href="?logout">Выход</a></p>
</div>
	
</div>

<div id="left-nav">
<ul>
<li><a href="orders.php">Заказы</a><?php echo $count_str1; ?></li>
<li><a href="tovar.php">Товары</a></li>
<li><a href="Clients.php">Клиенты</a></li>
</ul>
</div>
