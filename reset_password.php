<?php

    require 'db.php';
    session_start();

    if(isset($_SESSION['user_id']))
        $userid = $_SESSION['user_id'];
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];

    $result = $mysqli->query("SELECT * FROM users WHERE id='$userid'");
    $user = $result->fetch_assoc();

    if(strlen($newPassword) > 8 && isset($oldPassword) && isset($newPassword) && password_verify($oldPassword, $user['password'])){
        $password = $mysqli->escape_string(password_hash(trim($_POST['new_password']), PASSWORD_BCRYPT));
        $mysqli->query("UPDATE users SET password='$password' WHERE id='$userid'") or trigger_error("ERROR:" . mysqli_error($mysqli), E_USER_ERROR);
        header("location: reset_pass.php?success=1");
    }
    else{
        header("location: reset_pass.php?success=0");
    }

?>