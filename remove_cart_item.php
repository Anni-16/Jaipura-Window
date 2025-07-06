<?php
include('./admin/inc/config.php');

if (isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];

    // Delete the cart item from the database
    $stmt_remove = $pdo->prepare("DELETE FROM tbl_cart WHERE id = :cart_id");
    $stmt_remove->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
    $stmt_remove->execute();

    // Return a success response
    echo "Cart item removed successfully.";
}
?>
