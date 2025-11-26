<?php
session_start();
include 'config.php';
include 'nav.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM user WHERE id='$user_id'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$dpFile = $row['profile_pic'] ?? '';
$initial = strtoupper($row['username'][0] ?? 'U');
$isLetter = empty($dpFile) || !file_exists("uploads/profile/" . $dpFile);
$dpPath = $isLetter ? '' : "uploads/profile/$dpFile";

if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    
    $profilePic = $row['profile_pic'];

    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $targetDir = "uploads/profile/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $imageName = time() . "_" . basename($_FILES["profile_pic"]["name"]);
        $targetFile = $targetDir . $imageName;

        if (getimagesize($_FILES["profile_pic"]["tmp_name"]) !== false &&
            move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetFile)) {
            $profilePic = $imageName;
            $dpPath = $targetFile;
            $isLetter = false;
        }
    }

    $updateQuery = "UPDATE user SET username='$name', email='$email', phno='$phone',  profile_pic='$profilePic' WHERE id='$user_id'";
    if (mysqli_query($con, $updateQuery)) {
        $success = "Profile updated successfully!";
        $row['username'] = $name;
        $row['email'] = $email;
        $row['phno'] = $phone;
        
        $row['profile_pic'] = $profilePic;
    } else {
        $error = "Error updating profile: " . mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Profile</title>
<link rel="stylesheet" href="editprofile.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
<div class="edit-profile">
    <h2>Edit Profile</h2>
    <?php if(isset($success)) echo "<p class='msg success'>$success</p>"; ?>
    <?php if(isset($error)) echo "<p class='msg error'>$error</p>"; ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <div class="profile-pic" id="profile-pic">
            <?php if($isLetter): ?>
                <?= $initial ?>
            <?php else: ?>
                <img id="preview" src="<?= $dpPath ?>" alt="User DP">
            <?php endif; ?>
            <label for="dp-upload" class="edit-icon">
                <i class="fa-regular fa-pen-to-square"></i>
            </label>
        </div>
        <input type="file" name="profile_pic" id="dp-upload" style="display:none;" accept="image/*" onchange="previewImage(event)">

        <label>👤 Name:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($row['username']) ?>" required><br><br>

        <label>📧 Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" required><br><br>

        <label>📞 Phone:</label><br>
        <input type="text" name="phone" value="<?= htmlspecialchars($row['phno']) ?>" required><br><br>

  

        <input type="submit" name="update" value="Update Profile">
        <a href="home.php" class="back-home">⬅️ Back to Home</a>
    </form>
</div>

<script>
function previewImage(event) {
    const dpDiv = document.getElementById('profile-pic');
    const initial = dpDiv.querySelector('div');
    if(initial) initial.remove();

    let img = dpDiv.querySelector('img');
    if(!img) {
        img = document.createElement('img');
        img.id = 'preview';
        dpDiv.prepend(img);
    }
    const reader = new FileReader();
    reader.onload = function(){
        img.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
</body>
</html>
