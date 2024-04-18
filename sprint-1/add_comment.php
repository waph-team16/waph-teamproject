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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['post_id']) && isset($_POST['comment_content'])) {
        $post_id = $_POST['post_id'];
        $comment_content = $_POST['comment_content'];

        $mysqli = new mysqli('localhost', 'waph_team16', 'Pa$$w0rd', 'waph_team');
        if ($mysqli->connect_errno) {
            printf("Database connection failed: %s\n", $mysqli->connect_error);
            exit();
        }

        // Check if the post_id exists in the posts table
        $check_post_sql = "SELECT COUNT(*) AS post_count FROM posts WHERE post_id = ?";
        $check_post_stmt = $mysqli->prepare($check_post_sql);
        $check_post_stmt->bind_param("i", $post_id);
        $check_post_stmt->execute();
        $check_post_result = $check_post_stmt->get_result();
        $post_count = $check_post_result->fetch_assoc()['post_count'];
        $check_post_stmt->close();

        if ($post_count > 0) {
            // Post exists, proceed with adding the comment
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
            echo "Error adding comment: Post does not exist.";
        }

        $mysqli->close();
    } else {
        echo "Invalid request.";
    }
} else {
    echo "Invalid request method.";
}

// Display comments for the given post_id
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $mysqli = new mysqli('localhost', 'waph_team16', 'Pa$$w0rd', 'waph_team');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }

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
    $mysqli->close();
}
?>
