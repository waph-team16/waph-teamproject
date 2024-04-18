<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== TRUE) {
    echo "You are not logged in.";
    exit;
}

// Database connection
$mysqli = new mysqli('localhost', 'waph_team16', 'Pa$$w0rd', 'waph_team');
if ($mysqli->connect_errno) {
    printf("Database connection failed: %s\n", $mysqli->connect_error);
    exit();
}

// Function to get username by user_id
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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['post_id']) && isset($_POST['comment_content'])) {
        $post_id = $_POST['post_id'];
        $comment_content = $_POST['comment_content'];
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
    } else {
        echo "Invalid request.";
    }
}

// Fetch and display comments for the given post_id
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $sql = "SELECT c.content, u.username 
            FROM comments c 
            INNER JOIN users u ON c.user_id = u.user_id 
            WHERE c.post_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h2>Comments</h2>";
    while ($row = $result->fetch_assoc()) {
        $content = $row['content'];
        $username = $row['username'];
        echo "<p><strong>$username:</strong> $content</p>";
    }

    $stmt->close();
}

$mysqli->close();
?>
