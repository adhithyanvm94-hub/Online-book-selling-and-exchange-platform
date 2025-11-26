<?php
include 'config.php';
session_start();

$cndtn = $_GET['cndtn'] ?? [];
$genre = $_GET['genre'] ?? [];
$price_range = $_GET['price_range'] ?? '';
$min_rating = $_GET['min_rating'] ?? '';

if (!is_array($cndtn)) $cndtn = [$cndtn];
if (!is_array($genre)) $genre = [$genre];

$query = "SELECT b.* FROM books b WHERE 1";

if (!empty($genre)) {
    $escaped_genres = [];
    foreach ($genre as $g) {
        $escaped_genres[] = "'" . mysqli_real_escape_string($con, $g) . "'";
    }
    $query .= " AND b.genre IN (" . implode(",", $escaped_genres) . ")";
}

if (!empty($cndtn)) {
    $escaped_cndtn = [];
    foreach ($cndtn as $c) {
        $escaped_cndtn[] = "'" . mysqli_real_escape_string($con, $c) . "'";
    }
    $query .= " AND b.cndtn IN (" . implode(",", $escaped_cndtn) . ")";
}

if (!empty($price_range)) {
    if ($price_range === "exchange") {
        $query .= " AND b.price = 0";
    } else {
        list($min_price, $max_price) = explode('-', $price_range);
        $min_price = (int)$min_price;
        $max_price = (int)$max_price;
        $query .= " AND b.price BETWEEN $min_price AND $max_price";
    }
}

if (!empty($min_rating)) {
    $min_rating = (int)$min_rating;
    $query .= " AND b.userid IN (
        SELECT f.seller_id
        FROM feedback f
        GROUP BY f.seller_id
        HAVING AVG(f.rating) >= $min_rating
    )";
}

$result = mysqli_query($con, $query);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Books</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="buy.css" rel="stylesheet">

</head>

<body>

    <?php include 'nav.php'; ?>

    <div class="container">
        <div class="filter-container">
            <h3>Filter Books</h3>
            <form method="GET" action="buy.php">


                <div class="filter-group">
                    <label>Category</label>
                    <div class="checkbox-group">
                        <?php
                        $genres = ['Engineering','Educational', 'Novel', 'Fiction', 'Non-Fiction', 'Fantasy', 'Science Fiction', 'Mystery', 'Thriller', 'Romance', 'Biography', 'Self-Help', 'History', 'Children', 'Young Adult', 'Horror', 'Adventure', 'Comics', 'Poetry', 'Drama'];
                        $selectedGenres = isset($_GET['genre']) ? (array)$_GET['genre'] : [];

                        foreach ($genres as $g) {
                            $checked = in_array($g, $selectedGenres) ? 'checked' : '';
                            echo "<input type='checkbox' name='genre[]' id='genre_$g' value='$g' $checked>";
                            echo "<label for='genre_$g' class='custom-checkbox'>$g</label>";
                        }

                        ?>
                    </div>
                </div>


                <div class="filter-group">
                    <label>Condition</label>
                    <div class="checkbox-group">
                        <?php
                        $conditions = ['New', 'Like New', 'Very Good', 'Good', 'Acceptable'];
                        $selectedCndtn = isset($_GET['cndtn']) ? (array)$_GET['cndtn'] : [];

                        foreach ($conditions as $c) {
                            $checked = in_array($c, $selectedCndtn) ? 'checked' : '';
                            echo "<input type='checkbox' name='cndtn[]' id='cndtn_$c' value='$c' $checked>";
                            echo "<label for='cndtn_$c' class='custom-checkbox'>$c</label>";
                        }

                        ?>
                    </div>
                </div>


                <div class="filter-group">
                    <label>Price</label>
                    <div class="radio-group">
                        <input type="radio" name="price_range" id="price_all" value="" <?= empty($price_range) ? "checked" : "" ?>>
                        <label for="price_all" class="custom-radio">All</label>

                        <input type="radio" name="price_range" id="price_0_100" value="0-100" <?= ($price_range == "0-100") ? "checked" : "" ?>>
                        <label for="price_0_100" class="custom-radio">₹0 - ₹100</label>

                        <input type="radio" name="price_range" id="price_101_300" value="101-300" <?= ($price_range == "101-300") ? "checked" : "" ?>>
                        <label for="price_101_300" class="custom-radio">₹101 - ₹300</label>

                        <input type="radio" name="price_range" id="price_301_500" value="301-500" <?= ($price_range == "101-300") ? "checked" : "" ?>>
                        <label for="price_301_500" class="custom-radio">₹301 - ₹500</label>

                        <input type="radio" name="price_range" id="exchange" value="exchange" <?= ($price_range == "exchange") ? "checked" : "" ?>>
                        <label for="exchange" class="custom-radio">exchange</label>
                    </div>
                </div>


               <div class="filter-group">
    <label>Seller Rating</label>
    <div class="radio-group">
        <input type="radio" name="min_rating" id="rating_all" value="" <?= empty($min_rating) ? "checked" : "" ?>>
        <label for="rating_all" class="custom-radio">All</label>

        <input type="radio" name="min_rating" id="rating_1" value="1" <?= ($min_rating == 1) ? "checked" : "" ?>>
        <label for="rating_1" class="custom-radio">1 ★ & above</label>

        <input type="radio" name="min_rating" id="rating_2" value="2" <?= ($min_rating == 2) ? "checked" : "" ?>>
        <label for="rating_2" class="custom-radio">2 ★ & above</label>

        <input type="radio" name="min_rating" id="rating_3" value="3" <?= ($min_rating == 3) ? "checked" : "" ?>>
        <label for="rating_3" class="custom-radio">3 ★ & above</label>

        <input type="radio" name="min_rating" id="rating_4" value="4" <?= ($min_rating == 4) ? "checked" : "" ?>>
        <label for="rating_4" class="custom-radio">4 ★ & above</label>
    </div>
</div>


                <div class="filter-btn"><input type="submit" value="Apply Filters"></div>
            </form>
        </div>


        <div class="main-content">
            <div class="card-container">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $bookid = $row['bookid'];
                        $title = htmlspecialchars($row['title']);
                        $description = htmlspecialchars($row['description']);
                        $image = htmlspecialchars($row['image']);
                        $price = htmlspecialchars($row['price']);

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
                    echo "<p class='no-books'>No books found for the selected filters.</p>";
                }
                ?>
            </div>
        </div>
    </div>

</body>

</html>