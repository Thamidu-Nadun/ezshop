<main class="ttr-wrapper">
	<div class="container-fluid">
		<div class="db-breadcrumb">
			<h4 class="breadcrumb-title">Customer Data</h4>
			<ul class="db-breadcrumb-list">
				<li><a href="index.php"><i class="fa fa-home"></i>Home</a></li>
				<li>Customer Data</li>
			</ul>
		</div>
		<div class="row">
			<!-- Your Profile Views Chart -->
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
					<div class="wc-title">
						<h4>Your Customer Data</h4>
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
										<h4>Customer Name</h4>
									</div>
									<div class="card-courses-list-bx">
										<ul class="card-courses-view">
											<li class="card-courses-categories">
												<h5>Brand New</h5>
												<h4>SUV</h4>
											</li>
											<li class="card-courses-stats">
												<a href="#" class="btn button-sm yellow radius-xl outline">By Cash</a>
											</li>
											<li class="card-courses-stats">
												<a href="#" class="btn button-sm green radius-xl">2024-08-15</a>
											</li>
											<li class="card-courses-price">
												<h5 class="text-primary">$120</h5>
											</li>
										</ul>
									</div>
									<div class="row card-courses-dec">
										<div class="col-md-12">
											<h6 class="m-b10">Vehicle Name</h6>
											<ul class="list-group-flush list-unstyled">
												<li>E-mail: <a href="">john@mail.com</a></li>
												<li>Number: <a href="">+94 701 370 247</a></li>
												<li>Address: <a href="">location, country</a></li>
												<li>NIC: <a href="">045041541541401V</a></li>
											</ul>
										</div>
										<div class="col-md-12">
											<a href="#" class="btn green radius-xl outline">Say Hello!</a>
											<a href="#" class="btn blue radius-xl outline">See Agreement</a>
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