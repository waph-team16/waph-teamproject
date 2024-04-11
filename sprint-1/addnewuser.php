<?php
    $username = $_POST["username"];
    $password = $_POST["password"];
    $name = $_POST["name"];
    $additional_email = $_POST["additional_email"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    
    if (isset($username) && isset($password) && isset($name) && isset($additional_email) && isset($phone)) 
    {
        // Add user and fetch auto-generated user_id
        $user_id = addNewUser($username, $password);
        
        // if ($user_id !== false) {
        //     // Add user details to profiles table
        //     if (addUserProfile($user_id, $name, $additional_email, $phone)) {
        //         echo "Registration succeeded!";
        //     } else {
        //         echo "Failed to add user profile!";
        //     }
        // } else {
        //     echo "Registration failed!";
        // }

        if (addUserProfile($user_id, $name, $additional_email, $phone, $email)) {
                echo "Registration succeeded!";
            } else {
                echo "Failed to add user profile!";
            }

    } else {
        echo "Incomplete data provided!";
    }
    
    function addNewUser($username, $password) {
        $mysqli = new mysqli('localhost', 'waph_team16', 'Pa$$w0rd', 'waph_team');
        
        if ($mysqli->connect_errno) {
            printf("Database connection failed: %s\n", $mysqli->connect_error);
            return false;
        }
        
        $prepared_sql = "INSERT INTO users (username, password) VALUES (?, MD5(?))";
        $stmt = $mysqli->prepare($prepared_sql);
        
        if (!$stmt) {
            printf("Prepare failed: %s\n", $mysqli->error);
            return false;
        }
        
        $stmt->bind_param("ss", $username, $password);
        
        if (!$stmt->execute()) {
            printf("Execute failed: %s\n", $stmt->error);
            return false;
        }
        
        // Fetch auto-generated user_id
        //$user_id = $stmt->insert_id;
        $result = $mysqli->query("SELECT LAST_INSERT_ID() AS user_id");
    $row = $result->fetch_assoc();
    $user_id = $row['user_id'];
    
    $stmt->close();
    return $user_id;
    }
    
    function addUserProfile($user_id, $name, $additional_email, $phone, $email) {
        $mysqli = new mysqli('localhost', 'waph_team16', 'Pa$$w0rd', 'waph_team');
        
        if ($mysqli->connect_errno) {
            printf("Database connection failed: %s\n", $mysqli->connect_error);
            return false;
        }
        
        $prepared_sql = "INSERT INTO profiles (user_id, name, additional_email, phone, email) VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($prepared_sql);
        
        if (!$stmt) {
            printf("Prepare failed: %s\n", $mysqli->error);
            return false;
        }
        
        $stmt->bind_param("issss", $user_id, $name, $additional_email, $phone, $email);
        
        if (!$stmt->execute()) {
            printf("Execute failed: %s\n", $stmt->error);
            return false;
        }
        
        $stmt->close();
        return true;
    }
?>
