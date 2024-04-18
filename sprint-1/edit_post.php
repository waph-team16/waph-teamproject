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
    echo "You are not authorized to edit this post.";
    exit;
}

// If the user is authorized, display the edit form
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
</head>
<body>
    <h2>Edit Post</h2>
    <form action="update_post.php" method="post">
        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
        <textarea name="post_content" rows="4" cols="50"><?php echo htmlentities($post_content); ?></textarea><br>
        <input type="submit" value="Save">
    </form>
</body>
</html>
