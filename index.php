<?php

  require 'db.php';

  session_start();

  if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
    header("location: homepage.php");
  }

  if(isset($_POST['btnn'])){
    header ("Location: login.php");
  }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/nek.css">
    <title>Capture</title>
</head>
<body>

<!-- Get started button dj nasredino pa logotip ma moto "Capture the moment"-->


<!-- <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="Images/3.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="Images/1.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="Images/5.jpg" class="d-block w-100" alt="...">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div> -->


<div class="bd-example background">
                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
                  </ol>
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <img src="Images/3.jpg" class="d-block w-100 slika"alt="cover">
                      <div class="carousel-caption d-none d-md-block">
                        <form method="POST" action="index.php">
                        <h1> Capture </h1>
                        <h2> The moment </h2>
                        <button type="submit" name="btnn" class="btn">Get Started</button>
                        </form>
                      </div>
                    </div>
                    <div class="carousel-item">
                      <img src="Images/1.jpg" class="d-block w-100" alt="cover">
                      <div class="carousel-caption d-none d-md-block">
                      <form method="POST" action="index.php">
                        <h1> Capture </h1>
                        <h2> The moment </h2>
                        <button type="submit" name="btnn" class="btn">Get Started</button>
                        </form>
                      </div>
                    </div>
                    <div class="carousel-item">
                      <img src="Images/5.jpg" class="d-block w-100" alt="cover">
                      <div class="carousel-caption d-none d-md-block">
                      <form method="POST" action="index.php">
                        <h1> Capture </h1>
                        <h2> The moment </h2>
                        <button type="submit" name="btnn" class="btn">Get Started</button>
                        </form>
                      </div>
                    </div>
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
              </div>
</body>
</html>