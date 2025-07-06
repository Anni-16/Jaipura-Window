<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_testimonial WHERE test_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}else {
        // Fetch the record to get the image name
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $image = $result['test_image'];

        // Delete the image file
        if ($image != '' && file_exists('./uploads/testimonial/' . $image)) {
            unlink('./uploads/testimonial/' . $image);
        }

        // Delete the testimonial record
        $statement = $pdo->prepare("DELETE FROM tbl_testimonial WHERE test_id=?");
        $statement->execute(array($_REQUEST['id']));
    }
}

// Delete from tbl_testimonial
$statement = $pdo->prepare("DELETE FROM tbl_testimonial WHERE test_id=?");
$statement->execute(array($_REQUEST['id']));

header('location: testimonial.php');
?>
