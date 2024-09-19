<?php require_once('header.php'); ?>
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

	if (empty($_POST['p_main_photo'])) {
		$valid = 0;
		$error_message .= "Image cannot be empty<br>";
	}

	if ($valid == 1) {
		if ($valid) {
			$other_images_array = explode(',', $_POST['other_images']);
			$other_images_string = implode(',', $other_images_array);

			// Insert into database
			$statement = $pdo->prepare("INSERT INTO tbl_product(
                p_name,
                p_price,
                p_main_photo,
                p_description,
                p_short_description,
                p_feature,
                p_condition,
                p_total_view,
                p_is_active,
                ecat_id,
                p_other_images
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?)");

			$statement->execute([
				$_POST['p_name'],
				$_POST['p_price'],
				$_POST['p_main_photo'],
				$_POST['p_description'],
				$_POST['p_short_description'],
				$_POST['p_feature'],
				$_POST['p_condition'],
				0, // Value for p_total_view
				$_POST['p_is_active'],
				$_POST['ecat_id'],
				$other_images_string
			]);

			$success_message = 'Product added successfully.';
		} else {
			echo 'Something went wrong';
		}
	}
}
?>


<section class="content-header">
	<div class="content-header-left">
		<h1>Add Product</h1>
	</div>
	<div class="content-header-right">
		<a href="product.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">

			<?php if ($error_message): ?>
				<div class="callout callout-danger">
					<p><?php echo $error_message; ?></p>
				</div>
			<?php endif; ?>

			<?php if ($success_message): ?>
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
										echo '<option value="' . $row['tcat_id'] . '">' . $row['tcat_name'] . '</option>';
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
							<label for="" class="col-sm-3 control-label">Vehicle Name <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" name="p_name" class="form-control">
							</div>
						</div>
						<!-- Price -->
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Current Price <span>*</span><br><span
									style="font-size:10px;font-weight:normal;">(In LKR)</span></label>
							<div class="col-sm-4">
								<input type="text" name="p_price" class="form-control">
							</div>
						</div>

						<!-- Select Year -->
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Select Year</label>
							<div class="col-sm-4">
								<select name="year" class="form-control select2">
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_year ORDER BY id DESC");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
										echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
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
									id="editor2"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Short Description</label>
							<div class="col-sm-8">
								<textarea name="p_short_description" class="form-control" cols="30" rows="10"
									id="editor2"></textarea>
							</div>
						</div>
						<!-- Featured Photo Upload -->
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Main Image <span>*</span></label>
							<div class="col-sm-4">
								<input type="url" name="p_main_photo" class="form-control" placeholder="Image Link">
								<p class="text-danger">Please enter images link <span class="text-success">(URL
										https://example.com/image.png)</span></p>
							</div>
						</div>
						<!-- Other Images Upload -->
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Other Images</label>
							<div class="col-sm-4">
								<input type="text" name="other_images" class="form-control"
									placeholder="Image Link, Image Link">
								<p class="text-danger">Please enter images link <span class="text-success">(URL
										https://example.com/image.png)</span><br><span class="text-info">Use , for
										divide image link </span><span class="text-success">https://ex.com/img.png<span
											class="text-warning">, </span>https://ex.com/img-2.jpg</span></p>
							</div>
						</div>
						<!-- Condition -->
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Condition</label>
							<div class="col-sm-4">
								<input type="text" name="p_condition" class="form-control">
							</div>
						</div>
						<!-- Feature -->
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Feature</label>
							<div class="col-sm-4">
								<input type="text" name="p_feature" class="form-control">
							</div>
						</div>
						<!-- Is Active -->
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Is Active?</label>
							<div class="col-sm-4">
								<select name="p_is_active" class="form-control select2">
									<option value="1">Yes</option>
									<option value="0">No</option>
								</select>
							</div>
						</div>
						<!-- Submit Button -->
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
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
		const file = input.files[0];
		if (file) {
			const reader = new FileReader();
			reader.onload = function (e) {
				document.getElementById('imagePreview').style.display = 'block';
				document.getElementById('imagePreview').src = e.target.result;
			};
			reader.readAsDataURL(file);
		}
	}

	document.getElementById('drag-area').addEventListener('dragover', function (e) {
		e.preventDefault();
		this.classList.add('dragover');
	});

	document.getElementById('drag-area').addEventListener('dragleave', function () {
		this.classList.remove('dragover');
	});

	document.getElementById('drag-area').addEventListener('drop', function (e) {
		e.preventDefault();
		this.classList.remove('dragover');
		const fileInput = this.querySelector('input[type="file"]');
		fileInput.files = e.dataTransfer.files;
		previewImage(fileInput);
	});
</script>
<?php require_once('footer.php'); ?>