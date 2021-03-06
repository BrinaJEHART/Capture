<?php
    session_start();
    require 'db.php';
    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
        header ("location: login.php");
    }
 
    if(isset($_SESSION['user_id']))
        $current_id = $_SESSION['user_id'];
        if(isset($_GET['username']) && $_GET['username'] != null || isset($_GET['username']) && $_GET['username'] != "") {
        $username = $mysqli->escape_string($_GET['username']);
        $data = $mysqli->query("SELECT * FROM users WHERE username='$username'");
        $profile = $data->fetch_assoc();

        if($profile['id'] == $_SESSION['user_id']) $me = true; 
        else $me = false;
        $follow = false;

        if(!$me)
        {
            $query = "SELECT * FROM followers WHERE following_id = (SELECT id FROM users WHERE username='".$_GET['username']."') AND user_id = ".$_SESSION['user_id']."";
            $stmt = $mysqli->query($query);
            if($stmt->num_rows == 1) $follow = true;
        }
        
        //Če kliknemo follow sledimo profilu na katerem smo
        if(isset($_POST['follow']))
        {
            $query = "INSERT INTO followers (following_id, user_id) VALUES ((SELECT id FROM users WHERE username='".$_GET['username']."'), ".$_SESSION['user_id'].")";
            $mysqli->query($query);
            header("location: profile.php?username=". $username);
        }
        //Če kliknemo follow ne sledimo več profilu na katerem smo
        if(isset($_POST['unfollow']))
        {
            $query = "DELETE FROM followers WHERE following_id = (SELECT id FROM users WHERE username='".$_GET['username']."') AND  user_id = ".$_SESSION['user_id'];
            $mysqli->query($query);
            header("location: profile.php?username=". $username);
        }   

        $content = ($mysqli->query("SELECT u.username, i.title, i.dsc, i.pathh, i.id AS imgId FROM users u INNER JOIN images i ON i.user_id=u.id WHERE u.username ='$username'"));

        $postsData = $mysqli->query("SELECT u.username, i.title, i.dsc, i.pathh, i.id AS imgId FROM followers f INNER JOIN users u ON f.following_id = u.id INNER JOIN images i ON i.user_id = u.id WHERE f.user_id = '{$_SESSION['user_id']}'");

        if(isset($_POST['submit'])){
            $komentar = $_POST['comment'];
            $comment = $mysqli->query("INSERT INTO comments (content, date, user_id, image_id) VALUES('$komentar', NOW(), '{$_SESSION['user_id']}', '{$_POST['imgId']}')");
            header("location: profile.php?username=". $username);
        }

        $userFollows = ($mysqli->query("SELECT COUNT(*) as num FROM followers WHERE following_id = {$profile['id']}"))->fetch_assoc(); 
        $userFollowing = ($mysqli->query("SELECT COUNT(*) as num FROM followers WHERE user_id = {$profile['id']}"))->fetch_assoc(); 

        } else {
            header ("location: 404.html");
        }

        

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <link rel="stylesheet" type="text/css" href="css/posts.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600&display=swap" rel="stylesheet">
    <title><?php echo $profile["username"] ?></title>
</head>
<body>
<?php require 'navbar.php' ?>
    <div class="stuff">
        
        <div class="cover">
                <div class="box picture">
                    <img src="Images/<?php echo $profile['potka'] ?>" alt="profile picture" width="150px" height="150px;">
                    <p>Edit</p>
                </div>
                <div class="data">
                    <?php
                        echo "<p class='pdata'>" . $profile['username'] . "</p>";
                        echo "<a class='pdata links' href='follow_check.php?username=" .$profile['username'] ."&followers=1'>Followers: " . $userFollows['num'] . "</a><br>";
                        echo "<a class='pdata links' href='follow_check.php?username=".$profile['username']."&followers=0'>Following: " . $userFollowing['num'] . "</a>";
                    ?>
                </div>
                <div>
                <?php
                if(!$me && $follow == false) echo "<form method='POST'><input name='follow' type='submit' value='Follow'></form>";
                else if(!$me && $follow == true) echo "<form method='POST'><input name='unfollow' type='submit' value='Unfollow'></form>";
                ?>
                </div>
        </div>
        <?php require 'profbar.php'?>

        <div>
    
    <div clas="content"> 

        <div class="posts">
    <?php
    while($row=mysqli_fetch_assoc($content)){
    echo "
    <div class='card'>
        <div class='card--media'>
            <img class='noselect' src='Images/" . $row['pathh'] ."' alt='post' draggable='false' width='960'>
        </div>
        <div class='card--primary'>
            <h2> " . $row['title'] . "</h2>
            <a class='usrname' href='profile.php?username=" . $row['username'] ."'>". $row['username'] ."</a>
        </div>
        <div class='card--supporting'>
            <p class='description'>". $row['dsc'] ."</p>
        </div>
        <div>

        <form action='profile.php?username=" . $row['username'] ."' method='POST' enctype='multipart/form-data'>
            <div>
                <textarea class='txtarea' name='comment' placeholder='e.g. Beautiful picture!' required></textarea>
                <input type='hidden' name='imgId' value='" .$row['imgId'] . "'>
            </div>
            <div>
                <button type='submit' name='submit'>Send</button>
            </div>
            <div>";
            
                $displayComm = $mysqli->query("SELECT c.id as cid, c.content, c.date, c.user_id as cuid, u.username FROM comments c INNER JOIN users u ON u.id=c.user_id INNER JOIN images i ON i.id=c.image_id WHERE i.id='{$row['imgId']}' ORDER BY c.date DESC");
                    while($row = $displayComm->fetch_assoc()){
                        echo "<div class='comments'>";
                        echo "<p> <span style='font-size:1.1em'><b>" . $row['username'] . "</b></span>" . "&nbsp" . "<span style='color:black;font-size:0.8em;'>" . $row['date'] ."</span></p>";
                        echo $row['content'];
                        echo "<br><br>";
                        
                        echo "<div>";
                            if(isset($_SESSION['user_id']) && $row['cuid'] == $_SESSION['user_id']){
                            echo "<a class='izbrkom' href='delete.php?id=" . $row['cid'] . "'>Delete Comment</a>";
                            }
                        echo "</div>
                    </div>";
                    }

            echo "</div>
            
        </form>

        </div>
    </div>";
    }
    ?>
    </div>
</div>

    </div>
</body>
</html>