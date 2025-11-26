<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location:login.php");
    die("User not logged in. Please log in first.");
}

include 'config.php';
$userid = $_SESSION['user_id']; 

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Book ID is missing.");
}
$bookid = intval($_GET['id']);

$sql = mysqli_query($con, "SELECT * FROM books WHERE bookid='$bookid' AND userid='$userid'");
if (mysqli_num_rows($sql) == 0) {
    die("Book not found or you don’t have permission to edit it.");
}
$book = mysqli_fetch_assoc($sql);
$saved_author = $book['author'];

$authors_q = mysqli_query($con, "SELECT * FROM authors ORDER BY name ASC");
$author_names = [];
$is_dropdown_author = false;

while ($row = mysqli_fetch_assoc($authors_q)) {
    $author_names[] = $row;
    if ($row['name'] == $saved_author) {
        $is_dropdown_author = true;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title       = mysqli_real_escape_string($con, $_POST['title']);
    $genre       = mysqli_real_escape_string($con, $_POST['genre']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $cndtn       = mysqli_real_escape_string($con, $_POST['cndtn']);
    $price       = mysqli_real_escape_string($con, $_POST['price']);
    $status      = mysqli_real_escape_string($con, $_POST['status']);
        
    if (!preg_match("/^[A-Za-z0-9\s\.,'!:-]{2,100}$/", $title)) {
        echo "<script>alert('❌ Invalid book title! Only letters, numbers, and basic punctuation allowed (2–100 characters).'); window.history.back();</script>";
        exit();
    } elseif (preg_match("/(test|asdf|qwerty|fake|sample)/i", $title)) {
        echo "<script>alert('⚠️ Suspicious title detected. Please enter a valid book title.'); window.history.back();</script>";
        exit();
    }

    if (!(is_numeric($price) && $price > 101) && strtolower(trim($price)) !== "exchange") {
        echo "<script>alert('❌ Invalid price! Price atleast 101. Enter a positive number or “exchange”.'); window.history.back();</script>";
        exit();
    } elseif (is_numeric($price) && $price > 10000) {
        echo "<script>alert('⚠️ Price too high! Please verify before submitting.'); window.history.back();</script>";
        exit();
    }

    if (empty($description)) {
        echo "<script>alert('❌ Description cannot be empty.'); window.history.back();</script>";
        exit();
    } elseif (strlen($description) < 10) {
        echo "<script>alert('⚠️ Description too short! Please provide at least 10 characters.'); window.history.back();</script>";
        exit();
    } elseif (strlen($description) > 1000) {
        echo "<script>alert('⚠️ Description too long! Keep it under 1000 characters.'); window.history.back();</script>";
        exit();
    } elseif (preg_match("/(test|asdf|qwerty|fake|sample|lorem)/i", $description)) {
        echo "<script>alert('⚠️ Suspicious description detected. Please enter a valid one.'); window.history.back();</script>";
        exit();
    }

    if ($_POST['author_id'] === "other") {
        $manual = mysqli_real_escape_string($con, $_POST['manual_author']);
        if (empty($manual)) {
            echo "<script>alert('Enter author name'); window.history.back();</script>";
            exit();
        }

        $checkAuthor = mysqli_query($con, "SELECT author_id FROM authors WHERE name='$manual'");
        if (mysqli_num_rows($checkAuthor) > 0) {
            $authorRow = mysqli_fetch_assoc($checkAuthor);
            $author_id_update = $authorRow['author_id'];
        } else {

            $insertAuthor = mysqli_query($con, "INSERT INTO authors (name) VALUES ('$manual')");
            if ($insertAuthor) {
                $author_id_update = mysqli_insert_id($con);
            } else {
                echo "Error inserting new author: " . mysqli_error($con);
                exit();
            }
        }

        $author = $manual; 
    } else {
        $aid = intval($_POST['author_id']);
        $aq = mysqli_query($con, "SELECT name FROM authors WHERE author_id='$aid'");
        $a = mysqli_fetch_assoc($aq);
        $author = $a['name'];
        $author_id_update = $aid;
    }

    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "uploads/";
        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $imageName;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);
    } else {
        $imageName = $book['image']; 
    }

    $update = mysqli_query($con, "
        UPDATE books 
        SET title='$title',
            author='$author',
            author_id=$author_id_update,
            genre='$genre',
            description='$description',
            cndtn='$cndtn',
            image='$imageName',
            price='$price',
            status='$status'
        WHERE bookid='$bookid' AND userid='$userid'
    ");

    if ($update) {
        echo "<script>alert('Book updated successfully!'); window.location.href='account.php';</script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
    <link rel="stylesheet" href="selluser.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
</head>
<body>

<div class="nav-wrap">
    <?php include 'nav.php'; ?>
</div>

<div class="page-wrapper">
<form method="post" enctype="multipart/form-data">
<div class="container">

<h3>Edit your book!!</h3>

<img src="uploads/<?= htmlspecialchars($book['image']) ?>" 
     style="width:120px;height:auto;" />

<label>TITLE:</label>
<input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>

<label>AUTHOR:</label>
<select name="author_id" id="author_select" required>
    <option value="">-- Select Author --</option>

    <?php foreach ($author_names as $a) { 
        $selected = ($a['name'] == $saved_author) ? "selected" : "";
    ?>
        <option value="<?= $a['author_id'] ?>" <?= $selected ?>><?= $a['name'] ?></option>
    <?php } ?>

    <option value="other" <?= (!$is_dropdown_author) ? "selected" : "" ?>>
        Other (Add manually)
    </option>
</select>

<label>If 'Other', Enter Author Name:</label>
<input type="text" id="manual_author_input" name="manual_author"
       value="<?= (!$is_dropdown_author) ? htmlspecialchars($saved_author) : "" ?>"
       placeholder="Enter author name">

<label>GENRE:</label>
<select name="genre" required>
<?php
$genres = ["Novel","Educational","Fiction","Non-Fiction","Fantasy","Science Fiction",
           "Mystery","Thriller","Romance","Biography","Self-Help","History",
           "Children","Young Adult","Horror","Adventure","Comics","Poetry","Drama"];
foreach ($genres as $g) {
    $sel = ($book['genre'] == $g) ? "selected" : "";
    echo "<option value='$g' $sel>$g</option>";
}
?>
</select>

<label>DESCRIPTION:</label>
<textarea name="description" required><?= htmlspecialchars($book['description']) ?></textarea>

<label>CONDITION:</label>
<select name="cndtn" required>
<?php
$conditions = ["New","Like New","Very Good","Good","Acceptable","Poor"];
foreach ($conditions as $c) {
    $sel = ($book['cndtn'] == $c) ? "selected" : "";
    echo "<option value='$c' $sel>$c</option>";
}
?>
</select>

<label>COVER IMAGE:</label>
<input type="file" name="image" accept="image/*">
<small>Current: <?= htmlspecialchars($book['image']) ?></small>

<label>PRICE:</label>
<input type="text" name="price" value="<?= htmlspecialchars($book['price']) ?>">

<label>Status:</label>
<select name="status" required>
    <option value="Available" <?= ($book['status']=="Available")?"selected":"" ?>>Available</option>
    <option value="sold" <?= ($book['status']=="sold")?"selected":"" ?>>Sold</option>
</select>

<div class="btn-wrapper">
    <button type="submit" class="btn-sell">Update</button>
</div>

</div>
</form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    var selectBox = document.getElementById("author_select");
    var manualInput = document.getElementById("manual_author_input");

    function toggleManual() {
        if (selectBox.value === "other") {
            manualInput.disabled = false;
            manualInput.required = true;
        } else {
            manualInput.disabled = true;
            manualInput.required = false;
            manualInput.value = "";
        }
    }

    toggleManual();
    selectBox.addEventListener("change", toggleManual);
});
</script>

</body>
</html>
