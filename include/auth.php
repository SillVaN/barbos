<?php

    include("db_connect.php");
    session_start();

    $login = $_POST["login"];
    $pass = $_POST["pass"];

    $result = mysql_query("SELECT * FROM Clients WHERE name = '$login' AND password = '$pass'",$link);

    if (mysql_num_rows($result)>0) {

        $row = mysql_fetch_array($result);

        $_SESSION['auth'] = 'yes_auth';
        $_SESSION['auth_name'] = $row["name"];
        $_SESSION['auth_password'] = $row["password"];

        echo "yes_auth";

    } else {
        echo "no_auth";
    }
?>