<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$current_user_id = $_SESSION['user_id'];

$query = "
    SELECT DISTINCT 
        CASE 
            WHEN sender_id = $current_user_id THEN receiver_id
            ELSE sender_id
        END AS partner_id
    FROM chat
    WHERE sender_id = $current_user_id OR receiver_id = $current_user_id
    ORDER BY id DESC
";

$result = mysqli_query($con, $query);
$conversations = [];

while ($row = mysqli_fetch_assoc($result)) {
    $partner_id = $row['partner_id'];
    $res = mysqli_query($con, "SELECT username FROM user WHERE id = $partner_id");
    $user_data = mysqli_fetch_assoc($res);

    if ($user_data) {
        $conversations[] = [
            'partner_id' => $partner_id,
            'username' => $user_data['username']
        ];
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Your Inbox</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
            padding: 20px;
        }

        .inbox {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        .chat-link {
            display: block;
            padding: 12px;
            margin: 8px 0;
            background: #eaeaea;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
        }

        .chat-link:hover {
            background: #d6d6d6;
        }
    </style>
</head>

<body>

    <div class="inbox">
        <h2>📨 Your Inbox</h2>

        <?php if (empty($conversations)): ?>
            <p>No conversations yet.</p>
        <?php else: ?>
            <?php foreach ($conversations as $c): ?>
                <a class="chat-link" href="chat.php?receiver_id=<?= $c['partner_id'] ?>">
                    Chat with <?= htmlspecialchars($c['username']) ?>
                </a>

            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</body>

</html>