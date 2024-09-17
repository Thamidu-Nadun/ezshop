<?php require_once('header.php'); ?>
<style>
    .drag-area {
        border: 2px dashed #007bff;
        padding: 20px;
        border-radius: 6px;
        text-align: center;
        transition: background-color 0.3s ease;
    }

    .drag-area.dragover {
        background-color: #f0f8ff;
    }

    .img-thumbnail {
        max-width: 150px;
        margin-top: 10px;
    }

    .preview-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .image-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .image-preview img {
        max-width: 150px;
        height: auto;
        display: block;
    }

    .image-input-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .custom-file-label {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<?php

if (isset($_GET['tcat_id'])) {
    $p_id = $_GET['tcat_id'];
} else {
    die('No ID');
}

?>
<?php

if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    if (empty($_POST['tcat_id'])) {
        $valid = 0;
        $error_message .= "You must select a top-level category<br>";
    }

    if (empty($_POST['mcat_id'])) {
        $valid = 0;
        $error_message .= "You must select a mid-level category<br>";
    }

    if (empty($_POST['ecat_id'])) {
        $valid = 0;
        $error_message .= "You must select an end-level category<br>";
    }

    if (empty($_POST['p_name'])) {
        $valid = 0;
        $error_message .= "Product name cannot be empty<br>";
    }

    if (empty($_POST['p_price'])) {
        $valid = 0;
        $error_message .= "Current price cannot be empty<br>";
    }

    
    $path = $_FILES['p_main_photo']['name'];
    $path_tmp = $_FILES['p_main_photo']['tmp_name'];

    if ($path != '') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if (!in_array($ext, ['jpg', 'png', 'jpeg', 'gif'])) {
            $valid = 0;
            $error_message .= 'You must upload jpg, jpeg, gif, or png file<br>';
        }
    } else {
        $valid = 0;
        $error_message .= 'You must select a featured photo<br>';
    }

    if ($valid == 1) {
        // Handling the main image
        $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_product'");
        $statement->execute();
        $result = $statement->fetchAll();
        $ai_id = $result[0][10];

        $final_name = 'product-featured-' . $ai_id . '.' . $ext;
        move_uploaded_file($path_tmp, 'img/vehicles/' . $final_name);

        // Handling other images
        $other_images = $_FILES['other_images'];
        $other_images_names = $other_images['name'];
        $other_images_tmp_names = $other_images['tmp_name'];
        $other_images_array = [];

        foreach ($other_images_names as $index => $name) {
            if ($name != '') {
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                if (in_array($ext, ['jpg', 'png', 'jpeg', 'gif'])) {
                    $new_name = 'product-other-' . $ai_id . '-' . $index . '.' . $ext;
                    move_uploaded_file($other_images_tmp_names[$index], 'img/vehicles/' . $new_name);
                    $other_images_array[] = $new_name;
                } else {
                    $valid = 0;
                    $error_message .= 'You must upload jpg, jpeg, gif, or png file for other images<br>';
                }
            }
        }

        if ($valid) {
            // Update data
            $statement = $pdo->prepare("UPDATE `tbl_product`
             SET `p_name`=?,
             `p_price`=?, 
             `year`=?, 
             `p_main_photo`=?, 
             `p_description`=?, 
             `p_short_description`=?, 
             `p_feature`=?, 
             `p_condition`=?, 
             `p_is_active`=?, 
             `p_other_images`=? 
              WHERE id=:p_id");
            $statement->bindParam(':p_id', $p_id);
            $statement->execute(array(
                $_POST['p_name'],
                $_POST['p_price'],
                $_POST['year'],
                $final_name,
                $_POST['p_description'],
                $_POST['p_short_description'],
                $_POST['p_feature'],
                $_POST['p_condition'],
                $_POST['p_is_active'],
                json_encode($other_images_array) // Save the other images as a JSON-encoded array
            ));

            $success_message = 'Product updated successfully.';
        } else {
            // If validation failed, remove the main image and any other images
            unlink('img/vehicles/' . $final_name);
            foreach ($other_images_array as $file) {
                unlink('img/vehicles/' . $file);
            }
        }
    }
}
?>
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=:p_id");
$statement->bindValue(':p_id', $p_id);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $p_name = $row['p_name'];
    $p_price = $row['p_price'];
    $p_year = $row['year'];
    $p_main_photo = $row['p_main_photo'];
    $p_description = $row['p_description'];
    $p_short_description = $row['p_short_description'];
    $p_feature = $row['p_feature'];
    $p_condition = $row['p_condition'];
    $p_is_active = $row['p_is_active'];
    $p_other_images = $row['p_other_images'];
    $ecat_id = $row['ecat_id'];
}

$statement = $pdo->prepare("SELECT * 
                        FROM tbl_end_category t1
                        JOIN tbl_mid_category t2
                        ON t1.mcat_id = t2.mcat_id
                        JOIN tbl_top_category t3
                        ON t2.tcat_id = t3.tcat_id
                        WHERE t1.ecat_id=?");
$statement->execute(array($ecat_id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $ecat_name = $row['ecat_name'];
    $mcat_id = $row['mcat_id'];
    $tcat_id = $row['tcat_id'];
}

$statement = $pdo->prepare("SELECT * FROM tbl_product_color WHERE p_id=:p_id");
$statement->bindValue(':p_id', $p_id);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $color_id[] = $row['color_id'];
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Product</h1>
    </div>
    <div class="content-header-right">
        <a href="product.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php if (!empty($error_message)): ?>
                <div class="callout callout-danger">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($success_message)): ?>
                <div class="callout callout-success">
                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="box box-info">
                    <div class="box-body">
                        <!-- Top Level Category -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Top Level Category <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="tcat_id" class="form-control select2 top-cat">
                                    <option value="">Select</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_top_category ORDER BY tcat_name ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        ?>
                                        <option value="<?php echo $row['tcat_id']; ?>" <?php if ($row['tcat_id'] == $tcat_id) {
                                               echo 'selected';
                                           } ?>>
                                            <?php echo $row['tcat_name']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- Mid Level Category -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Mid Level Category <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="mcat_id" class="form-control select2 mid-cat">
                                    <option value="">Select</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=? ORDER BY mcat_name ASC");
                                    $statement->execute(array($tcat_id));
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        ?>
                                        <option value="<?php echo $row['mcat_id']; ?>" <?php if ($row['mcat_id'] == $mcat_id) {
                                               echo 'selected';
                                           } ?>>
                                            <?php echo $row['mcat_name']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Level Category -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">End Level Category <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="ecat_id" class="form-control select2 end-cat">
                                    <option value="">Select</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id=? ORDER BY ecat_name ASC");
                                    $statement->execute(array($mcat_id));
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        ?>
                                        <option value="<?php echo $row['ecat_id']; ?>" <?php if ($row['ecat_id'] == $ecat_id) {
                                               echo 'selected';
                                           } ?>>
                                            <?php echo $row['ecat_name']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- Product Name -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Product Name <span>*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="p_name"
                                       value="<?php echo $p_name; ?>">
                            </div>
                        </div>

                        <!-- Current Price -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Price <span>*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="p_price"
                                       value="<?php echo $p_price; ?>">
                            </div>
                        </div>
                        <!-- Year -->

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Select Year</label>
                            <div class="col-sm-4">
                                <select name="year" class="form-control select2">
                                    <?php
                                    $is_select = '';
                                    $statement = $pdo->prepare("SELECT * FROM tbl_year ORDER BY id DESC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        ?>
                                        <option value="<?php echo $row['id']; ?>" <?php if ($row['name'] == $p_year) {
                                               echo 'selected';
                                           } ?>>
                                            <?php echo $row['name']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- Select Color -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Select Color</label>
                            <div class="col-sm-4">
                                <select name="color[]" class="form-control select2">
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_color ORDER BY color_id ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        echo '<option value="' . $row['color_id'] . '">' . $row['color_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Description -->
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Short Description</label>
							<div class="col-sm-8">
								<textarea name="p_description" class="form-control" cols="30" rows="10"
									id="editor2"><?php echo $p_short_description; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Short Description</label>
							<div class="col-sm-8">
								<textarea name="p_short_description" class="form-control" cols="30" rows="10"
									id="editor2"><?php echo $p_description; ?></textarea>
							</div>
						</div>

                        <!-- Main Photo -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Featured Photo </label>
                            <div class="col-sm-9">
                                <input type="file" name="p_main_photo" id="featuredPhoto"
                                       onchange="previewImage(this);">
                                <div class="image-preview">
                                    <img src="img/vehicles/<?php echo $p_main_photo; ?>"
                                         alt="Main Photo" id="imagePreview" class="img-thumbnail">
                                </div>
                            </div>
                        </div>

                        <!-- Other Photos -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Other Photos</label>
                            <div class="col-sm-9">
                                <div class="drag-area" id="drag-area">
                                    Drag and drop or select images
                                    <input type="file" name="other_images[]" multiple style="display:none;">
                                </div>
                                <div class="image-preview" id="otherImagesPreview">
                                    <?php
                                    foreach (json_decode($p_other_images) as $img) {
                                        echo '<img src="img/vehicles/' . $img . '" alt="Other Photo" class="img-thumbnail">';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Condition -->
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Condition</label>
							<div class="col-sm-4">
								<input type="text" name="p_condition" class="form-control" value="<?php echo $p_condition; ?>">
							</div>
						</div>
						<!-- Feature -->
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Feature</label>
							<div class="col-sm-4">
								<input type="text" name="p_feature" class="form-control" value="<?php echo $p_feature; ?>">
							</div>
						</div>
						<!-- Is Active -->
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Is Active?</label>
							<div class="col-sm-4">
								<select name="p_is_active" class="form-control select2">
									<option value="1" <?php if (1== $p_is_active) echo 'selected'; ?>>Active</option>{
                                    } ?>>Yes</option>
									<option value="0" <?php if (0== $p_is_active) echo 'selected'; ?>>Active</option>{
                                    } ?>>No</option>
								</select>
							</div>
						</div>
                        <!-- Submit Button -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    const dragArea = document.getElementById('drag-area');
    dragArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        dragArea.classList.add('dragover');
    });

    dragArea.addEventListener('dragleave', () => {
        dragArea.classList.remove('dragover');
    });

    dragArea.addEventListener('drop', (e) => {
        e.preventDefault();
        dragArea.classList.remove('dragover');
        const input = dragArea.querySelector('input[type="file"]');
        input.files = e.dataTransfer.files;
        previewImage(input); // Call the preview function
    });
</script>

<?php require_once('footer.php'); ?>
