<?php
    require 'db.php';

    session_start();

    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
        header("location: index.php");
    }

    $errors = [];
    if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2'])){

        $username = $_POST['username'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $email = $_POST['email'];

        if(strlen($password) < 8){
            $errors[] = 'Password must be at least 8 characters long.';
        }
        else if($password != $password2){
            $errors[] = 'The passwords do not match.';
        }
        else if((strlen($username) < 4) || (strlen($username) > 16)){
            $errors[] = 'Username must be between 4 and 16 characters long.';
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "Invalid email format";
        }
        else{
            $username = $mysqli->escape_string(trim($_POST['username']));
            $email = $mysqli->escape_string(trim($_POST['email']));
            $password = $mysqli->escape_string(password_hash(trim($_POST['password']), PASSWORD_BCRYPT));

            $result = $mysqli->query("SELECT * FROM users WHERE username='$username'") or die($mysqli->error());

            $user = $result->fetch_assoc();

            if($result->num_rows > 0){
                $errors[] = "Account already exists!";
            }
            else{
                $sql = "INSERT INTO users (username, password, email, time_created)". " VALUES ('$username', '$password', '$email', NOW())";
                if($mysqli->query($sql)){
                    $successmsg = "Account created!";
                    header("Location: login.php");
                }
                else{
                    $errors[] = "Account creation failed!";
                }
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
    <link rel="stylesheet" type="text/css" href="login_register.css">
    <script src="loginjava.js"></script>
    <title>Register</title>
</head>

<body>

    <hgroup>
        <h1>Register to Capture</h1>
    </hgroup>
    <form method="POST" action="register.php" enctype="multipart/form-data">
        <div class="group">
            <input type="text" name="username" required><span class="highlight"></span><span class="bar"></span>
            <label>Username:</label>
        </div>
        <div class="group">
            <input type="email" name="email" required><span class="highlight"></span><span class="bar"></span>
            <label>Email:</label>
        </div>
        <div class="group">
            <input type="password" name="password" required><span class="highlight"></span><span class="bar"></span>
            <label>Password:</label>
        </div>
        <div class="group">
            <input type="password" name="password2" required><span class="highlight"></span><span class="bar"></span>
            <label>Confirm Password:</label>
        </div>
        <button type="submit" class="button buttonBlue">Register
            <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
        </button>
        <div>
            <a href="login.php" class="button buttonBlue">Login</a>
        </div>
        <div>
            <?php
                    if(!empty($errors)){
                        foreach($errors as $error){
                            echo "<p class='error' style='color: red;'>" . $error . "</p>";

                        }
                   }
                ?>           
            </div>
    </form>
    <footer>
        <img src="https://www.polymer-project.org/images/logos/p-logo.svg"></a>
        <p>©2019 Capture by JEHART</p>
    </footer>

</body>

</html>