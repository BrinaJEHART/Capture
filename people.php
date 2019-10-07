<?php

session_start();

require 'db.php';

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false){
    header ("location: login.php");
}

$result = $mysqli->query("SELECT * FROM users WHERE NOT id='{$_SESSION['user_id']}' ORDER BY RAND()");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/peple.css">
    <title>People</title>
</head>
<body>
    
    <?php require 'navbar.php' ?>

    <div class="people">
    <?php

    while($row=mysqli_fetch_assoc($result)){
        echo"
        <a href='profile.php?username=" . $row['username'] . "'>" .$row['username'] . "</a> <br>
        ";
    }
    ?>
    </div>
    
</body>
</html>