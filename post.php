<?php
require('includes/db.php');
require('includes/functions.php');

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <title>Blog</title>
</head>

<body>
  <?php include_once('includes/navbar.php') ?>
  <div>
    <div class="container m-auto mt-3 row">
      <div class="col-8">

        <?php
        $post_id = $_GET['id'];
        $postQuery = "SELECT * FROM posts WHERE id=$post_id";
        $runPQ = mysqli_query($db, $postQuery);
        $post = mysqli_fetch_assoc($runPQ);
        ?>
        <div class="card mb-3">

          <div class="card-body">
            <h5 class="card-title"><?= $post['title'] ?></h5>
            <span class="badge bg-primary ">Posted on <?= date('F jS, Y', strtotime($post['created_at'])) ?></span>
            <span class="badge bg-danger"><?= getCategory($db, $post['category_id']) ?></span>
            <div class="border-bottom mt-3"></div>

            <?php
            $post_images = getImagesByPost($db, $post['id']);



            ?>

            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">

                <?php
                $c = 1;
                foreach ($post_images as $image) {
                  if ($c > 1) {
                    $sw = "";
                  } else {
                    $sw = "active";
                  }
                ?>
                  <div class="carousel-item <?= $sw ?>">
                    <img src="images/<?= $image['image'] ?>" class="d-block w-100" alt="...">
                  </div>
                <?php
                  $c++;
                }

                ?>

              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>




            <!-- <img src="https://images.moneycontrol.com/static-mcnews/2020/04/stock-in-the-news-770x433.jpg" class="img-fluid mb-2 mt-2" alt="Responsive image"> -->

            <p class="card-text"><?= $post['content'] ?></p>
            <a href="#" class="btn btn-primary">Share this post</a>
            <a href="#" class="btn btn-primary">Comment on this</a>

          </div>
        </div>

        <div>
          <h4>Related Posts</h4>


          <?php
          $pquery = "SELECT *  FROM  posts WHERE category_id={$post['category_id']} ORDER BY id DESC";
          $prun = mysqli_query($db, $pquery);
          while ($rpost = mysqli_fetch_assoc($prun)) {
            if ($rpost['id'] == $post_id) {
              continue;
            }

          ?>

            <div class="card mb-3" style="max-width: 700px;">
              <div class="row g-0">
                <div class="col-md-5" style="background-image: url('https://images.moneycontrol.com/static-mcnews/2020/04/stock-in-the-news-770x433.jpg');background-size: cover">
                  <!-- <img src="https://images.moneycontrol.com/static-mcnews/2020/04/stock-in-the-news-770x433.jpg" alt="..."> -->
                </div>
                <div class="col-md-7">
                  <div class="card-body">
                    <h5 class="card-title"><?= $rpost['title'] ?></h5>
                    <p class="card-text text-truncate"><?= $rpost['content'] ?></p>
                    <p class="card-text"><small class="text-muted">Posted on <?= date('F jS, Y', strtotime($rpost['created_at'])) ?></small></p>
                  </div>
                </div>
              </div>
            </div>


          <?php
          }

          ?>



        </div>

      </div>
      <?php include_once('includes/sidebar.php') ?>
    </div>


    <?php include_once('includes/footer.php') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>