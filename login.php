<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "All fields are required";
    } else {
        
        $sql = "SELECT * FROM `user` WHERE email = '$email'";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if ($password === $row['password']) {
                if ($row['status'] === 'accepted') {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    header("Location: home.php");
                    exit();
                } elseif ($row['status'] === 'pending') {
                    $error = "Your account is pending admin approval.";
                } elseif ($row['status'] === 'rejected') {
                    $error = "Your account has been rejected by the admin.";
                } else {
                    $error = "Invalid account status.";
                }

            } else {
                $error = "Invalid email or password!";
            }
        } else {
            $error = "Invalid email or password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <link rel="stylesheet" href="style.css"/>
</head>
<body>
  <div class="container">
    <div class="form-box">
      <h2>Login</h2>

      <?php if (!empty($error)): ?>
        <p style="color:red; text-align:center;"><?php echo $error; ?></p>
      <?php endif; ?>
      
      <form method="post">
        <div class="input-group"> 
          <label for="email">Email:</label>
          <input type="email" name="email" placeholder="Your Email" required />

          <label for="password">Password:</label>
          <input type="password" name="password" placeholder="Password" required />
        </div>
        <button type="submit" class="register-btn">Login</button>
        <button type="submit" class="register-btn">example</button>
      </form>

      <p class="login-link"><a href="signup.php">New member?</a></p>
      <p class="login-link"><a href="OTP.php">Forgot password?</a></p>
    </div>
    <div class="image">
      <img src="lock.png" alt="Login image" />
    </div>
  </div>
</body>
</html>
