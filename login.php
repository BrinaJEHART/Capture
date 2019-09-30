<?php

    require 'db.php';

    session_start();

    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
        header("location: index.php");
    }

    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $result = $mysqli->query("SELECT * FROM users WHERE username='$username'") or trigger_error("ERROR:". mysqli_error($mysqli), E_USER_ERROR);

        if($result->num_rows == 0){
            $usererror = "User doesn't exist!";
        }
        else{
            $user = $result->fetch_assoc();

            if(password_verify($_POST['password'], $user['password'])){
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("location: index.php");
            }
            else{
                $passerror = "Incorrect password!";
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
  <title>Login</title>
</head>
<body>
  
  <hgroup>
    <h1>Login to Capture</h1>
  </hgroup>
  <form method="POST" action="login.php" enctype="multipart/form-data">
    <div class="group">
      <input type="text" name="username"><span class="highlight" required></span><span class="bar"></span>
      <label>Username:</label>
    </div>
    <div class="group">
      <input type="password" name="password"><span class="highlight" required></span><span class="bar"></span>
      <label>Password:</label>
    </div>
    <button type="submit" class="button buttonBlue">Log in
      <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
    </button>
    <div>
      <a href="register.php" class="button buttonBlue">Register</a>
    </div>
    <div class="errormsg">
            <!-- Errors -->
            <?php if(!empty($usererror)){
                        echo "<p class='error'>" . $usererror . "</p>";
                }
            ?>
            <?php if(!empty($passerror)){
                        echo "<p class='error'>". $passerror. "</p>";
                }
            ?>
            <?php if(!empty($errors)){
                foreach ($errors as $error){
                        echo "<p class='error'>" . $error . "</p>";
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