<?php 
include 'db.php';
$id = file_get_contents('php://input');
$query = "UPDATE `cart` SET qty=(SELECT qty FROM (SELECT * FROM `cart` WHERE id={$id}) as t)-1 WHERE id={$id}";
$res = mysqli_query($con, $query);
// echo $_POST['id'];
if ($res == true) {
  echo 'true';
} else {
  echo 'false';
}

?>