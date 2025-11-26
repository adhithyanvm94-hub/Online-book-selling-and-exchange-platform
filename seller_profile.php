<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$current_user_id = $_SESSION['user_id'];

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Seller ID not provided in URL.";
    exit;
}
$seller_id = $_GET['id'];

$sellerQuery = mysqli_query($con, "SELECT * FROM user WHERE id='$seller_id'");
if (mysqli_num_rows($sellerQuery) == 0) {
    echo "Seller not found.";
    exit;
}
$seller = mysqli_fetch_assoc($sellerQuery);

$bookQuery = mysqli_query($con, "SELECT * FROM books WHERE userid='$seller_id'");

$ratingCounts = [];
for ($i = 1; $i <= 5; $i++) $ratingCounts[$i] = 0;

$countQuery = mysqli_query($con, "SELECT rating, COUNT(*) as c FROM feedback WHERE seller_id='$seller_id' GROUP BY rating");
while ($row = mysqli_fetch_assoc($countQuery)) {
    $ratingCounts[$row['rating']] = $row['c'];
}
$maxCount = max($ratingCounts);

$feedbackQuery = mysqli_query($con, "SELECT f.*, u.username 
                                    FROM feedback f 
                                    JOIN user u ON f.user_id = u.id 
                                    WHERE f.seller_id='$seller_id'
                                    ORDER BY f.id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Profile</title>
    <link href="seller_profile2.css" rel="stylesheet"> 
    <link href="buy.css" rel="stylesheet">  
</head>
<body>
<?php include "nav.php"; ?>

<div class="seller-profile-container">

    <div class="seller-left-column">
        <div class="seller-unified-card">
            <div class="seller-info">
                <?php
                $dpPath = "uploads/profile/" . ($seller['profile_pic'] ?? '');
                if (!empty($seller['profile_pic']) && file_exists($dpPath)) {
                    echo '<div class="seller-avatar"><img src="'. $dpPath .'" alt="Seller DP"></div>';
                } else {
                    echo '<div class="seller-avatar">'. strtoupper(substr($seller['username'], 0, 1)) .'</div>';
                }
                ?>
                <div class="seller-details">
                    <h2><?= htmlspecialchars($seller['username']) ?></h2>
                    <p class="seller-location">📍 <?= htmlspecialchars($seller['city']) ?></p>
                </div>
            </div>
             
        <div class="seller-actions">
            <a href="feedback.php?seller_id=<?= $seller_id ?>" class="action-btn">Leave Feedback</a>
            <a href="report.php?seller_id=<?= $seller_id ?>" class="action-btn report-btn">Report Seller</a>
        </div>
           
            <div class="rating-section">
                <h3>Rating Distribution</h3>
                <?php
                for ($i = 5; $i >= 1; $i--) {
                    $count = $ratingCounts[$i];
                    $percentage = $maxCount > 0 ? ($count / $maxCount) * 100 : 0;
                    echo "
                    <div class='rating-row'>
                        <span class='rating-label'>$i ★</span>
                        <div class='rating-bar'>
                            <div class='rating-bar-fill' style='width:{$percentage}%;'></div>
                        </div>
                        <span class='rating-count'>$count</span>
                    </div>";
                }
                ?>
            </div>

            
            <div class="feedback-section">
                <h3>User Feedback</h3>
                <?php
                if (mysqli_num_rows($feedbackQuery) > 0) {
                    while ($row = mysqli_fetch_assoc($feedbackQuery)) {
                        echo "
                        <div class='feedback-row'>
                            <p><strong>{$row['username']}</strong> rated <strong>{$row['rating']} ★</strong></p>
                            <p>{$row['comment']}</p>
                        </div>";
                    }
                } else {
                    echo "<p>No feedback yet.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <div class="seller-right-column">
        <h3>Books by Seller</h3>
        <div class="card-container">
            <?php
            if (mysqli_num_rows($bookQuery) > 0) {
                while ($row = mysqli_fetch_assoc($bookQuery)) {
                    $bookid = $row['bookid'];
                    $title = htmlspecialchars($row['title']);
                    $description = htmlspecialchars($row['description']);
                    $image = htmlspecialchars($row['image']);
                    $price = htmlspecialchars($row['price']);

                    echo "
                    <div class='card'>
                        <div class='card-itm'>
                            <h4>$title</h4>
                            <img src='uploads/$image' alt='$image'>
                            <p>$description</p>
                            <p>Rs: $price</p>
                            <div class='btn-container'>
                                <a href='details.php?id=$bookid' class='card-btn'>View More</a>
                                <a href='addtocart.php?id=$bookid' class='card-btn'>Add to Cart</a>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "<p>No books found for this seller.</p>";
            }
            ?>
        </div>
    </div>

</div>
</body>
</html>
