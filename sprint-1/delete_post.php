<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== TRUE) {
    echo "You are not logged in.";
    exit;
}

// Check if post_id is set
if (!isset($_GET['post_id'])) {
    echo "Invalid request.";
    exit;
}

// Check if the user is the owner of the post
$post_id = $_GET['post_id'];

$mysqli = new mysqli('localhost', 'waph_team16', 'Pa$$w0rd', 'waph_team');
if ($mysqli->connect_errno) {
    printf("Database connection failed: %s\n", $mysqli->connect_error);
    exit();
}

$sql = "SELECT user_id FROM posts WHERE post_id=?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row || $row['user_id'] !== $_SESSION['user_id']) {
    echo "You are not authorized to delete this post.";
    exit;
}

// If the user is authorized, delete the post
$sql = "DELETE FROM posts WHERE post_id=?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $post_id);
if ($stmt->execute()) {
    echo "Post deleted successfully.";
} else {
    echo "Error deleting post: " . $mysqli->error;
}

$stmt->close();
$mysqli->close();
?>
