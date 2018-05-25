<?php
    include ("include/db_connect.php");
    session_start();
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.css">

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="header">
    <div class="top-header">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-12">
                    <div class="logo">
                        <a href="index.php"><img src="img/brand-logo-barbos.png" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div id="block_form_registration" class="card card-body">
                        <h3 class="text-center">Регистрация</h3>
                        <form method="post" id="form_reg" name="signup-form" action="reg/handler_reg.php">
                            <div class="form-group">
                                <label>Имя</label>
                                <input type="text" name="name" class="form-control" id="name" >
                            </div>
                            <div class="form-group">
                                 <label>Телефон</label>
                                 <input type="text" name="phone" class="form-control" id="phone" >
                            </div>
                            <div class="form-group">
                                <label>Пароль</label>
                                <input type="password" name="password" class="form-control" id="password"" >
                            </div>

                            <button type="submit" id="reg_submit" class="btn btn-primary" name="reg_submit">Зарегиться!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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




