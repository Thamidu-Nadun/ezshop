<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {

	if ($_SESSION['user']['role'] == 'Super Admin') {

		$valid = 1;

		if (empty($_POST['full_name'])) {
			$valid = 0;
			$error_message .= "Name can not be empty<br>";
		}

		if (empty($_POST['email'])) {
			$valid = 0;
			$error_message .= 'Email address can not be empty<br>';
		} else {
			if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
				$valid = 0;
				$error_message .= 'Email address must be valid<br>';
			} else {
				// current email address that is in the database
				$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id=?");
				$statement->execute(array($_SESSION['user']['id']));
				$result = $statement->fetchAll(PDO::FETCH_ASSOC);
				foreach ($result as $row) {
					$current_email = $row['email'];
				}

				$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE email=? and email!=?");
				$statement->execute(array($_POST['email'], $current_email));
				$total = $statement->rowCount();
				if ($total) {
					$valid = 0;
					$error_message .= 'Email address already exists<br>';
				}
			}
		}

		if ($valid == 1) {

			$_SESSION['user']['full_name'] = $_POST['full_name'];
			$_SESSION['user']['email'] = $_POST['email'];

			// updating the database
			$statement = $pdo->prepare("UPDATE tbl_user SET full_name=?, email=?, phone=? WHERE id=?");
			$statement->execute(array($_POST['full_name'], $_POST['email'], $_POST['phone'], $_SESSION['user']['id']));

			$success_message = 'User Information is updated successfully.';
		}
	} else {
		$_SESSION['user']['phone'] = $_POST['phone'];

		// updating the database
		$statement = $pdo->prepare("UPDATE tbl_user SET phone=? WHERE id=?");
		$statement->execute(array($_POST['phone'], $_SESSION['user']['id']));

		$success_message = 'User Information is updated successfully.';
	}
}

if (isset($_POST['form2'])) {
	$user_image = $_POST['photo'];
	$statement = $pdo->prepare("UPDATE tbl_user SET photo=? WHERE id=?");
	$statement->execute(array($user_image, $_SESSION['user']['id']));

	$success_message = 'User Avatar is updated successfully.';
}

if (isset($_POST['form3'])) {
	$valid = 1;

	if (empty($_POST['password']) || empty($_POST['re_password'])) {
		$valid = 0;
		$error_message .= "Password can not be empty<br>";
	}

	if (!empty($_POST['password']) && !empty($_POST['re_password'])) {
		if ($_POST['password'] != $_POST['re_password']) {
			$valid = 0;
			$error_message .= "Passwords do not match<br>";
		}
	}

	if ($valid == 1) {

		$_SESSION['user']['password'] = md5($_POST['password']);

		// updating the database
		$statement = $pdo->prepare("UPDATE tbl_user SET password=? WHERE id=?");
		$statement->execute(array(md5($_POST['password']), $_SESSION['user']['id']));

		$success_message = 'User Password is updated successfully.';
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Edit Profile</h1>
	</div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id=?");
$statement->execute(array($_SESSION['user']['id']));
$statement->rowCount();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$full_name = $row['full_name'];
	$email = $row['email'];
	$phone = $row['phone'];
	$photo = $row['photo'];
	$status = $row['status'];
	$role = $row['role'];
}
?>


<section class="content">

	<div class="row">
		<div class="col-md-12">

			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab_1" data-toggle="tab">Update Information</a></li>
					<li><a href="#tab_2" data-toggle="tab">Update Photo</a></li>
					<li><a href="#tab_3" data-toggle="tab">Update Password</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_1">

						<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Name <span>*</span></label>
										<?php
										if ($_SESSION['user']['role'] == 'Super Admin') {
											?>
											<div class="col-sm-4">
												<input type="text" class="form-control" name="full_name"
													value="<?php echo $full_name; ?>">
											</div>
											<?php
										} else {
											?>
											<div class="col-sm-4" style="padding-top:7px;">
												<?php echo $full_name; ?>
											</div>
											<?php
										}
										?>

									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Existing Photo</label>
										<div class="col-sm-6" style="padding-top:6px;">
											<img src="<?php echo $photo; ?>" class="existing-photo"
												width="140">
										</div>
									</div>

									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Email Address
											<span>*</span></label>
										<?php
										if ($_SESSION['user']['role'] == 'Super Admin') {
											?>
											<div class="col-sm-4">
												<input type="email" class="form-control" name="email"
													value="<?php echo $email; ?>">
											</div>
											<?php
										} else {
											?>
											<div class="col-sm-4" style="padding-top:7px;">
												<?php echo $email; ?>
											</div>
											<?php
										}
										?>

									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Phone </label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="phone"
												value="<?php echo $phone; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Role <span>*</span></label>
										<div class="col-sm-4" style="padding-top:7px;">
											<?php echo $role; ?>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form1">Update
												Information</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="tab_2">
						<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">New Photo</label>
										<div class="col-sm-6" style="padding-top:6px;">
											<input type="url" name="photo" placeholder="Your Image Link">
											<p class="mt-1 text-danger">Insert image URL(https://photos.example.com/john.png)</p>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form2">Update
												Photo</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="tab_3">
						<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Password </label>
										<div class="col-sm-4">
											<input type="password" class="form-control" name="password">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Retype Password </label>
										<div class="col-sm-4">
											<input type="password" class="form-control" name="re_password">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form3">Update
												Password</button>
										</div>
									</div>
								</div>
							</div>
						</form>

					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<?php require_once('footer.php'); ?>