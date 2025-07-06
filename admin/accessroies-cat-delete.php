<?php require_once('header.php'); ?>

<?php
// Prevent direct access
if (!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
}

$cat_id = $_REQUEST['id'];

try {
    // Start Transaction
    $pdo->beginTransaction();

    // Check if category exists
    $statement = $pdo->prepare("SELECT * FROM tbl_accessroies_category WHERE cat_id = ?");
    $statement->execute([$cat_id]);
    $category = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$category) {
        header('location: logout.php');
        exit;
    }

    // Delete category image file if it exists
    if (!empty($category['cat_image']) && file_exists('./uploads/accessroies/category/' . $category['cat_image'])) {
        unlink('./uploads/accessroies/category/' . $category['cat_image']);
    }

    // Fetch all accessroies under this category
    $statement = $pdo->prepare("SELECT * FROM tbl_accessroies WHERE cat_id = ?");
    $statement->execute([$cat_id]);
    $accessroies = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($accessroies as $accessory) {
        $a_id = $accessory['a_id'];

        // Delete accessory photo
        if (!empty($accessory['a_photo']) && file_exists('./uploads/accessroies/' . $accessory['a_photo'])) {
            unlink('./uploads/accessroies/' . $accessory['a_photo']);
        }

        // Fetch and delete other accessory photos
        $statement = $pdo->prepare("SELECT photo FROM tbl_accessroies_photo WHERE a_id = ?");
        $statement->execute([$a_id]);
        $photos = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($photos as $photo) {
            if (!empty($photo['photo']) && file_exists('./uploads/accessroies/' . $photo['photo'])) {
                unlink('./uploads/accessroies/' . $photo['photo']);
            }
        }

        // Delete accessory records
        $pdo->prepare("DELETE FROM tbl_accessroies WHERE a_id = ?")->execute([$a_id]);
        $pdo->prepare("DELETE FROM tbl_accessroies_photo WHERE a_id = ?")->execute([$a_id]);
        $pdo->prepare("DELETE FROM tbl_accessroies_size WHERE a_id = ?")->execute([$a_id]);
        $pdo->prepare("DELETE FROM tbl_accessroies_color WHERE a_id = ?")->execute([$a_id]);
    }

    // Delete category
    $pdo->prepare("DELETE FROM tbl_accessroies_category WHERE cat_id = ?")->execute([$cat_id]);

    // Commit transaction
    $pdo->commit();

    // Redirect after successful deletion
    header('location: accessroies-cat.php');
    exit;

} catch (Exception $e) {
    // Rollback on error
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
    exit;
}
?>
