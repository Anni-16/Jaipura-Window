<?php require_once('header.php'); ?>

<?php
if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    // Check if the ID exists
    $statement = $pdo->prepare("SELECT * FROM tbl_faq WHERE id = ?");
    $statement->execute([$_REQUEST['id']]);
    $total = $statement->rowCount();

    if ($total == 0) {
        header('location: logout.php');
        exit;
    }
}

// Delete the FAQ
$statement = $pdo->prepare("DELETE FROM tbl_faq WHERE id = ?");
$statement->execute([$_REQUEST['id']]);

header('location: faq.php');
exit;
?>
