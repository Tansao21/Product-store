<?php session_start();?>
<?php include 'inc/handler.php'; ?>
<?php include 'inc/header.php'; ?>

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
            <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                  All
                </a>
              <?php foreach ($cats as $value) : ?>
                <?php 
                  $id = $value['id'];
                  $name = $value['name'];
                ?>
            
                <a href="#" class="list-group-item list-group-item-action" aria-current="true">
                  <?= ucfirst($name) ?>
                </a>
              
              <?php endforeach; ?>
            </div>
          </div>

          <div class="col-sm-8 offset-sm-1 mt-0 content row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

          <?php foreach ($products as $value) : ?>
            <div class="col">
              <div class="card shadow-sm">
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
                      <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                      <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                    </div>
                    <small class="text-muted">9 mins</small>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>


          </div>
        </div>
      </div>
    </div>

  </main>

<?php include 'inc/footer.php'; ?>
