<?php
include 'config.php';
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['razorpay_payment_id'])) {

  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  $confirm_password = trim($_POST['confirm_password']);
  $phno = trim($_POST['phno']);
  $city = trim($_POST['city']);
  $razorpay_payment_id = $_POST['razorpay_payment_id'];


  $check = mysqli_query($con, "SELECT * FROM user WHERE email = '$email'");
  if (mysqli_num_rows($check) > 0) {
    $error = "Email already exists.";
  } else {
    $target_dir = "uploads/";
    $id_proof_name = time() . "_" . basename($_FILES["id_proof"]["name"]);
    $target_file = $target_dir . $id_proof_name;

    if (move_uploaded_file($_FILES["id_proof"]["tmp_name"], $target_file)) {
      $sql = "INSERT INTO user (username, email, password, phno, city, razorpay_payment_id, id_proof, status) 
                    VALUES ('$username', '$email', '$password', '$phno', '$city', '$razorpay_payment_id', '$id_proof_name', 'pending')";

      if (mysqli_query($con, $sql)) {
        header("Location: login.php");
        exit();
      } else {
        $error = "Database error: " . mysqli_error($con);
      }
    } else {
      $error = "Error uploading ID proof.";
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
  <link rel="stylesheet" href="style.css" />
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

          <label for="confirm_password">Confirm Password:</label>
          <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required />

          <label for="phno">Number:</label>
          <input type="tel" name="phno" id="phno" placeholder="Phone Number" required />

          <label for="city">Place:</label>
          <select name="city" id="city" required>
            <option value="">-- Select District --</option>
            <?php
            $result = mysqli_query($con, "SELECT district_name FROM place");
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<option value='{$row['district_name']}'>{$row['district_name']}</option>";
            }
            ?>
          </select>

          <label for="id_proof">ID Proof:</label>
          <input type="file" name="id_proof" id="id_proof" accept="image/*" required />
        </div>

        <button type="submit" class="register-btn">Register</button>
      </form>
      <p class="login-link"><a href="login.php">I am already member</a></p>
    </div>
    <div class="image">
      <img src="login-sticker.png" alt="Login image" />
    </div>
  </div>

  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <script>
    document.getElementById("signupform").addEventListener("submit", function(e) {
      e.preventDefault(); 

      const username = document.getElementById("username").value.trim();
      const email = document.getElementById("email").value.trim();
      const password = document.getElementById("password").value.trim();
      const confirmPassword = document.getElementById("confirm_password").value.trim();
      const phno = document.getElementById("phno").value.trim();
      const id_proof = document.getElementById("id_proof").value.trim();
      const errorMsg = document.getElementById("errorMsg");

      errorMsg.textContent = "";


      if (username === "" || email === "" || password === "" || phno === "" || id_proof === "") {
        errorMsg.textContent = "All fields including ID proof are required!";
        return;
      }

      if (!/^[A-Za-z]+$/.test(username)) {
        errorMsg.textContent = "Username should contain only alphabetic letters!";
        return;
      }

      if (!/^[a-zA-Z0-9._%+-]+@gmail\.com$/.test(email)) {
        errorMsg.textContent = "Enter a valid Gmail address (example@gmail.com)!";
        return;
      }

      if (!/^[0-9]{10}$/.test(phno)) {
        errorMsg.textContent = "Enter a valid 10-digit phone number!";
        return;
      }

      if (password.length < 6) {
        errorMsg.textContent = "Password must be at least 6 characters!";
        return;
      }

      if (password !== confirmPassword) {
        errorMsg.textContent = "Passwords do not match!";
        return;
      }

      
      const form = this;
      const options = {
        key: "api key",
        amount: 2000,
        currency: "INR",
        name: "Booklin",
        description: "Signup Payment",
        handler: function(response) {
         
          const input = document.createElement("input");
          input.type = "hidden";
          input.name = "razorpay_payment_id";
          input.value = response.razorpay_payment_id;
          form.appendChild(input);
          form.submit();
        },
        prefill: {
          name: username,
          email: email,
          contact: phno
        },
        theme: {
          color: "#3399cc"
        }
      };
      const rzp = new Razorpay(options);
      rzp.open();
    });
  </script>
</body>

</html>
