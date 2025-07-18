<?php require_once('header.php'); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE mcat_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	} else {
        // Fetch the record to get the image name
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $image = $result['mcat_image'];

        // Delete the image file
        if ($image != '' && file_exists('./uploads/wear/subcategory/' . $image)) {
            unlink('./uploads/wear/subcategory/' . $image);
        }

        // Delete the category record
        $statement = $pdo->prepare("DELETE FROM tbl_mid_category WHERE mcat_id=?");
        $statement->execute(array($_REQUEST['id']));
    }
}
?>

<?php

	// Getting all ecat ids
	$statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE tcat_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$tcat_ids[] = $row['tcat_id'];
	}

	if(isset($ecat_ids)) {

		for($i=0;$i<count($ecat_ids);$i++) {
			$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE mcat_id=?");
			$statement->execute(array($ecat_ids[$i]));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) {
				$p_ids[] = $row['p_id'];
			}
		}

		for($i=0;$i<count($p_ids);$i++) {

			// Getting photo ID to unlink from folder
			$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
			$statement->execute(array($p_ids[$i]));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) {
				$p_featured_photo = $row['p_featured_photo'];
				unlink('./uploads/wear/'.$p_featured_photo);
			}

			// Getting other photo ID to unlink from folder
			$statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
			$statement->execute(array($p_ids[$i]));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) {
				$photo = $row['photo'];
				unlink('./uploads/wear/'.$photo);
			}

			// Delete from tbl_photo
			$statement = $pdo->prepare("DELETE FROM tbl_product WHERE p_id=?");
			$statement->execute(array($p_ids[$i]));

			// Delete from tbl_product_photo
			$statement = $pdo->prepare("DELETE FROM tbl_product_photo WHERE p_id=?");
			$statement->execute(array($p_ids[$i]));

			// Delete from tbl_product_size
			$statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
			$statement->execute(array($p_ids[$i]));

			// Delete from tbl_product_color
			$statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id=?");
			$statement->execute(array($p_ids[$i]));

			// Delete from tbl_rating
			$statement = $pdo->prepare("DELETE FROM tbl_rating WHERE p_id=?");
			$statement->execute(array($p_ids[$i]));

			// Delete from tbl_payment
			$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE product_id=?");
			$statement->execute(array($p_ids[$i]));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) {
				$statement1 = $pdo->prepare("DELETE FROM tbl_payment WHERE payment_id=?");
				$statement1->execute(array($row['payment_id']));
			}

			// Delete from tbl_order
			$statement = $pdo->prepare("DELETE FROM tbl_order WHERE product_id=?");
			$statement->execute(array($p_ids[$i]));
		}

		// Delete from tbl_end_category
		for($i=0;$i<count($mcat_ids);$i++) {
			$statement = $pdo->prepare("DELETE FROM tbl_mid_category WHERE mcat_id=?");
			$statement->execute(array($mcat_ids[$i]));
		}

	}

	// Delete from tbl_mid_category
	$statement = $pdo->prepare("DELETE FROM tbl_mid_category WHERE mcat_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: wear-sub-category.php');
?>