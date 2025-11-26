<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = (int) $_SESSION['user_id'];  

$sql = "DELETE FROM users WHERE id=$user_id";

if (mysqli_query($con, $sql)) {
    session_unset();
    session_destroy();
    echo "<script>alert('Account deleted permanently.'); window.location.href='signup.php';</script>";
} else {
    echo "Error: " . mysqli_error($con);
}

mysqli_close($con);
?>
