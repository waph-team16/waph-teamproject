
<!-- Index.php^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->

<?php
        include 'header.php';

    // Start session with secure settings
    session_set_cookie_params([
        'lifetime' => 3600, // Lifetime in seconds
        'path' => '/',
        'domain' => 'localhost', // Change to your domain
        'secure' => true, // HTTPS only
        'httponly' => true // HTTP only
    ]);
    session_start();

    // Function to sanitize user inputs
    function sanitize($input) {
        return htmlentities($input, ENT_QUOTES, 'UTF-8');
    }
    if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== TRUE) {
        session_destroy();
        echo "<script>alert('You have not logged in. Please log in first!');</script>";
        header("Refresh: 0; url=register.php");
        die();
    }

 if(isset($_SESSION['last_visit'])) {
        $lastVisit = $_SESSION['last_visit'];
    } else {
        $lastVisit = "This is your first visit!";
    }

    // Update last visit time
    $_SESSION['last_visit'] = date("Y-m-d H:i:s");

    if(isset($_POST['post'])){
        $uploadOk = 1;
        $imageName = sanitize($_FILES['fileToUpload']['name']);
        $errorMessage = "";

        // Rest of your code
    }

    // Rest of your code

    // Validate session to prevent hijacking
    if(isset($_SESSION['user_agent']) && $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
        // Session hijacked, destroy session
        session_destroy();
        // Perform further actions like redirecting to login page
    echo "<script>alert('Session hijacking attack detected!');</script>";
    header("Refresh: 0; url=register.php");
    die();
    }

    // Update user agent in session
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

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
                        <a href="<?php echo $userLoggedIn; ?>"><img src="<?php echo $user['profile_pic']; ?>"></a>
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
