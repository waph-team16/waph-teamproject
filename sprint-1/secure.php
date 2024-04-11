<?php
session_start();

// Function to generate a random token
function generateCSRFToken() {
    return bin2hex(random_bytes(32)); // Generate a 32-byte token
}

// Function to validate CSRF token
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    echo "<script>alert('You have not login. Please login first!');</script>";
    $_SESSION['alert_message'] = 'Session hijacking attack is detected!';
    header("Location: form2.php");
    exit;
}

// Generate CSRF token and store it in the session
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = generateCSRFToken();
}

// Check if the user agent has changed (possible session hijacking)
if ($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]) {
    session_destroy();
    echo "<script>alert('You have not login. Please login first!');</script>";
    $_SESSION['alert_message'] = 'Session hijacking attack is detected!';
    header("Location: form2.php");
    exit;
}

// Check for form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!validateCSRFToken($_POST['csrf_token'])) {
        $_SESSION['alert_message'] = 'CSRF Attack detected!';
        header("Location: form2.php");
        exit;
    }

    // CSRF token is valid, continue processing the form submission
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

    <script>
        // Check if there's an alert message stored in the session
        <?php if(isset($_SESSION['alert_message'])): ?>
            // Display the alert message
            alert('<?php echo $_SESSION['alert_message']; ?>');
            // Remove the alert message from the session
            <?php unset($_SESSION['alert_message']); ?>
        <?php endif; ?>
    </script>
</body>
</html>
