<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: adlogin.php");
    exit();
}

$admin_id = $_SESSION['user_id']; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_delete'])) {
    $delete_query = "DELETE FROM admin WHERE admin_id='$admin_id'";
    if (mysqli_query($con, $delete_query)) {
        session_destroy();
        header("Location: adlogin.php?msg=deleted");
        exit();
    } else {
        $error = "❌ Error deleting account: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Delete Admin Account</title>
  <link rel="stylesheet" href="../style.css"/>
</head>
<body>
  <div class="container">
    <div class="form-box">
      <h2>Delete My Account</h2>

      <?php if (!empty($error)): ?>
        <p style="color:red; text-align:center;"><?php echo $error; ?></p>
      <?php endif; ?>

      <p style="color:red; text-align:center;">⚠️ Warning: This action cannot be undone!</p>

      <form method="POST">
        <button type="submit" name="confirm_delete" class="register-btn" 
          style="background:red;">Delete My Account</button>
      </form>

      <p class="login-link"><a href="adminhome.php">⬅️ Cancel</a></p>
    </div>
    <div class="image">
      <img src="../lock.png" alt="Delete image" />
    </div>
  </div>
</body>
</html>
