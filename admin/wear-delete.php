<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
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
	// Getting photo ID to unlink from folder
	$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$p_featured_photo = $row['p_featured_photo'];
		unlink('./uploads/wear/'.$p_featured_photo);
	}

	// Getting other photo ID to unlink from folder
	$statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$photo = $row['photo'];
		unlink('./uploads/wear/'.$photo);
	}


	// Delete from tbl_photo
	$statement = $pdo->prepare("DELETE FROM tbl_product WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));

	// Delete from tbl_product_photo
	$statement = $pdo->prepare("DELETE FROM tbl_product_photo WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));

	// Delete from tbl_product_size
	$statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));

	// Delete from tbl_product_color
	$statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));



	header('location: wear.php');
?>