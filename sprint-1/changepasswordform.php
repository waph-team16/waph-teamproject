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
</head>
<body>
  <h1>Change password</h1>
  <div id="digit-clock"></div>  
 <?php
  session_start();
?>
  <form action="changepassword.php" method="POST" class="form login">
    <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
    Password: <input type="password" class="text_field" name="password" /> <br>
    <button class="button" type="submit">Submit</button>
  </form>
</body>
</html>