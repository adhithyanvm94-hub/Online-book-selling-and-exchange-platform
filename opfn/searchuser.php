<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="../buy.css" rel="stylesheet">
</head>
<body>
    <style>.card-container{margin-left: 60px;}</style>
<?php
include("../config.php");

if (isset($_GET['searchdataproduct']) && !empty($_GET['searchdata'])) {
    $search_data_value = mysqli_real_escape_string($con, $_GET['searchdata']);

    $searchquery = "
        SELECT b.*, a.name AS author_name 
        FROM books b
        LEFT JOIN authors a ON b.author_id = a.author_id
        WHERE b.title LIKE '%$search_data_value%' OR a.name LIKE '%$search_data_value%'
    ";

    $resultquery = mysqli_query($con, $searchquery);

    echo "<h2>Search Results for: <em>$search_data_value</em></h2>";

    if (mysqli_num_rows($resultquery) > 0) {
        echo "<div class='card-container'>";
        while ($row = mysqli_fetch_assoc($resultquery)) {
            $title = htmlspecialchars($row['title']);
            $author = htmlspecialchars($row['author_name'] ?? 'Unknown');
            $description = htmlspecialchars($row['description']);
            $image = htmlspecialchars($row['image']);
            $price = htmlspecialchars($row['price']);
            $bookid = htmlspecialchars($row['bookid']);

            echo "
            <div class='card'>
                <div class='card-itm'>
                    <h4>$title</h4>
                    <img src='/booklin/uploads/$image' alt='$title'>
                    <p><strong>Author:</strong> $author</p>
                    <p>$description</p>
                    <p><strong>₹$price</strong></p>
                    <div class='btn-container'>
                        <a href='details.php?id=$bookid' class='card-btn'>View More</a>
                        <a href='addtocart.php?id=$bookid' class='card-btn'>Add to Cart</a>
                    </div>
                </div>
            </div>";
        }
        echo "</div>";
    } else {
        echo "<p>No books found for '<em>$search_data_value</em>'.</p>";
    }
} else {
    echo "<p>Please enter a search term.</p>";
}
?>
</body>
</html>
