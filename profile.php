<?php
    session_start();
    require 'db.php';
    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
        header ("location: login.php");
    }
    if(isset($_SESSION['user_id']))
        $current_id = $_SESSION['user_id'];
        if(isset($_GET['username']) && $_GET['username'] != null || isset($_GET['username']) && $_GET['username'] != "") {
        $username = $mysqli->escape_string($_GET['username']);
        $data = $mysqli->query("SELECT * FROM users WHERE username='$username'");
        $profile = $data->fetch_assoc();

        $userFollows = ($mysqli->query("SELECT COUNT(*) as num FROM followers WHERE following_id = {$profile['id']}"))->fetch_assoc(); 
        $userFollowing = ($mysqli->query("SELECT COUNT(*) as num FROM followers WHERE user_id = {$profile['id']}"))->fetch_assoc(); 
    } else {
        header ("location: 404.html");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600&display=swap" rel="stylesheet">
    <title><?php echo $profile["username"] ?></title>
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
                        echo "<p class='pdata'>" . $profile['username'] . "</p>";
                        echo "<p class='pdata'>Followers: " . $userFollows['num'] . "</p>";
                        echo "<p class='pdata'>Following: " . $userFollowing['num'] . "</p>";
                    ?>
                </div>
        </div>
        <?php require 'profbar.php'?>

    </div>
</body>
</html>