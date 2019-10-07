<?php

require 'db.php';

session_start();

$commentID = $mysqli->escape_string($_GET['id']);  
$result = $mysqli->query("SELECT * FROM comments WHERE id='$commentID'");
$comments = $result->fetch_assoc();

if((isset($_SESSION['user_id']) && $comments['user_id'] == $_SESSION['user_id']))
{
    $sql = "DELETE FROM comments WHERE id='$commentID'";
    if($mysqli->query($sql)){
        header ("location:homepage.php");
    }
    else{
        echo "Oops! Something went wrong.";
        header ("location:homepage.php");
    }
}
else{
    header ("location:homepage.php");
}

?>