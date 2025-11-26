<?php
session_start();
include 'config.php';

if(isset($_SESSION['user_id']) && isset($_GET['id'])){
    $userid=$_SESSION['user_id'];
    $bookid=$_GET['id'];

    $sql=mysqli_query($con,"DELETE FROM cart WHERE bookid='$bookid' AND userid='$userid'");

}
header("Location:cart.php");
exit();

?>