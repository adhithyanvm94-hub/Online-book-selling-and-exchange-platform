<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM books WHERE genre='Educational'";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educational Books | Booklin</title>
    <link rel="stylesheet" href="buy.css"> 
    

</head>
<body>
    <style>.edu-container{margin-top:  100px; }</style>
<?php include "nav.php";?>
    <div class="edu-container">
        <h2>Educational Books</h2>

        <div class="edu-books">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $bookid = $row['bookid'];
                    $title = $row['title'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $image = $row['image'];

                    echo "
                    <div class='card'>
                        <div class='card-itm'>
                            <h4>$title</h4>
                            <img src='uploads/$image' alt='$title'>
                            <p>$description</p>
                            <p class='price'>₹ $price</p>
                            <div class='btn-container'>
                                <a href='details.php?id=$bookid' class='card-btn view'>View More</a>
                                <a href='addtocart.php?id=$bookid' class='card-btn cart'>Add to Cart</a>
                            </div>
                        </div>
                    </div>
                    ";
                }
            } else {
                echo "<p class='no-books'>No educational books available right now.</p>";
            }
            ?>
        </div>
    </div>

</body>
</html>
