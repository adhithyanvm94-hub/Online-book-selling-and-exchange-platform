<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM user WHERE id = '$user_id'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

$dpFile = $user['profile_pic'] ?? '';
$isLetter = empty($dpFile) || !file_exists("uploads/profile/" . $dpFile);
$dpPath = $isLetter ? '' : "uploads/profile/$dpFile";
$initial = strtoupper($user['username'][0] ?? 'U');

$bookQuery = "SELECT * FROM books WHERE userid = '$user_id' ORDER BY bookid DESC";
$bookResult = mysqli_query($con, $bookQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Account</title>
<link rel="stylesheet" href="account.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<?php include 'nav.php'; ?>

<div class="dashboard-container">
    <div class="sidebar">
        <div class="profile-section">
            <div class="profile-pic-wrapper">
                <?php if($isLetter): ?>
                    <div class="profile-pic initial"><?= $initial ?></div>
                <?php else: ?>
                    <img src="<?= $dpPath ?>" alt="Profile" class="profile-pic">
                <?php endif; ?>
            </div>
            <h2><?= htmlspecialchars($user['username']); ?></h2>
            <p><?= htmlspecialchars($user['email']); ?></p>

            <div class="account-actions">
                <a href="editprofile.php" class="btn">Edit Profile</a>
                <a href="OTP.php" class="btn">Forgot Password</a>
                <a href="view_feedback.php" class="btn">View Feedback</a>
                <a href="view_report.php" class="btn">View Report</a>
                <a href="opfn/logout.php" class="btn logout">Logout</a>
            </div>
        </div>
    </div>

    
    <div class="main-content">
        <h2>My Uploaded Books</h2>
        <div class="card-container">
            <?php
            if(mysqli_num_rows($bookResult) > 0){
                while($row = mysqli_fetch_assoc($bookResult)){
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
                            <p class='price'>₹ $price</p>
                            <div class='btn-container'>
                                <a href='details.php?id=$bookid' class='card-btn'>View More</a>
                                <a href='editbook.php?id=$bookid' class='card-btn edit'>Edit</a>
                                <a href='deletebookuser.php?id=$bookid' class='card-btn delete' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "<p class='no-books'>You haven't uploaded any books yet.</p>";
            }
            ?>
        </div>
    </div>
</div>

</body>
</html>
