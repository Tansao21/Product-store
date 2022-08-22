<?php 
include 'db.php';

// Make order
if ($_POST['user_id']) {
  $user_id = $_POST['user_id'];
  $query = "SELECT id,qty,price FROM `cart` WHERE user_id={$user_id}"; 
  $res = mysqli_query($con,$query);
  $data = mysqli_fetch_all($res,MYSQLI_ASSOC);
  foreach ($data as $product) {
      $total = $product['qty']*$product['price'];
      $query = "INSERT INTO `orders` SET product_id={$product['id']}, user_id={$user_id},qty={$product['qty']},total={$total}";
      $res = mysqli_query($con,$query);
      if ($res) {
          $query = "DELETE FROM `cart` WHERE id={$product['id']}";
          $res = mysqli_query($con,$query);
      }
  }
  die();
}



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
} else if ($data['qty'] <= 1) {
  $query = "DELETE FROM `cart` WHERE id={$id}";
  mysqli_query($con, $query);
  $query = "SELECT SUM(qty*price) AS total FROM `cart`";
  $res = mysqli_query($con, $query);
  $data = mysqli_fetch_assoc($res);
  $total = $data['total'];
  echo json_encode(['qty'=>0,'total'=>$total]);
}




// echo $_POST['id'];
// if ($res == true) {
//   echo 'true';
// } else {
//   echo 'false';
// }

?>