<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== TRUE) {
    echo "You are not logged in.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['post_id'])) {
        $post_id = $_POST['post_id'];

        // Assuming you have a function to retrieve post content based on post ID
        $post_content = getPostContent($post_id);

        if ($post_content !== false) {
            echo "<form method='post' action='index.php'>";
            echo "<input type='hidden' name='post_id' value='" . $post_id . "'>";
            echo "<textarea name='updated_content' rows='4' cols='50'>" . $post_content . "</textarea><br>";
            echo "<input type='submit' value='Update'>";
            echo "</form>";
        } else {
            echo "Post not found.";
        }
    } else {
        echo "Invalid request.";
    }
} else {
    echo "Invalid request method.";
}

function getPostContent($post_id)
{
    // Assuming you have already established a database connection
    $mysqli = new mysqli('localhost', 'waph_team16', 'Pa$$w0rd', 'waph_team');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }

    $sql = "SELECT content FROM posts WHERE post_id=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        return $row['content'];
    } else {
        return false;
    }
}
?>
