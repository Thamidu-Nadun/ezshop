<?php require_once('header.php'); ?>

<?php
// Initialize variables to hold product data
$product_data = [
    'tcat_id' => '',
    'mcat_id' => '',
    'ecat_id' => '',
    'p_name' => '',
    'p_price' => '',
    'p_main_photo' => '',
    'p_description' => '',
    'p_short_description' => '',
    'p_feature' => '',
    'p_condition' => '',
    'p_is_active' => '',
    'p_other_images' => []
];

// Check if product_id is set in URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product data from the database
    $stmt = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id = ?");
    $stmt->execute([$product_id]);
    $product_data = $stmt->fetch(PDO::FETCH_ASSOC);

    // Decode other images if they exist
    if ($product_data['p_other_images']) {
        $product_data['p_other_images'] = json_decode($product_data['p_other_images'], true);
    }
}

// Handle form submission for updating the product
if (isset($_POST['form1'])) {
    $product_id = $_POST['product_id'];
    $tcat_id = $_POST['tcat_id'];
    $mcat_id = $_POST['mcat_id'];
    $ecat_id = $_POST['ecat_id'];
    $p_name = $_POST['p_name'];
    $p_price = $_POST['p_price'];
    $p_description = $_POST['p_description'];
    $p_short_description = $_POST['p_short_description'];
    $p_feature = $_POST['p_feature'];
    $p_condition = $_POST['p_condition'];
    $p_is_active = $_POST['p_is_active'];
    
    $p_main_photo = $product_data['p_main_photo'];
    if (isset($_FILES['p_main_photo']) && $_FILES['p_main_photo']['error'] == 0) {
        $p_main_photo = time() . '_' . $_FILES['p_main_photo']['name'];
        move_uploaded_file($_FILES['p_main_photo']['tmp_name'], 'img/vehicles/' . $p_main_photo);
    }

    $p_other_images = $product_data['p_other_images'];
    if (isset($_FILES['other_images'])) {
        foreach ($_FILES['other_images']['name'] as $key => $name) {
            if ($_FILES['other_images']['error'][$key] == 0) {
                $image_name = time() . '_' . $name;
                move_uploaded_file($_FILES['other_images']['tmp_name'][$key], 'img/vehicles/' . $image_name);
                $p_other_images[] = $image_name;
            }
        }
    }
    $p_other_images = json_encode($p_other_images);

    // Update product data in the database
    $stmt = $pdo->prepare("UPDATE tbl_product SET tcat_id = ?, mcat_id = ?, ecat_id = ?, p_name = ?, p_price = ?, p_main_photo = ?, p_description = ?, p_short_description = ?, p_feature = ?, p_condition = ?, p_is_active = ?, p_other_images = ? WHERE p_id = ?");
    $stmt->execute([$tcat_id, $mcat_id, $ecat_id, $p_name, $p_price, $p_main_photo, $p_description, $p_short_description, $p_feature, $p_condition, $p_is_active, $p_other_images, $product_id]);

    $success_message = 'Product updated successfully.';
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Update Product</h1>
    </div>
    <div class="content-header-right">
        <a href="product.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php if (isset($error_message)): ?>
                <div class="callout callout-danger">
                    <p><?php echo htmlspecialchars($error_message); ?></p>
                </div>
            <?php endif; ?>

            <?php if (isset($success_message)): ?>
                <div class="callout callout-success">
                    <p><?php echo htmlspecialchars($success_message); ?></p>
                </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="box box-info">
                    <div class="box-body">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id ?? ''); ?>">
                        
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
                                        echo '<option value="' . htmlspecialchars($row['tcat_id']) . '"' . ($row['tcat_id'] == htmlspecialchars($product_data['tcat_id']) ? ' selected' : '') . '>' . htmlspecialchars($row['tcat_name']) . '</option>';
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
                                </select>
                            </div>
                        </div>
                        
                        <!-- End Level Category -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">End Level Category <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="ecat_id" class="form-control select2 end-cat">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Product Name -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Car Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="p_name" class="form-control" value="<?php echo htmlspecialchars($product_data['p_name']); ?>">
                            </div>
                        </div>
                        
                        <!-- Price -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Current Price <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="p_price" class="form-control" value="<?php echo htmlspecialchars($product_data['p_price']); ?>">
                            </div>
                        </div>
                        
                        <!-- Main Image -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Main Image <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="file" name="p_main_photo" class="form-control">
                                <?php if ($product_data['p_main_photo']): ?>
                                    <img src="img/vehicles/<?php echo htmlspecialchars($product_data['p_main_photo']); ?>" class="img-thumbnail">
                                <?php endif; ?>
                                <small class="form-text text-muted">Accepted formats: jpg, jpeg, png, gif</small>
                            </div>
                        </div>
                        
                        <!-- Other Images -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Other Images</label>
                            <div class="col-sm-4">
                                <input type="file" name="other_images[]" multiple class="form-control">
                                <?php if ($product_data['p_other_images']): ?>
                                    <div class="image-preview">
                                        <?php foreach ($product_data['p_other_images'] as $image): ?>
                                            <img src="img/vehicles/<?php echo htmlspecialchars($image); ?>" class="img-thumbnail">
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                <small class="form-text text-muted">Accepted formats: jpg, jpeg, png, gif</small>
                            </div>
                        </div>
                        
                        <!-- Description -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="p_description" class="form-control" rows="4"><?php echo htmlspecialchars($product_data['p_description']); ?></textarea>
                            </div>
                        </div>
                        
                        <!-- Short Description -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Short Description</label>
                            <div class="col-sm-8">
                                <textarea name="p_short_description" class="form-control" rows="2"><?php echo htmlspecialchars($product_data['p_short_description']); ?></textarea>
                            </div>
                        </div>
                        
                        <!-- Features -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Features</label>
                            <div class="col-sm-8">
                                <textarea name="p_feature" class="form-control" rows="3"><?php echo htmlspecialchars($product_data['p_feature']); ?></textarea>
                            </div>
                        </div>
                        
                        <!-- Condition -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Condition</label>
                            <div class="col-sm-4">
                                <select name="p_condition" class="form-control">
                                    <option value="">Select</option>
                                    <option value="New" <?php echo ($product_data['p_condition'] == 'New') ? 'selected' : ''; ?>>New</option>
                                    <option value="Used" <?php echo ($product_data['p_condition'] == 'Used') ? 'selected' : ''; ?>>Used</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Status -->
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-4">
                                <select name="p_is_active" class="form-control">
                                    <option value="1" <?php echo ($product_data['p_is_active'] == '1') ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?php echo ($product_data['p_is_active'] == '0') ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                    <div class="box-footer">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button type="submit" name="form1" class="btn btn-primary">Update Product</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
