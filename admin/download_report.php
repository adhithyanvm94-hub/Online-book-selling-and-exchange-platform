<?php
include "../config.php"; 

$type = $_GET['type'] ?? '';

if($type == 'users') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=users.csv');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['ID', 'Username', 'Email', 'Status', 'ID Proof']);

    $result = mysqli_query($con, "SELECT * FROM user");
    while($row = mysqli_fetch_assoc($result)) {
        $id_proof = !empty($row['id_proof']) ? $row['id_proof'] : 'Not Provided';
        fputcsv($output, [$row['id'], $row['username'], $row['email'], $row['status'], $id_proof]);
    }
    fclose($output);
    exit();
}
elseif($type == 'books') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=books.csv');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Book ID', 'Title', 'Author', 'Price', 'Genre', 'Seller', 'Status']);

    $result = mysqli_query($con, "SELECT b.bookid, b.title, b.author, b.price, b.genre, u.username AS seller, b.status 
                                 FROM books b 
                                 JOIN user u ON b.userid=u.id");
    while($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, [$row['bookid'], $row['title'], $row['author'], $row['price'], $row['genre'], $row['seller'], $row['status']]);
    }
    fclose($output);
    exit();
}
else {
    echo "Invalid report type.";
}
?>