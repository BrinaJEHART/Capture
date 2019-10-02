<?php

    session_start();

    require 'db.php';

    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
        header ("location: login.php");
    }

    if(isset($_SESSION['user_id']))
    $id = $_SESSION['user_id'];

    $result = $mysqli->query("SELECT * FROM users");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600&display=swap" rel="stylesheet">
    <title>Profile</title>
</head>

<body>

    <div class="content">

        <?php require 'navbar.php' ?>

        <div class="cover">

                <div class="box picture">
                    <img src="Images/2.jpg" alt="profile picture" width="250px">
                    <p>Edit</p>
                </div>
                <div class="data">
                    <?php
                        echo "<p class='pdata'>" . $_SESSION['username'] . 
                        "<br> kao followers <br> kao following" .               
                        "</p>";
                    ?>
                </div>
        </div>

    </div>

</body>

</html>