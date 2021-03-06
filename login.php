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
                    <div class="card card-body">
                        <h3 class="text-center mb-3">Надо..надо залогиниться..</h3>
                        <form>
                            <div class="form-group">
                                 <label for="auth_name">Имя</label>
                                 <input type="text" name="auth_name" class="form-control" id="auth_name" >
                            </div>
                            <div class="form-group">
                                 <label for="auth_password">Пароль</label>
                                 <input type="password" name="auth_password" class="form-control" id="auth_password" >
                            </div>
                            <button type="submit" class="btn btn-primary" id="auth_button" name="auth_button">Вход</button>
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