<?php
$lifetime = 15 * 60;
$path = "/";
$domain = "192.167.9.255";
$secure = TRUE;
$httponly = TRUE;
session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
session_start();
if (isset($_POST["username"]) and isset($_POST["password"])) {
		if (checklogin_mysql($_POST["username"],$_POST["password"])) {
			$_SESSION['authenticated'] = TRUE;
			$_SESSION['username'] = $_POST["username"];
			$_SESSION['browser'] = $_SERVER["HTTP_USER_AGENT"];	
		}else{
			session_destroy();
			echo "<script>alert('Invalid username/password');window.location='form2.php';</script>";
			die();
		}
	}
	if (!isset($_SESSION['authenticated']) or $_SESSION['authenticated']!= TRUE) {
		session_destroy();
		echo "<script>alert('You have not login. Please login first!');</script>";
		header("Refresh: 0; url=form2.php");
		die();
	}
        if($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]){
		session_destroy();
		echo "<script>alert('Session hijacking attack is detected!');</script>";
		header("Refresh:0; url=from.php");
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
    if ($result->num_rows == 1)
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
            echo "<p>Posted by : " . $row['name'] . "</p>";
            echo "<p>Time: " . $row['timestamp'] . "</p>";
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
    <title>MiniFacebook Homepage</title>
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
        <h1>Individual Project 2</h1>
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
    </section>
</div>
</body>
</html>

