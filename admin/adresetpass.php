<?php
include '../config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['reset_email']) && isset($_POST['OTP']) && isset($_POST['password'])) {
        $email = $_SESSION['reset_email'];
        $entered_otp = $_POST['OTP'];
        $new_password = $_POST['password'];

        if(empty($entered_otp) || empty($new_password)) {
             $error="all fields required";
        }elseif(strlen($new_password) < 6) {
          $error= "password must be atleast 6 charecters";
        }
     else {
        $check = mysqli_query($con, "SELECT * FROM admin WHERE email='$email' AND OTP='$entered_otp'");
        
        if (mysqli_num_rows($check) > 0) {
            mysqli_query($con, "UPDATE admin SET password='$new_password', OTP=NULL WHERE email='$email'");
            unset($_SESSION['reset_email']);
            echo "<script>alert('Password changed successfully'); window.location='adlogin.php';</script>";
        } 
      else {
            echo "<script>alert('Invalid OTP');</script>";
        }
    } 
  }else {
        echo "<script>alert('All fields are required');</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset password</title>
  <link rel="stylesheet" href="../style.css"/>
</head>
<body>
  <div class="container">
    <div class="form-box">
      <h2> Reset password </h2>

       <?php if (!empty($error)): ?>
        <p style="color:red; text-align:center;"><?php echo $error; ?></p>
      <?php endif; ?>
      
      <form method="post">
         <div class="input-group"> 
        
         <label for="email">OTP</label>
          <input type="number" name="OTP" placeholder="Your OTP" required />
        
        
          <label for="password">New Password:</label>
          <input type="password" name="password" placeholder="New Password" required />
        
         </div>
        <button type="submit" class="register-btn">Login</button>
      </form>
      <p class="login-link"><a href="signup.php">New Admin?</a></p>
     
    </div>
    <div class="image">
        <img src="../login-sticker.png" alt="Login image" />
    </div>
  </div>
</body>
</html>
