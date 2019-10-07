<?php

    require 'db.php';

    session_start();

    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
        header ("location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Questrial|Rajdhani" rel="stylesheet">
    <link href="css/reset_pass.css" rel="stylesheet" type="text/css" media="screen">
    <title>Reset password</title>
</head>
<body>

    <?php require 'profile.php'?>                
    <br>

    <h1 class="naslov">Reset password</h1>

    <div class="vsebina">
    <form action="reset_password.php" method="POST">
        <div>
        <p>Previous password:</p>
        <input class="inpt" type="password" name="old_password">
        </div>
        <div>
        <p>New password:</p>
        <input class="inpt" type="password" name="new_password">
        </div>
        <input class="button" type="submit" name="submit" value="Change password">
    </form>
    <div>
    <?php
        if(isset($_GET['success'])){

            if($_GET['success'] == 1){
                echo "<p>You have successfully changed your password!</p>";
            }

            else if($_GET['success'] == 0){
                echo "<p>Oops! Something went wrong!</p>";
            }
        }
    ?>
    </div>
    </div>
</body>
</html>