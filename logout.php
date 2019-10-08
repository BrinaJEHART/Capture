<?php
    session_start();
    session_destroy();
    echo '<script>
        window.open("https://www.google.com/accounts/Logout", "_blank");
        window.location.href = "index.php";
    </script>';
    //header("Location: index.php");

?>