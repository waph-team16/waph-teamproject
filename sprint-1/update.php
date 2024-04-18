<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== TRUE) {
    echo "You are not logged in.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['post_id']) && isset($_POST['updated_content'])) {
        $post_id = $_POST['post_id'];
        $updated_content = $_POST['updated_content'];

        // Assuming you have a function to update a post based on post ID
        if (updatePost($post_id, $updated_content)) {
            echo "Post updated successfully.";
            echo '<a href="index.php"> Home page </a>';
        } else {
            echo "Failed to update post.";
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

function updatePost($post_id, $updated_content)
{
    // Assuming you have already established a database connection
    $mysqli = new mysqli('localhost', 'waph_team16', 'Pa$$w0rd', 'waph_team');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }

    $sql = "UPDATE posts SET content=? WHERE post_id=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("si", $updated_content, $post_id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
?>
