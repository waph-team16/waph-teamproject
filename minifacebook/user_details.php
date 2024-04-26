<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$username = $_SESSION['username'];

$mysqli = new mysqli('localhost', 'waph_team16', 'password', 'waph_teamproject');
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$query = "SELECT * FROM users WHERE username = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // $name = $row['name'];
    $firstName = $row['first_name'];
    $lastName = $row['last_name'];
    $name = $firstName . ' ' . $lastName;
    $email = $row['email'];
    $additional_email = $row['additional_email'];
    $phone = $row['phone'];
} else {
    echo "No profile found for the logged-in user.";
}

$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .profile-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile-container h2 {
            margin-top: 0;
            color: #007bff; /* Blue heading color */
            text-align: center;
        }
        .profile-info {
            margin-bottom: 10px;
        }
        .profile-info label {
            font-weight: bold;
        }
        .profile-info span {
            color: #555; /* Dark gray text color */
        }
        .home-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff; /* Blue link color */
        }
        .home-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>Profile Details</h2>
        <div class="profile-info">
            <label>Name:</label>
            <span><?php echo $name; ?></span>
        </div>
        <div class="profile-info">
            <label>Email:</label>
            <span><?php echo $email; ?></span>
        </div>
        <div class="profile-info">
            <label>Additional Email:</label>
            <span><?php echo $additional_email; ?></span>
        </div>
        <div class="profile-info">
            <label>Phone:</label>
            <span><?php echo $phone; ?></span>
        </div>
    </div>
    <a href="index.php" class="home-link">Home Page</a>
</body>
</html>

