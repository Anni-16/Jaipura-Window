<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_decorate WHERE d_id=?");
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
	$statement = $pdo->prepare("SELECT * FROM tbl_decorate WHERE d_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$d_photo = $row['d_photo'];
		unlink('./uploads/decorate/'.$d_photo);
	}

	// Getting other photo ID to unlink from folder
	$statement = $pdo->prepare("SELECT * FROM tbl_decorate_photo WHERE d_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$photo = $row['photo'];
		unlink('./uploads/decorate/'.$photo);
	}


	// Delete from tbl_photo
	$statement = $pdo->prepare("DELETE FROM tbl_decorate WHERE d_id=?");
	$statement->execute(array($_REQUEST['id']));

	// Delete from tbl_product_photo
	$statement = $pdo->prepare("DELETE FROM tbl_decorate_photo WHERE d_id=?");
	$statement->execute(array($_REQUEST['id']));

	// Delete from tbl_product_size
	$statement = $pdo->prepare("DELETE FROM tbl_decorate_size WHERE d_id=?");
	$statement->execute(array($_REQUEST['id']));

	// Delete from tbl_product_color
	$statement = $pdo->prepare("DELETE FROM tbl_decorate_color WHERE d_id=?");
	$statement->execute(array($_REQUEST['id']));

	

	// Delete from tbl_order
	$statement = $pdo->prepare("DELETE FROM tbl_order WHERE product_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: decorate.php');
?>