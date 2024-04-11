<?php
$lifetime = 15 * 60;
$path = "/";
$domain = "192.167.9.255";
$secure = TRUE;
$httponly = TRUE;
session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
session_start();
if (!isset($_SESSION['authenticated']) or $_SESSION['authenticated'] != TRUE) {
    session_destroy();
    echo "<script>alert('You have not logged in. Please log in first!');</script>";
    header("Refresh: 0; url=form.php");
    die();
}
if ($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]) {
    session_destroy();
    echo "<script>alert('Session hijacking attack is detected!');</script>";
    header("Refresh:0; url=form.php");
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
    $sql = "SELECT * FROM posts ORDER BY timestamp DESC";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='post'>";
            echo "<h3>" . $row['post_id'] . "</h3>";
            echo "<p>" . $row['content'] . "</p>";
            echo "<p>Posted by user ID: " . $row['user_id'] . "</p>";
            echo "<p>Timestamp: " . $row['timestamp'] . "</p>";
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
    <title>WAPH - Feed</title>
    <link rel="stylesheet" href="minifbstyle.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Welcome to Mini Facebook</h1>
        <h2>Team-16</h2>
    </header>
    <nav>
        <ul>
            <li><a href="logout.php">Logout</a></li>
            <li><a href="editprofileform.php">Edit Profile</a></li>
        </ul>
    </nav>
    <section class="main-content">
        <h2>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</h2>
        <h3>Posts:</h3>
        <?php getPosts(); ?>
    </section>
</div>
</body>
</html>
