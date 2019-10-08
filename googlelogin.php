<?php 
    require 'db.php';
    session_start();
    $result = ($mysqli->query("SELECT COUNT(*) as num FROM users WHERE google_id =".$_GET['id']))->fetch_assoc(); 
    $isAlready = true;
    if($result['num'] == 0) {
        $isAlready = false;
        $mysqli->query("INSERT INTO users (google_id, email, username, PASSWORD, time_created) values ('".$_GET['id']."', '".$_GET['email']."', '".$_GET['username']."', '".$_GET['password']."', NOW() )");
    }

    $arr = array('user_aready' => $isAlready ? true : false);

    echo json_encode($arr);
?>