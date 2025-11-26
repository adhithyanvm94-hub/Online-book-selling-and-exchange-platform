<?php
session_start();
include 'config.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_SESSION['user_id'];

    
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $genre = mysqli_real_escape_string($con, $_POST['genre']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $cndtn = mysqli_real_escape_string($con, $_POST['cndtn']);
    $price = mysqli_real_escape_string($con, $_POST['price']);

   
    if ($_POST['author_id'] === 'other') {
        $manual_author = mysqli_real_escape_string($con, $_POST['manual_author']);

        if (empty($manual_author)) {
            echo "<script>alert('Please enter an author name.'); window.history.back();</script>";
            exit();
        }

       
        $check = mysqli_query($con, "SELECT author_id FROM authors WHERE name='$manual_author'");
        if (mysqli_num_rows($check) > 0) {
            $row = mysqli_fetch_assoc($check);
            $author_id = $row['author_id'];
        } else {
            $insert_author = "INSERT INTO authors (name) VALUES ('$manual_author')";
            if (mysqli_query($con, $insert_author)) {
                $author_id = mysqli_insert_id($con);
            } else {
                echo "<script>alert('Error adding author.'); window.history.back();</script>";
                exit();
            }
        }
    } else {
        $author_id = intval($_POST['author_id']);
    }

   
    if (!preg_match("/^[A-Za-z0-9\s\.,'!:-]{2,100}$/", $title)) {
        echo "<script>alert('❌ Invalid book title! Only letters, numbers, and basic punctuation allowed (2–100 characters).'); window.history.back();</script>";
        exit();
    } elseif (preg_match("/(test|asdf|qwerty|fake|sample)/i", $title)) {
        echo "<script>alert('⚠️ Suspicious title detected. Please enter a valid book title.'); window.history.back();</script>";
        exit();
    }

    
    if (!(is_numeric($price) && $price > 101) && strtolower(trim($price)) !== "exchange") {
        echo "<script>alert('❌ Invalid price! Enter a positive number or “exchange”.'); window.history.back();</script>";
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

    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "uploads/";
        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $imageName;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
            echo "<script>alert('❌ Only JPG, PNG, GIF files are allowed.'); window.history.back();</script>";
            exit();
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $sql = "INSERT INTO books (userid, title, author_id, genre, description, cndtn, image, price)
                    VALUES ('$userid', '$title', '$author_id', '$genre', '$description', '$cndtn', '$imageName', '$price')";
            if (mysqli_query($con, $sql)) {
                $message = "✅ Book uploaded successfully!";
            } else {
                $message = "Database error: " . mysqli_error($con);
            }
        } else {
            $message = "❌ Error uploading the image.";
        }
    } else {
        $message = "❌ Please upload an image file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Books</title>
    <link rel="stylesheet" href="selluser.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="nav-wrap">
        <?php include 'nav.php'; ?>
    </div>

    <div class="page-wrapper">
        <div class="container">
            <h3>Sell here!!</h3>
            <img src="sell.png" alt="bookimage" />

            <?php if ($message != ""): ?>
                <p style="color: green; text-align: center;"><?php echo $message; ?></p>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">
                <label for="title">TITLE:</label>
                <input type="text" name="title" placeholder="eg. HARRY POTTER" required>

                <label for="author">AUTHOR:</label>
                <select name="author_id" required>
                    <option value="">-- Select Author --</option>
                    <?php
                    $authors = mysqli_query($con, "SELECT * FROM authors ORDER BY name ASC");
                    while ($a = mysqli_fetch_assoc($authors)) {
                        echo "<option value='{$a['author_id']}'>{$a['name']}</option>";
                    }
                    ?>
                    <option value="other">Other (Add manually)</option>
                </select>

                <label for="manual_author">If 'Other', Enter Author Name:</label>
                <input type="text" name="manual_author" placeholder="Enter author name">

                <label for="genre">GENRE:</label>
                <select name="genre" required>
                    <option value="">-- Select Genre --</option>
                    <option value="Novel">Novel</option>
                    <option value="Educational">Educational</option>
                    <option value="Fiction">Fiction</option>
                    <option value="Non-Fiction">Non-Fiction</option>
                    <option value="Fantasy">Fantasy</option>
                    <option value="Science Fiction">Science Fiction</option>
                    <option value="Mystery">Mystery</option>
                    <option value="Thriller">Thriller</option>
                    <option value="Romance">Romance</option>
                    <option value="Biography">Biography</option>
                    <option value="Self-Help">Self-Help</option>
                    <option value="History">History</option>
                    <option value="Children">Children</option>
                    <option value="Young Adult">Young Adult</option>
                    <option value="Horror">Horror</option>
                    <option value="Adventure">Adventure</option>
                    <option value="Comics">Comics</option>
                    <option value="Poetry">Poetry</option>
                    <option value="Drama">Drama</option>
                </select>

                <label for="description">DESCRIPTION:</label>
                <textarea name="description" placeholder="Describe your book..." required></textarea>

                <label for="cndtn">CONDITION:</label>
                <select name="cndtn" required>
                    <option value="">-- Select Condition --</option>
                    <option value="New">New</option>
                    <option value="Like New">Like New</option>
                    <option value="Very Good">Very Good</option>
                    <option value="Good">Good</option>
                    <option value="Acceptable">Acceptable</option>
                    <option value="Poor">Poor</option>
                </select>

                <label for="image">COVER IMAGE:</label>
                <input type="file" name="image" accept="image/*" required>

                <label for="price">PRICE:</label>
                <input type="text" name="price" placeholder="eg. 200 or exchange" required>

                <div class="btn-wrapper">
                    <button type="submit" class="btn-sell">Sell</button>
                </div>
            </form>
        </div>
    </div>
    <script>

document.addEventListener("DOMContentLoaded", function() {

    var authorSelect = document.querySelector("select[name='author_id']");
    var manualInput = document.querySelector("input[name='manual_author']");

    manualInput.disabled = true;

    authorSelect.addEventListener("change", function() {

    
        if (authorSelect.value === "other") {
            manualInput.disabled = false;   
            manualInput.required = true;    
            manualInput.focus();            
        } 
        
        else {
            manualInput.value = "";         
            manualInput.disabled = true;    
            manualInput.required = false;   
        }
    });
});
</script>

</body>
</html>
