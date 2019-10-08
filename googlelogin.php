<?php 
    require 'db.php';

    session_start();

    $result = ($mysqli->query("SELECT COUNT(*) as num FROM users WHERE google_id = 50"))->fetch_assoc(); 
    $isAlready = TRUE;
    if($result['num'] == 0) {
        $isAlready = false;
        $mysqli->query("INSERT INTO users (google_id, email, username, password) values ('$_POST["id"]', '$_POST["email"]', '$_POST["username"]', '$_POST["password"]' )");
    }

    $arr = array('result' => $isAlready, 'id' => $_POST['id']);

    echo json_encode($arr);


?>