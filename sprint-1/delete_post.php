<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== TRUE) {
    echo "You are not logged in.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['post_id'])) {
        $post_id = $_POST['post_id'];

        // Assuming you have a function to delete a post based on post ID
        if (deletePost($post_id)) {
            echo "Post deleted successfully.";
            echo '<a href="index.php"> Home page </a>';
        } else {
            echo "Failed to delete post.";
            echo '<a href="index.php"> Home page </a>';
        }
    } else {
        echo "Invalid request.";
        echo '<a href="index.php"> Home page </a>';
    }
} else {
    echo "Invalid request method.";
    echo '<a href="index.php"> Home page </a>';
}

function deletePost($post_id)
{
    // Assuming you have already established a database connection
    $mysqli = new mysqli('localhost', 'waph_team16', 'Pa$$w0rd', 'waph_team');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }

    // Delete comments associated with the post
    $sql_delete_comments = "DELETE FROM comments WHERE post_id=?";
    $stmt_delete_comments = $mysqli->prepare($sql_delete_comments);
    $stmt_delete_comments->bind_param("i", $post_id);
    $stmt_delete_comments->execute();

    // Delete the post
    $sql_delete_post = "DELETE FROM posts WHERE post_id=?";
    $stmt_delete_post = $mysqli->prepare($sql_delete_post);
    $stmt_delete_post->bind_param("i", $post_id);
    if ($stmt_delete_post->execute()) {
        return true;
    } else {
        return false;
    }
}
?>
