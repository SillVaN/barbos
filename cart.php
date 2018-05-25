<?php
    include ("include/db_connect.php");
    session_start();

    $id = $_GET["id"];
    $action = $_GET["action"];

    switch ($action) {

        case 'clear':
        $clear = mysql_query("DELETE FROM cart WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}'",$link);
        break;

        case 'delete':
        $delete = mysql_query("DELETE FROM cart WHERE cart_id = '$id' AND cart_ip = '{$_SERVER['REMOTE_ADDR']}'",$link);
        break;
    }

    if (isset($_POST["submitdata"]))
    {

$_SESSION["order_delivery"] = $_POST["order_delivery"];
$_SESSION["order_fio"] = $_POST["order_fio"];
$_SESSION["order_phone"] = $_POST["order_phone"];
$_SESSION["order_address"] = $_POST["order_address"];
$_SESSION["order_note"] = $_POST["order_note"];

    mysql_query("INSERT INTO orders(order_datetime,order_dostavka,order_fio,order_address,order_phone,order_note)
                        VALUES(
                             NOW(),
                            '".($_POST["order_delivery"])."',
                            '".($_POST["order_fio"])."',
                            '".($_POST["order_address"])."',
                            '".($_POST["order_phone"])."',
                            '".($_POST["order_note"])."'
                            )",$link);

$_SESSION["order_id"] = mysql_insert_id();
                            
$result = mysql_query("SELECT * FROM cart WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}'",$link);

if (mysql_num_rows($result) > 0)
{
$row = mysql_fetch_array($result);    

do{

    mysql_query("INSERT INTO buy_products(buy_id_order,buy_id_product,buy_count_product)
                        VALUES( 
                            '".$_SESSION["order_id"]."',                    
                            '".$row["cart_id_products"]."',
                            '".$row["cart_count"]."'                   
                            )",$link);



} while ($row = mysql_fetch_array($result));
}

header("Location: cart.php?action=completion");

}


// $result = mysql_query("SELECT * FROM cart,products WHERE cart.cart_ip = '{$_SERVER['REMOTE_ADDR']}' AND products.Kod_tov = cart.cart_id_product",$link);
// If (mysql_num_rows($result) > 0)
// {
// $row = mysql_fetch_array($result);

// do
// {
// $int = $int + ($row["price"] * $row["cart_count"]);
// }
//  while ($row = mysql_fetch_array($result));


//    $itogpricecart = $int;
// }
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Корзина заказов</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.css">

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="header">
    <div class="top-header">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-3">
                    <div class="logo">
                        <a href="index.php"><img src="img/brand-logo-barbos.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="email mb-3">
                        <i class="icon icon-mail"></i>
                        <span>info.barbos@gmail.com</span>
                    </div>
                    <div class="phone">
                        <i class="icon icon-phone"></i>
                        <span>(057)111-111-11</span>
                    </div>
                </div>
                <div class="col-lg-3">
                    <p>Время работы:</p>
                    <span class="d-block">пн-пт 09:00 - 21:00</span>
                    <span class="d-block">сб-вс 10:00 - 18:00</span>
                </div>
                <div class="col-lg-2">
                    <div class="mb-3">
                        <div class="social d-flex justify-content-between">
                            <a href="#"><i class="icon icon-facebook"></i></a>
                            <a href="#"><i class="icon icon-twitter"></i></a>
                            <a href="#"><i class="icon icon-telegram"></i></a>
                            <a href="#"><i class="icon icon-gplus"></i></a>
                        </div>
                    </div>

                    <?php

                    if ($_SESSION['auth'] == 'yes_auth') {
                        echo '
                        <div class="d-flex align-items-center">
                            <p class="user-name mr-5" id="auth-user-info" align="right">'.$_SESSION['auth_name'].'</p>
                            <a href="index.php" class="exit" id="exit-btn">Выход</a>
                        </div>
                        ';
                    }else{
                        echo '
                        <div class="registr">
                           <a href="login.php" class="mr-1 top-auth">Вход</a>
                           <a href="registration.php">Регистрация</a>
                        </div>
                        ';
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
    <div class="bottom-header">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-11">
                    <nav class="navbar navbar-expand-lg">

                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="index.php">Главная</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="view_aystopper.php?go=news">Новинки</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="view_aystopper.php?go=leaders">Лидеры продаж</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="view_aystopper.php?go=sale">Распродажа</a>
                                </li>
                            </ul>
                            <form method="GET" action="search.php?q=" class="form-inline my-2 my-lg-0">
                                <input id="input-search" class="form-control mr-sm-2" type="text" name="q" placeholder="Поиск по сайту" aria-label="Search">
                                <button type="submit" id="button-search"><i class="icon icon-search"></i></button>
                            </form>
                        </div>
                    </nav>
                </div>
                <div class="col-lg-1">
                    <div class="block-basket d-flex align-items-center">
                        <i class="icon icon-basket"></i>
                        <a href="cart.php?action=oneclick">Корзина</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<main class="main">
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Корзина заказов</h1>
                </div>
            </div>
            <div class="block-border">

                    <?php
                        $action = $_GET["action"];

                        switch ($action)

                        {
                            case 'oneclick':
                                echo '
                                <div id="block-step">
                                    <div id="name-step">
                                        <ul class="d-flex">
                                            <li><a href="cart.php?action=oneclick" class="active">1. Корзина товаров</a></li>
                                            <li><span>&rarr;</span></li>
                                            <li><a href="cart.php?action=confirm">2. Контактная информация</a></li>
                                            <li><span>&rarr;</span></li>
                                            <li><a href="cart.php?action=completion">3. Завершение</a></li>
                                        </ul>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                    <span class="arrow-cart">шаг 1 из 3</span>
                                    <a href="cart.php?action=clear" class="clear-cart-btn">Очистить</a>
                                    </div>
                                </div>
                                ';

                                $result = mysql_query ("SELECT * FROM cart,products WHERE cart.cart_ip = '{$_SERVER[REMOTE_ADDR]}' AND products.Kod_tov = cart.cart_id_products",$link);

                                if (mysql_num_rows($result) > 0) {

                                    $row = mysql_fetch_array($result);

                                    echo '
                                    <div class="header-list-cart d-flex justify-content-around">
                                       <div id="head1">Изображение</div>
                                       <div id="head1">Наименование товара</div>
                                       <div id="head1">Кол-во</div>
                                       <div id="head1">Цена</div>
                                    </div>
                                    ';

                                do
                                {
                                $int = $row["cart_price"] * $row["cart_count"];
                                $all_price = $all_price + $int;
                                $img_path = 'img/uploads-img/'.$row["image"];


                                 echo '
                                 <div class="block-list-cart d-flex justify-content-around">
                                    <div class="img-cart text-center">
                                        <img src="'.$img_path.'" width="100px" height="100px">
                                    </div>
                                    <div class="title-cart text-center">
                                        <p><a>'.$row["nazv"].'</a></p>
                                    </div>
                                    <div class="count-cart text-center">
                                        <ul class="input-count-style">
                                            <li class="count-minus" iid="'.$row["cart_id"].'">-</li>
                                            <li>
                                                <input id="input-id'.$row["cart_id"].'" iid="'.$row["cart_id"].'" class="count-input text-center" type="text" maxlength="3" value="'.$row["cart_count"].'">
                                            </li>
                                            <li class="count-plus" iid="'.$row["cart_id"].'">+</li>
                                        </ul>
                                    </div>
                                    <div id="tovar'.$row["cart_id"].'" class="price-product text-center"><h5><span class="span-count">'.$row["cart_count"].'</span> x <span>'.$row["cart_price"].'</span></h5><p price="'.$row["cart_price"].'">'.$int.' грн</p></div>
                                 </div>
                                 <div class="delete-cart"><a href="cart.php?id='.$row["cart_id"].'&action=delete">Удалить товар</a></div>
                                 ';
                                }
                                while ($row = mysql_fetch_array($result));

                                echo '
                                    <h3 class="itogo">Итого: <span class="itog_price">'.$all_price.'</span> грн</h3>
                                    <div class="next_cart_btn"><a href="cart.php?action=confirm" name="submitdata">Далее</a>                                ';
                                } else {
                                    echo '<h3>Корзина пуста</h3>';
                                }
                            break;

                            case 'confirm':
                                echo '
                                <div id="block-step">
                                    <div id="name-step">
                                        <ul class="d-flex">
                                            <li><a href="cart.php?action=oneclick">1. Корзина товаров</a></li>
                                            <li><span>&rarr;</span></li>
                                            <li><a href="cart.php?action=confirm" class="active">2. Контактная информация</a></li>
                                            <li><span>&rarr;</span></li>
                                            <li><a href="cart.php?action=completion">3. Завершение</a></li>
                                        </ul>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                    <span class="arrow-cart">шаг 2 из 3</span>
                                    </div>
                                </div>
                                ';

                                if($_SESSION['order_delivery'] == "По почте") $chck1 = "checked";
                                if($_SESSION['order_delivery'] == "Курьером") $chck2 = "checked";
                                if($_SESSION['order_delivery'] == "Самовывоз") $chck3 = "checked";

                                echo '

                                <h3 class="title-dostavka">Способы доставки:</h3>
                                <form method="post">
                                    <ul id="info-radio">
                                        <li>
                                            <input type="radio" name="order_delivery" class="order_delivery" id="order_delivery1" value="По почте" '.$chck1.'>
                                            <label class="order_delivery" for="order_delivery1">По почте</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="order_delivery" class="order_delivery" id="order_delivery2" value="Курьером" '.$chck2.'>
                                            <label class="order_delivery" for="order_delivery2">Курьером</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="order_delivery" class="order_delivery" id="order_delivery3" value="Самовывоз" '.$chck3.'>
                                            <label class="order_delivery" for="order_delivery3">Самовывоз</label>
                                        </li>
                                    </ul>
                                    <h3 class="title-dostavka">Информация для доставки:</h3>
                                    <ul id="info-order">
                                    ';

                                    if($_SESSION['auth'] == 'yes_auth') {
                                    echo '
                                        <li><label for="order_fio">ФИО</label><input type="text" id="order_fio" class="form-control mb-3" name="order_fio" value="'.$_SESSION['auth_name'].'"></li>
                                        <li><label for="order_phone">Телефон</label><input type="text" id="order_phone" class="form-control mb-3" name="order_phone" value="'.$_SESSION["order_phone"].'"></li>
                                        <li><label for="order_address">Адрес</label><input type="text" id="order_address" class="form-control mb-3" name="order_address" value="'.$_SESSION["order_address"].'"></li>
                                    ';
                                    } else {

                                    echo '
                                        <li><label for="order_fio"><span class="red"></span>ФИО</label><input type="text" id="order_fio" class="form-control mb-3" name="order_fio" value="'.$_SESSION["order_fio"].'"></li>
                                        <li><label for="order_phone"><span class="red"></span>Телефон</label><input type="text" id="order_phone" class="form-control mb-3" name="order_phone" placeholder="(+380) 11 111 11 11"></li>
                                        <li><label for="order_address">Адрес</label><input type="text" id="order_address" class="form-control mb-3" name="order_address" value="'.$_SESSION["order_address"].'"></li>
                                    ';
                                    }
                                     echo '
                                        <li><label for="order_note">Примечание:</label><textarea name="order_note" class="form-control mb-4" id="order_note" placeholder="Может у Вас есть какие-то пожелания? Мы с радостью реализуем их!">'.$_SESSION["order_note"].'</textarea></li>

                                        </ul>
                                        <div class="next_cart_btn"><input name="submitdata" type="submit" value="Далее"></div>
                                        </form>
                                     ';

                            break;

                            case 'completion':
                                echo '
                                <div id="block-step">
                                    <div id="name-step">
                                        <ul class="d-flex">
                                            <li><a href="cart.php?action=oneclick">1. Корзина товаров</a></li>
                                            <li><span>&rarr;</span></li>
                                            <li><a href="cart.php?action=confirm">2. Контактная информация</a></li>
                                            <li><span>&rarr;</span></li>
                                            <li><a href="cart.php?action=completion" class="active">3. Завершение</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                    <span class="arrow-cart">шаг 3 из 3</span>
                                    <span class="d-block mt-3">Ваш заказ отпрален. Проверьте, пожалуйста, правильность введенных Вами данных. В случае какой-либо ошибки Вы всегда сможете связаться с нашим менеджером по телефону (057)111-111-11. Приятных покупок и отличного настроения!!!</span>
                                    </div>
                                </div>

                                <div id="block-info-user">
                                    <p>Способ доставки: <span> '.$_SESSION["order_delivery"].'</span></p>
                                    <p>Ваше Имя: <span>'.$_SESSION["order_fio"].'</span></p>
                                    <p>Телефон: <span>'.$_SESSION["order_phone"].'</span></p>
                                    <p>Адрес: <span>'.$_SESSION["order_address"].'</span></p>
                                    <p>Примечание: <span>'.$_SESSION["order_note"].'</span></p>
                                </div>
                                ';
                            break;

                            default:
                                echo '
                                <div id="block-step">
                                    <div id="name-step">
                                        <ul class="d-flex">
                                            <li><a href="cart.php?action=oneclick" class="active">1. Корзина товаров</a></li>
                                            <li><span>&rarr;</span></li>
                                            <li><a href="cart.php?action=confirm">2. Контактная информация</a></li>
                                            <li><span>&rarr;</span></li>
                                            <li><a href="cart.php?action=completion">3. Завершение</a></li>
                                        </ul>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                    <span class="arrow-cart">шаг 1 из 3</span>
                                    <a href="cart.php?action=clear" class="clear-cart-btn">Очистить</a>
                                    </div>
                                </div>
                                ';

                                $result = mysql_query ("SELECT * FROM cart,products WHERE cart.cart_ip = '{$_SERVER[REMOTE_ADDR]}' AND products.Kod_tov = cart.cart_id_products",$link);

                                if (mysql_num_rows($result) > 0) {

                                    $row = mysql_fetch_array($result);

                                    echo '
                                    <div class="header-list-cart d-flex justify-content-around">
                                       <div id="head1">Изображение</div>
                                       <div id="head1">Наименование товара</div>
                                       <div id="head1">Кол-во</div>
                                       <div id="head1">Цена</div>
                                    </div>
                                    ';

                                do
                                {
                                $int = $row["cart_price"] * $row["cart_count"];
                                $all_price = $all_price + $int;
                                $img_path = 'img/uploads-img/'.$row["image"];


                                 echo '
                                 <div class="block-list-cart d-flex justify-content-around">
                                    <div class="img-cart text-center">
                                        <img src="'.$img_path.'" width="100px" height="100px">
                                    </div>
                                    <div class="title-cart text-center">
                                        <p><a>'.$row["nazv"].'</a></p>
                                    </div>
                                    <div class="count-cart text-center">
                                    <ul class="input-count-style">
                                        <li class="count-minus" iid="'.$row["cart_id"].'">-</li>
                                        <li>
                                           <input id="input-id'.$row["cart_id"].'" iid="'.$row["cart_id"].'" class="count-input text-center" type="text" maxlength="3" value="'.$row["cart_count"].'">
                                        </li>
                                        <li class="count-plus" iid="'.$row["cart_id"].'">+</li>
                                    </ul>
                                    </div>
                                    <div id="tovar'.$row["cart_id"].'" class="price-product text-center"><h5><span class="span-count">'.$row["cart_count"].'</span> x <span>'.$row["cart_price"].'</span></h5><p price="'.$row["cart_price"].'">'.$int.'</p> грн</div>
                                 </div>
                                 <div class="delete-cart"><a href="cart.php?id='.$row["cart_id"].'&action=delete">Удалить товар</a></div>
                                 ';
                                }
                                while ($row = mysql_fetch_array($result));

                                echo '
                                    <h3 class="itogo">Итого: <span class="itog_price">'.$all_price.'</span> грн</h3>
                                    <div class="next_cart_btn"><a href="cart.php?action=confirm" name="submitdata">Далее</a>                                ';
                                } else {
                                    echo '<h3>Корзина пуста</h3>';
                                }
                            break;
                        }
                    ?>
            </div>
        </div>
    </section>
</main>

<footer class="footer"></footer>

<!-- jQuery -->
<script src="js/jquery-1.12.3.min.js"></script>
<script src="js/jquery.validate.js"></script>
<script src="js/jquery.form.js"></script>

<!-- Bootstrap -->
<script src="js/bootstrap.min.js"></script>

<script src="js/shop-script.js"></script>
<script src="js/validate.js"></script>

</body>
</html>