<?php
    session_start();
    require 'db.php';

    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
        header ("location: login.php");
    }

    $pageload = "SELECT * FROM images i WHERE i.user_id = '{$_SESSION['user_id']}' AND NOT EXISTS (SELECT ai.image_id FROM albums_images ai WHERE ai.image_id = i.id)"; // bog ve a to dela lol, kao da ti da vse slike ki še niso v kakem albumu idk lul
    $pics = $mysqli->query($pageload) or trigger_error("ERROR:" . mysqli_error($mysqli), E_USER_ERROR);

    $albumsql = "SELECT * FROM albums a INNER JOIN users u ON u.id = a.user_id WHERE u.id = '{$_SESSION['user_id']}'";
    $albums = $mysqli->query($albumsql);

    if(isset($_POST['submit'])) {
        if(isset($_POST['slike']) && !empty($_POST['slike'])) {
            foreach($_POST['slike'] as $slikca) {
                $sql = "INSERT INTO albums_images (image_id, album_id) VALUES('$slikca', '{$_POST['album_id']}')";
                $mysqli->query($sql);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600&display=swap" rel="stylesheet">
    <title>Albums - add image</title>
    <style>
    .slikca {
        border: 1px solid #000;
        margin: 10px;
    }
    </style>
</head>
<body>
    <?php require 'navbar.php' ?>
    <div class="container">
        <form method="post" enctype="multipart/form-data">
            <p>izberi album:</p>
            <select name="album_id">
                <?php while($album = mysqli_fetch_assoc($albums)) {
                    echo "<option value='" . $album['id'] . "'>" . $album['title'] . "</option>";
                }?>
            </select>
            <?php while($row = mysqli_fetch_assoc($pics)) {
                echo "<div class='slikca'>";
                    echo "<input type='checkbox' name='slike[]' value='" . $row['id'] . "'>";
                    echo "<img src='Images/" . $row['pathh'] . "'>";
                echo "</div>";
            }?>
            <button type="submit" name="submit">add to album</button>
        </form>
    </div>
</body>
</html>