<?php

    session_start();
    require 'db.php';

    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false){
        header ("location: login.php");
    }

    $result = $mysqli->query("SELECT * FROM users WHERE NOT id='{$_SESSION['user_id']}' ORDER BY RAND() LIMIT 5 ");
    //$postsData = $mysqli->query("SELECT * FROM followers f INNER JOIN users u ON f.following_id = u.id INNER JOIN images i ON i.user_id = u.id WHERE f.user_id = '{$_SESSION['user_id']}'");
    $postsData = $mysqli->query("SELECT u.username, i.title, i.dsc, i.pathh, i.id AS imgId FROM followers f INNER JOIN users u ON f.following_id = u.id INNER JOIN images i ON i.user_id = u.id WHERE f.user_id = '{$_SESSION['user_id']}'");

    if(isset($_POST['submit'])){
        $komentar = $_POST['comment'];
        $comment = $mysqli->query("INSERT INTO comments (content, date, user_id, image_id) VALUES('$komentar', NOW(), '{$_SESSION['user_id']}', '{$_POST['imgId']}')");
        header("location: homepage.php");
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/main_css.css">
    <link rel="stylesheet" type="text/css" href="css/posts.css">
    <title>Capture</title>
</head>

<body>

    <!-- Navigation bar -->

    <?php require 'navbar.php' ?>

    <div class="kekec">
    <?php

    while($row=mysqli_fetch_assoc($result)){
        echo"
        <a href='profile.php?username=" . $row['username'] . "'>" .$row['username'] . "</a> <br>
        ";
    }
    ?>
    </div>
    <div class="posts">
    <?php
    while($row=mysqli_fetch_assoc($postsData)){
    echo "
    <div class='card'>
        <div class='card--media'>
            <img class='noselect' src='Images/" . $row['pathh'] ."' alt='post' draggable='false'>
        </div>
        <div class='card--primary'>
            <h2> " . $row['title'] . "</h2>
            <a href='profile.php?username=" . $row['username'] ."'>". $row['username'] ."</a>
        </div>
        <div class='card--supporting'>
            <p>". $row['dsc'] ."</p>
        </div>
        <div>

        <form action='homepage.php' method='POST' enctype='multipart/form-data'>
            <div>
                <textarea class='txtarea' name='comment' placeholder='e.g. Mijav' required></textarea>
                <input type='hidden' name='imgId' value='" .$row['imgId'] . "'>
            </div>
            <div>
                <button type='submit' name='submit'>Send</button>
            </div>
            <div>";
            
                $displayComm = $mysqli->query("SELECT c.id as cid, c.content, c.date, c.user_id as cuid, u.username FROM comments c INNER JOIN users u ON u.id=c.user_id INNER JOIN images i ON i.id=c.image_id WHERE i.id='{$row['imgId']}' ORDER BY c.date DESC");
                    while($row = $displayComm->fetch_assoc()){
                        echo "<div class='comments'>";
                        echo "<p> <span style='color:orange;font-size:1.1em'><b>" . $row['username'] . "</b></span>" . "&nbsp" . "<span style='color:black;font-size:0.8em;'>" . $row['date_time'] ."</span></p>";
                        echo $row['content'];
                        echo "<br><br>";
                        
                        echo "<div>";
                            if(isset($_SESSION['user_id']) && $row['cuid'] == $_SESSION['user_id'] || isset($_SESSION['admin']) && $_SESSION['admin']){
                            echo "<a class='izbrkom' href='delete.php?id=" . $row['cid'] . "'>Izbriši komentar</a>";
                            }
                        echo "</div>
                    </div>";
                    }

            echo "</div>
            
        </form>

        </div>
    </div>";
    }
    ?>
    </div>

</body>

</html>