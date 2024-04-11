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
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9; /* Light gray background */
      color: #333; /* Dark gray text color */
    }
    h1, h2 {
      color: #ff4500; /* Orange heading color */
      text-align: center;
    }
    #digit-clock {
      text-align: center;
      margin-bottom: 20px;
      color: #00bfff; /* Sky blue text color */
    }
    .form {
      max-width: 300px; /* Adjust form width as needed */
      margin: 0 auto;
      padding: 20px;
      background: #ffffe0; /* Light yellow background */
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Shadow effect */
    }
    .text_field {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ff6347; /* Tomato border color */
      border-radius: 5px;
      box-sizing: border-box;
    }
    .button {
      width: 100%;
      padding: 10px;
      background-color: #4caf50; /* Green button background */
      color: #fff; /* White button text color */
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .button:hover {
      background-color: #45a049; /* Darker green on hover */
    }
  </style>
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
