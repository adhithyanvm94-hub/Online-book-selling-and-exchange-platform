<?php
session_start();
include '../config.php';
if($_SERVER['REQUEST_METHOD']=='POST')
{
  $email=$_POST['email'];
  $password=$_POST['password'];

  if(empty($email) || empty($password)){
    echo "all fields required";
  }

  $sql="select * from `admin` where email ='$email' and password='$password'";
  $result=mysqli_query($con,$sql);
  if(mysqli_num_rows($result)==1){
    $row = mysqli_fetch_assoc($result);
       $_SESSION['user_id'] = $row['admin_id'];
        $_SESSION['username'] = $row['username'];
        header("Location: admin.php"); 
        exit();
    } 
    else {
        $error="Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>LoginIn</title>
  <link rel="stylesheet" href="../style.css"/>
</head>
<body>
  <div class="container">
    <div class="form-box">
      <h2>Admin Login</h2>

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
      </form>
      <p class="login-link"><a href="adsignup.php">New admin?</a></p>
      <p class="login-link"><a href="adotp.php">forgot password?</a></p>
    </div>
    <div class="image">
      <img src="../lock.png" alt="Login image" />
    </div>
  </div>
</body>
</html>
