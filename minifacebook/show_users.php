<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .container {
            margin-top: 20px;
            text-align: center;
        }
        .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>User List</h2>
    <table>
        <tr>
            <th>Firstname</th>
            <th>Username</th>
            <th>Email</th>
            <th>User Closed</th>
        </tr>
        <?php
        // Database connection details
        $host = "localhost"; // Assuming your database is on the same server
        $username = "waph_team16";
        $password = "password";
        $database = "waph_teamproject";

        // Create connection
        $conn = new mysqli($host, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to fetch list of users
        $sql = "SELECT first_name, username, email, user_closed FROM users";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["first_name"] . "</td>
                        <td>" . $row["username"] . "</td>
                        <td>" . $row["email"] . "</td>
                        <td>" . $row["user_closed"] . "</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>0 results</td></tr>";
        }

        // Close connection
        $conn->close();
        ?>
    </table>
    <a class="button" href="admin_home.php">Go to Admin Home</a>
</div>

</body>
</html>
