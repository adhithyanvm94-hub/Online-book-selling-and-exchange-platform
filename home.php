
 <?php
   include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>booklin</title>
<link rel="stylesheet" href="homecss.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
  <link href="opfn/footer.css" rel="stylesheet">
  <link href="navbar.css" rel="stylesheet">
</head>
<body>
   <?php include 'nav.php';?>
<div class="container">
<div class="details">
  <h2>Booklin</h2>
  <h4>"Where Every Book Finds a New Reader"</h4>
  <h5>With Booklin, every book gets a second chance and every reader finds their next story.</h5>
</div>
<div class="img">
<img src="read4.jpg" alt="read4image"/>
</div>
</div>


<div class="status-container">
<h3>Browse by Genre</h3>
</div>

  <div class="genre-container">
  <a href="buy.php?genre=Fiction" style="text-decoration:none; color:inherit;">
    <div class="genre">
      <div class="genre-icon fiction">
        <img src="icons/books.png" alt="Fiction">
      </div>
      <p>Fiction</p>
    </div>
  </a>

  <a href="buy.php?genre=Non-Fiction" style="text-decoration:none; color:inherit;">
    <div class="genre">
      <div class="genre-icon nonfiction1">
        <img src="icons/earth-globe.png" alt="Non-Fiction">
      </div>
      <p>Non-Fiction</p>
    </div>
  </a>

  <a href="buy.php?genre=Thriller" style="text-decoration:none; color:inherit;">
    <div class="genre">
      <div class="genre-icon nonfiction2">
        <img src="icons/search.png" alt="Thriller">
      </div>
      <p>Thriller</p>
    </div>
  </a>

  <a href="buy.php?genre=sci-fantasy" style="text-decoration:none; color:inherit;">
    <div class="genre">
      <div class="genre-icon scifi">
        <img src="icons/magic-wand.png" alt="Sci-Fi & Fantasy">
      </div>
      <p>Sci-Fi & Fantasy</p>
    </div>
  </a>

  <a href="buy.php?genre=Novel" style="text-decoration:none; color:inherit;">
    <div class="genre">
      <div class="genre-icon easy">
        <img src="icons/open-book.png" alt="Novel">
      </div>
      <p>Novel</p>
    </div>
  </a>

  <a href="buy.php?genre=Children" style="text-decoration:none; color:inherit;">
    <div class="genre">
      <div class="genre-icon children">
        <img src="icons/teddy-bear.png" alt="Children Books">
      </div>
      <p>Children Books</p>
    </div>
  </a>
</div>

<div class='status-container'>
<h3>Explore</h3>
</div>
  <div class="s-container">
    
 <div class="l-card">
  <p>Introducing...</p>
  <h2>World of Education</h2>
  <p>Inspiring Knowledge Through Learning</p>
  <a href="education.php" class="link">Learn more →</a>
</div>


  
    <div class="l-card">
      <h2>Explore Us</h2>
      <div>
        <img src="https://covers.openlibrary.org/b/id/8235116-L.jpg" alt="Book 1">
        <img src="https://covers.openlibrary.org/b/id/10523365-L.jpg" alt="Book 2">
        <img src="https://covers.openlibrary.org/b/id/11153256-L.jpg" alt="Book 3">
        <img src="https://covers.openlibrary.org/b/id/10423143-L.jpg" alt="Book 4">
      </div>
      <a href="buy.php" class="link">Shop now →</a>
    </div>

  </div>


<div class='status-container'>
    <h3>Author Spotlight</h3>
</div>

<div class="author-spotlight">
    <?php

    $today = date('Y-m-d H:i:s');
    $authors = mysqli_query($con, "SELECT * FROM authors WHERE featured_until >= '$today' ORDER BY RAND() LIMIT 5");

    while ($a = mysqli_fetch_assoc($authors)) {
    ?>
        <a href="author.php?id=<?= $a['author_id'] ?>" class="author-card">
            <img src="authors/<?= $a['image'] ?>" alt="<?= $a['name'] ?>" width="150" height="200">
            <p><?= $a['name'] ?></p>
        </a>
    <?php } ?>
</div>



<div class="status-container">
<h3>New arrivals</h3>
</div>

<?php
if (isset($_GET['searchdataproduct']) && isset($_GET['searchdata']))  {
    include 'opfn/searchuser.php';
    // searchdata();
}else{
  $selectquery="select * from `books` order by `bookid` desc limit 5";
  $resultquery=mysqli_query($con,$selectquery);
   echo "<div class='card-container'>";
  while($row=mysqli_fetch_assoc($resultquery)){
    $bookid=$row['bookid'];
    $title=$row['title'];
    $description=$row['description'];
    $image=$row['image'];
    $price=$row['price'];
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
  echo '<a href="buy.php" class="view-all-link"><i class="fa-solid fa-right-long"></i></a>';
 echo"</div>";
}
?>


<div class='status-container'>
<h3>Most visited</h3>
</div>

<?php
include 'config.php';
$visitedQuery = "SELECT * FROM books ORDER BY views DESC limit 5";
$visitedResult = mysqli_query($con, $visitedQuery);

echo "<div class='card-container'>";
while($row = mysqli_fetch_assoc($visitedResult)) {
    echo "
    <div class='card'>
      <div class='card-itm'>
        <h4>{$row['title']}</h4>
        <img src='uploads/{$row['image']}' alt='{$row['image']}'>
        <p>{$row['description']}</p>
        <div class='btn-container'>
          <a href='details.php?id={$row['bookid']}' class='card-btn'>View More</a>
          <a href='addtocart.php?id={$row['bookid']}' class='card-btn'>Add to cart</a>
        </div>
      </div>
    </div>";
}
echo "</div>";
?>

<div class='status-container'>
<h3>sold</h3>
</div>
<?php
$soldBooksQuery = "SELECT * FROM books WHERE status='sold' ORDER BY bookid DESC LIMIT 5";
$soldBooksResult = mysqli_query($con, $soldBooksQuery);

echo "<div class='card-container'>";
while($row = mysqli_fetch_assoc($soldBooksResult)) {
    $bookid = $row['bookid'];
    $title = $row['title'];
    $description = $row['description'];
    $image = $row['image'];
    $price = $row['price'];

    echo "
    <div class='card'>
        <div class='card-itm'>
            <h4>$title</h4>
            <img src='uploads/$image' alt='$title'>
            <p>$description</p>
            <p><strong>Status:</strong> Sold</p>
            <div class='btn-container'>
                <a href='details.php?id=$bookid' class='card-btn'>View More</a>
            </div>
        </div>
    </div>";
}
// echo '<a href="sold_books.php" class="view-all-link"><i class="fa-solid fa-right-long"></i></a>';
echo "</div>";
?>



<?php
$sql = "
    SELECT u.id, u.username, u.email, u.profile_pic, COUNT(b.bookid) AS total_books
    FROM user u
    LEFT JOIN books b ON u.id = b.userid
    GROUP BY u.id, u.username, u.email, u.profile_pic
    ORDER BY total_books DESC
    LIMIT 5
";

$topSellers = mysqli_query($con, $sql);
?>
<div class="status-container">
<h3>TOP SELLERS</h3>
</div>
<div class="page-container">
    <div class="all-sellers-grid">
        <?php while ($row = mysqli_fetch_assoc($topSellers)) { 
            
            $serverPath = __DIR__ . "/uploads/profile/" . ($row['profile_pic'] ?? '');
            $webPath = "uploads/profile/" . ($row['profile_pic'] ?? '');
            
            if (!empty($row['profile_pic']) && file_exists($serverPath)) {
                $dpHtml = "<img src='$webPath' alt='Profile' class='all-seller-dp'>";
            } else {
                $initial = strtoupper(substr($row['username'], 0, 1));
                $dpHtml = "<div class='all-seller-dp all-seller-initial'>$initial</div>";
            }
        ?>
            <a href="seller_profile.php?id=<?= $row['id'] ?>" class="all-seller-card">
                <?= $dpHtml ?>
                <div class="all-seller-username"><?= htmlspecialchars($row['username']); ?></div>
                <div class="all-seller-email"><?= htmlspecialchars($row['email']); ?></div>
                <div class="all-seller-count">Books Listed: <?= $row['total_books']; ?></div>
            </a>
        <?php } ?>
    </div>

    <div class="top-sellers-view-all">
        <a href="list_users.php">View All Sellers →</a>
    </div>
</div>



</body>
</html>
<?php include 'opfn/footer.php'; ?>