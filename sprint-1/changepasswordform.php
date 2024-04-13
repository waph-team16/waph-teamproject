<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Change Password</title>
  <script type="text/javascript">
      function displayTime() {
        document.getElementById('digit-clock').innerHTML = "Current time:" + new Date();
      }
      setInterval(displayTime,500);
  </script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2; /* Light gray background */
      color: #333; /* Dark gray text color */
    }
    h1 {
      color: #007bff; /* Blue heading color */
      text-align: center;
    }
    #digit-clock {
      text-align: center;
      margin-bottom: 20px;
    }
    .form {
      max-width: 300px; /* Adjust form width as needed */
      margin: 0 auto;
      padding: 20px;
      background: #fff; /* White background */
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Shadow effect */
    }
    .text_field {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc; /* Light gray border */
      border-radius: 5px;
      box-sizing: border-box;
    }
    .button {
      width: 100%;
      padding: 10px;
      background-color: #28a745; /* Green button background */
      color: #fff; /* White button text color */
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .button:hover {
      background-color: #218838; /* Darker green on hover */
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
  <h1>Change Password</h1>
  <div id="digit-clock"></div>  
 <?php
  session_start();
?>
  <form action="changepassword.php" method="POST" class="form login">
    <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
    Password: <input type="password" class="text_field" name="password" /> <br>
    <button class="button" type="submit">Submit</button>
  </form>
  <a href="index.php" class="home-link">Home Page</a>
</body>
</html>
