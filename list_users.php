<?php
include 'config.php';

$sort = $_GET['sort'] ?? 'all';
$place = $_GET['place'] ?? '';

if ($sort == 'books') {
    $order = "book_count DESC";
} elseif ($sort == 'feedback') {
    $order = "avg_rating DESC, book_count DESC";
} else {
    $order = "u.username ASC";
}

$places = mysqli_query($con, "SELECT district_name FROM place ORDER BY district_name ASC");

$sql = "
    SELECT 
        u.id, 
        u.username, 
        u.email, 
        u.profile_pic, 
        u.city AS place,
        COUNT(DISTINCT b.bookid) AS book_count,
        IFNULL(AVG(f.rating), 0) AS avg_rating
    FROM user u
    LEFT JOIN books b ON u.id = b.userid
    LEFT JOIN feedback f ON u.id = f.seller_id
";

if ($place != '') {
    $sql .= " WHERE u.city = '" . mysqli_real_escape_string($con, $place) . "'";
}

$sql .= " GROUP BY u.id ORDER BY $order";

$result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Top Sellers</title>
    <link rel="stylesheet" href="list_users.css">
</head>
<body>
    <style>
        .filter-form {
            background: #f9f9f9;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .filter-form label {
            margin-right: 10px;
            font-weight: bold;
            font-size: 14px;
        }

        .filter-form select {
            padding: 5px 8px;
            margin-right: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .filter-form button {
            padding: 5px 12px;
            background: #007bff;
            border: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }

        .filter-form button:hover {
            background: #0056d2;
        }
    </style>
<?php include 'nav.php'; ?>

<div class="main-content">
    <h1>Top Sellers</h1>

    <form method="GET" class="filter-form">
        <label>Sort By:
            <select name="sort">
                <option value="all" <?= $sort == 'all' ? 'selected' : '' ?>>All Users</option>
                <option value="books" <?= $sort == 'books' ? 'selected' : '' ?>>Books Listed</option>
                <option value="feedback" <?= $sort == 'feedback' ? 'selected' : '' ?>>Feedback</option>
            </select>
        </label>

        <label>Place:
            <select name="place">
                <option value="">All Places</option>
                <?php while ($p = mysqli_fetch_assoc($places)) { ?>
                    <option value="<?= htmlspecialchars($p['district_name']) ?>"
                        <?= $place == $p['district_name'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($p['district_name']) ?>
                    </option>
                <?php } ?>
            </select>
        </label>

        <button type="submit">Filter</button>
    </form>

    <div class="container">
        <?php if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $dp = $row['profile_pic'];
                $img = (!empty($dp) && file_exists("uploads/profile/$dp"))
                    ? "uploads/profile/$dp"
                    : "";
                $initial = strtoupper($row['username'][0]);
        ?>
                <a href="seller_profile.php?id=<?= $row['id'] ?>" class="card">
                    <div class="profile-pic-wrapper">
                        <?php if ($img): ?>
                            <img src="<?= $img ?>" alt="Profile" class="profile-pic">
                        <?php else: ?>
                            <div class="profile-pic initial"><?= $initial ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="username"><?= htmlspecialchars($row['username']) ?></div>
                    <div class="email"><?= htmlspecialchars($row['email']) ?></div>
                    <div class="count">Books: <?= $row['book_count'] ?></div>
                    <div class="place">Place: <?= htmlspecialchars($row['place']) ?></div>
                </a>
            <?php }
        } else { ?>
            <p>No users found.</p>
        <?php } ?>
    </div>
</div>

</body>
</html>
