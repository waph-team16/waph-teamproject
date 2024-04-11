<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Sign Up</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      color: #333;
      margin: 0;
      padding: 0;
    }
    h1 {
      text-align: center;
      color: #007bff;
    }
    #digit-clock {
      text-align: center;
      font-size: 16px;
      margin-bottom: 20px;
    }
    .form {
      max-width: 400px;
      margin: 20px auto;
      background: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .text_field {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }
    .button {
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .button:hover {
      background-color: #0056b3;
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
  <script type="text/javascript">
    function displayTime() {
      document.getElementById('digit-clock').innerHTML = "Current time:" + new Date();
      
    }
    setInterval(displayTime,500);
  </script>
</head>
<body>
  <h1>New user registration, for Individual Project</h1>
<div class="centered">
  <div id="digit-clock"></div>
    <?php
    // Get the visited time
    $visitedTime = date("Y-m-d h:i:sa");
    // Output the visited time
 
  ?>


<script>
  // Get the visited time from PHP and display it in an alert using JavaScript
  var visitedTime = "<?php echo $visitedTime; ?>";
  alert("Visited time: " + visitedTime);
</script>


  <form action="addnewuser.php" method="POST" class="form login">
    Username:<input type="text" class="text_field" name="username" /> <br>
    Password: <input type="password" class="text_field" name="password" /> <br>
    Name:<input type="text" class="text_field" name="name" /> <br>
    Additional Email: <input type="text" class="text_field" name="additional_email" /> <br>
    Email:<input type="text" class="text_field" name="email" /> <br>
    Phone: <input type="text" class="text_field" name="phone" /> <br>
    <button class="button" type="submit">Submit</button>
  </form>
  <a href="form2.php" class="home-link">Home Page</a>
</body>
</html>
