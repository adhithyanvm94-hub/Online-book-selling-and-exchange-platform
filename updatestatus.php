<?php
session_start();
include "config.php";
include "opfn/nav.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userid = $_SESSION['user_id'];

if (isset($_POST['update_status'])) {
    foreach ($_POST['status'] as $bookid => $status) {
        $bookid = intval($bookid);
        $status = mysqli_real_escape_string($con, $status);
        mysqli_query($con, "UPDATE books SET status='$status' WHERE bookid='$bookid' AND userid='$userid'");
    }
    $msg = "Book status updated!";
}

$sql = mysqli_query($con, "SELECT * FROM books WHERE userid='$userid'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Update Book Status</title>
  <link href="manage.css" rel="stylesheet">
<script>
function confirmChange(select) {
    if (!confirm("Are you sure you want to change the status to '" + select.value + "'?")) {
        select.selectedIndex = 0; 
    }
}
</script>
</head>
<body>
        <div class="my-books">
<h2>Your Books</h2>
<?php if (!empty($msg)) echo "<p style='color:green;'>$msg</p>"; ?>

<form method="POST">
<table border="1" cellpadding="8" cellspacing="0">
<thead>
<tr>
<th>Title</th>
<th>Author</th>
<th>Price</th>
<th>Image</th>
<th>Status</th>
</tr>
</thead>
<tbody>
<?php
if (mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_assoc($sql)) {
        echo "<tr>
            <td>{$row['title']}</td>
            <td>{$row['author']}</td>
            <td>{$row['price']}</td>
            <td><img src='uploads/{$row['image']}' width='80'></td>
            <td>
                <select name='status[{$row['bookid']}]' onchange='confirmChange(this)'>
                    <option value='Available' ".($row['status']=='Available'?'selected':'').">Available</option>
                    <option value='Sold' ".($row['status']=='Sold'?'selected':'').">Sold</option>
                </select>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No books found.</td></tr>";
}
?>
</tbody>
</table>
<br>
<button type="submit" name="update_status">Update</button>
</form></div>
</body>
</html>
