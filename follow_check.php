<?php

    session_start();

    require 'db.php';

    if(isset($_GET['username']) && isset($_GET['followers'])) {
        $username = $mysqli->escape_string($_GET['username']);
        if($_GET['followers'] == 1) { // followers
            $result = $mysqli->query("SELECT u.username FROM users u INNER JOIN followers f ON f.user_id = u.id WHERE following_id = (SELECT id FROM users WHERE username='$username')"); 
        } else if($_GET['followers'] == 0) { // following
            $result = $mysqli->query("SELECT u.username FROM users u INNER JOIN followers f ON f.following_id = u.id WHERE f.user_id = (SELECT id FROM users WHERE username='$username')"); 
        }    
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/ppl.css">

    <title>Status</title>
</head>
<body>  

    <?php require 'navbar.php' ?>

    <div class="content1">
    <div class="content">
    <?php

if(isset($_GET['username']) && isset($_GET['followers'])) {
    $username = $mysqli->escape_string($_GET['username']);
    if($_GET['followers'] == 1) { // followers
        echo "<h1> Followers </h1>";
    } else if($_GET['followers'] == 0) { // following
        echo "<h1> Following </h1>";
    }    
}

    ?>

    

    <?php
    while($row=mysqli_fetch_assoc($result)){
        echo"
        <a href='profile.php?username=" . $row['username'] . "'>" .$row['username'] . "</a> <br>
        ";
    }
    ?>

        </div>
    </div>
</body>
</html>