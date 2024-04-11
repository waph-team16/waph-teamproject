<!-- <!DOCTYPE html>
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
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Welcome to Mini Facebook, Please Login</h1>
      <h2>Team-16</h2>
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
      <button type="submit" class="btn btn-primary">Log In</button>
    </form>
  </div>
</body>
</html>
 -->

<!-- <!DOCTYPE html>
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
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Welcome to Mini Facebook, Please Login</h1>
      <h2>Team-16</h2>
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
      <button type="submit" class="btn btn-primary">Log In</button>
    </form>
    < Sign Up Button -->
    <!-- <div class="signup-container">
      <button onclick="window.location.href='registrationform.php';" class="btn btn-secondary">Sign Up</button>
    </div>
  </div>
</body>
</html> -->

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
    .button-group {
      display: flex;
      justify-content: space-between; /* Aligns items with space between */
    }
    .button-group button {
      flex: 1; /* Each button will take equal width */
      margin: 5px; /* Ideal space between buttons */
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Welcome to Mini Facebook, Please Login</h1>
      <h2>Team-16</h2>
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


