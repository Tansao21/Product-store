<?php 
include 'db.php';
$id = file_get_contents('php://input');
$query = "SELECT `qty` FROM `cart` WHERE id={$id}";
$res = mysqli_query($con, $query);
$data = mysqli_fetch_assoc($res);
if ($data['qty'] > 1) {
  $query = "UPDATE `cart` SET qty=(SELECT qty FROM (SELECT * FROM `cart` WHERE id={$id}) as t)-1 WHERE id={$id}";
  mysqli_query($con, $query);
  $query = "SELECT qty,price, (SELECT SUM(qty*price) FROM `cart`) AS total FROM `cart` WHERE id={$id}";
  $res = mysqli_query($con, $query);
  $data = mysqli_fetch_assoc($res);
  echo json_encode($data);
} else {
  $query = "DELETE FROM `cart` WHERE id={$id}";
  mysqli_query($con, $query);
  echo json_encode(['qty'=>0]);
}




// echo $_POST['id'];
// if ($res == true) {
//   echo 'true';
// } else {
//   echo 'false';
// }

?>