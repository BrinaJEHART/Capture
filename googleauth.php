<?php 

    require 'db.php';

    session_start();
    if (isset($_GET['username']) && isset($_GET['google'])) {
        $username = $_GET['username'];
        $result = $mysqli->query("SELECT * FROM users WHERE username='$username'") or trigger_error("ERROR:". mysqli_error($mysqli), E_USER_ERROR);

        if($result->num_rows == 0){
            $usererror = "User doesn't exist!";
        }
        else{
            $user = $result->fetch_assoc();
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("location: index.php");
        }
    }
    header("location: index.php");
?> 