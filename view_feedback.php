<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

$seller_id = $_SESSION['user_id'];


$query = "SELECT f.id, f.rating, f.comment, u.username AS feedback_by
          FROM feedback f
          JOIN user u ON f.user_id = u.id
          WHERE f.seller_id = '$seller_id'
          ORDER BY f.id DESC";

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Report</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="view_feedback.css">
    <link rel="stylesheet" href="manage.css">
</head>
<body>
<?php include 'nav.php'?>
<div class="my-books">
    <div class="status-container">
    <h1>Feedback Received</h1>
    </div>

    <?php if(mysqli_num_rows($result) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Feedback By</th>
                <th>Rating</th>
                <th>Comment</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1; ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $count++; ?></td>
                <td><?= htmlspecialchars($row['feedback_by']); ?></td>
                <td><?= htmlspecialchars($row['rating']); ?>/5</td>
                <td><?= htmlspecialchars($row['comment']); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p style="text-align:center; padding: 20px;">No feedback received yet.</p>
    <?php endif; ?>
</div>


</body>
</html>
