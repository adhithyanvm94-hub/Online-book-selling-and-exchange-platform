<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

$seller_id = $_SESSION['user_id'];

$query = "SELECT r.id, r.details, r.reason, u.username AS reported_by
          FROM reports r
          JOIN user u ON r.user_id = u.id
          WHERE r.seller_id = '$seller_id'
          ORDER BY r.id DESC";

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reports Received</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body {
    margin:0;
    font-family: 'Poppins', sans-serif;
    background:#f4f6f9;
}

.my-books {
    padding: 40px;
    margin-top: 60px;
}

.my-books h1 {
    margin-bottom: 20px;
    color: #333;
}

.my-books table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-radius: 12px;
    overflow: hidden;
}

.my-books thead {
    background: rgb(192, 163, 125);
    color: #0b0a0a;
}

.my-books thead th {
    padding: 14px;
    text-align: left;
    font-size: 17px;
}

.my-books tbody td {
    padding: 12px 14px;
    border-bottom: 1px solid #e5e5e5;
    font-size: 14px;
    color: #333;
}

.my-books tbody tr:nth-child(even) {
    background: #f9f9f9;
}

.my-books tbody tr:hover {
    background: #eef4fc;
}

.my-books td a {
    text-decoration: none;
    color: #4a90e2;
    font-weight: bold;
    padding: 6px 10px;
    border: 1px solid #4a90e2;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.my-books td a:hover {
    background: #4a90e2;
    color: #fff;
}
</style>
</head>
<body>
<?php include 'nav.php';?>
<div class="my-books">
    <h1>Reports Received</h1>

    <?php if(mysqli_num_rows($result) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Details</th>
                <th>Reason</th>
                <th>Reported By</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1; ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $count++; ?></td>
                <td><?= htmlspecialchars($row['details']); ?></td>
                <td><?= htmlspecialchars($row['reason']); ?></td>
                <td><?= htmlspecialchars($row['reported_by']); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p style="text-align:center; padding: 20px;">No reports received yet.</p>
    <?php endif; ?>
</div>

</body>
</html>
