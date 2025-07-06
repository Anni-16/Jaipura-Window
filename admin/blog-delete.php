<?php require_once('header.php'); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_blog WHERE bol_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	} else {
        // Fetch the record to get the image name
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $image = $result['bol_image'];

        // Delete the image file
        if ($image != '' && file_exists('./uploads/blog/' . $image)) {
            unlink('./uploads/blog/' . $image);
        }

        // Delete the category record
        $statement = $pdo->prepare("DELETE FROM tbl_blog WHERE bol_id=?");
        $statement->execute(array($_REQUEST['id']));
    }
}
	// Delete from tbl_blog
	$statement = $pdo->prepare("DELETE FROM tbl_blog WHERE bol_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: blog.php');
?>