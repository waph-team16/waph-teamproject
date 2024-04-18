<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== TRUE) {
    echo "You are not logged in.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['post_id']) && isset($_POST['comment_content'])) {
        $post_id = $_POST['post_id'];
        $comment_content = $_POST['comment_content'];

        $mysqli = new mysqli('localhost', 'waph_team16', 'Pa$$w0rd', 'waph_team');
        if ($mysqli->connect_errno) {
            printf("Database connection failed: %s\n", $mysqli->connect_error);
            exit();
        }

        $user_id = getUserId($_SESSION['username'], $mysqli);

        $sql = "INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("iis", $post_id, $user_id, $comment_content);
        if ($stmt->execute()) {
            echo "Comment added successfully.";
        } else {
            echo "Error adding comment: " . $mysqli->error;
        }

        $stmt->close();
        $mysqli->close();
    } else {
        echo "Invalid request.";
    }
} else {
    echo "Invalid request method.";
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
