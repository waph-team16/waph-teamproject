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
  <script>
    function validateForm() {
      // Client-side validation logic
      var username = document.forms["registrationForm"]["username"].value;
      var password = document.forms["registrationForm"]["password"].value;
      var email = document.forms["registrationForm"]["email"].value;
      // Add more validation checks as needed
      
      if (username == "" || password == "" || email == "") {
        alert("All fields are required");
        return false;
      }
      // Add more client-side validation checks as needed
      return true;
    }
  </script>
</head>
<body>
  <h1>New user registration, for Individual Project</h1>
  <form action="addnewuser.php" method="POST" class="form login">
    Username:<input type="text" class="text_field" name="username" /> <br>
    Password: <input type="password" class="text_field" name="password" /> <br>
    name:<input type="text" class="text_field" name="name" /> <br>
    additional_email: <input type="text" class="text_field" name="additional_email" /> <br>
    email:<input type="text" class="text_field" name="email" /> <br>
    phone: <input type="text" class="text_field" name="phone" /> <br>
    <button class="button" type="submit">Submit</button>
  </form>
  <a href="form2.php" class="home-link">Login Page</a>
</body>
</html>
