<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.98.0">
  <title>Album example · Bootstrap v5.2</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/album/">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

<link rel="stylesheet" href="style.css">


</head>

<body>

  <header>
    <div class="collapse bg-dark" id="navbarHeader">
      <div class="container">
        <div class="row">
          <div class="col-sm-8 col-md-7 py-4">
            <h4 class="text-white">About</h4>
            <p class="text-muted">Add some information about the album below, the author, or any other background context. Make it a few sentences long so folks can pick up some informative tidbits. Then, link them off to some social networking sites or contact information.</p>
          </div>
          <div class="col-sm-4 offset-md-1 py-4">
            <ul class="list-unstyled">
              <li><a href="index.php" class="text-white">Home</a></li>
              <li><a href="about.php" class="text-white">About</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="navbar navbar-dark bg-dark shadow-sm">
      <div class="container">
        <a href="index.php" class="navbar-brand d-flex align-items-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2" viewBox="0 0 24 24">
            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
            <circle cx="12" cy="13" r="4" />
          </svg>
          <strong>Home</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Button login modal -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#loginModal">
              Login
        </button>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <i class="bi bi-cart-plus"></i>
        </button>
      </div>
    </div>
  </header>

<?php 
    // var_dump($_SESSION);
    if (isset($_SESSION['login_error'])) {
      echo $_SESSION['login_error'];
      unset($_SESSION['login_error']);
      // $variable = $_SESSION['login_error'];
      // unset( $_SESSION['login_error'], $variable );
    }
?>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">User cart</h5>
        <!-- <?=$data_product?> -->
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <ul class="list-group">
        <?php foreach ($cart as $product) :?>
          <?php $total += $product['price'] *  $product['qty']?>
        <li class="list-group-item border-primary" data-id="<?=$product['id']?>">
          <img src="<?=$product['image']?>"  class="me-3" width="30">
          <label style="width: 90%; display: -webkit-box;-webkit-box-orient: vertical; -webkit-line-clamp: 3;overflow: hidden;"><?=$product['title']?></label>
          <hr>
          <span class="d-block text-primary">x <span class="qty"><?=$product['qty']?></span></span>
          <span class="mx-2 fw-bold">$<span class="price"><?=$product['price'] * $product['qty']?></span> </span>
          <!-- <button class="btn btn-danger float-end">x</button> -->
          <a href="?cart_product_id=<?$product['id']?>" class="btn btn-danger float-end btn-delete">x</a>
        </li>
        <?php endforeach;?>
      </ul>
      </div>
      <div class="modal-footer justify-content-between">
        <div>
          <label>Итого: </label>
          <!-- <span class="fw-bold">$<span class="total"><?=($total == null ?' 0.00' : $total)?></span></span> -->
          <span class="fw-bold">$<span class="total"><?=number_format(((float) $total),2,'.','')?></span></span>
        </div>

        <div>
          <!-- <button type="button" class="btn btn-danger btn-clear" data-bs-dismiss="modal">Clear All</button> -->
          <a href="?clear=true" class="btn btn-danger btn-clear">Clear All</a>
          <button type="button" class="btn btn-success order">Make order</button>
        </div>

      </div>
    </div>
  </div>
</div>







<!-- Modal login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Login</h5>
        <!-- <?=$data_product?> -->
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="input-group mb-3">
          <input type="text" name="login" id="login" class="form-control" placeholder="Login" required>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-success er">log in</button>
      </div>
    </form>
  </div>
</div>