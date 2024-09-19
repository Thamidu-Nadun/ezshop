<?php
include('../admin/inc/config.php');
?>
<?php
if (isset($_GET['p_id'])) {
    // Get product id
    $p_id = $_GET['p_id'];

    $statement = $pdo->prepare("SELECT *, tbl_user.phone AS user_number, tbl_end_category.ecat_name AS end_name, tbl_mid_category.mcat_name AS mid_name, tbl_top_category.tcat_name AS top_name, tbl_year.name AS year_name
    FROM tbl_product
    INNER JOIN tbl_user ON tbl_user.id = tbl_product.user_id
    INNER JOIN tbl_end_category ON tbl_end_category.ecat_id = tbl_product.ecat_id
    INNER JOIN tbl_mid_category ON tbl_mid_category.mcat_id = tbl_end_category.mcat_id
    INNER JOIN tbl_top_category ON tbl_top_category.tcat_id = tbl_mid_category.tcat_id
    INNER JOIN tbl_year ON tbl_year.id = tbl_product.year
    WHERE p_id=:p_id");
    $statement->bindValue(':p_id', $p_id);
    $statement->execute();
    $result = $statement->fetchAll();
    if ($result) {
        foreach ($result as $row) {
            $id = $row['p_id'];
            $p_name = $row['p_name'];
            $p_price = $row['p_price'];
            $year = $row['year_name'];
            $p_main_photo = $row['p_main_photo'];
            $p_description = $row['p_description'];
            $p_short_description = $row['p_short_description'];
            $p_feature = $row['p_feature'];
            $p_condition = $row['p_condition'];
            $engine = $row['engine'];
            $p_total_view = $row['p_total_view'];
            $p_is_active = $row['p_is_active'];
            $ecat_id = $row['ecat_id'];
            $p_other_images = $row['p_other_images'];

            $top_name = $row['top_name'];
            $mid_name = $row['mid_name'];
            $end_name = $row['end_name'];

            $user_number = $row['user_number'];
        }
        $other_images_array = explode(', ', $p_other_images);
    } else {
        echo "<h2 class='text-center mt-4 min-vh-100'>ID not exist</h2>";
        die();
    }
} else {
    die("Please provide id");
}
?>
<div class="detail">
    <div class="row mx-5 my-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/index.php">Home</a></li>
            <li class="breadcrumb-item text-capitalize"><a href="#"><?php echo $top_name; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $end_name; ?></li>
        </ol>
        <div class="col-12 col-lg-6">
            <div id="carouselExampleIndicators" class="carousel slide">
                <div class="carousel-indicators">
                    <?php
                    $total_images = count($other_images_array) + 1; // Total images including the main photo
                    for ($i = 0; $i < $total_images; $i++) { ?>
                        <button type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide-to="<?php echo $i; ?>" class="<?php echo $i === 0 ? 'active' : ''; ?>"
                            aria-label="Slide <?php echo $i + 1; ?>"></button>
                    <?php } ?>
                </div>
                <div class="carousel-inner rounded-4">
                    <div class="carousel-item active">
                        <img src="<?php echo $p_main_photo; ?>" class="d-block w-100" alt="..." />
                    </div>
                    <?php
                    foreach ($other_images_array as $image) { ?>
                        <div class="carousel-item">
                            <img src="<?php echo $image; ?>" class="d-block w-100" alt="..." />
                        </div>
                    <?php } ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

        </div>
        <div class="col-12 col-lg-6 mt-3 ps-4">
            <div class="p-name">
                <h1 class="text-uppercase fw-semibold"><?php echo $p_name; ?></h1>
            </div>
            <div class="p-description mt-3">
                <p>
                    <?php echo $p_short_description; ?>
                </p>
            </div>
            <div class="p-price mt-5">
                <h2>
                    <span class="price-tag">Rs.</span>
                    <span class="price-value"><?php echo $p_price; ?></span>
                    /=
                </h2>
            </div>
            <div class="features mt-5">
                <div class="row">
                    <div class="col">
                        <div class="text-uppercase fw-semibold">
                            <i class="fa-solid fa-arrow-up-right-from-square ps-2 me-3"></i>
                            <?php echo $engine; ?>
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-uppercase fw-semibold">
                            <i class="fa-solid fa-arrow-up-right-from-square ps-2 me-3"></i>
                            <?php echo $mid_name; ?>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <div class="text-uppercase fw-semibold">
                            <i class="fa-solid fa-arrow-up-right-from-square ps-2 me-3"></i>
                            <?php echo $p_condition; ?>
                        </div>
                    </div>
                    <div class="col">
                        <div class="text-uppercase fw-semibold">
                            <i class="fa-solid fa-arrow-up-right-from-square ps-2 me-3"></i>
                            <?php echo $year; ?>
                        </div>
                    </div>
                </div>
            </div>
            <a href="callto:<?php echo $user_number; ?>" class="btn btn-primary text-uppercase w-100 me-5 mt-5">call</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 mx-5 my-5">
        <div class="col-lg-5">
            <div class="description">
                <p>
                    <?php echo $p_description; ?>
                </p>
            </div>
            <div class="text-success">
                <hr>
            </div>
            <div class="options">
                <ul class="list-group list-group-flush">
                    <?php
                    $options = explode(',', $p_feature);
                    foreach ($options as $data) { ?>
                        <li class="text-capitalize list-group-item bg-bg-color">
                            <?php echo $data; ?>
                        </li>
                        <hr class="text-dark">
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>