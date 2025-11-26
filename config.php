<?php
$host='localhost';
$user='root';
$pass='';
$dbname='booklin';
$con=mysqli_connect($host,$user,$pass,$dbname);
if(!$con){
    die("connection failed:".mysqli_connect_error($con));
}
?>