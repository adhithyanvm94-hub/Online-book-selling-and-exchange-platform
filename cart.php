<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart</title>
    <link href="cart.css" rel="stylesheet">
</head>
<body>
    
</body>
</html><?php
include 'config.php';
include 'nav.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userid = $_SESSION['user_id'];

$check = mysqli_query($con, "SELECT * FROM books WHERE bookid IN (SELECT bookid FROM cart WHERE userid = '$userid')");

if (!$check) {
    die("Query Failed: " . mysqli_error($con));
}

echo "<div class='card-container'>";

if (mysqli_num_rows($check) == 0) {
    echo "<p style='text-align:center;'>Your cart is empty.</p>";
} else {
    while ($row = mysqli_fetch_assoc($check)) {
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
                <p>Rs: $price</p>
                <div class='btn-container'>
                    <a href='details.php?id=$bookid' class='card-btn'>View More</a>
                    <a href='removecart.php?id=$bookid' class='card-btn'>Remove</a>
                </div>
            </div>
        </div>
        ";
    }
}

echo "</div>";
?>
