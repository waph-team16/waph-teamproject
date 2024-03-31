<?php
session_start();

// Check if user is authenticated
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] != TRUE) {
    header("Location: form.php");
    exit();
}

// Check if browser has changed (preventing session hijacking)
if ($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]) {
    session_destroy();
    echo "<script>alert('Session hijacking attack is detected!');</script>";
    header("Location: form.php");
    exit();
}

// Function to check login credentials in MySQL
function checkLoginMySQL($username, $password) {
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

// Retrieve posts from the database
function getPosts() {
    $mysqli = new mysqli('localhost', 'waph_team16', 'Pa$$w0rd', 'waph_team');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }

    $sql = "SELECT * FROM posts";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<h3>" . $row['post_id'] . "</h3>";
            echo "<p>" . $row['content'] . "</p>";
            echo "<p>Posted by user ID: " . $row['user_id'] . "</p>";
            echo "<p>Timestamp: " . $row['timestamp'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "No posts found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
</head>
<body>
    <h2>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</h2>
    <a href="logout.php">Logout</a>
    <a href="editprofileform.php">Edit Profile</a>

    <h3>Posts:</h3>
    <?php getPosts(); ?>
</body>
</html>
