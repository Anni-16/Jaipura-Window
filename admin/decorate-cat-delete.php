<?php require_once('header.php'); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_decorate_category WHERE cat_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	} else {
        // Fetch the record to get the image name
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $image = $result['cat_image'];

        // Delete the image file
        if ($image != '' && file_exists('./uploads/decorate/category/' . $image)) {
            unlink('./uploads/decorate/category/' . $image);
        }

        // Delete the category record
        $statement = $pdo->prepare("DELETE FROM tbl_decorate_category WHERE cat_id=?");
        $statement->execute(array($_REQUEST['id']));
    }
}
?>

<?php	
	$statement = $pdo->prepare("SELECT * FROM tbl_decorate_category WHERE cat_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$cat_ids[] = $row['cat_id'];
	}

	if(isset($cat_ids)) {

		for($i=0;$i<count($cat_ids);$i++) {
			$statement = $pdo->prepare("SELECT * FROM tbl_decorate WHERE cat_id=?");
			$statement->execute(array($cat_ids[$i]));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) {
				$p_ids[] = $row['d_id'];
			}
		}

		for($i=0;$i<count($p_ids);$i++) {

			// Getting photo ID to unlink from folder
			$statement = $pdo->prepare("SELECT * FROM tbl_decorate WHERE a_id=?");
			$statement->execute(array($p_ids[$i]));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) {
				$a_photo = $row['a_photo'];
				unlink('./uploads/decorate/'.$a_photo);
			}

			// Getting other photo ID to unlink from folder
			$statement = $pdo->prepare("SELECT * FROM tbl_decorate_photo WHERE a_id=?");
			$statement->execute(array($p_ids[$i]));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) {
				$photo = $row['photo'];
				unlink('./uploads/decorate/'.$photo);
			}

			// Delete from tbl_photo
			$statement = $pdo->prepare("DELETE FROM tbl_decorate WHERE a_id=?");
			$statement->execute(array($p_ids[$i]));

			// Delete from tbl_product_photo
			$statement = $pdo->prepare("DELETE FROM tbl_decorate_photo WHERE a_id=?");
			$statement->execute(array($p_ids[$i]));

			// Delete from tbl_product_size
			$statement = $pdo->prepare("DELETE FROM tbl_decorate_size WHERE a_id=?");
			$statement->execute(array($p_ids[$i]));

			// Delete from tbl_product_color
			$statement = $pdo->prepare("DELETE FROM tbl_decorate_color WHERE a_id=?");
			$statement->execute(array($p_ids[$i]));

		}

		// Delete from tbl_end_category
		for($i=0;$i<count($cat_ids);$i++) {
			$statement = $pdo->prepare("DELETE FROM tbl_decorate_category WHERE cat_id=?");
			$statement->execute(array($cat_ids[$i]));
		}

	}

	// Delete from tbl_top_category
	$statement = $pdo->prepare("DELETE FROM tbl_decorate_category WHERE cat_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: decorate-cat.php');
?>