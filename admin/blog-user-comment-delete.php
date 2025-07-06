<?php require_once('header.php'); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_blog_comment WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
	// Delete from tbl_blog
	$statement = $pdo->prepare("DELETE FROM tbl_blog_comment WHERE id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: blog-user-comment.php');
?>