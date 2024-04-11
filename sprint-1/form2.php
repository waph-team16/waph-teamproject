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
