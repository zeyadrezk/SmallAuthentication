<?php
$dsn="localhost";
$userDb="root";
$passwordDb = "";
$DbN = "authentication";

$conn = mysqli_connect($dsn,$userDb,$passwordDb);
if(empty($conn)){
    echo mysqli_connect_error($conn);
}
$sql = "CREATE DATABASE IF NOT EXISTS $DbN";
$result = mysqli_query($conn,$sql);
mysqli_close($conn);


$conn = mysqli_connect($dsn,$userDb,$passwordDb,$DbN);
if(empty($conn)){
    echo mysqli_connect_error($conn);
}
$sql ="CREATE TABLE IF NOT EXISTS `USER` (
    id INT PRIMARY KEY AUTO_INCREMENT ,
    `name` VARCHAR(25)NOT NULL,
    `email` VARCHAR(30) NOT NULL,
    `password` VARCHAR(40) NOT NULL ,
    `confirmPassword` varchar(40) NOT NULL
)";
$result = mysqli_query($conn,$sql);
mysqli_close($conn);




