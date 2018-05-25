<?php
    include ("include/db_connect.php");
    session_start();

    $search = $_GET["q"];

    $sorting = $_GET["sort"];

    switch ($sorting)

    {
        case 'price-asc';
        $sorting = 'price ASC';
        break;

        case 'price-desc';
        $sorting = 'price DESC';
        break;

        default:
        $sorting = 'Kod_tov DESC';
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
    <title>Поиск - <?php echo $search; ?></title>

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
                                    <a class="nav-link" href="">Новинки</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="">Лидеры продаж</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="">Распродажа</a>
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
    <section class="slider">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="img/slider-img_1.jpg" alt="First slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="img/slider-img_2.jpg" alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="img/slider-img_3.jpg" alt="Third slide">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Наши товары</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9">
                    <div class="block-content">
                        <ul id="block-tovar-grid">

                            <?php

                               $result = mysql_query("SELECT * FROM products WHERE nazv LIKE '%$search%' ORDER BY $sorting",$link);

                               if (mysql_num_rows($result) > 0){
                                  $row = mysql_fetch_array($result);
                                  do
                                  {
                                  echo '

                                  <li>
                                    <div class="block-images-grid">
                                    <img src="img/uploads-img/'.$row["image"].'">
                                    </div>
                                    <p class="style-title-grid">'.$row["nazv"].'</p>
                                    <p class="style-discription-grid">
                                        <span class="mr-3"><i>размер:</i>'.$row["razm"].' см</span>
                                        <span><i>вес:</i>'.$row["ves"].' г</span>
                                    </p>
                                    <p class="style-discription-grid">
                                        <span class="mr-3"><i>материал:</i>'.$row["mtrl"].'</span>
                                        <span><i>состав:</i>'.$row["consist"].'</span>
                                    </p>
                                    <div class="price-and-basket">
                                        <a class="add-cart-style-grid" href="/" tid="'.$row["Kod_tov"].'"><i class="icon icon-basket"></i></a>
                                        <p class="style-price-grid"><span>'.$row["price"].'</span> грн</p>
                                    </div>
                                  </li>

                                  ';
                                  }
                                  while ($row = mysql_fetch_array($result));
                               }
                            ?>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="block-category">
                        <p>Категории товаров</p>
                        <ul>

                           <li>
                              <a href="view_cat-game.php">Игрушки</a>
                           </li>
                           <li>
                              <a href="view_cat-prod.php">Питание</a>
                           </li>
                        </ul>
                    </div>
                    <div class="block-parameter">
                         <p>Поиск по параметрам</p>
                         <ul class="block-parameter__item">
                            <li class="mb-2"><a href="search.php?sort=price-asc">От дешёвых к дорогим</a></li>
                            <li><a href="search.php?sort=price-desc">От дорогих к дешёвым</a></li>
                         </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="reclame-blocks">
            <div class="container">
                <h1>О нас</h1>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="reclame-blocks__item">
                            <img src="img/gena.jpg" alt="">
                            <span>Лучшие цены</span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="reclame-blocks__item">
                            <img src="img/mama.png" alt="">
                            <span>Квалифицированное обслуживание</span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="reclame-blocks__item">
                            <img src="img/druzhok.png" alt="">
                            <span>Доставка по всей Украине</span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="reclame-blocks__item">
                            <img src="img/liza.jpg" alt="">
                            <span>Более 120 000 товаров</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <section class="about-us">
        <div class="container">
            <div class="col-lg-12">
                <p>
                    Магазин детских товаров Барбоскины поможет обеспечить любимого малыша всем необходимым. Доверие и преданность многолетних клиентов позволяют смело заявлять о надежности, высоком качестве товаров, квалифицированном профессионализме и отличной работе команды магазина Барбоскины.<br>
                    Склад гипермаркета Барбоскины – поистине уникальное место! Поскольку тут собрано более 120 000 товаров! Такое огромное количество товара говорит о том, что большинство ассортимента, представленного на сайте, имеется в наличии. Это означает, что понравившийся Вам товар не придется долго ждать – его доставят Вам напрямую со склада в Харькове, а если Вы проживаете в Харькове либо Харьковской области, то наша собственная курьерская служба доставит заказанный товар прямо к Вам домой абсолютно бесплатно! Одной из главнейших задач компании является удовлетворение различных потребностей клиентов в поиске товаров и мебели для детей, поэтому нам так важно создать максимально удобные условия для приятных покупок в нашем интернет- магазине.<br>
                    Одним словом , мы предоставляем все, что сделает Вашего ребенка счастливым, а его детство ярким и безопасным. Всякий каприз любимого ребенка – наша забота!
                </p>
            </div>
        </div>
    </section>
    <section class="brands">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Бренды</h1>
                    <p>Мы работаем только с проверенными поставщиками детских товаров!</p>
                    <div class="d-flex justify-content-between">
                        <img src="img/logo-agusha.png" alt="">
                        <img src="img/chicco-logo.jpg" alt="">
                        <img src="img/dom-logo.png" alt="">
                        <img src="img/fruto-logo.jpg" alt="">
                        <img src="img/umka-logo.png" alt="">
                        <img src="img/bestscooter-logo.png" alt="">
                        <img src="img/LEGO_logo.svg.png" alt="">
                    </div>
                </div>
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