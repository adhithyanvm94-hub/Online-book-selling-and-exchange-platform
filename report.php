<?php
session_start();
include "config.php";


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['seller_id'])) {
    echo " Seller ID not provided in URL.";
    exit;
}
$seller_id = intval($_GET['seller_id']);


$message = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $reason = mysqli_real_escape_string($con, trim($_POST['reason']));
    $details = mysqli_real_escape_string($con, trim($_POST['details']));

    if (empty($reason)) {
        $message = "<p class='msg error'>⚠️ Please select a reason for reporting.</p>";
    } elseif (empty($details)) {
        $message = "<p class='msg error'>⚠️ Please enter report details.</p>";
    } elseif (strlen($details) < 5) {
        $message = "<p class='msg error'>⚠️ Details must be at least 5 characters long.</p>";
    } elseif (!preg_match('/[a-zA-Z]{2,}/', $details)) {
        $message = "<p class='msg error'>⚠️ Please write a meaningful report.</p>";
    } elseif (preg_match('/(.)\\1{3,}/', $details)) {
        $message = "<p class='msg error'>⚠️ Please avoid repeating the same letter too many times.</p>";
    } elseif (strlen(preg_replace('/[^a-zA-Z0-9]/', '', $details)) < 3) {
        $message = "<p class='msg error'>⚠️ Report must contain real words.</p>";
    } else {
        $sql = "INSERT INTO reports (seller_id, user_id, reason, details) 
                VALUES ('$seller_id', '$user_id', '$reason', '$details')";
        if (mysqli_query($con, $sql)) {
            $message = "<p class='msg success' style='color: green;'>✅ Report submitted successfully.</p>";

        } else {
            $message = "<p class='msg error'> Error: " . mysqli_error($con) . "</p>";
        }
    }
}



?>
<!DOCTYPE html>
<html>
<head>
    <title>Report Seller</title>
    <link rel="stylesheet" href="report.css">
</head>
<body>
    <div class="report-form">
        <h2>Report Seller</h2>
        <?php if ($message) echo $message; ?>
        
        <form method="POST">
            <label for="reason">Reason:</label>
            <select name="reason" required>
                <option value="">-- Select Reason --</option>
                <option value="Fraudulent activity">Fraudulent activity</option>
                <option value="Fake product">Fake product</option>
                <option value="Abusive behavior">Abusive behavior</option>
                <option value="Other">Other</option>
            </select>

            <label for="details">Details:</label>
            <textarea name="details" placeholder="Write details here..."></textarea>

            <button type="submit">Submit Report</button>
            <a href="home.php" class="back-home">⬅️ Back to Home</a>
        </form>
    </div>
</body>
</html>
