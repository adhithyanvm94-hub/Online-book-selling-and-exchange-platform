<?php
session_start();
include "../config.php"; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../PHPMailer/PHPMailer.php';
require __DIR__ . '/../PHPMailer/SMTP.php';
require __DIR__ . '/../PHPMailer/Exception.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: adlogin.php");
    exit;
}

$page = $_GET['page'] ?? 'dashboard';
$userid = $_SESSION['user_id'];


$totalBooks = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM books"))['total'];
$totalUsers = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM user"))['total'];
$totalSales = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total_sold FROM books WHERE status='sold'"))['total_sold'];


$genres = ['Fiction', 'Non-Fiction', 'Drama', 'Children', 'Others'];
$genreCounts = [];
foreach($genres as $g){
    $res = mysqli_query($con, "SELECT COUNT(*) AS total FROM books WHERE genre='$g'");
    $genreCounts[$g] = mysqli_fetch_assoc($res)['total'] ?? 0;
}


$months = [];
$monthCounts = [];
for($m=1;$m<=12;$m++){
    $monthName = date('F', mktime(0,0,0,$m,1));
    $months[] = $monthName;
    $res = mysqli_query($con, "SELECT COUNT(*) AS total FROM books WHERE MONTH(created_at)=$m");
    $monthCounts[] = mysqli_fetch_assoc($res)['total'] ?? 0;
}


$userMonths = [];
$userCounts = [];
for ($i = 11; $i >= 0; $i--) {
    $month = date('Y-m', strtotime("-$i month"));
    $userMonths[] = date('M Y', strtotime($month));
    $res = mysqli_query($con, "SELECT COUNT(*) AS total FROM user WHERE DATE_FORMAT(created_at,'%Y-%m')='$month'");
    $userCounts[] = mysqli_fetch_assoc($res)['total'] ?? 0;
}



$admin = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM user WHERE id='$userid'"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="home.css" rel="stylesheet">
<link href="../buy.css" rel="stylesheet">


</head>
<body>

<div class="sidebar">
    <h2>Admin</h2>

   
    <div class="search-container">
        <form method="GET" action="admin.php">
            <input type="hidden" name="page" value="search">
            <input type="text" name="query" placeholder="Search books" required>
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>

    <div class="account-actions">
        <a href="?page=dashboard">Dashboard</a>
        <a href="?page=manageuser">Manage Users</a>
        <a href="?page=managebook">Manage Books</a>
        <a href="?page=addauthor">Add Author</a>
        <a href="?page=view_report">Reports</a>
        <a href="?page=adeditprofile">Edit Profile</a>
        <a href="?page=adotp">Change Password</a>
        <a href="?page=addelete">Delete Account</a>
    </div>
</div>


<div class="main-content">
<?php if($page=='dashboard'): ?>
<h1>Dashboard Overview</h1>
<div class="stats-cards">
    <div class="stat-card"><div class="stat-icon books-icon"><i class="fas fa-book"></i></div><div class="stat-info"><h3><?= $totalBooks ?></h3><p>Total Books</p></div></div>
    <div class="stat-card"><div class="stat-icon users-icon"><i class="fas fa-users"></i></div><div class="stat-info"><h3><?= $totalUsers ?></h3><p>Users</p></div></div>
    <div class="stat-card"><div class="stat-icon sales-icon"><i class="fas fa-dollar-sign"></i></div><div class="stat-info"><h3><?= $totalSales ?></h3><p>Total Sales</p></div></div>
</div>

<h2>Dashboard Charts</h2>
<div class="charts-wrapper" style="display:flex; gap:40px; flex-wrap:wrap; justify-content:center; align-items:flex-start;">
    
    <!-- Donut Chart -->
    <div class="chart-container" style="flex:1; min-width:300px; max-width:400px;">
        <h3 style="text-align:center;">Books Sold by Genre</h3>
        <canvas id="genreDonutChart"></canvas>
    </div>
    
    <!-- Bar Chart -->
    <div class="chart-container" style="flex:1; min-width:300px; max-width:400px; height:350px;">
        <h3 style="text-align:center;">Books Sold per Month</h3>
        <canvas id="booksMonthChart"></canvas>
    </div>
</div>
<div class="charts-wrapper" style="display:flex; gap:40px; flex-wrap:wrap; justify-content:center; align-items:flex-start; margin-top:40px;">
    <div class="chart-container" style="flex:1; min-width:300px; max-width:700px; height:350px;">
        <h3 style="text-align:center;">Users Joined per Month</h3>
        <canvas id="usersMonthChart"></canvas>
    </div>
</div>
<a href="download_report.php?type=users" class="btn accept">Download Users</a>
<a href="download_report.php?type=books" class="btn accept">Download Books</a>
<script>
// Donut chart
const ctx1 = document.getElementById('genreDonutChart').getContext('2d');
new Chart(ctx1, {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($genres) ?>,
        datasets: [{
            data: <?= json_encode(array_values($genreCounts)) ?>,
            backgroundColor: ['#4a6fa5','#28a745','#ff6b6b','#ffc107','#6d98ba']
        }]
    },
    options: { responsive:true, plugins:{ legend:{ position:'bottom' } } }
});

// Bar chart
const ctx2 = document.getElementById('booksMonthChart').getContext('2d');
new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: <?= json_encode($months) ?>,
        datasets: [{
            label: 'Books Sold',
            data: <?= json_encode($monthCounts) ?>,
            backgroundColor: '#4a6fa5'
        }]
    },
    options: {
        responsive:true,
        maintainAspectRatio: false,
        plugins: { legend:{ display:false } },
        scales: { y: { beginAtZero:true } }
    }
});
// Users per Month chart
const ctx3 = document.getElementById('usersMonthChart').getContext('2d');
new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: <?= json_encode($userMonths) ?>,
        datasets: [{
            label: 'Users Joined',
            data: <?= json_encode($userCounts) ?>,
            backgroundColor: '#28a745'
        }]
    },
    options: {
        responsive:true,
        maintainAspectRatio:false,
        plugins: { legend:{ display:false } },
        scales: { y: { beginAtZero:true } }
    }
});
</script>


<?php
elseif($page=='manageuser'):
    
    if(isset($_POST['action']) && isset($_POST['user_id'])){
        $user_id = intval($_POST['user_id']);
        $action = $_POST['action'];

        if($action == 'accept'){
            mysqli_query($con, "UPDATE user SET status='accepted' WHERE id=$user_id");
            echo "<p style='color:green;'>User accepted successfully!</p>";
        } elseif($action == 'reject'){
            mysqli_query($con, "UPDATE user SET status='rejected' WHERE id=$user_id");
            echo "<p style='color:orange;'>User rejected successfully!</p>";
        } elseif($action == 'delete'){
            mysqli_query($con, "DELETE FROM user WHERE id=$user_id");
            echo "<p style='color:red;'>User deleted successfully!</p>";
        }
    }

    $statuses = ['pending'=>'Pending Users','accepted'=>'Accepted Users','rejected'=>'Rejected Users'];
    foreach($statuses as $statusKey=>$statusTitle):
        $users = mysqli_query($con, "SELECT * FROM user WHERE status='$statusKey'");
        echo "<h2>$statusTitle</h2>";
        if(mysqli_num_rows($users)>0):
            echo "<div class='page-container manage-users'>";
            echo "<table>
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Username</th>
                      <th>Email</th>
                      <th>ID Proof</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>";
            while($u=mysqli_fetch_assoc($users)):
                $proofPath = !empty($u['id_proof']) ? "../uploads/".$u['id_proof'] : "";
                echo "<tr>
                      <td>{$u['id']}</td>
                      <td>{$u['username']}</td>
                      <td>{$u['email']}</td>
                      <td>";
                if($proofPath) echo "<a href='$proofPath' target='_blank'>View</a>";
                else echo "Not Provided";
                echo "</td><td>";

                
                if($statusKey=='pending'){
                    echo "<form method='post' style='display:inline;' onsubmit='return confirm(\"Accept this user?\");'>
                            <input type='hidden' name='user_id' value='{$u['id']}'>
                            <input type='hidden' name='action' value='accept'>
                            <button type='submit' class='btn accept'>Accept</button>
                          </form> ";

                    echo "<form method='post' style='display:inline;' onsubmit='return confirm(\"Reject this user?\");'>
                            <input type='hidden' name='user_id' value='{$u['id']}'>
                            <input type='hidden' name='action' value='reject'>
                            <button type='submit' class='btn reject'>Reject</button>
                          </form> ";
                }

                
                echo "<form method='post' style='display:inline;' onsubmit='return confirm(\"Delete this user?\");'>
                        <input type='hidden' name='user_id' value='{$u['id']}'>
                        <input type='hidden' name='action' value='delete'>
                        <button type='submit' class='btn delete'>Delete</button>
                      </form>";

                echo "</td></tr>";
            endwhile;
            echo "</tbody></table></div>";
        else: 
            echo "<p style='text-align:center; margin-top:20px;'>No $statusTitle found.</p>";
        endif;
    endforeach;


elseif($page=='managebook'):
    
    if(isset($_POST['delete_id'])){
        $book_id = intval($_POST['delete_id']);
        mysqli_query($con, "DELETE FROM books WHERE bookid=$book_id");
        echo "<p style='color:green;'>Book deleted successfully!</p>";
    }
$books = mysqli_query($con, "
    SELECT b.*, u.username, a.name AS author_name
    FROM books b
    JOIN user u ON b.userid = u.id
    LEFT JOIN authors a ON b.author_id = a.author_id
");





    echo "<h2>Manage Books</h2>";
    echo "<div class='page-container manage-users'>";
    echo "<table>
          <thead>
            <tr>
              <th>Title</th>
              <th>Author</th>
              <th>Price</th>
              <th>Genre</th>
              <th>Seller</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>";
    while($b=mysqli_fetch_assoc($books)):
        echo "<tr>
              <td>{$b['title']}</td>
              <td>{$b['author_name']}</td>
              <td>{$b['price']}</td>
              <td>{$b['genre']}</td>
              <td>{$b['username']}</td>
              <td>
                <form method='post' style='display:inline;' onsubmit='return confirm(\"Delete this book?\");'>
                    <input type='hidden' name='delete_id' value='{$b['bookid']}'>
                    <button type='submit' class='btn delete'>Delete</button>
                </form>
              </td>
              </tr>";
    endwhile;
    echo "</tbody></table></div>";



elseif($page=='addauthor'):

$authors = mysqli_query($con, "SELECT * FROM authors ORDER BY author_id DESC");

if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $author = mysqli_fetch_assoc(mysqli_query($con,"SELECT image FROM authors WHERE author_id=$id"));
    if($author && !empty($author['image']) && $author['image'] != 'default-author.png'){
        @unlink("../authors/" . $author['image']);
    }
    mysqli_query($con,"DELETE FROM authors WHERE author_id=$id");
    echo "<script>window.location.href='admin.php?page=addauthor';</script>";
}


if(isset($_POST['add_author'])){
    $name = mysqli_real_escape_string($con,$_POST['name']);
    $bio  = mysqli_real_escape_string($con,$_POST['bio']);
    $featured_until = date('Y-m-d H:i:s', strtotime('+2 hour')); // featured time

    $photoName = 'default-author.png';
    if(isset($_FILES['image']) && $_FILES['image']['error']==0){
        $uploadDir = "../authors/";
        if(!is_dir($uploadDir)) mkdir($uploadDir,0755,true);
        $filename = str_replace(' ','_',basename($_FILES['image']['name']));
        $photoName = time().'_'.$filename;
        move_uploaded_file($_FILES['image']['tmp_name'],$uploadDir.$photoName);
        $photoName = mysqli_real_escape_string($con,$photoName);
    }

    mysqli_query($con,"INSERT INTO authors(name,bio,image,featured_until) VALUES('$name','$bio','$photoName','$featured_until')");
    $success = "Author added successfully!";
}


$author_data = null;
if(isset($_GET['edit'])){
    $edit_id = intval($_GET['edit']);
    $author_data = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM authors WHERE author_id=$edit_id"));
}


if(isset($_POST['update_author'])){
    $id   = intval($_POST['id']);
    $name = mysqli_real_escape_string($con,$_POST['name']);
    $bio  = mysqli_real_escape_string($con,$_POST['bio']);
    $set_image = "";

    if(isset($_FILES['image']) && $_FILES['image']['error']==0){
        $uploadDir = "../authors/";
        if(!is_dir($uploadDir)) mkdir($uploadDir,0755,true);
        $filename = str_replace(' ','_',basename($_FILES['image']['name']));
        $photoName = time().'_'.$filename;
        move_uploaded_file($_FILES['image']['tmp_name'],$uploadDir.$photoName);
        $photoName = mysqli_real_escape_string($con,$photoName);
        $set_image = ", image='$photoName'";
    }

    $featured_until = date('Y-m-d H:i:s', strtotime('+2 hour')); // update featured
    mysqli_query($con,"UPDATE authors SET name='$name', bio='$bio' $set_image, featured_until='$featured_until' WHERE author_id=$id");
    echo "<script>window.location.href='admin.php?page=addauthor';</script>";
}
?>

<div class="page-container">

    <?php if(isset($success)) echo "<p class='msg success'>$success</p>"; ?>

    
    <div class="author-form-container">
        <h2><?= isset($author_data) ? 'Edit Author' : 'Add Author' ?></h2>
        <form method="post" enctype="multipart/form-data" class="form-box">
            <input type="hidden" name="id" value="<?= $author_data['author_id'] ?? '' ?>">

            <input type="text" name="name" placeholder="Author Name" value="<?= $author_data['name'] ?? '' ?>" required>
            <textarea name="bio" placeholder="Short Bio" required><?= $author_data['bio'] ?? '' ?></textarea>
            <input type="file" name="image">

            <?php if(!empty($author_data['image'])): ?>
                <div class="image-preview">
                    <img src="../authors/<?= $author_data['image'] ?>" alt="Author Image" width="80">
                </div>
            <?php endif; ?>

            <button type="submit" name="<?= isset($author_data) ? 'update_author' : 'add_author' ?>" class="btn <?= isset($author_data) ? 'accept' : 'add-btn' ?>">
                <?= isset($author_data) ? 'Update Author' : 'Add Author' ?>
            </button>
        </form>
    </div>

    <hr>

    <table class="manage-users">
        <thead>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Bio</th>
                <th>Featured Until</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($a = mysqli_fetch_assoc($authors)):
                $photo_path = "../authors/" . ($a['image'] ?? 'default-author.png');
                if(!file_exists($photo_path)) $photo_path = "../authors/default-author.png";
                $now = date('Y-m-d H:i:s');
                $is_featured = ($a['featured_until'] > $now) ? '✅' : '';
            ?>
            <tr>
                <td><?= $a['author_id'] ?></td>
                <td><img src="<?= $photo_path ?>" width="50" style="border-radius:5px;"></td>
                <td><?= htmlspecialchars($a['name']) ?></td>
                <td><?= htmlspecialchars(substr($a['bio'],0,50)) ?>...</td>
                <td><?= htmlspecialchars($a['featured_until']) ?> <?= $is_featured ?></td>
                <td>
                    <a href="?page=addauthor&edit=<?= $a['author_id'] ?>" class="btn accept">Edit</a>
                    <a href="?page=addauthor&delete=<?= $a['author_id'] ?>" class="btn delete" onclick="return confirm('Delete this author?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>



<?php
elseif($page == 'view_report'):
    $sql = "SELECT r.id, r.reason, r.details, u.username AS reporter, s.username AS seller 
            FROM reports r 
            JOIN user u ON r.user_id = u.id 
            JOIN user s ON r.seller_id = s.id 
            ORDER BY r.id DESC";
    $result = mysqli_query($con, $sql);
    echo "<h2>Reported Sellers</h2>";
    echo "<div class='page-container manage-users'>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Reporter</th>
                        <th>Seller</th>
                        <th>Reason</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>";
    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['reporter']}</td>
                    <td>{$row['seller']}</td>
                    <td>{$row['reason']}</td>
                    <td>{$row['details']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5' style='text-align:center;'>No reports found ✅</td></tr>";
    }
    echo "</tbody></table></div>";








elseif($page=='adeditprofile'):

    $admin_id = $_SESSION['user_id'];
    $query = "SELECT * FROM admin WHERE admin_id='$admin_id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    if(isset($_POST['update'])){
        $username = $_POST['username'];
        $email    = $_POST['email'];
        $phone    = $_POST['phone'];
        

        $update_query = "UPDATE admin SET username='$username', email='$email', phone='$phone' WHERE admin_id='$admin_id'";

        if(mysqli_query($con,$update_query)){
            $success = "✅ Profile updated successfully!";
            $_SESSION['username'] = $username;
            $row['username']=$username; $row['email']=$email; $row['phone']=$phone; 
        } else { $error="❌ Error updating profile: ".mysqli_error($con); }
    }
?>
    <div class="edit-profile">
        <h2>Edit Profile</h2>
        <?php if(isset($success)) echo "<p class='msg success'>$success</p>"; ?>
        <?php if(isset($error)) echo "<p class='msg error'>$error</p>"; ?>
        <form method="POST">
            <label>👤 Name:</label><br>
            <input type="text" name="username" value="<?= $row['username'] ?>" required><br><br>

            <label>📧 Email:</label><br>
            <input type="email" name="email" value="<?= $row['email'] ?>" required><br><br>

            <label>📞 Phone:</label><br>
            <input type="text" name="phone" value="<?= $row['phone'] ?>" required><br><br>

            <input type="submit" name="update" value="Update Profile">
            <a href="dashboard.php?page=dashboard" class="back-home">⬅️ Back to Home</a>
        </form>
    </div>
<?php

elseif($page=='adotp'):

    $error = "";

    if($_SERVER['REQUEST_METHOD']=="POST"){
        $email = $_POST['email'];
        $otp = rand(100000,999999);

        if(empty($email)){
            $error = "⚠️ Email is required!";
        } else {
            $check = mysqli_query($con,"SELECT * FROM admin WHERE email='$email'");
            if(mysqli_num_rows($check)>0){
                mysqli_query($con,"UPDATE admin SET otp='$otp' WHERE email='$email'");

                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host='smtp.gmail.com';
                $mail->SMTPAuth=true;
                $mail->Username='booklin205@gmail.com';
                $mail->Password='jedw rstb uobh wejo';
                $mail->SMTPSecure='tls';
                $mail->Port=587;

                $mail->setFrom('booklin205@gmail.com','Booklin');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject='Your OTP Code';
                $mail->Body="<p>Use this OTP to reset your password: <b>$otp</b></p>";

                if($mail->send()){
                    $_SESSION['reset_email']=$email;
                    echo "<script>alert('✅ OTP sent to your email.'); window.location.href='adresetpass.php';</script>";
                } else { $error="❌ Mailer Error: ".$mail->ErrorInfo; }
            } else { $error="❌ Email not found!"; }
        }
    }
?>
<link rel="stylesheet" href="../style.css"/>
<style>
    body{margin: 0;padding: 0%;}
    .container{ margin-top: 200px;}
</style>

    <div class="container">
        <div class="form-box">
            <h2>Forgot Password</h2>
            <?php if(!empty($error)) echo "<p style='color:red;text-align:center;'>$error</p>"; ?>
            <form method="post">
                <div class="input-group">
                    <label for="email">Enter your Email:</label>
                    <input type="email" name="email" required>
                </div>
                <button type="submit" class="register-btn">Send OTP</button>
            </form>
            <p class="login-link"><a href="adlogin.php">⬅ Back to Login</a></p>
        </div>
        <div class="image">
            <img src="../login-sticker.png" alt="Login image">
        </div>
    </div>
<?php

elseif($page == 'search'):
    $query = mysqli_real_escape_string($con, $_GET['query'] ?? '');
    echo "<h2>Search Results for '<em>$query</em>'</h2>";

    
    $books = mysqli_query($con, "
        SELECT b.*, a.name AS author_name 
        FROM books b
        LEFT JOIN authors a ON b.author_id = a.author_id
        WHERE b.title LIKE '%$query%' OR a.name LIKE '%$query%'
    ");

    if (mysqli_num_rows($books) > 0) {
        echo "<div class='card-container'>";
        while ($b = mysqli_fetch_assoc($books)) {
            $bookid = htmlspecialchars($b['bookid']);
            $title = htmlspecialchars($b['title']);
            $author = htmlspecialchars($b['author_name'] ?? 'Unknown');
            $description = htmlspecialchars($b['description']);
            $image = htmlspecialchars($b['image']);
            $price = htmlspecialchars($b['price']);

            echo "
            <div class='card'>
                <div class='card-itm'>
                    <h4>$title</h4>
                    <img src='/booklin/uploads/$image' alt='$title'>
                    <p><strong>Author:</strong> $author</p>
                    <p>$description</p>
                    <p><strong>₹$price</strong></p>
                    <div class='btn-container'>
                        <a href='addetails.php?id=$bookid' class='card-btn'>View More</a>
                    </div>
                </div>
            </div>";
        }
        echo "</div>";
    } else {
        echo "<p>No books found for '<em>$query</em>'.</p>";
    }

elseif($page=='addelete'):
    echo "<h1>Delete Account</h1>
          <p>Warning: This will delete your admin account permanently.</p>
          <a href='addelete.php?id={$userid}' onclick='return confirm(\"Delete your account?\")'>Delete Account</a>";

else:
    echo "<h1>Page not found</h1>";
endif;
?>
</div>


</body>
</html>
