<?php
    header( 'Location: /index.php', true, 303 );
    header("Cache-Control : no-store, no-cache, must-revalidate, max-age=0");
    session_start();
    setcookie ("login", "", time()-14800);
    setcookie ("password", "", time()-14800);
    session_destroy();
    mysql_query
?>