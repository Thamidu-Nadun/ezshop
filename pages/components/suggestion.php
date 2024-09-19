<div class="row mx-5 my-5">
    <h2 class="sec-title text-uppercase text-center mt-3 mb-5">
        suggestions
    </h2>
    <?php
    $statement = $pdo->prepare("SELECT *, tbl_end_category.ecat_name AS end_name, tbl_year.name AS year_name
FROM tbl_product
INNER JOIN tbl_end_category ON tbl_end_category.ecat_id = tbl_product.ecat_id
INNER JOIN tbl_year ON tbl_year.id = tbl_product.year
LIMIT 3");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $id = $row['p_id'];
        $p_name = $row['p_name'];
        $p_price = $row['p_price'];
        $year = $row['year_name'];
        $p_main_photo = $row['p_main_photo'];
        $p_short_description = $row['p_short_description'];
        $p_condition = $row['p_condition'];
        $engine = $row['engine'];
        $p_total_view = $row['p_total_view'];
        $p_is_active = $row['p_is_active'];

        $end_name = $row['end_name'];

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
                        <h5 class="card-title mb-3 p-card-title"><?php echo $p_name; ?></h5>
                    </a>
                    <p><?php echo $p_short_description; ?></p>
                    <div class="icon-box d-flex justify-content-around">
                        <div class="p-icon text-center text-capitalize fw-semibold">
                            <i class="fa-solid fa-arrow-up-right-from-square ps-2"></i><br />
                            <?php echo $engine; ?>
                        </div>
                        <div class="p-icon text-center text-capitalize fw-semibold">
                            <i class="fa-solid fa-arrow-up-right-from-square ps-2"></i><br />
                            <?php echo $year; ?>
                        </div>
                        <div class="p-icon text-center text-capitalize fw-semibold">
                            <i class="fa-solid fa-arrow-up-right-from-square ps-2"></i><br />
                            <?php echo $p_condition; ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-around">
                    <div class="price fw-semibold">
                        <span class="price-tag">Rs.</span>
                        <span class="price-value"><?php echo $p_price; ?></span>
                    </div>
                    <a href="" class="text-uppercase text-reset fw-semibold text-decoration-none">view more
                        <i style="font-size: 0.8em" class="fa-solid fa-arrow-up-right-from-square ps-2"></i></a>
                </div>
            </div>
        </div>
        <?php
    } ?>
</div>