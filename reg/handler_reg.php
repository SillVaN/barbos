<?php

    include("../include/db_connect.php");

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    mysql_query("INSERT INTO Clients (name, phone, password) VALUES ('".$name."', '".$phone."', '".$password."')",$link);

    header('Refresh: 1; URL=../welcome.html');
?>