<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

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
$author_name = $book["author"];

if (!empty($author_id)) {
    $authorQuery = "SELECT name FROM authors WHERE author_id = $author_id";
    $authorResult = mysqli_query($con, $authorQuery);

    if (mysqli_num_rows($authorResult) > 0) {
        $authorRow = mysqli_fetch_assoc($authorResult);
        $author_name = $authorRow['name'];
    }
}

$updateViews = "UPDATE books SET views = views + 1 WHERE bookid = $id";
mysqli_query($con, $updateViews) or die("Error updating views: " . mysqli_error($con));

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

$genreEscaped = mysqli_real_escape_string($con, $genre);
$moreQuery = "SELECT * FROM books WHERE genre = '$genreEscaped' AND bookid != $id LIMIT 5";
$moreResult = mysqli_query($con, $moreQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Book Details</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="details.css" rel="stylesheet">
<link href="buy.css" rel="stylesheet">
</head>
<body>
<div class="nav-wrap">
    <?php include 'nav.php'; ?>
</div>

<div class="details-page">
    <div class="book-left">
        <img src="uploads/<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($title) ?>" />
    </div>

    <div class="book-right">
        <h2 class="book-title"><?= htmlspecialchars($title) ?></h2>
        <p class="book-price">₹ <?= htmlspecialchars($price) ?></p>

        <div class="book-meta">
            <p><span>Author:</span> <a href="author.php?id=<?= $author_id ?>"><?= htmlspecialchars($author_name) ?></a></p>
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

        <div class="dbuttons">
            <a href="addtocart.php?id=<?= $id ?>" class="btn">Add to Cart</a>
            <?php if ($_SESSION['user_id'] != $owner_id): ?>
                <a href="chat.php?receiver_id=<?= $owner_id ?>" class="btn chat">Chat with Seller</a>
            <?php else: ?>
                <span class="btn-disabled">This is your book</span>
            <?php endif; ?>
            <a href="seller_profile.php?id=<?= $owner_id ?>" class="btn profile">Seller Profile</a>
        </div>
    </div>
</div>

<div class="status-container">
    <h3>More Like This</h3>
</div>
<div class="card-container">
    <?php
    if(mysqli_num_rows($moreResult) > 0){
        while($row = mysqli_fetch_assoc($moreResult)){
            $bookid = $row['bookid'];
            $title = $row['title'];
            $description = $row['description'];
            $image = $row['image'];
            $price = $row['price'];
            echo "
            <div class='card'>
                <div class='card-itm'>
                    <h4>$title</h4>
                    <img src='uploads/$image' alt='$image'>
                    <p>$description</p>
                    <div class='btn-container'>
                        <a href='details.php?id=$bookid' class='card-btn'>View More</a>
                        <a href='addtocart.php?id=$bookid' class='card-btn'>Add to cart</a>
                    </div>
                </div>
            </div>";
        }
    } else {
        echo "<p>No similar books found.</p>";
    }
    ?>
</div>
</body>
</html>
