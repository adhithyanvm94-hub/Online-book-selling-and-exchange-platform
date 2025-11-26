<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$current_user_id = $_SESSION['user_id'];
$receiver_id = isset($_GET['receiver_id']) ? intval($_GET['receiver_id']) : 0;

$receiver_query = mysqli_query($con, "SELECT username FROM user WHERE id = $receiver_id");
$receiver = mysqli_fetch_assoc($receiver_query);
$receiver_name = $receiver ? $receiver['username'] : 'Unknown User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with <?= $receiver_name ?></title>
    <link rel="stylesheet" href="chat.css">
</head>
<body>
    <div class="chat-container">
        <div class="recievername">
            Chat with <?= $receiver_name ?>
        </div>

        <div class="chat-space">
            <?php
            $chat_query = "
                SELECT chat.*, user.username 
                FROM chat 
                JOIN user ON chat.sender_id = user.id 
                WHERE (chat.sender_id = $current_user_id AND chat.receiver_id = $receiver_id)
                   OR (chat.sender_id = $receiver_id AND chat.receiver_id = $current_user_id)
                ORDER BY chat.id ASC
            ";

            $result = mysqli_query($con, $chat_query);

            while ($row = mysqli_fetch_assoc($result)) {
                $class = ($row['sender_id'] == $current_user_id) ? 'sent' : 'received';
                echo "<div class='message $class'>" . $row['message'] . "</div>";
            }
            ?>
        </div>

        <div class="send-reply">
            <form action="send_message.php" method="post">
                <input type="hidden" name="receiver_id" value="<?= $receiver_id ?>">
                <input type="text" name="message" placeholder="Type your message..." required>
                <button type="submit">Send</button>
            </form>
        </div>
    </div>
</body>
</html>