<?php

    session_start();

    require 'db.php';

    $result = $mysqli->query("SELECT * FROM images WHERE title LIKE '%$_GET["title"]%'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search</title>
</head>
<body>
    
<?php echo $result['title']; ?>
    
</body>
</html>