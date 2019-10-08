


<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <?php if($me) :?>
    <a class="navbar-brand" href="settings.php">Settings</a>
  <?php endif ?>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="profile.php?username=<?php echo $username?>">Photos <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="#">Albums</a>
    </div>
  </div>
</nav>