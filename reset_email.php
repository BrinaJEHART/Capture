<?php
    require 'db.php';
    session_start();
    $email = $mysqli->escape_string($_POST['new_email']);
    $userid = $_SESSION['user_id'];
    $result = $mysqli->query("SELECT id FROM users WHERE id='$userid'");
    $user = $result->fetch_assoc();
    if(isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $mysqli->query("UPDATE users SET email='$email' WHERE id='$userid'") or trigger_error("ERROR:" . mysqli_error($mysqli), E_USER_ERROR);
        header("location: settings.php?success=1");
    }
    else {
        header("location: settings.php?success=0");
    }
?>