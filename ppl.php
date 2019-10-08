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
    <title>Document</title>
</head>
<body>

    <?php while($row = mysqli_fetch_assoc($result))
        echo $row['username'];
    ?>

</body>
</html>