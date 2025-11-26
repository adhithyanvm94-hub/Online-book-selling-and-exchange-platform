<?php
include "config.php";
if (isset($_GET['id'])) {
    $bookid = $_GET['id'];
    $query = "DELETE FROM books WHERE bookid = $bookid";
    if (mysqli_query($con, $query)) {
        header("Location: account.php");
        exit;
    } else {
        echo "Error deleting book: " . mysqli_error($con);
    }
} else {
    echo "No Book ID provided.";
}
?>
