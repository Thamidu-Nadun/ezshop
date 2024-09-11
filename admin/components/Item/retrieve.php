<main class="ttr-wrapper">
	<div class="container-fluid">
		<div class="db-breadcrumb">
			<h4 class="breadcrumb-title">Vehicles</h4>
			<ul class="db-breadcrumb-list">
				<li><a href="index.php"><i class="fa fa-home"></i>Home</a></li>
				<li>Vehicles</li>
			</ul>
		</div>
		<div class="row">
			<!-- Your Profile Views Chart -->
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
					<div class="wc-title">
						<h4>Your Vehicle</h4>
					</div>
					<div class="widget-inner">
						<?php
						for ($item = 0; $item < 5; $item++) {
							?>
							<div class="card-courses-list admin-courses">
								<div class="card-courses-media">
									<img src="/assets/img/product.png" alt="" />
								</div>
								<div class="card-courses-full-dec">
									<div class="card-courses-title">
										<h4>Product Name</h4>
									</div>
									<div class="card-courses-list-bx">
										<ul class="card-courses-view">
											<li class="card-courses-categories">
												<h5>Brand New</h5>
												<h4>SUV</h4>
											</li>
											<li class="card-courses-review">
												<h5>3 Review</h5>
												<ul class="cours-star">
													<li class="active"><i class="fa fa-star"></i></li>
													<li class="active"><i class="fa fa-star"></i></li>
													<li class="active"><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
												</ul>
											</li>
											<li class="card-courses-stats">
												<a href="#" class="btn button-sm green radius-xl">In Stock</a>
											</li>
											<li class="card-courses-price">
												<del>$190</del>
												<h5 class="text-primary">$120</h5>
											</li>
										</ul>
									</div>
									<div class="row card-courses-dec">
										<div class="col-md-12">
											<h6 class="m-b10">Vehicle Description</h6>
											<p>Lorem ipsum dolor sit amet, est ei idque voluptua copiosae, pro detracto
												disputando
												reformidans at, ex vel suas eripuit. Vel alii zril maiorum ex, mea id sale
												eirmod
												epicurei. Sit te possit senserit, eam alia veritus maluisset ei, id cibo
												vocent
												ocurreret per. Te qui doming doctus referrentur, usu debet tamquam et. Sea
												ut nullam
												aperiam, mei cu tollit salutatus delicatissimi. </p>
										</div>
										<div class="col-md-12">
											<a href="#" class="btn green radius-xl outline">Edit</a>
											<a href="#" class="btn red outline radius-xl ">Remove</a>
										</div>
									</div>

								</div>
							</div>
							<?php
						} ?>
					</div>
				</div>
			</div>
			<!-- Your Profile Views Chart END-->
		</div>
	</div>
</main>