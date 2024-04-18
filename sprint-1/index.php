<?php
// Start session
$lifetime = 15 * 60;
$path = "/";
$domain = "192.167.9.255";
$secure = TRUE;
$httponly = TRUE;
session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
session_start();

// Check if the user is logged in
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== TRUE) {
    session_destroy();
    echo "<script>alert('You have not logged in. Please log in first!');</script>";
    header("Refresh: 0; url=form2.php");
    die();
}

// Check for session hijacking
if ($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]) {
    session_destroy();
    echo "<script>alert('Session hijacking attack detected!');</script>";
    header("Refresh: 0; url=form2.php");
    die();
}

// Function to check login credentials
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

// Function to get posts
function getPosts()
{
    $mysqli = new mysqli('localhost', 'waph_team16', 'Pa$$w0rd', 'waph_team');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }
    $sql = "SELECT posts.post_id, profiles.name, posts.content, posts.timestamp 
            FROM posts 
            INNER JOIN profiles ON posts.user_id = profiles.user_id
            ORDER BY posts.timestamp DESC";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='post'>";
            echo "<p>" . $row['content'] . "</p>";
            echo "<p>Posted by: " . $row['name'] . "</p>";
            echo "<p>Time: " . $row['timestamp'] . "</p>";
            
            // Check if the post is owned by the current user
            if ($_SESSION['username'] == $row['name']) {
                echo "<a href='edit_post.php?post_id=" . $row['post_id'] . "'>Edit</a>";
                echo "<a href='delete_post.php?post_id=" . $row['post_id'] . "'>Delete</a>";
            }
            
            echo "<form method='post' action='add_comment.php'>";
            echo "<input type='hidden' name='post_id' value='" . $row['post_id'] . "'>";
            echo "<input type='text' name='comment_content' placeholder='Add a comment'>";
            echo "<input type='submit' value='Comment'>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "<p>No posts found.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>MiniFacebook</title>
    <link rel="stylesheet" href="minifbstyle.css">
    <style>
        /* Interactive styles */
        .user-info a {
            color: #007bff; /* Blue link color */
            text-decoration: none;
            margin-right: 10px;
            transition: color 0.3s; /* Smooth color transition */
        }

        .user-info a:hover {
            color: #0056b3; /* Darker blue on hover */
        }

        .main-content h3 {
            color: #007bff; /* Blue heading color */
        }

        .post {
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .post:hover {
            background-color: #f9f9f9; /* Light gray background on hover */
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <h1>MiniFacebook</h1>
        <div class="user-info">
            <h2>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</h2>
            <a href="logout.php">Logout</a>
            <a href="editprofileform.php">Edit Profile</a>
            <a href="changepasswordform.php">Change Password</a>
            <a href="profile.php">Current Profile</a>
        </div>
    </header>
    <section class="main-content">
        <h3>Posts:</h3>
        <?php getPosts(); ?>
        <h3>Add New Post:</h3>
        <form method="post" action="add_post.php">
            <textarea name="post_content" rows="4" cols="50" placeholder="Write something..."></textarea><br>
            <input type="submit" value="Post">
        </form>
    </section>
</div>
</body>
</html>
