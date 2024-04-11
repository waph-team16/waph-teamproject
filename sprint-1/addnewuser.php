<?php
$username = $_POST["username"];
$password = $_POST["password"];
$name = $_POST["name"];
$additional_email = $_POST["additional_email"];
$email = $_POST["email"];
$phone = $_POST["phone"];

// Check if all required fields are set
if (isset($username, $password, $name, $additional_email, $phone, $email)) {
    // Perform database connection
    $mysqli = new mysqli('localhost', 'waph_team16', 'Pa$$w0rd', 'waph_team');

    // Check for connection errors
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }

    // Check if the username or email already exists in the database
    $checkQuery = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $mysqli->prepare($checkQuery);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // If a matching record is found, display a popup alert
    if ($result->num_rows > 0) {
        echo "<script>alert('User with the same username or email already exists');</script>";
        exit();
    }

    // If no matching record is found, proceed with adding the new user
    $insertQuery = "INSERT INTO users (username, password) VALUES (?, MD5(?))";
    $stmt = $mysqli->prepare($insertQuery);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    // Check if the user was successfully added
    if ($stmt->affected_rows > 0) {
        // Add user details to profiles table
        $insertProfileQuery = "INSERT INTO profiles (user_id, name, additional_email, phone, email) VALUES (LAST_INSERT_ID(), ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($insertProfileQuery);
        $stmt->bind_param("ssss", $name, $additional_email, $phone, $email);
        $stmt->execute();

        // Display success message
        echo "<script>alert('Registration successful');</script>";
    } else {
        // Display failure message
        echo "<script>alert('Registration failed');</script>";
    }

    // Close database connection
    $stmt->close();
    $mysqli->close();
} else {
    // Display message if required fields are not set
    echo "<script>alert('Incomplete data provided');</script>";
}
?>
