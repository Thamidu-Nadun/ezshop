<?php include('admin/inc/config.php'); ?>
<?php
if (isset($_GET['p_name'])) {

  $search_text = $_GET['p_name'];
  $year = $_GET['year'];
  $ecat_id = $_GET['brand'];

  try {
    $statement = $pdo->prepare("SELECT p_id, p_name, p_short_description, p_price
  FROM tbl_product
  WHERE p_name LIKE :search_text 
  AND ecat_id=:ecat_id
  OR year = :year 
  ");
    $statement->bindValue(':year', $year);
    $statement->bindValue(':ecat_id', $ecat_id);
    $statement->bindValue(':search_text', '%' . $search_text . '%');
    $statement->execute();
    $result = $statement->fetchAll();


    $product_data = [];
    foreach ($result as $row) {
      $id = $row['p_id'];
      $name = $row['p_name'];
      $short_description = $row['p_short_description'];
      $p_price = $row['p_price'];

      $row_data = array(
        "id" => $id,
        "name" => $name,
        "short_description" => $short_description,
        "price" => $p_price,
      );
      $product_data[] = $row_data;
    }
  } catch (e) {
    echo $e;
  }
} else {
  die("Please provide search query");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="css/stylemin.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/components/theme-switch.css" />
  <!-- External Libraries -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css"
    integrity="sha512-MqL4+Io386IOPMKKyplKII0pVW5e+kb+PI/I3N87G3fHIfrgNNsRpzIXEi+0MQC0sR9xZNqZqCYVcC61fL5+Vg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-bg-color">
  <?php include('components/Navbar/navbar.php'); ?>


  <div class="container">
    <form class="hero-form mt-lg-5 mt-3 input-group w-lg-50 mx-auto" action="search.php">
      <select name="brand" class="year bg-form-color text-light form-control">
        <?php
        $statement = $pdo->prepare("SELECT * FROM tbl_top_category;");
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) { ?>
          <option value="<?php echo $row['tcat_id']; ?>"<?php
          if ($row['tcat_id'] == $ecat_id) {
            echo ' selected="selected"';
          }
          ?>><?php echo $row['tcat_name']; ?></option>
          <?php
        }
        ?>
      </select>
      <select name="year" class="brand bg-form-color text-light form-control">
        <?php
        $current_year = date('Y');
        $statement = $pdo->prepare("SELECT * FROM tbl_year
                        ORDER BY id desc;");
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) { ?>
          <option value="<?php echo $row['name']; ?>" <?php
             if ($row['name'] == $year) {
               echo ' selected="selected"';
             }else if($row['name'] == $current_year){
                echo ' selected="selected"';
             }
             ?>><?php echo $row['name']; ?></option>
          <?php
        }
        ?>
      </select>
      <input type="text" name="p_name" placeholder="Car Name" class="name bg-form-color text-light form-control" />
      <button class="btn btn-highlight btn-find form-control">
        <i class="fa-solid fa-magnifying-glass find-icon"></i>
      </button>
    </form>
    <div class="col-12 mb-5">
      <h2 class="text-capitalize mb-5 mt-3 text-primary" style="font-family: var(--font-main-fancy);">search results on
        <a href="" class="ms-2 text-hightlight text-uppercase fs-4"
          style="font-family: var(--font-main-semibold);"><?php echo $search_text; ?></a>
      </h2>
      <?php if (!empty($product_data)): ?>
      <div class="row">
          <?php foreach ($product_data as $data) {
            ?>
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card">
              <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light" data-mdb-ripple-color="light">
                <div class="bookmark position-absolute end-0 me-3 mt-3 btn btn-warning rounded-5">
                  <i class="fa-regular fa-bookmark"></i>
                </div>
                <img src="/assets/img/product.png" class="w-100" />
                <a href="#!">
                  <div class="mask">
                    <div class="d-flex justify-content-start align-items-end h-100">
                      <h5><span class="badge bg-primary ms-2">New</span></h5>
                    </div>
                  </div>
                  <div class="hover-overlay">
                    <div class="mask bg-primary"></div>
                  </div>
                </a>
              </div>
              <div class="card-body">
                <a href="" class="text-reset text-decoration-none">
                  <h5 class="card-title mb-3 p-card-title"><?php echo $data['name']; ?></h5>
                </a>
                <p><?php echo $data['short_description']; ?></p>
                <div class="icon-box d-flex justify-content-around">
                  <div class="p-icon text-center text-capitalize fw-semibold">
                    <i class="ri-speed-up-line fs-5 fw-bold"></i><br />
                    180 km<sup>-h</sup>
                  </div>
                  <div class="p-icon text-center text-capitalize fw-semibold">
                    <i class="ri-user-6-line fs-5 fw-bold"></i><br />
                    2 owners
                  </div>
                  <div class="p-icon text-center text-capitalize fw-semibold">
                    <i class="ri-file-list-fill fs-5 fw-bold"></i><br />
                    available
                  </div>
                </div>
              </div>
              <div class="card-footer d-flex justify-content-around">
                <div class="price fw-semibold">
                  <span class="price-tag">Rs.</span>
                  <span class="price-value"><?php echo $data['price']; ?></span>
                </div>
                <a href="" class="text-uppercase text-reset fw-semibold text-decoration-none">view more
                  <i style="font-size: 0.8em" class="fa-solid fa-arrow-up-right-from-square ps-2"></i></a>
              </div>
            </div>
          </div>
          <?php
          } ?>
      </div>
      <?php else: ?>
        <p>No result found</p>
      <?php endif; ?>
    </div>
  </div>




  <!-- Footer Section -->
  <footer class="text-center text-lg-start bg-footer-bg text-muted">
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom text-light">
      <!-- Left -->
      <div class="me-5 d-none d-lg-block">
        <span class="text-capitalize">stay in touch with our social networks</span>
      </div>
      <!-- Left -->

      <!-- Right -->
      <div>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-google"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-linkedin"></i>
        </a>
        <a href="" class="me-4 text-reset">
          <i class="fab fa-github"></i>
        </a>
      </div>
      <!-- Right -->
    </section>
    <!-- Section: Social media -->

    <!-- Section: Links  -->
    <section class="text-light">
      <div class="container text-center text-md-start mt-5">
        <!-- Grid row -->
        <div class="row mt-3">
          <!-- Grid column -->
          <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
            <!-- Content -->
            <h6 class="text-uppercase fw-bold mb-4">
              <i class="fas fa-gem me-3"></i>company
            </h6>
            <p>
              Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure
              alias nostrum reprehenderit animi nobis possimus!
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">trending vehicles</h6>
            <p>
              <a href="#!" class="text-reset text-capitalize">honda</a>
            </p>
            <p>
              <a href="#!" class="text-reset text-capitalize">toyota</a>
            </p>
            <p>
              <a href="#!" class="text-reset text-capitalize">benz</a>
            </p>
            <p>
              <a href="#!" class="text-reset text-capitalize">tesla</a>
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">Useful links</h6>
            <p>
              <a href="#!" class="text-reset text-capitalize">trending vehicles</a>
            </p>
            <p>
              <a href="#!" class="text-reset text-capitalize">contact us</a>
            </p>
            <p>
              <a href="#!" class="text-reset text-capitalize">find us</a>
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
            <p><i class="fas fa-home me-3"></i> nad tech, sri lanka</p>
            <p>
              <i class="fas fa-envelope me-3"></i>
              info@mail.com
            </p>
            <p><i class="fas fa-phone me-3"></i> + 94 70 137 0247</p>
            <p>
              <i class="fa-brands fa-whatsapp me-3 fw-semibold"></i> + 94 77
              117 0247
            </p>
          </div>
          <!-- Grid column -->
        </div>
        <!-- Grid row -->
      </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div class="text-center p-4 text-light border-top" style="background-color: rgba(0, 0, 0, 0.05)">
      © 2024 Copyright:
      <a class="text-reset fw-bold text-decoration-none" href="https://nadun.web.lk">NadSoft.lk</a>
    </div>
    <!-- Copyright -->
  </footer>
  <!-- Footer -->
  <script src="./node_modules/bootstrap/dist/js/bootstrap.js"></script>
</body>

</html>