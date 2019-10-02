<?php

    session_start();

    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false){
        header ("location: login.php");
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main_css.css">
    <title>Capture</title>
</head>

<body>

    <!-- Navigation bar -->

    <?php require 'navbar.php' ?>

</body>

</html>