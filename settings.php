<?php
    session_start();
    require 'db.php';

    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
        header ("location: login.php");
    }

    $query = "SELECT potka FROM users WHERE id='{$_SESSION['user_id']}'";
    $result = $mysqli->query($query) or trigger_error("ERROR:" . mysqli_error($mysqli), E_USER_ERROR);
    $user = $result->fetch_assoc();

    if(isset($_POST['submit_image'])) {
        // do your shit
        $currentDir = getcwd();
        $uploadDirectory = "/Images/";
        $errors = [];
        $fileExtensions = ['jpeg','jpg','png', 'gif'];

        $fileName = $_FILES['profile_pic_file']['name'];
        $fileSize = $_FILES['profile_pic_file']['size'];
        $fileTempName = $_FILES['profile_pic_file']['tmp_name'];
        $fileType = $_FILES['profile_pic_file']['type'];
        $fileExtension = substr($fileName, strrpos($fileName, '.') + 1);


        $potHash = bin2hex(random_bytes(5));

        $uploadPath = $currentDir . $uploadDirectory . basename($fileName);

        if(!in_array($fileExtension, $fileExtensions)) {
            $errors[] = "Invalid picture format, please use only .jpeg, .jpg, or .png formats.";
        }

        if($fileSize > 2000000) {
            $errors[] = "File exceeds the maximum size limit of 2MB";
        }
        else {
            $didUpload = move_uploaded_file($fileTempName, $uploadPath);
            if ($didUpload) {
                rename('Images/' . basename($fileName), 'Images/' . $potHash . "." . $fileExtension);
                $potDoSlike = $potHash . "." . $fileExtension;
                $sql = "UPDATE users SET potka='$potDoSlike' WHERE id='{$_SESSION['user_id']}'";
                if($mysqli->query($sql)) {
                    header("location: profile.php?username=" . $_SESSION['username']);
                }
                else {
                    $errors[] = "Couldn't execute the query.";
                    trigger_error("ERROR." . mysqli_error($mysqli), E_USER_ERROR);
                }
            }
            else{
                $errors[] = "Oops! Something went wrong!";
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
    <link rel="stylesheet" type="text/css" href="css/upload.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <title>Settings</title>
    <style>
    .settings{
        width: 80%;
        padding: 20px;
        margin: auto;
    }

    .profile-pic {
        padding: 20px;
        border-bottom: 2px solid #000;
    }

    .profile-pic img{
        margin: 20px;
    }
    </style>
</head>
<body>
    
    <?php require 'navbar.php'; ?>

    <div class="settings">

        <div>
            <h3>Change your email:</h3>

            <form action="reset_email.php" method="POST">
            <div>
            <p>New email:</p>
            <input class="inpt" type="email" name="new_email">
            </div>
            <input class="button" type="submit" name="submit" value="Change email">
        </form>
        <div>
            <?php

                if(isset($_GET['success'])){

                    if($_GET['success'] == 1){
                        echo "<p>You have successfully changed your email!</p>";
                    }
    
                    else if($_GET['success'] == 0){
                        echo "<p>Oops! Something went wrong!</p>";
                    }
                }
        
            ?>
        </div>
        <hr>

        </div>
        <div>
            <h3>Change your password:</h3>
            
            <form action="reset_password.php" method="POST">
                <div>
                    <p>Previous password:</p>
                    <input class="inpt" type="password" name="old_password">
                </div>
                <div>
                    <p>New password:</p>
                    <input class="inpt" type="password" name="new_password">
                </div>
                    <input class="button" type="submit" name="submit" value="Change password">
            </form>
        <div>
        <hr>
    <?php
        if(isset($_GET['success'])){

            if($_GET['success2'] == 1){
                echo "<p>You have successfully changed your password!</p>";
            }

            else if($_GET['success2'] == 0){
                echo "<p>Oops! Something went wrong!</p>";
            }
        }
    ?>



        </div>
            <h3>Change your profile picture:</h3>

            <?php if(!empty($errors))
                {
                    foreach ($errors as $error) {
                        echo "<p class='error'>" . $error . "</p>";
                    }
                }
            ?>
            <div class="profile-pic">

                <img src="Images/<?php echo $user['potka'] ?>" alt="profile_picture" width="150px" height="150px">
                <form method="POST" enctype="multipart/form-data">
                    <input type="file" name="profile_pic_file">
                    <button type="submit" name="submit_image">Save image</button>
                </form>
            </div>


    </div>
</body>
</html>