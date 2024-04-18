<?php
$lifetime = 15 * 60;
$path = "/";
$domain = "192.167.9.255";
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
        echo "<script>alert('Invalid username/password');window.location='form2.php';</script>";
        die();
    }
}

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== TRUE) {
    session_destroy();
    echo "<script>alert('You have not logged in. Please log in first!');</script>";
    header("Refresh: 0; url=form2.php");
    die();
}

if ($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]) {
    session_destroy();
    echo "<script>alert('Session hijacking attack detected!');</script>";
    header("Refresh: 0; url=form2.php");
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
            // echo "<h3>" . $row['post_id'] . "</h3>";
            echo "<p>" . $row['content'] . "</p>";
            echo "<p>Posted by: " . $row['name'] . "</p>";
            echo "<p>Time: " . $row['timestamp'] . "</p>";
            
            echo "<form method='post' action='edit_post.php'>";
            echo "<input type='hidden' name='post_id' value='" . $row['post_id'] . "'>";
            echo "<input type='submit' value='Edit'>";
            echo "</form>";
            echo "<form method='post' action='delete_post.php'>";
            echo "<input type='hidden' name='post_id' value='" . $row['post_id'] . "'>";
            echo "<input type='submit' value='Delete'>";
            echo "</form>";
           
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

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .action-buttons button {
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .action-buttons button.edit {
            background-color: #ffc107;
            border: none;
        }

        .action-buttons button.delete {
            background-color: #dc3545;
            border: none;
        }

        .action-buttons button.edit:hover {
            background-color: #ffca2c;
        }

        .action-buttons button.delete:hover {
            background-color: #e0243a;
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
