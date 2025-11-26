
<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sender_id = $_SESSION['user_id'];  
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    $query = "INSERT INTO chat (sender_id, receiver_id, message)
    
              VALUES ('$sender_id', '$receiver_id', '$message')";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Message sent!'); window.history.back();</script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
