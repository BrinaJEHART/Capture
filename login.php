<?php

    require 'db.php';

    session_start();

    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
        header("location: homepage.php");
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
  <link rel="stylesheet" type="text/css" href="css/login_register.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <meta name="google-signin-scope" content="profile email">
  <meta name="google-signin-client_id" content="904097946288-8gmthbicfnsm6q1p7384pgvflr75gabd.apps.googleusercontent.com">
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
    <div class="g-signin2" data-onsuccess="onSignIn"></div>
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
  <script>
    function onSignIn(googleUser) {
        var profile = googleUser.getBasicProfile();
        console.log(profile, "fdsfds");
        let data = {
            "id": profile['Eea'],
            "email": profile['U3'],
            "username": profile['ig'],
            "password": '/'
        };
        console.log(data);
        fetch(`googlelogin.php?id=${data.id}&email=${data.email}&username=${data.username}&password=${data.password}`)
        .then(res => res.json()).then(response => {
            window.location.href = `googleauth.php?username=${data.username}&google=${1}`;
        })
    }
</script>
  <footer>
    <img src="Images/logo2.png"></a>
    <p>©2019 Capture by JEHART</p>
  </footer>

</body>
</html>