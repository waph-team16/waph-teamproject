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

if($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]){
		session_destroy();
		echo "<script>alert('Session hijacking attack is detected!');</script>";
		header("Refresh:0; url=from2.php");
		die();
	}
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Protected Form</title>
</head>
<body>
    <h1>Protected Form</h1>
    <form action="process_form.php" method="POST">
        <!-- Include CSRF token as a hidden input field -->
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <!-- Add your form fields here -->
        <button type="submit">Submit</button>
    </form>
</body>
</html>


