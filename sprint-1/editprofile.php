<?php



$username = $_POST["username"];
$name = $_POST["name"];
$additional_email = $_POST["additional_email"];
$phone = $_POST["phone"];

// Check if the form is submitted
if (isset($username) && isset($name) && isset($additional_email) && isset($phone)) {
    if (updateProfile($username, $name, $additional_email, $phone)) {
        echo "Profile updated successfully!";
    } else {
        echo "Failed to update profile!";
    }
} else {
    echo "Invalid data provided!";
}

function updateProfile($username, $name, $additional_email, $phone)
{
    // Assuming you have already established a database connection

    
// Assuming you have already established a database connection
 $mysqli = new mysqli('localhost', 'waph_team16', 'Pa$$w0rd', 'waph_team');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        return FALSE;
    }
    // Retrieve the user's ID based on the username
    $query = "SELECT user_id FROM users WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "Error: User not found!";
        return false;
    }

    $row = $result->fetch_assoc();
    $user_id = $row['user_id'];

    // Update the profile information in the database
    $query = "UPDATE profiles SET name = ?, additional_email = ?, phone = ? WHERE user_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sssi", $name, $additional_email, $phone, $user_id);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows == 1) {
        echo "Profile updated successfully!";
        return true;
    } else {
        echo "Failed to update profile!";
        return false;
    }
}

?>
