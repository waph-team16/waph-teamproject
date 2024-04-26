<?php
    session_start();


    $username = $_SESSION["username"];
    $old_password = $_POST["old_password"];
    $new_password = $_POST["password"];

    if (isset($username) && isset($old_password) && isset($new_password)) {
        if (authenticateUser($username, $old_password)) {
            if (changepassword($username, $new_password)) {
                echo "Your password has been changed!";
            } else {
                echo "Failed to change password!";
            }
        } else {
            echo "Authentication failed! Please check your old password.";
        }
    } else {
        echo "Incomplete data provided!";
    }

    function authenticateUser($username, $old_password) {
        // $mysqli = new mysqli('localhost', 'waph_team16', 'password', 'waph_teamproject');
        // if ($mysqli->connect_errno) {
        //     printf("Database connection failed: %s\n", $mysqli->connect_error);
        //     return false;
        // }

        // $prepared_sql = "SELECT password FROM users WHERE username = ?";
        // $stmt = $mysqli->prepare($prepared_sql);
        // $stmt->bind_param("s", $username);
        // $stmt->execute();
        // $result = $stmt->get_result();
        // $row = $result->fetch_assoc();

        // // Check if old password matches the stored password
        // if (password_verify($old_password, $row['password'])) {
        //     return true;
        // } else {
        //     return false;
        $con= mysqli_connect("localhost","waph_team16","password","waph_teamproject");
        $hashed_pwd = md5($old_password);
        $check_database_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND password ='$hashed_pwd'");
        $check_login_query = mysqli_num_rows($check_database_query);

        if($check_login_query == 1){
            return true;
                                    }
                                }

    // function changepassword($username, $new_password) {
    //     $mysqli = new mysqli('localhost', 'waph_team16', 'password', 'waph_teamproject');
    //     if ($mysqli->connect_errno) {
    //         printf("Database connection failed: %s\n", $mysqli->connect_error);
    //         return false;
    //     }

    //     // Hashings the new password before updating
    //     $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    //     $prepared_sql = "UPDATE users SET password = ? WHERE username = ?";
    //     $stmt = $mysqli->prepare($prepared_sql);
    //     // Binding parameters
    //     $stmt->bind_param("ss", $hashed_password, $username);
    //     $stmt->execute();
    //     // Checking if the execution was successful
    //     if ($stmt->affected_rows == 1) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }


        function changepassword($username, $password)
{
    $mysqli = new mysqli('localhost', 'waph_team16', 'password', 'waph_teamproject');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        return FALSE;
    }

    // Hash the password before updating
    $hashed_password = md5($password);

    $prepared_sql = "UPDATE users SET password = ? WHERE username = ?;";
    $stmt = $mysqli->prepare($prepared_sql);
    // the Binding parameters
    $stmt->bind_param("ss", $hashed_password, $username);
    $stmt->execute();
    //  to Checking if the execution was successful
    if ($mysqli->affected_rows == 1)
        return TRUE;
    return FALSE;
}
?>
