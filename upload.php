<?php

    require 'db.php';

    session_start();

    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
        header ("location: login.php");
    }

    if(isset($_POST['submit'])){

        $title = $mysqli->escape_string(trim($_POST['title']));
        $desc = $mysqli->escape_string(trim($_POST['desc']));

        $currentDir = getcwd();
        $uploadDirectory = "/images/";
        $errors = [];
        $fileExtensions = ['jpeg','jpg','png'];

        $fileName = $_FILES['picfile']['name'];
        $fileSize = $_FILES['picfile']['size'];
        $fileTempName = $_FILES['picfile']['tmp_name'];
        $fileType = $_FILES['picfile']['type'];
        $fileExtension = substr($fileName, strrpos($fileName, '.')+1);

        $potHash = bin2hex(random_bytes(5));

        $uploadPath = $currentDir . $uploadDirectory . basename($fileName);

        if(!in_array($fileExtension, $fileExtensions)){
            $errors[] = "Invalid picture format, please use only .jpeg, .jpg, or .png formats.";
        }

        if($fileSize > 2000000){
            $errors[] = "File exceeds the maximum size limit of 2MB";
        }

        else{
            $didUpload = move_uploaded_file($fileTempName, $uploadPath);
            
            if ($didUpload){
                rename('images/' . basename($fileName), 'images/' . $potHash . "." . $fileExtension);
                $potDoSlike = $potHash . "." . $fileExtension;
                $sql = "INSERT INTO images (user_id, name, path)". "VALUES('{$_SESSION['user_id']}'), '$title', '$potDoSlike'";
                if($mysqli->query($sql)){
                    header("location: insert.php?success=1");
                }
                else{
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
    <title>Upload</title>
</head>

<body>

    <h1>Share your moment</h1>

    <!-- <form method="POST" action="upload.html">

        <input type="text" name="title" placeholder="title">


        <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
            </div>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="inputGroupFile01"
                aria-describedby="inputGroupFileAddon01">
              <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
            </div>
          </div>

    </form> -->

    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <div>
        <p class="contentp">Title:</p>
        <input class='inpt' type="text" name="title" placeholder="e.g. Sunset" required>
        </div>
        <div>
            <p class="contentp">Description:</p>
            <textarea class='txtarea' name="desc" placeholder="e.g. Sunset on hawaii beach" ></textarea><br>
        </div>
        <div>
            <input type="file" class="stranpejt" name="picfile" id="picfile" accept=".jpeg, .jpg, .png" required><br>
            <label class="upload-label" for="picfile">Add picture</label><br>
        </div>
        <div>
            <br>
            <button class="button" type="submit" name="submit">Post</button><br>
        </div>
        <div>
        <?php
                    if(!empty($errors)){
                        foreach($errors as $error){
                            echo "<p class='error' style='color: white;'>" . $error . "</p>";

                        }
                   }

                   if(isset($_GET['success'])){

                    if($_GET['success'] == 1){
                        echo "<p>You have successfully uploaded your receipt!</p>";
                    }
    
                    else if($_GET['success'] == 0){
                        echo "<p>Oops! Something went wrong!</p>";
                    }
                }
            ?>   
        </div>
    </form>

</body>

</html>