<?php
ob_start();
session_start();
include("inc/config.php");
include("inc/functions.php");
include("inc/CSRF_Protect.php");
$csrf = new CSRF_Protect();
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';

// Check if the user is logged in or not
if (!isset($_SESSION['user'])) {
	header('location: login.php');
	exit;
}
?>
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$favicon = $row['favicon'];
	$meta_keyword = $row['meta_keyword'];
	$meta_description = $row['meta_description'];
	$meta_openGraph_image = $row['meta_opengraph_img'];
	$meta_openGraph_description = $row['meta_description'];
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Admin Panel</title>
	<link rel="icon" type="image/png" href="../assets/uploads/<?php echo $favicon ?>">

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
		integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/ionicons.min.css">
	<link rel="stylesheet" href="css/datepicker3.css">
	<link rel="stylesheet" href="css/all.css">
	<link rel="stylesheet" href="css/select2.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="css/jquery.fancybox.css">
	<link rel="stylesheet" href="css/AdminLTE.min.css">
	<link rel="stylesheet" href="css/_all-skins.min.css">
	<link rel="stylesheet" href="css/on-off-switch.css" />
	<link rel="stylesheet" href="css/summernote.css">
	<link rel="stylesheet" href="style.css">


	<!--Meta Tags-->

	<meta name="keywords" content="<?php echo $meta_keyword; ?>">
	<meta name="description" content="<?php echo $meta_description; ?>">
	<meta property="og:image" content="<?php echo $meta_openGraph_image; ?>">
	<meta property="og:description" content="<?php echo $meta_openGraph_description; ?>">

</head>

<body class="hold-transition fixed skin-blue sidebar-mini">

	<div class="wrapper">

		<header class="main-header">

			<a href="index.php" class="logo">
				<span class="logo-lg">Achala Motors</span>
			</a>

			<nav class="navbar navbar-static-top">

				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>

				<span style="float:left;line-height:50px;color:#fff;padding-left:15px;font-size:18px;">Admin
					Panel</span>
				<!-- Top Bar ... User Inforamtion .. Login/Log out Area -->
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="<?php echo $_SESSION['user']['photo']; ?>"
									class="user-image" alt="User Image">
								<span class="hidden-xs"><?php echo $_SESSION['user']['full_name']; ?></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-footer">
									<div>
										<a href="profile-edit.php" class="btn btn-default btn-flat">Edit Profile</a>
									</div>
									<div>
										<a href="logout.php" class="btn btn-default btn-flat">Log out</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>

			</nav>
		</header>

		<?php $cur_page = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1); ?>
		<!-- Side Bar to Manage Shop Activities -->
		<aside class="main-sidebar">
			<section class="sidebar">

				<ul class="sidebar-menu">

					<li class="treeview <?php if ($cur_page == 'index.php') {
						echo 'active';
					} ?>">
						<a href="index.php">
							<i class="fa fa-dashboard"></i> <span>Dashboard</span>
						</a>
					</li>


					<li class="treeview <?php if (($cur_page == 'settings.php')) {
						echo 'active';
					} ?>">
						<a href="settings.php">
							<i class="fa fa-sliders"></i> <span>Website Settings</span>
						</a>
					</li>

					<li
						class="treeview <?php if (($cur_page == 'top-category.php') || ($cur_page == 'top-category-add.php') || ($cur_page == 'top-category-edit.php') || ($cur_page == 'mid-category.php') || ($cur_page == 'mid-category-add.php') || ($cur_page == 'mid-category-edit.php') || ($cur_page == 'end-category.php') || ($cur_page == 'end-category-add.php') || ($cur_page == 'end-category-edit.php')) {
							echo 'active';
						} ?>">
						<a href="#">
							<i class="fa fa-cogs"></i>
							<span>Site Settings</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="top-category.php"><i class="fa fa-circle-o"></i> Top Level Category
									Settings</a></li>
							<li><a href="mid-category.php"><i class="fa fa-circle-o"></i> Mid Level Category
									Settings</a></li>
							<li><a href="end-category.php"><i class="fa fa-circle-o"></i> End Level Category
									Settings</a></li>
						</ul>
					</li>


					<li
						class="treeview <?php if (($cur_page == 'product.php') || ($cur_page == 'product-add.php') || ($cur_page == 'product-edit.php')) {
							echo 'active';
						} ?>">
						<a href="product.php">
							<i class="fa fa-shopping-bag"></i> <span>Manage Products</span>
						</a>
					</li>


					<!-- Icons to be displayed on Shop -->
					<li class="treeview <?php if (($cur_page == 'service.php')) {
						echo 'active';
					} ?>">
						<a href="service.php">
							<i class="fa fa-list-ol"></i> <span>Services</span>
						</a>
					</li>

					<li class="treeview <?php if (($cur_page == 'faq.php')) {
						echo 'active';
					} ?>">
						<a href="faq.php">
							<i class="fa fa-question-circle"></i> <span title="faq">FAQ</span>
						</a>
					</li>

					<li
						class="treeview <?php if (($cur_page == 'customer.php') || ($cur_page == 'customer-add.php') || ($cur_page == 'customer-edit.php')) {
							echo 'active';
						} ?>">
						<a href="customer.php">
							<i class="fa fa-user-plus"></i> <span>Registered Customer</span>
						</a>
					</li>

					
					<li class="treeview <?php if (($cur_page == 'social-media.php')) {
						echo 'active';
					} ?>">
						<a href="social-media.php">
							<i class="fa fa-globe"></i> <span>Social Media Links</span>
						</a>
					</li>

					<li
						class="treeview <?php if (($cur_page == 'subscriber.php') || ($cur_page == 'subscriber.php')) {
							echo 'active';
						} ?>">
						<a href="subscriber.php">
							<i class="fa fa-hand-o-right"></i> <span>Our Subscribers</span>
						</a>
					</li>

					<li class="treeview <?php if (($cur_page == 'customer-message.php')) {
						echo 'active';
					} ?>">
						<a href="customer-message.php">
							<i class="fa fa-user"></i> <span>Customer Messages</span>
						</a>
					</li>

				</ul>
			</section>
		</aside>

		<div class="content-wrapper">