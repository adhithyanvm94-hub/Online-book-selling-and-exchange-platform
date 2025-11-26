<?php
include '../config.php';

if (!isset($_GET['id'])) {
    die("Book ID not found");
}

$book_id = intval($_GET['id']);

$selectquery = "SELECT * FROM books WHERE bookid = $book_id";
$bookResult = mysqli_query($con, $selectquery) or die("Error fetching book: " . mysqli_error($con));

if (mysqli_num_rows($bookResult) === 0) {
    die("No book found");
}

$book = mysqli_fetch_assoc($bookResult);
$id = $book["bookid"];
$title = $book["title"];
$description = $book["description"];
$status = $book["status"];
$price = $book["price"];
$cndtn = $book["cndtn"];
$genre = $book["genre"];
$image = $book["image"];
$owner_id = $book["userid"];
$author_id = $book["author_id"]; 
$author_name = "Unknown Author";
if ($author_id) {
    $authorQuery = "SELECT name FROM authors WHERE author_id = $author_id";
    $authorResult = mysqli_query($con, $authorQuery);
    if (mysqli_num_rows($authorResult) > 0) {
        $authorRow = mysqli_fetch_assoc($authorResult);
        $author_name = $authorRow['name'];
    }
}

$sellerQuery = "SELECT username, city FROM `user` WHERE id = $owner_id";
$sellerResult = mysqli_query($con, $sellerQuery) or die("Error fetching seller: " . mysqli_error($con));
if (mysqli_num_rows($sellerResult) > 0) {
    $seller = mysqli_fetch_assoc($sellerResult);
    $sellerName = $seller['username'];
    $sellerLocation = $seller['city'];
} else {
    $sellerName = "Unknown";
    $sellerLocation = "Unknown";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Book Details</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="../details.css" rel="stylesheet">
<link href="../buy.css" rel="stylesheet">
</head>
<body>
<style>
    .details-page{
        margin-top: 50px;
    }
</style>
<div class="details-page">
    
    <div class="book-left">
        <img src="../uploads/<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($title) ?>" />
    </div>

    <div class="book-right">
        <h2 class="book-title"><?= htmlspecialchars($title) ?></h2>
        <p class="book-price">₹ <?= htmlspecialchars($price) ?></p>

        <div class="book-meta">
            <p><span>Author:</span> <?= htmlspecialchars($author_name) ?></p>
            <p><span>Condition:</span> <?= htmlspecialchars($cndtn) ?></p>
            <p><span>Status:</span> <?= htmlspecialchars($status) ?></p>
            <p><span>Genre:</span> <?= htmlspecialchars($genre) ?></p>
        </div>

        <div class="seller-info">
            <h3>Sold By</h3>
            <div class="seller-details">
                <div class="seller-avatar"><?= substr($sellerName, 0, 1) ?></div>
                <div class="seller-text">
                    <h4><?= htmlspecialchars($sellerName) ?></h4>
                    <p><?= htmlspecialchars($sellerLocation) ?></p>
                </div>
            </div>
        </div>

        <div class="book-description">
            <h3>Description</h3>
            <p><?= htmlspecialchars($description) ?></p>
        </div>
    </div>
</div>

</body>
</html>
