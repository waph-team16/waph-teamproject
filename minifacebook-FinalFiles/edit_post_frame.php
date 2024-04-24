<!-- edit_post_frame.php -->
<?php
// Include necessary files and configurations
require_once("config.php");
require_once("classes/User.php");
require_once("classes/Post.php");

// Check if user is logged in
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Retrieve post ID from GET parameter
if(isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    // Fetch post details from database based on post ID
    // Implement the logic to retrieve post details and pre-fill the edit form
    // Example: $post = new Post($con, $_SESSION['username']);
    //          $post_details = $post->getPostDetails($post_id);
    //          $post_body = $post_details['body'];
    //          $imagePath = $post_details['image'];

    // Generate HTML form for editing post
    echo "
        <form action='edit_post.php' method='post'>
            <textarea name='edited_body'>$post_body</textarea>
            <input type='hidden' name='post_id' value='$post_id'>
            <input type='submit' value='Save'>
        </form>
    ";
} else {
    echo "Post ID not provided.";
}
?>
