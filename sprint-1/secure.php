<?php
session_start();

// Function to generate a random token
function generateToken() {
    return bin2hex(random_bytes(32)); // Generate a 32-byte token
}

// Function to check if the CSRF token is valid
function isTokenValid($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    echo "<script>alert('Session hijacking attack is detected!');</script>";
    header("Location: form2.php");
    exit;
}

// Generate CSRF token and store it in the session
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = generateToken();
}

// Check if the user agent has changed (possible session hijacking)
if ($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]) {
    session_destroy();
    echo "<script>alert('Session hijacking attack is detected!');</script>";
    header("Refresh:0; url=form2.php"); // Redirect after alert
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Page Title</title>
    <!-- Include any necessary styles or scripts here -->
</head>
<body>
    <!-- Your HTML content goes here -->
</body>
</html>
