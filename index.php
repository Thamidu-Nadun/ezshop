<?php
include('admin_2/inc/config.php');
$id = 1;
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=:id");
$statement->bindParam(':id', $id);
$statement->execute();
$result = $statement->fetchAll();
foreach ($result as $row){
    $name = $row['name'];
    $description = $row['description'];
    $hero_title = $row['hero_title'];
    $hero_paragraph = $row['hero_paragraph'];
    $about_1 = $row['about_1'];
    $about_1_description = $row['about_1_description'];
    $about_2 = $row['about_2'];
    $about_2_description = $row['about_2_description'];
    $about_3 = $row['about_3'];
    $about_3_description = $row['about_3_description'];
    $contact_link = $row['contact_link'];
    $findUs_link = $row['findUs_link'];
    $address = $row['address'];
    $mail = $row['mail'];
    $number = $row['number'];
    $whatsapp = $row['whatsapp'];
    $facebook = $row['facebook'];
    $x = $row['x'];
    $google = $row['google'];
    $instagram = $row['instagram'];
    $linkedin = $row['linkedin'];
    $github = $row['github'];
    $copyright = $row['copyright'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="css/stylemin.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/components/theme-switch.css" />
  <!-- External Libraries -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css"
    integrity="sha512-MqL4+Io386IOPMKKyplKII0pVW5e+kb+PI/I3N87G3fHIfrgNNsRpzIXEi+0MQC0sR9xZNqZqCYVcC61fL5+Vg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-bg-color">
  <?php include('components/Navbar/navbar.php'); ?>
  <?php include('components/Hero/hero.php'); ?>
  <?php include('components/About/about.php'); ?>
  <?php include('components/Products/products.php'); ?>
  <?php include('components/App/app.php'); ?>
  <?php include('components/Footer/footer.php'); ?>






  <script src="./node_modules/bootstrap/dist/js/bootstrap.js"></script>
</body>

</html>