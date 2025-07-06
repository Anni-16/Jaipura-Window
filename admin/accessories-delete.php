<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_accessroies WHERE a_id=?");
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
	$statement = $pdo->prepare("SELECT * FROM tbl_accessroies WHERE a_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$a_photo = $row['a_photo'];
		unlink('./uploads/accessroies/'.$a_photo);
	}

	// Getting other photo ID to unlink from folder
	$statement = $pdo->prepare("SELECT * FROM tbl_accessroies_photo WHERE a_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$photo = $row['photo'];
		unlink('./uploads/accessroies/'.$photo);
	}


	// Delete from tbl_photo
	$statement = $pdo->prepare("DELETE FROM tbl_accessroies WHERE a_id=?");
	$statement->execute(array($_REQUEST['id']));

	// Delete from tbl_product_photo
	$statement = $pdo->prepare("DELETE FROM tbl_accessroies_photo WHERE a_id=?");
	$statement->execute(array($_REQUEST['id']));

	// Delete from tbl_product_size
	$statement = $pdo->prepare("DELETE FROM tbl_accessroies_size WHERE a_id=?");
	$statement->execute(array($_REQUEST['id']));

	// Delete from tbl_product_color
	$statement = $pdo->prepare("DELETE FROM tbl_accessroies_color WHERE a_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: accessories.php');
?>