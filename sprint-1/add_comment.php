<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== TRUE) {
    echo "You are not logged in.";
    exit;
}

// Function to get user_id by username
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

// Database connection
$mysqli = new mysqli('localhost', 'waph_team16', 'Pa$$w0rd', 'waph_team');
if ($mysqli->connect_errno) {
    printf("Database connection failed: %s\n", $mysqli->connect_error);
    exit();
}

// Fetch posts from the database
$sql_posts = "SELECT * FROM posts";
$result_posts = $mysqli->query($sql_posts);

if ($result_posts->num_rows > 0) {
    // Output data of each row
    while ($row_posts = $result_posts->fetch_assoc()) {
        $post_id = $row_posts['post_id'];
        $post_content = $row_posts['content'];
        $username = $row_posts['username'];

        echo "<div>";
        echo "<p><strong>$username:</strong> $post_content</p>";

        // Fetch and display comments for the current post
        $sql_comments = "SELECT c.content, u.username 
                        FROM comments c 
                        INNER JOIN users u ON c.user_id = u.user_id 
                        WHERE c.post_id = $post_id";
        $result_comments = $mysqli->query($sql_comments);

        if ($result_comments->num_rows > 0) {
            echo "<h3>Comments</h3>";
            while ($row_comments = $result_comments->fetch_assoc()) {
                $comment_content = $row_comments['content'];
                $comment_username = $row_comments['username'];
                echo "<p><strong>$comment_username:</strong> $comment_content</p>";
            }
        } else {
            echo "<p>No comments yet.</p>";
        }

        echo "</div>";
    }
} else {
    echo "No posts found.";
}

$mysqli->close();
?>
