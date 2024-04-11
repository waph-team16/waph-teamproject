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
    // Redirect the user to the login page or perform any other action
    header("Location: form2.php");
    exit;
}

// Generate CSRF token and store it in the session
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = generateToken();
}

// Check for form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isTokenValid($_POST['csrf_token'])) {
        // CSRF token is invalid, display an alert
        echo "<script>alert('CSRF Attack detected!');</script>";
        // Redirect or perform any other action as needed
        header("Location: index.php");
        exit;
    }

    // CSRF token is valid, process the form submission
    // Add your form processing logic here...
}
?>


