<?php
include "config.php";

$author_id = $_GET['id'] ?? 0;

$authorQuery = mysqli_query($con, "SELECT * FROM authors WHERE author_id=$author_id");
$author = mysqli_fetch_assoc($authorQuery);

$booksQuery = mysqli_query($con, "
    SELECT * FROM books 
    WHERE author_id=$author_id
");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($author['name']) ?> - Author Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 10%;
        }

        .page-header {
            background: #2c3e50;
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-back {
            color: white;
            text-decoration: none;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: opacity 0.3s;
        }

        .btn-back:hover {
            opacity: 0.8;
        }

        .author-profile {
            padding: 40px 30px;
            border-bottom: 1px solid #eaeaea;
        }

        .author-header {
            display: flex;
            align-items: flex-start;
            gap: 30px;
            margin-bottom: 30px;
        }

        .author-image {
            flex-shrink: 0;
            width: 200px;
            height: 200px;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .author-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .author-info {
            flex: 1;
        }

        .author-name {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .section-title {
            font-size: 24px;
            color: #2c3e50;
            margin: 30px 0 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eaeaea;
        }

        .author-bio {
            font-size: 16px;
            line-height: 1.7;
            color: #555;
        }

        .author-books {
            padding: 30px;
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }

        .book-item {
            display: flex;
            flex-direction: column;
            background: #f8f9fa;
            border-radius: 6px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #eaeaea;
        }

        .book-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .book-image {
            height: 200px;
            overflow: hidden;
        }

        .book-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .book-item:hover .book-image img {
            transform: scale(1.05);
        }

        .book-details {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .book-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .book-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .book-price {
            font-size: 18px;
            font-weight: 600;
            color: #e74c3c;
            margin-bottom: 15px;
        }

        .book-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            text-align: center;
            transition: all 0.3s;
            flex: 1;
        }

        .btn-primary {
            background: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background: #2980b9;
        }

        .btn-secondary {
            background: #2ecc71;
            color: white;
        }

        .btn-secondary:hover {
            background: #27ae60;
        }

        .no-books {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
            font-style: italic;
        }

        .view-all {
            display: block;
            text-align: center;
            margin-top: 30px;
        }

        .view-all-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #2c3e50;
            color: white;
            padding: 12px 25px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.3s;
        }

        .view-all-link:hover {
            background: #1a252f;
        }

        @media(max-width:768px) {
            .author-header {
                flex-direction: column;
                text-align: center;
            }

            .author-image {
                align-self: center;
            }

            .books-grid {
                grid-template-columns: 1fr;
            }

            .book-actions {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <?php include 'nav.php' ?>
    <div class="container">
        <div class="page-header">
            <h1>Author Profile</h1>
            <a href="home.php" class="btn-back">← Back to Home</a>
        </div>

        <div class="author-profile">
            <div class="author-header">
                <div class="author-image">
                    <img src="authors/<?= htmlspecialchars($author['image']) ?>" alt="<?= htmlspecialchars($author['name']) ?>">
                </div>
                <div class="author-info">
                    <h2 class="author-name"><?= htmlspecialchars($author['name']) ?></h2>
                    <h3 class="section-title">Bio</h3>
                    <p class="author-bio">
                        <?= !empty($author['bio']) ? nl2br(htmlspecialchars($author['bio'])) : "No biography available." ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="author-books">
            <h3 class="section-title">Books by <?= htmlspecialchars($author['name']) ?></h3>

            <?php if (mysqli_num_rows($booksQuery) > 0): ?>
                <div class="card-container">
                    <?php
                    while ($row = mysqli_fetch_assoc($booksQuery)) {
                        $bookid = $row['bookid'];
                        $title = htmlspecialchars($row['title']);
                        $description = htmlspecialchars($row['description']);
                        $image = htmlspecialchars($row['image']);
                        if (is_numeric($row['price'])) {
                            $price = "" . number_format((float)$row['price'], 2);
                        } else {
                            $price = htmlspecialchars($row['price']);
                        }

                        echo "
                <div class='card'>
                    <div class='card-itm'>
                        <h4>$title</h4>
                        <img src='uploads/$image' alt='$title'>
                        <p>$description</p>
                        <div class='price'>₹$price</div>
                        <div class='btn-container'>
                            <a href='details.php?id=$bookid' class='card-btn'>View More</a>
                            <a href='addtocart.php?id=$bookid' class='card-btn'>Add to Cart</a>
                        </div>
                    </div>
                </div>";
                    }
                    ?>
                </div>
            <?php else: ?>
                <div class="no-books">No books available for this author.</div>
            <?php endif; ?>

            <div class="view-all">
                <a href="buy.php?author=<?= $author_id ?>" class="view-all-link">
                    View All Books <i class="fa-solid fa-right-long"></i>
                </a>
            </div>
        </div>



        <style>
            .card-container {
                display: flex;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                width: auto;
                gap: 70px;
                padding: 20px;
                align-items: center;
                margin-left: 25px;
                margin-bottom: 150px;
                background: linear-gradient(135deg, #f3f4f7, #e7f7e8);
            }

            .card {
                width: 300px;
                height: 600px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                display: flex;
                align-items: center;
                justify-content: center;
                margin-left: 10px;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                border-radius: 12px;
                background: #fff;
            }


            .card:hover {
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
                transform: translateY(-15px);
            }

            .card-itm {
                padding: 16px;
            }

            .card-itm img {
                width: 100%;
                height: 300px;

            }

            .card-itm p {
                overflow: hidden;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;

            }

            .card-btn {
                flex: 1;
                padding: 10px 15px;
                background-color: rgb(192, 163, 125);
                color: white;
                border-radius: 5px;
                text-decoration: none;
                text-align: center;
                font-size: 16px;
                font-weight: 500;
                display: inline-block;
                cursor: pointer;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .card-btn:hover {

                background-color: #b30000;
                transform: scale(1.05);
                /* slight zoom */

            }

            .btn-container {
                display: flex;
                justify-content: space-between;
                gap: 10px;
                margin-top: 10px;
            }
        </style>