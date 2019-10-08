<?php
    session_start();
    require 'db.php';

    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
        header ("location: login.php");
    }

    // albums.php?uid=1&aid=1

    // comments so za vsak slučaj čeprav vem da veš te stvari sam včasih kljub temu mal narobe razmišljaš in pač ja, ne zamerit

    $display = 0; // idk make a default value probs ma smisel i'm tired so idk, just go with the flow

    if(isset($_POST['album_create'])) { // button z name="album_create"
		$title = $mysqli->escape_string($_POST['title']); // input z name="title"
		$description = $mysqli->escape_string($_POST['description']); // input z name="description"
		$sql = "INSERT INTO albums (user_id, title, description, time_created) VALUES('{$_SESSION['user_id']}', '$title', '$description', NOW())";
		if($mysqli->query($sql)) {
            // je dalo v bazo
            // nared neki tu če hočeš
        } else {
            // ni dalo v bazo
            // nared neki tu če hočeš
        }
    }

    if(isset($_GET['username']) && $_GET['username'] != null || isset($_GET['username']) && $_GET['username'] != "") {
        $username = $mysqli->escape_string($_GET['username']);
        if(isset($_GET['aid']) && $_GET['aid'] != null || isset($_GET['aid']) && $_GET['aid'] != "") { // ma nastavlen "aid"
            $display = 1; // 1 - album, 0 - albumi
            $album_id = $mysqli->escape_string($_GET['aid']);
            $userAlbums = $mysqli->query("SELECT * FROM albums a INNER JOIN users u ON a.user_id = u.id WHERE u.id = (SELECT id FROM users WHERE username='$username') AND a.id='$album_id'") or trigger_error("ERROR:" . mysqli_error($mysqli), E_USER_ERROR);
            if($userAlbums->num_rows > 0) { // če najde več kot 0 vrstic album pripada temu uporabniku, lahk bi dav == 1 sam če kaj crkne pa ga večkrat da v bazo je bolš da ga večkrat izpiše ko pa ničkrat i'd say
                $sql = "SELECT a.title, a.description, a.time_created, i.pathh FROM albums a INNER JOIN albums_images ai ON ai.album_id = a.id INNER JOIN images i ON ai.image_id = i.id WHERE a.id = '$album_id'";
                $albums = $mysqli->query($sql) or trigger_error("ERROR:" . mysqli_error($mysqli), E_USER_ERROR);
            } else { // album s tem IDjem ne pripada temu uporabniku, at least that's what i hope i made it do, to je biv cilj vsaj
                // misim da je to probably najbols solution 
                header("location: albums.php?username=".$username); // in te vrže v spodnji else
            }
        } else { //"aid" ni podan torej bo prikazalo vse albume od tega userja
            $display = 0;
            $sql = "SELECT a.id, a.title, a.description, a.time_created FROM albums a WHERE a.user_id = (SELECT id FROM users WHERE username='$username')";
            $albums = $mysqli->query($sql) or trigger_error("ERROR:" . mysqli_error($mysqli), E_USER_ERROR);
        }
    } else {
        header("location: homepage.php"); // pa ja naj gre na homepage če misli it na albums.php brez da bi povedo kirga userja hoče
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600&display=swap" rel="stylesheet">
    <title>Albums</title>
    <style>
    * {padding: 0; margin: 0; box-sizing: border-box;}
    .container {max-width: 960px; width: 100%; margin: 0 auto;}
    .album, .image {border: 1px solid #000; padding: 10px; margin: 10px;}
    </style>
</head>
<body>
    <?php require 'navbar.php' ?>

    <div class="container">
    <?php while($row = mysqli_fetch_assoc($albums)) {
        if($display == 0) {
            echo "<div class='album'>";
                echo "<p>" . $row['title'] . "</p>";
                echo "<p>" . $row['description'] . "</p>";
                echo "<p>" . $row['time_created'] . "</p>";
                echo "<a href='albums.php?username=" . $username . "&aid=" . $row['id'] . "'>LINK</a>";
            echo "</div>";
        } else if($display == 1) {
            echo "<div class='image'>";
                echo "<p>" . $row['title'] . "</p>";
                echo "<p>" . $row['title'] . "</p>";
                echo "<p>" . $row['description'] . "</p>";
                echo "<p>" . $row['time_created'] . "</p>";
                echo "<img src='Images/" . $row['pathh'] . "'/>";
            echo "</div>";
        }
    }?>
    </div>
</body>
</html>