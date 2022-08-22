<!-- <script>
    //1
  /*  
fetch('https://fakestoreapi.com/products/')
.then(function(res) {
    return res.json();
})
.then(function(data) {
    console.log(data);
})
.catch(function(err) {
   var error = `
   <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
  </symbol>
  <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
  </symbol>
  <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </symbol>
</svg>
   <div class="alert alert-dismissible alert-danger d-flex align-items-center fade show" role="alert">
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
  <div>
    ${err.message}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>
   `;
   document.querySelector('header').insertAdjacentHTML('afterend',error);
})
*/
</script> -->

<!-- <?php 
//2
// $connect = curl_init();
// curl_setopt($connect,CURLOPT_URL,'https://fakestoreapi.com/products/');
// curl_setopt($connect, CURLOPT_POSTFIELDS, http_build_query(['key' => 'hgyj6789hy7']));
// curl_setopt($connect,CURLOPT_RETURNTRANSFER,true);
// $result = curl_exec($connect);
// curl_close($connect);
// jsonStringify = json_encode()
// jsonparse = json_decode()
// $data = json_decode($result,true);
// var_dump($data);

//3
// $opts = [
//     'http' => [
//         'method' => 'POST',
//         'content' => http_build_query(['key' => 'hgyj6789hy7'])
//     ]
//     ];
// $json = file_get_contents('https://fakestoreapi.com/products/',false,stream_context_create($opts));
?> -->

<?php include 'inc/db.php';?>
<!-- <?php //$_SESSION['isInsert'] = false;?> -->
<?php 
// if (isset($_SESSION['isInsert']) or $_SESSION['isInsert'] == false)
// unset($_SESSION['isInsert']);
$cart = select_products_from_cart();
function get_data($url) {
  $json = file_get_contents($url);
  $data = json_decode($json,true);
  return $data;
}

function insert_categories_table() {
  global $data, $con;
  $categories = [];
  foreach ($data as $product) {
    $categories[] = str_replace("'","",$product['category']);
  }
  $categories = array_unique($categories);
  $query = "INSERT INTO `categories` (name) VALUES ('" . implode("'), ('", $categories) . "')";
  mysqli_query($con,$query);
}

function select_categoties() {
  global  $con;
  $query = "SELECT * FROM `categories`";
  $res = mysqli_query($con,$query);
  $cats = mysqli_fetch_all($res, MYSQLI_ASSOC);
  return $cats;
}

function insert_product_table() {
  global $data, $cats, $con;
  foreach ($data as $product) {
    $product_category = str_replace("'","",$product['category']);
    $ind = array_search($product_category,array_column($cats, 'name'));
    $category_id = $cats[$ind]['id'];
    $title = $product['title'];
    $price = $product['price'];
    $description = $product['description'];
    $image = $product['image'];
    $rate = $product['rating']['rate'];
    $count = $product['rating']['count'];

    $query = "INSERT INTO `products` SET title='{$title}', price={$price}, description='{$description}', category_id={$category_id}, image='{$image}', rate={$rate}, count={$count}";
    mysqli_query($con,$query);
  }
}

function select_products() {
  global  $con;
  $query = "SELECT * FROM `products`";
  $res = mysqli_query($con,$query);
  $products = mysqli_fetch_all($res, MYSQLI_ASSOC);
  return $products;
}

function insert_product_into_cart($id, $title, $image, $price) {
  $user_id = $_SESSION['user_id'];
  global  $con;
  $query = "INSERT INTO `cart` (id, user_id, title, image, price) VALUES ($id, $user_id, '$title', '$image', $price)";
  mysqli_query($con, $query);
  header("location:index.php");
}

function select_products_from_cart() {
  global  $con;
  $query = "SELECT * FROM `cart`";
  $res = mysqli_query($con, $query);
  return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

function update_product_in_cart($id) {
  global  $con;
  $query = "UPDATE `cart` SET qty=(SELECT qty FROM (SELECT * FROM `cart` WHERE id={$id}) as t)+1 WHERE id={$id}";
  $res = mysqli_query($con, $query);
  header("location:index.php");
  // mysqli_fetch_all($res, MYSQLI_ASSOC);
}

function get_data_product() {
  global $products, $cart;
  $id = $_GET['id'];
  // var_dump($_GET);
  $is_in_cart = false;
  foreach ($cart as $value) {
    if ($id == $value['id']) {
      $is_in_cart = true;
      update_product_in_cart($value['id']);
      break;
    }
  }
if ($is_in_cart == false) {
  $ind = array_search($id, array_column($products, 'id'));
  $arr = $products[$ind];
  $title = $arr['title'];
  $image = $arr['image'];
  $price = $arr['price'];
  insert_product_into_cart($id, $title, $image, $price);
}
  $cart = select_products_from_cart();
  // return ['id' => $id,'title' => $title, 'image' => $image,'price' => $price];
  return $cart;
}

function  clear() {
  global $con;
  $query = "DELETE  FROM `cart`";
  $res = mysqli_query($con, $query);
  header("location:index.php");
}

function login($login, $password) {
  global $con;
  $query = "SELECT * FROM `users`";
  $res = mysqli_query($con, $query);
  $arr = mysqli_fetch_all($res, MYSQLI_ASSOC);
  foreach ($arr as $user) {
    if ($user['login'] == $login and $user['password'] == $password){
      $_SESSION['user_id'] = $user['id'];
      $is_auth = true;
      break;
    }
  }
  if (!$is_auth) {
    $_SESSION['login_error'] = "<script>alert('Пользователь не найден')</script>";
  }
  header("location:index.php");
}

if (!isset($_COOKIE['isInsert']) or $_COOKIE['isInsert'] != true) {
  $data = get_data('https://fakestoreapi.com/products/');
  insert_categories_table();
  $cats = select_categoties();
  insert_product_table();
  // $_SESSION['isInsert'] = true;
  setcookie('isInsert', true, time() + 365*24*60*60);
}
$cats = select_categoties();
$products = select_products();

if (isset($_GET['id'])) {
  $cart= get_data_product();
}

if (isset($_GET['clear']) and $_GET['clear'] == true) {
  clear();
}
if (isset($_POST['login']) and isset($_POST['password'])) {
  login($_POST['login'], $_POST['password']);
}
// var_dump($cart);
// var_dump($_COOKIE['isInsert']);
// setcookie('isInsert', true, time() - 365*24*60*60);
?>
