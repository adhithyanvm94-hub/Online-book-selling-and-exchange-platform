<?php
session_start();
include 'config.php';
if(!isset($_SESSION['userid'])){
   header("Location:login.php");
   

}

$userid = $_SESSION['user_id'];
if(isset($_GET['id'])){
    $bookid=$_GET['id'];

    $check=mysqli_query($con,"SELECT * FROM cart WHERE userid=$userid AND bookid=$bookid");
    if(mysqli_num_rows($check)==0){
        $sql=mysqli_query($con,"INSERT INTO cart (userid,bookid) VALUES ('$userid','$bookid')");
    }
}
header("Location:cart.php");
?>