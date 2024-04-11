<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>WAPH-Login page</title>
  <script type="text/javascript">
      function displayTime() {
        document.getElementById('digit-clock').innerHTML = "Current time:" + new Date();
      }
      setInterval(displayTime,500);
  </script>
  <link rel="stylesheet" href="minifbstyle.css">
  <style>
    .container {
      background-color: #f2f2f2; /* Light gray background */
      padding: 20px;
      border-radius: 10px;
      margin: 20px auto;
      width: 400px; /* Adjust width as needed */
    }
    .header {
      text-align: center;
      margin-bottom: 20px;
    }
    .header h1 {
      color: #ff0000; /* Red text color */
    }
    .form-group label {
      color: #ff0000; /* Red label color */
    }
    .btn-primary {
      background-color: #ff0000; /* Red button background */
      color: #fff; /* White button text color */
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }
    .btn-primary:hover {
      background-color: #cc0000; /* Darker red on hover */
    }
    .btn-secondary {
      background-color: #333; /* Dark gray button background */
      color: #fff; /* White button text color */
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }
    .btn-secondary:hover {
      background-color: #555; /* Darker gray on hover */
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Welcome to My page, Please Login</h1>
      <h2>Individual Project 2</h2>
      <div id="digit-clock"></div>
    </div>
    <form action="index.php" method="POST" class="form login">
      <div class="form-group">
        <label for="username">Email address or phone number:</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Email address or phone number">
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
      </div>
      <!-- Button Group -->
      <div class="button-group">
        <button type="submit" class="btn btn-primary">Log In</button>
        <button type="button" onclick="window.location.href='registrationform.php';" class="btn btn-secondary">Sign Up</button>
      </div>
    </form>
  </div>
</body>
</html>
