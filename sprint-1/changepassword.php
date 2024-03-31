<?php
	$username = $_POST["username"];
	$password = $_POST["password"];
	if (isset($username) and isset($password)){
		//echo "Debug> changepassword.php got username=$username;password=$password";
		if(changepassword($username,$password))
	{
		echo "Registration succeeded!";
	}
	else
	{
		echo "Registration failed!";
	}
	}else {
		echo "No username/password provided!";
	}
	
	function changepassword($username, $password)
{
    $mysqli = new mysqli('localhost', 'waph_team16', 'Pa$$w0rd', 'waph_team');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        return FALSE;
    }

    // Hash the password before updating
    $hashed_password = md5($password);

    $prepared_sql = "UPDATE users SET password = ? WHERE username = ?;";
    $stmt = $mysqli->prepare($prepared_sql);
    // Binding parameters
    $stmt->bind_param("ss", $hashed_password, $username);
    $stmt->execute();
    // Checking if the execution was successful
    if ($mysqli->affected_rows == 1)
        return TRUE;
    return FALSE;
}
?>