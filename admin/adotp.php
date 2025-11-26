<?php
session_start();
include '../config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../PHPMailer/PHPMailer.php';
require __DIR__ . '/../PHPMailer/SMTP.php';
require __DIR__ . '/../PHPMailer/Exception.php';


if($_SERVER['REQUEST_METHOD'] == "POST")  {
    $email = $_POST['email'];
    $otp = rand(100000, 999999);
    if(empty($email) || empty($otp)) {
        $error="all fields required";
    } else {

    $check = mysqli_query($con, "SELECT * FROM admin WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($con, "UPDATE admin SET otp='$otp' WHERE email='$email'");

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'booklin205@gmail.com';       
        $mail->Password   = 'jedw rstb uobh wejo';           
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('booklin205@gmail.com', 'booklin');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = "<p>Use this OTP to reset your password: <b>$otp</b></p>";

        if ($mail->send()) {
            $_SESSION['reset_email'] = $email;
            echo "<script>alert('OTP sent to your email.'); window.location.href='adresetpass.php';</script>";
        } else {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "<script>alert('Email not found!');</script>";
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OTP</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container">
    <div class="form-box">
        <h2>Forgot Password</h2>

         <?php if (!empty($error)): ?>
        <p style="color:red; text-align:center;"><?php echo $error; ?></p>
      <?php endif; ?>

        <form method="post">
            <div class="input-group">
                <label for="email">Enter your Email:</label>
                <input type="email" name="email" required>
            </div>
            <button type="submit" class="register-btn">Send OTP</button>
        </form>
        <p class="login-link"><a href="adlogin.php">I am already a member</a></p>
    </div>
    <div class="image">
        <img src="../login-sticker.png" alt="Login image">
    </div>
</div>
</body>
</html>
