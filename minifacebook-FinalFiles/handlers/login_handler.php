<!-- login Handler.PHP^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
<?php

$lifetime = 15 * 60;
$path = "/";
$domain = "192.167.9.255";
$secure = TRUE;
$httponly = TRUE;
session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
session_start();

$error_array_login = array();

if(isset($_POST['login_button'])){
    $email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL);

    $_SESSION['log_email'] = $email;
    $password = $_POST['log_password'];
    $hashed_pwd = md5($password);

    $check_database_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password ='$hashed_pwd'");
    $check_login_query = mysqli_num_rows($check_database_query);

    if($check_login_query == 1){
        $row = mysqli_fetch_array($check_database_query);
        $username = $row['username'];

        $user_closed_query = mysqli_query($con,"select * from users where email='$email' and user_closed='yes'");
        if(mysqli_num_rows($user_closed_query) == 1){
            // $reopen_acc = mysqli_query($con, "update users set user_closed='no' where email='$email'");
            array_push($error_array_login, "User disabled by admin");
        }
        else {
        $_SESSION['username'] = $username;
        $_SESSION['authenticated'] = TRUE;
        header("Location: index.php");
        exit();
    }
    }
    else{
        array_push($error_array_login, "Email or Password was incorrect");
    }
}

?>