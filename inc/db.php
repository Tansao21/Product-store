<?php 
$host = 'localhost';
$user = 'root';
$password = '';

if (!isset($_SESSION['isDb']) or $_SESSION['isDb'] == false) {
  $con = mysqli_connect($host,$user,$password,null) or die ('Connect error');
} else {
  $con = mysqli_connect($host,$user,$password,'product-store') or mysqli_connect($host,$user,$password,null);
}

$query = 'CREATE DATABASE IF NOT EXISTS `product-store`';
$isDb = mysqli_select_db($con,'product-store');
if ($isDb == false) {
  mysqli_query($con,$query);
  $_SESSION['isDb'] = false;
} else {
  $_SESSION['isDb'] = true;
}

$query = "CREATE TABLE IF NOT EXISTS `products`(
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(150) NOT NULL,
  `price` FLOAT NOT NULL, 
  `description` TEXT,
  `category_id` INT,
  `image` VARCHAR(255),
  `rate` FLOAT,
  `count` INT
)";


mysqli_query($con,$query);

$query = "CREATE TABLE IF NOT EXISTS `categories` (
`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`name` VARCHAR(50) NOT NULL
)";
mysqli_query($con,$query);



?>