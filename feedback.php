<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to leave feedback.";
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['seller_id'])) {
    echo "No seller specified.";
    exit;
}

$seller_id = intval($_GET['seller_id']);
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = intval($_POST['rating']);
    $comment = mysqli_real_escape_string($con, trim($_POST['comment']));

    
    if ($rating < 1 || $rating > 5) {
        $message = "⚠️ Please select a valid rating.";
    } elseif (empty($comment)) {
        $message = "⚠️ Comment cannot be empty.";
    } elseif (strlen($comment) < 5) {
        $message = "⚠️ Comment must be at least 5 characters long.";
    } elseif (!preg_match('/[a-zA-Z]{2,}/', $comment)) {
        $message = "⚠️ Please write a meaningful comment.";
    } elseif (preg_match('/(.)\\1{3,}/', $comment)) { 
        $message = "⚠️ Please avoid repeating the same letter too many times.";
    } elseif (strlen(preg_replace('/[^a-zA-Z0-9]/', '', $comment)) < 3) {
        $message = "⚠️ Comment must contain real words.";
    } else {
        
        $insert = "INSERT INTO feedback (seller_id, user_id, rating, comment) 
                   VALUES ($seller_id, $user_id, $rating, '$comment')";
        if (mysqli_query($con, $insert)) {
            $message = " Feedback submitted successfully!";
        } else {
            $message = " Error: " . mysqli_error($con);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Leave Feedback</title>
    <link rel="stylesheet" href="feedback.css">

</head>
<body>
    <div class="feedback-form">
        <h2>Leave Feedback for Seller</h2>
        <?php if ($message) echo "<p class='msg'>$message</p>"; ?>
        
        <form method="POST">
            <label for="rating">Rating:</label>
            <select name="rating" required>
                <option value="">-- Select Rating --</option>
                <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                <option value="4">⭐⭐⭐⭐ Good</option>
                <option value="3">⭐⭐⭐ Average</option>
                <option value="2">⭐⭐ Poor</option>
                <option value="1">⭐ Very Bad</option>
            </select>

            <label for="comment">Comment:</label>
            <textarea name="comment" placeholder="Write your feedback here..."></textarea>

            <button type="submit">Submit Feedback</button>
               <a href="home.php" class="back-home">⬅️ Back to Home</a>
        </form>
    </div>
</body>
</html>
