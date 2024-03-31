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
</head>
<body>
  <h1>New user registration, WAPH</h1>
  <h2>Maheedhar Atmakuru</h2>
  <div id="digit-clock"></div>  
<?php
  //some code here
  echo "Visited time: " . date("Y-m-d h:i:sa")
?>
  <form action="addnewuser.php" method="POST" class="form login">
    Username:<input type="text" class="text_field" name="username" /> <br>
    Password: <input type="password" class="text_field" name="password" /> <br>
    name:<input type="text" class="text_field" name="name" /> <br>
    additional_email: <input type="text" class="text_field" name="additional_email" /> <br>
    email:<input type="text" class="text_field" name="email" /> <br>
    phone: <input type="text" class="text_field" name="phone" /> <br>
    <button class="button" type="submit">Submit</button>
  </form>
</body>
</html>