<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>WAPH-Edit Profile</title>
  <script type="text/javascript">
      function displayTime() {
        document.getElementById('digit-clock').innerHTML = "Current time:" + new Date();
      }
      setInterval(displayTime,500);
  </script>
</head>
<body>
  <?php
  session_start();
?>
  <h1>Edit Profile, WAPH</h1>
  <h2>Welcome <?PHP echo htmlentities($_SESSION['username']); ?> !</h2>
  <div id="digit-clock"></div>  

  <form action="editprofile.php" method="POST" class="form edit-profile">
     <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
    Name:<input type="text" class="text_field" name="name"  /> <br>
    Additional Email: <input type="email" class="text_field" name="additional_email" /> <br>
    Phone: <input type="tel" class="text_field" name="phone" /> <br>
    <!-- Add more fields as needed -->
    <button class="button" type="submit">Save Changes</button>
  </form>
</body>
</html>
