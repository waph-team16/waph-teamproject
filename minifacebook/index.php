
<!-- Index.php^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->

<?php
    include 'header.php';
    // include 'classes/User.php';
    // include 'classes/Post.php';
    // include 'classes/Message.php';
$lifetime = 15 * 60;
$path = "/";
$domain = "localhost";
$secure = TRUE;
$httponly = TRUE;
session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
session_start();

if (isset($_POST["username"]) && isset($_POST["password"])) {
    if (checklogin_mysql($_POST["username"], $_POST["password"])) {
        $_SESSION['authenticated'] = TRUE;
        $_SESSION['username'] = $_POST["username"];
        $_SESSION['browser'] = $_SERVER["HTTP_USER_AGENT"];
    } else {
        session_destroy();
        echo "<script>alert('Invalid username/password');window.location='register.php';</script>";
        die();
    }
}

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== TRUE) {
    session_destroy();
    echo "<script>alert('You have not logged in. Please log in first!');</script>";
    header("Refresh: 0; url=register.php");
    die();
}

if ($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]) {
    session_destroy();
    echo "<script>alert('Session hijacking attack detected!');</script>";
    header("Refresh: 0; url=register.php");
    die();
}

function checklogin_mysql($username, $password)
{
    $mysqli = new mysqli('localhost', 'waph_team16', 'Pa$$w0rd', 'waph_team');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }
    $sql = "SELECT * FROM users WHERE username=? AND password = md5(?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows >= 1)
        return TRUE;
    return FALSE;
}


    if(isset($_POST['post'])){
        $uploadOk = 1;
        $imageName = $_FILES['fileToUpload']['name'];
        $errorMessage = "";
        
        if($imageName != ""){
            $targetDir = "assets/images/posts/";
            $imageName = $targetDir . uniqid() . basename($imageName);
            $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);
            
            if($uploadOk){
                if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageName)){
                    //image Upload Okey
                    $errorMessage = "uploaded";
                }
                else{
                    $uploadOk = 0;
                    $errorMessage = "fail to upload";
                }
            }
        }
        
        if($uploadOk){
            $post = new Post($con, $userLoggedIn);
            $post->submitPost($_POST['post_text'], $imageName);
        }
        else{
            echo "<div style='text-align: center;' class='alert alert-danger'> $errorMessage </div>";
        }
    }

    $user_detail_query = mysqli_query($con,"select * from users where username='$userLoggedIn'");
    $user_array = mysqli_fetch_array($user_detail_query);
    $num_friends = (substr_count($user_array['friend_array'],","))-1;

?>

<div class="index-wrapper">
    <div class="info-box">
        <div class="info-inner">
            <div class="info-in-head">
                <a href="<?php echo $userLoggedIn; ?>"><img src="<?php echo $user['cover_pic']; ?>"></a>
            </div>
            <div class="info-in-body">
                <div class="in-b-box">
                    <div class="in-b-img">
                        <a href="<?php echo $userLoggedIn; ?>"><img src="<?php echo $user['profile_pic'] ; ?>"></a>
                        <h2>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</h2>
                    </div>
                </div>
                <div class="info-body-name">
                    <div class="in-b-name">
                        <div><a href="<?php echo $userLoggedIn; ?>"><?php echo $user['first_name'] . " " . $user['last_name']; ?></a>
                        </div>
                        <span><small><a href="<?php echo $userLoggedIn; ?>"><?php echo "@" . $user['username'] ?></a></small></span>
                    </div>
                </div>
            </div>
            <div class="info-in-footer">
                <div class="number-wrapper">
                    <div class="num-box">
                        <div class="num-head">
                            POSTS
                        </div>
                        <div class="num-body">
                            <?php echo $user['num_posts']; ?>
                        </div>
                    </div>
                    <div class="num-box">
                        <div class="num-head">
                            LIKES
                        </div>
                        <div class="num-body">
                            <span class="count-likes">
                                <?php echo $user['num_likes']; ?>
                            </span>
                        </div>
                    </div>
                    <div class="num-box">
                        <div class="num-head">
                            Friends
                        </div>
                        <div class="num-body">
                            <?php echo $num_friends ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="post-wrap">
        <div class="post-inner">
            <div class="post-h-left">
                <div class="post-h-img">
                    <a href="<?php echo $userLoggedIn; ?>"><img src="<?php echo $user['profile_pic'] ?>"></a>
                 </div>
            </div>
            
            <div class="post-body">
                <form class="post_form" action="index.php" method="POST" enctype="multipart/form-data">
                    <textarea class="status" name="post_text" id="post_text" placeholder="Type Something here!" rows="4" cols="50"></textarea>
                    <div class="hash-box">
                        <ul>
                        </ul>
                    </div>
            </div>
                <div class="post-footer">
                    <div class="p-fo-left">
                        <ul>
                            <input type="file" name="fileToUpload" id="fileToUpload"/>
                            <label for="fileToUpload"> <img src="assets/images/camera.png" alt="" height="30px"></i> </label>
                            <span class="tweet-error"></span>
                            <input id="sub-btn" type="submit" name="post" value="SHARE">
                        </ul>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="show_post">
        <?php 
            $post = new Post($con, $userLoggedIn) ;
            $post->indexPosts();
        ?>
    </div>
</div>
</body>
</html>
