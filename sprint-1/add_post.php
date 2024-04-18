<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== TRUE) {
    echo "You are not logged in.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['post_content'])) {
        $post_content = $_POST['post_content'];

        $mysqli = new mysqli('localhost', 'waph_team16', 'Pa$$w0rd', 'waph_team');
        if ($mysqli->connect_errno) {
            printf("Database connection failed: %s\n", $mysqli->connect_error);
            exit();
        }

        $user_id = getUserId($_SESSION['username'], $mysqli);

        $sql = "INSERT INTO posts (user_id, content, timestamp) VALUES (?, ?, NOW())";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("is", $user_id, $post_content);
        if ($stmt->execute()) {
            echo "Post added successfully.";
            echo '<a href="index.php"> Home page </a>';
        } else {
            echo "Error adding post: " . $mysqli->error;
            echo '<a href="index.php"> Home page </a>';
        }

        $stmt->close();
        $mysqli->close();
    } else {
        echo "Invalid request.";
        echo '<a href="index.php"> Home page </a>';
    }
} else {
    echo "Invalid request method.";
    echo '<a href="index.php"> Home page </a>';
}

function getUserId($username, $mysqli)
{
    $sql = "SELECT user_id FROM users WHERE username=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['user_id'];
}
?>
