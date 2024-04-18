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

// Handle adding comments
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['post_id']) && isset($_POST['comment_content'])) {
        $post_id = $_POST['post_id'];
        $comment_content = $_POST['comment_content'];

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
                echo '<a href="index.php"> Home page </a>';
            } else {
                echo "Error adding comment: " . $mysqli->error;
                echo '<a href="index.php"> Home page </a>';
            }

            $stmt->close();
        } else {
            echo "Error adding comment: Post does not exist.";
            echo '<a href="index.php"> Home page </a>';
        }
    } else {
        echo "Invalid request.";
        echo '<a href="index.php"> Home page </a>';
    }
}

$mysqli->close();
?>
