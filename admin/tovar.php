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
$_SESSION['urlpage'] = "<a href='index.php' >Главная</a> \ <a href='tovar.php' >Товары</a>";

include("include/db_connect.php");

$cat = $_GET['cat'];
// $type = $_GET['type'];

if (isset($cat))
{
	switch ($cat) {
		case 'all':
		$cat_name = 'Все товары';
		$url = "cat=all&";
		$cat = "";
		
		break;
		
		case 'Питание':
		$cat_name = 'Питание';
		$url = "cat=prod&";
		$cat = "WHERE kategory='Питание'";
		
		break;
		
		case 'Игрушки':
		$cat_name = 'Игрушки';
		$url = "cat=game&";
		$cat = "WHERE kategory='Игрушки'";
		
		break;
	}


}

$action = $_GET["action"];

if (isset($action))
{
	$id = (int)$_GET["id"];
	switch ($action) {
		
		case 'delete':
			
			$delete = mysql_query("DELETE FROM products WHERE Kod_tov = '$id'",$link);
			
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

    <link rel="stylesheet" href="css/style.css" type="text/css">

        <title>Панель Управления</title>
    </head>
    <body>
        <div id="block-body">
        <?php
            include("include/block-header.php");

			$all_count = mysql_query("SELECT * FROM products",$link);
			$all_count_result = mysql_num_rows($all_count);
        ?>
        <div id="block-content">
        	<div id="block-parameters">
        		<ul id="option-list">
        			<li><strong>Товары</strong></li>
        			<li><a id="select-links" href="#"><?php echo $cat_name ?></a>
        				<div id="list-links" >
        					<ul>
        						<li><a href="tovar.php?cat=all"><strong>Все товары</strong></a></li>
        						<li><a href="tovar.php?cat=Питание"><strong>Питание</strong></a></li>
        						<?php
        						$result1 = mysql_query("SELECT * FROM products WHERE kategory = 'Питание'",$link);
								 if(mysql_num_rows($result1) > 0)
								 {
								 	$row1 = mysql_fetch_array($result1);
									do
									{
										echo '<li><a href="tovar.php?type='.$row1["type"].'&cat='.$row1["kategory"].'"></a></li>';
										
									}while ($row1 = mysql_fetch_array($result1));
								 }
        						?>		
        						<li><a href="tovar.php?cat=Игрушки"><strong>Игрушки</strong></a></li>
        						<?php
        						$result1 = mysql_query("SELECT * FROM products WHERE kategory = 'Игрушки'",$link);
								 if(mysql_num_rows($result1) > 0)
								 {
								 	$row1 = mysql_fetch_array($result1);
									do
									{
										echo '<li><a href="tovar.php?type='.$row1["kategory"].'&cat='.$row1["kategory"].'"></a></li>';
										
									}while ($row1 = mysql_fetch_array($result1));
								 }
        						?>
        					</ul>
        				</div>
        			</li>        		        		
        		</ul>
        	</div>
        	<div id="block-info">
        	<p id="count-style">Всего товаров - <strong><?php echo $all_count_result ?></strong></p>
        	<p align="right" id="add-style"><a href="add_product.php">Добавить товар</a></p>
        	</div>
            <ul id="block-tovar">
        	
        	<?php
        	
        	$count = mysql_query("SELECT COUNT(*) FROM products $cat",$link);
			$temp = mysql_fetch_array($count);
			$post = $temp[0];
			
			if ($temp[0] > 0)
			{
				$result = mysql_query("SELECT * FROM products $cat ORDER BY Kod_tov DESC",$link);
				if (mysql_num_rows($result) > 0)
				{
					$row = mysql_fetch_array($result);
					do
					{
						if (strlen($row["image"]) > 0 && file_exists('../img/uploads-img/'.$row["image"]))
						{
							$img_path = '../img/uploads-img/'.$row["image"];
							list($width, $height) = getimagesize($img_path);
							$ratioh = $max_height/$height;
							$ratiow = $max_width/$width;
							$ratio = min ($ratioh, $ratiow);
							$width = intval($ratio*$width);
							$height = intval($ratio*$height);
						}
						
						echo '
						<li>
						<p class="mb-3">'.$row["nazv"].'</p>
						<center>
						<img src="'.$img_path.'" width="130px" height="130px">
						</center>
						<p align="center" class="link-action" >
						<a href="tovar.php?'.$url.'id='.$row["Kod_tov"].'&action=delete" class="delete">Удалить</a>
						</p>
						</li>												
						';
					} while ($row = mysql_fetch_array($result));
					echo'
					</ul>
					';
				}
			}
         ?>
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