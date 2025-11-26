<?php
include '../config.php';
$error = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $phno = $_POST['phno'];


  if (empty($username) || empty($email) || empty($password) || empty($phno)) {
    $error = "All fields are required!";
  } elseif (!preg_match("/^[a-zA-Z]+$/", $username)) {
    $error = "Username must contain only alphabets!";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/@gmail\.com$/", $email)) {
    $error = "Enter a valid Gmail address (must end with @gmail.com)!";
  } elseif (!preg_match("/^[0-9]{10}$/", $phno)) {
    $error = "Enter a valid 10-digit phone number!";
  } elseif (strlen($password) < 6) {
    $error = "Password must be at least 6 characters!";
  } else {

    $check = mysqli_query($con, "SELECT * FROM admin WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
      $error = "Email already exists.";
    } else {

      $sql = "INSERT INTO admin (username, email, password, phone) 
                        VALUES ('$username', '$email', '$password', '$phno')";
      if (mysqli_query($con, $sql)) {
        header("Location: adlogin.php");
        exit();
      } else {
        $error = "Database error: " . mysqli_error($con);
      }
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up</title>
  <link rel="stylesheet" href="../style.css" />
</head>

<body>
  <div class="container">
    <div class="form-box">
      <h2>Sign up</h2>
      <p id="errorMsg" style="color:red; text-align:center;">
        <?php if (!empty($error)) echo $error; ?>
      </p>

      <form method="post" id="signupform" action="" enctype="multipart/form-data">
        <div class="input-group">
          <label for="name">Name:</label>
          <input type="text" name="username" id="username" placeholder="Your Name" required />

          <label for="email">Email:</label>
          <input type="email" name="email" id="email" placeholder="Your Email" required />

          <label for="password">Password:</label>
          <input type="password" name="password" id="password" placeholder="Password" required />

          <label for="phno">Number:</label>
          <input type="tel" name="phno" id="phno" placeholder="Phone Number" required />

        </div>

        <button type="submit" class="register-btn">Register</button>
      </form>
      <p class="login-link"><a href="adlogin.php">I am already admin</a></p>
    </div>
    <div class="image">
      <img src="../login-sticker.png" alt="Login image" />
    </div>
  </div>
</body>

</html>