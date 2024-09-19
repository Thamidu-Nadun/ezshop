<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    // Check if the ID is valid or not
    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    if( $total == 0 ) {
        header('location: logout.php');
        exit;
    }
}
?>

<?php
// Getting featured photo to unlink from folder
$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $p_featured_photo = $row['p_featured_photo'];
    if (file_exists('img/vehicles/'.$p_featured_photo)) {
        unlink('img/vehicles/'.$p_featured_photo);
    }
}

// Getting other photos to unlink from folder
$statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $photo = $row['photo'];
    if (file_exists('img/vehicles/'.$photo)) {
        unlink('img/vehicles/'.$photo);
    }
}

// Delete from tbl_product
$statement = $pdo->prepare("DELETE FROM tbl_product WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));

// Delete from tbl_product_color
$statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));

header('location: product.php');
?>
