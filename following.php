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
    <title>Following</title>
</head>
<body>

    <div>

    </div>
    
</body>
</html>