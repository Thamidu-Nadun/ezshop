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

	/* Ensure the button container is below the preview area */
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

	/* Fix the positioning of buttons and previews */
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
<!-- Main container start -->
<main class="ttr-wrapper bg-bg-color">
	<div class="container-fluid">
		<div class="db-breadcrumb">
			<h4 class="breadcrumb-title">Add Vehicle</h4>
			<ul class="db-breadcrumb-list">
				<li><a href="#"><i class="fa fa-home"></i>Home</a></li>
				<li>Add Vehicle</li>
			</ul>
		</div>
		<div class="row">
			<!-- Your Profile Views Chart -->
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
					<div class="wc-title">
						<h4>Add Vehicle</h4>
					</div>
					<div class="widget-inner bg-primary text-light">
						<form class="edit-profile m-b30">
							<div class="row">
								<div class="col-12">
									<div class="ml-auto">
										<h3>1. Basic info</h3>
									</div>
								</div>
								<div class="form-group col-12">
									<label class="col-form-label">Vehicle Brand</label>
									<div>
										<select name="v-type" class="form-control">
											<option value="car">car</option>
											<option value="jeep">jeep</option>
										</select>
									</div>
									<div>
										<select name="v-brand" class="form-control">
											<option value="honda">Honda</option>
											<option value="toyota">Toyota</option>
										</select>
									</div>
								</div>
								<div class="form-group col-6">
									<label class="col-form-label">Vehicle Name</label>
									<div>
										<input class="form-control" type="text" value="" name="v-name">
									</div>
								</div>
								<div class="form-group col-6">
									<label class="col-form-label">Vehicle Year</label>
									<select name="v-year" class="form-control">
										<option value="2022">2022</option>
										<option value="2023">2023</option>
									</select>
								</div>
								<div class="form-group col-6">
									<label class="col-form-label">Vehicle Price</label>
									<div class="input-group">
										<span class="input-group-text">Rs.</span>
										<input class="form-control" type="text" value="" name="v-price">
									</div>
								</div>
								<div class="form-group col-6">
									<label class="col-form-label">Vehicle Condition</label>
									<select name="v-condition" class="form-control">
										<option value="new">Brand New</option>
										<option value="reconditioned">Re-Conditioned</option>
									</select>
								</div>
							</div>

							<div class="seperator"></div>

							<div class="col-12 m-t20">
								<div class="ml-auto m-b5">
									<h3>2. Description</h3>
								</div>
							</div>
							<div class="form-group col-12">
								<label class="col-form-label">Vehicle Description</label>
								<div>
									<textarea class="form-control"></textarea>
								</div>
							</div>

							<!-- Main Image Upload (Drag and Drop) -->
							<div class="form-group">
								<label for="mainImage">Main Image (Drag & Drop)</label>
								<div class="drag-area" id="drag-area">
									<p>Drag & Drop an image here or click to select</p>
									<input type="file" id="mainImage" class="d-none" accept="image/*">
									<p id="mainImageText" class="text-muted">No image selected</p>
								</div>
								<!-- Main Image Preview -->
								<div id="mainImagePreview" class="image-preview"></div>
							</div>

							<!-- Additional Images Upload with Add and Undo Buttons -->
							<div class="form-group">
								<label for="additionalImages">Additional Images</label>
								<div id="additional-images-container">
									<!-- First additional image input -->
									<div class="image-input-container" id="imageWrapper1">
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="additionalImages1"
												accept="image/*" name="additionalImages[]">
											<label class="custom-file-label" for="additionalImages1">Choose
												Image</label>
										</div>
										<div id="additionalImagePreview1" class="ml-3"></div>
										<!-- Preview area for additional image -->
									</div>
								</div>
								<div class="mt-3">
									<button type="button" class="btn btn-secondary" id="addImageButton">Add
										Image</button>
									<button type="button" class="btn btn-danger" id="undoButton">Undo Last
										Image</button>
								</div>
							</div>

							<!-- Display Selected Additional Images -->
							<div id="additionalPreview" class="image-preview row mt-3"></div>


							<div class="col-12 m-t20">
								<div class="ml-auto">
									<h3 class="m-form__section">3. Add Main Features</h3>
								</div>
							</div>
							<div class="col-12">
								<table id="item-add" style="width:100%;">
									<tr class="list-item">
										<td class="text-light">
											<div class="row">
												<div class="col-md-2">
													<label class="col-form-label">Vehicle Engine</label>
													<div>
														<input class="form-control" type="text" value=""
															name="v-engine">
													</div>
												</div>
												<div class="col-md-2">
													<label class="col-form-label">Vehicle Owners</label>
													<div>
														<input class="form-control" type="text" value="1"
															name="v-owner">
													</div>
												</div>
												<div class="col-md-3">
													<label class="col-form-label">Vehicle Documents Availability</label>
													<div>
														<select name="v-documents" class="form-control">
															<option value="true" selected>Yes</option>
															<option value="false">No</option>
														</select>
													</div>
												</div>
												<div class="col-md-2">
													<label class="col-form-label">Close</label>
													<div class="form-group">
														<a class="delete" href="#"><i class="fa fa-close"></i></a>
													</div>
												</div>
											</div>
										</td>
									</tr>
								</table>
							</div>
							<div class="col-12 mt-3">
								<button type="button" class="btn-secondry add-item m-r5"><i
										class="fa fa-fw fa-plus-circle"></i>Add Item</button>
								<button type="reset" class="btn">Save changes</button>
							</div>
							<div class="wc-title bg-dark mt-5 rounded-4 mb-5">
								<h4>Customer Details</h4>
							</div>
							<div class="row">
								<div class="col-12">
									<div class="ml-auto">
										<h3>1. Basic info</h3>
									</div>
								</div>
								<div class="form-group col-6">
									<label class="col-form-label">Customer Name</label>
									<div>
										<input class="form-control" type="text" value="" name="c-name">
									</div>
								</div>
								<div class="form-group col-6">
									<label class="col-form-label">Customer E-Mail</label>
									<div>
										<input class="form-control" type="email" value="" name="c-mail">
									</div>
								</div>
								<div class="form-group col-6">
									<label class="col-form-label">Customer NIC</label>
									<div class="input-group">
										<input class="form-control" type="number" value="" name="c-nic">
										<span class="input-group-text">V</span>
									</div>
								</div>
								<div class="form-group col-6">
									<label class="col-form-label">Customer Number</label>
									<div class="input-group">
										<span class="input-group-text">+94</span>
										<input class="form-control" type="number" value="" name="c-number">
									</div>
								</div>
								<div class="col-12">
									<label class="col-form-label">Customer Address</label>
									<div class="input-group">
										<input class="form-control" type="text" name="c-address-home">
										<select name="c-address-district" class="form-control">
											<option value="colombo">Colombo</option>
											<option value="gampaha">Gampaha</option>
											<option value="kalutara">Kalutara</option>
											<option value="kandy">Kandy</option>
											<option value="matale">Matale</option>
											<option value="nuwara-eliya">Nuwara Eliya</option>
											<option value="galle">Galle</option>
											<option value="matara">Matara</option>
											<option value="hambantota">Hambantota</option>
											<option value="jaffna">Jaffna</option>
											<option value="kilinochchi">Kilinochchi</option>
											<option value="mannar">Mannar</option>
											<option value="mullaitivu">Mullaitivu</option>
											<option value="vavuniya">Vavuniya</option>
											<option value="badulla">Badulla</option>
											<option value="monaragala">Monaragala</option>
											<option value="ratnapura">Ratnapura</option>
											<option value="kegalle">Kegalle</option>
										</select>
										<input class="form-control" type="text" name="c-address-country"
											value="Sri Lanka">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>

			</div>
			<!-- Your Profile Views Chart END-->
		</div>
	</div>
</main>
<div class="ttr-overlay"></div>

<!-- External JavaScripts -->
<!-- <script src="assets/js/jquery.min.js"></script>
<script src="assets/vendors/bootstrap/js/popper.min.js"></script>
<script src="assets/vendors/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendors/bootstrap-select/bootstrap-select.min.js"></script>
<script src="assets/vendors/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script> -->
<script src="assets/vendors/magnific-popup/magnific-popup.js"></script>
<script src="assets/vendors/counter/waypoints-min.js"></script>
<script src="assets/vendors/counter/counterup.min.js"></script>
<script src="assets/vendors/imagesloaded/imagesloaded.js"></script>
<script src="assets/vendors/masonry/masonry.js"></script>
<script src="assets/vendors/masonry/filter.js"></script>
<script src="assets/vendors/owl-carousel/owl.carousel.js"></script>
<script src='assets/vendors/scroll/scrollbar.min.js'></script>
<script src="assets/js/functions.js"></script>
<script src="assets/vendors/chart/chart.min.js"></script>
<script src="assets/js/admin.js"></script>
<script src='assets/vendors/switcher/switcher.js'></script>
<script>
	// Pricing add
	function newMenuItem() {
		var newElem = $('tr.list-item').first().clone();
		newElem.find('input').val('');
		newElem.appendTo('table#item-add');
	}
	if ($("table#item-add").is('*')) {
		$('.add-item').on('click', function (e) {
			e.preventDefault();
			newMenuItem();
		});
		$(document).on("click", "#item-add .delete", function (e) {
			e.preventDefault();
			$(this).parent().parent().parent().parent().remove();
		});
	}
</script>
<script>
	// Drag and Drop functionality for the main image
	const dragArea = document.getElementById('drag-area');
	const mainImageInput = document.getElementById('mainImage');
	const mainImageText = document.getElementById('mainImageText');
	const mainImagePreview = document.getElementById('mainImagePreview');

	dragArea.addEventListener('click', () => mainImageInput.click());

	// Handle dragover effect
	dragArea.addEventListener('dragover', (e) => {
		e.preventDefault();
		dragArea.classList.add('dragover');
	});

	dragArea.addEventListener('dragleave', () => dragArea.classList.remove('dragover'));

	dragArea.addEventListener('drop', (e) => {
		e.preventDefault();
		dragArea.classList.remove('dragover');
		const file = e.dataTransfer.files[0];
		handleMainImage(file);
	});

	mainImageInput.addEventListener('change', (e) => {
		const file = e.target.files[0];
		handleMainImage(file);
	});

	function handleMainImage(file) {
		if (file && file.type.startsWith('image/')) {
			mainImageText.textContent = `Selected: ${file.name}`;
			const reader = new FileReader();
			reader.onload = function (e) {
				mainImagePreview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail">`;
			}
			reader.readAsDataURL(file);
		} else {
			mainImageText.textContent = 'Please select an image file';
			mainImageInput.value = ''; // Reset the input value
			mainImagePreview.innerHTML = ''; // Clear preview
		}
	}

	// Add more additional image input fields when "Add Image" button is clicked
	let imageCounter = 2; // Counter for unique IDs
	const addImageButton = document.getElementById('addImageButton');
	const additionalImagesContainer = document.getElementById('additional-images-container');
	const undoButton = document.getElementById('undoButton'); // Undo button

	addImageButton.addEventListener('click', () => {
		const newInput = document.createElement('div');
		newInput.classList.add('image-input-container', 'mb-3');
		newInput.setAttribute('id', `imageWrapper${imageCounter}`); // Assign unique ID for undo functionality
		newInput.innerHTML = `
				<div class="custom-file">
					<input type="file" class="custom-file-input" id="additionalImages${imageCounter}" accept="image/*" name="additionalImages[]">
					<label class="custom-file-label" for="additionalImages${imageCounter}">Choose Image</label>
				</div>
				<div id="additionalImagePreview${imageCounter}" class="ml-3"></div> <!-- Preview area for additional image -->
			`;
		additionalImagesContainer.appendChild(newInput);
		addFileInputListener(imageCounter); // Attach listener to the new input
		imageCounter++;
	});

	// Undo the last added image input
	undoButton.addEventListener('click', () => {
		if (imageCounter > 2) { // Ensure there's more than the initial field
			imageCounter--;
			const lastImageWrapper = document.getElementById(`imageWrapper${imageCounter}`);
			lastImageWrapper.remove();
		} else {
			alert('No more images to undo.');
		}
	});

	// Display the file name and preview the image for each additional image input
	function addFileInputListener(counter) {
		const inputElement = document.getElementById(`additionalImages${counter}`);
		const previewElement = document.getElementById(`additionalImagePreview${counter}`);
		inputElement.addEventListener('change', function (e) {
			const file = e.target.files[0];
			if (file && file.type.startsWith('image/')) {
				e.target.nextElementSibling.textContent = file.name; // Update label with file name
				const reader = new FileReader();
				reader.onload = function (e) {
					previewElement.innerHTML = `<img src="${e.target.result}" class="img-thumbnail">`; // Display image preview
				}
				reader.readAsDataURL(file);
			} else {
				e.target.nextElementSibling.textContent = 'Choose Image'; // Reset label if not an image
				e.target.value = ''; // Reset the input value
				previewElement.innerHTML = ''; // Clear preview
			}
		});
	}

	// Attach listener to the first file input
	addFileInputListener(1);
</script>