<?php
    session_start();
    session_destroy();
    echo "<script>window.open('https://www.google.com/accounts/Logout')</script>";
    header("Location: index.php");

?>