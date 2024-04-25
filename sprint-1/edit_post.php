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
            echo "<form method='post' action='update.php'>";
            echo "<input type='hidden' name='post_id' value='" . $post_id . "'>";
            echo "<textarea name='updated_content' rows='4' cols='50'>" . $post_content . "</textarea><br>";
            echo "<input type='submit' value='Update'>";
            echo "</form>";
        } else {
            echo "Post can not be edited.";
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

function getPostContent($post_id)
{
    // Assuming you have already established a database connection
    $mysqli = new mysqli('localhost', 'waph_team16', 'password', 'waph_teamproject');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }

    // Check if the logged-in user is the author of the post
    $username = $_SESSION['username'];

    $sql = "SELECT body FROM posts WHERE id=? AND added_by=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("is", $post_id, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Debugging statements using JavaScript console.log()
    echo "<script>";
    echo "console.log('SQL: " . $sql . "');";
    echo "console.log('Post ID: " . $post_id . "');";
    echo "console.log('Username: " . $username . "');";
    echo "</script>";

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        return $row['body'];
    } else {
        return false;
    }
}



function getUserName($username, $mysqli)
{
    $sql = "SELECT username FROM users WHERE username=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['username'];
}
?>
