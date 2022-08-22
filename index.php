<?php session_start();?>
<?php include 'inc/handler.php'; ?>
<?php include 'inc/header.php'; ?>

<script>
// console.log(document.querySelector("#exampleModal"));
document.querySelector("#exampleModal .list-group").addEventListener("click",function(e) {
  e.preventDefault();
  if (e.target.matches('.btn-delete')) {
    // console.log(123);
    let id = e.target.parentElement.dataset.id;
    fetch('inc/fetch.php',{
      method: 'post',
      body: id
    }).then((resp) => resp.json())
    .then((data) => {
      console.log(data);
      let qty = data.qty;
      let price = data.price * qty;
      let total = data.total;
      if (qty > 0) {
        e.target.parentElement.querySelector('.qty').textContent = qty;
        e.target.parentElement.querySelector('.price').textContent = price;
      } else {
        e.target.parentElement.remove();
        // возврощать тотал перепитать итого
      }
      document.querySelector('#exampleModal .total').textContent = Number(total).toFixed(2);
    })
    .catch(() =>  alert('Ошибка удаления товара...'));
  }
})


</script>

  <main>

    <section class="py-5 text-center container">
      <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
          <h1 class="fw-light">Album example</h1>
          <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
          <p>
            <a href="#" class="btn btn-primary my-2">Main call to action</a>
            <a href="#" class="btn btn-secondary my-2">Secondary action</a>
          </p>
        </div>
      </div>
    </section>

    <div class="album py-5 bg-light">
      <div class="container">
        <div class="row">
          <div class="col-sm-3 category mb-3 d-flex">

            <div class="list-group w-100 mt-3">
              <?php 
                $active_category_id = $_GET['cat_id'];
              ?>
              <?php 
                $clazz = '';
                if ($active_category_id == 0) $clazz = 'active';
              ?>
                <a href="?cat_id=0" class="list-group-item list-group-item-action <?= $clazz; ?>"  aria-current="true">
                  All
                </a>
              <?php foreach ($cats as $value) : ?>
                <?php 
                  $id = $value['id'];
                  $name = $value['name'];
                  $clazz = '';
                  if ($id == $active_category_id) $clazz = 'active';
                ?>
            
                <a href="?cat_id=<?=$id?>" class="list-group-item list-group-item-action <?= $clazz; ?>" aria-current="true">
                  <?= ucfirst($name) ?>
                </a>
              
              <?php endforeach; ?>
            </div>
          </div>

          <div class="col-sm-8 offset-sm-1 mt-0 content row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

          <?php $category_id = $_GET['cat_id']; ?>
          <!-- <?php var_dump($category_id);?> -->
          <?php foreach ($products as $value) : ?>
            <?php if($category_id == 0 or $value['category_id'] == $category_id) :?>
            <div class="col">
              <div class="card shadow-sm" data-id="<?= $value['category_id']?>">
                <img class="bd-placeholder-img card-img-top w-50 m-auto"" height="225" src="<?= $value['image']?>" alt="">
                <div class="card-body">
                  <h3 style="width: 100%; display: -webkit-box;-webkit-box-orient: vertical; -webkit-line-clamp: 3;overflow: hidden;"><?= $value['title']?></h3>
                  <p style="width: 100%; display: -webkit-box;-webkit-box-orient: vertical; -webkit-line-clamp: 3;overflow: hidden;" class="card-text"><?= $value['description']?></p>
                  <div class="md-3 d-flex justify-content-between">
                    <span class="fw-bold md-3">$ <?= $value['price']?></span>
                    <?php 
                      // if ($value['rate'] >= 3) {
                      //   $rate_color = "text-success";
                      // } else {
                      //   $rate_color = "text-danger";
                      // }

                      $rate_color = ($value['rate'] >= 3) ? 'text-success' : 'text-danger';
                    ?>
                    <p>
                      <label>Rating: </label><span class="fw-bold <?= $rate_color ?>"><?= $value['rate']?></span>
                    </p>
                  </div>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <!-- <button type="button" class="btn  btn-primary">Add to cart</button> -->
                      <a class="btn  btn-primary" href="?id=<?=$value['id']?>&cat_id=<?= $category_id?>">Add to cart</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endif; ?>
          <?php endforeach; ?>


          </div>
        </div>
      </div>
    </div>

  </main>

  <?php //var_dump ($_GET);?>
<?php include 'inc/footer.php'; ?>

<script>
  $('.order').click(function() {
  const user_id = <?= $_SESSION['user_id']; ?>;
  console.log(user_id);
  $.ajax({
    method: 'POST',
    url: 'inc/fetch.php',
    data: {user_id: user_id}
  })
  .done(function(resp) {
    console.log(resp);
  });
});
</script>