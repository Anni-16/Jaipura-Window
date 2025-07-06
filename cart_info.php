<?php
include('./admin/inc/config.php');
session_start();

if (!isset($_SESSION['customer_id'])) {
    echo json_encode([
        'success' => false,
        'total_items' => 0,
        'total_price' => 0
    ]);
    exit;
}

$customer_id = $_SESSION['customer_id'];

// Query total items
$stmt_count = $pdo->prepare("SELECT SUM(quantity) AS total_items FROM tbl_cart WHERE user_id = :user_id");
$stmt_count->bindParam(':user_id', $customer_id, PDO::PARAM_INT);
$stmt_count->execute();
$count_result = $stmt_count->fetch(PDO::FETCH_ASSOC);
$total_items = $count_result['total_items'] ? $count_result['total_items'] : 0;

// Query total price
$stmt_total = $pdo->prepare("SELECT SUM(product_price * quantity) AS total_price FROM tbl_cart WHERE user_id = :user_id");
$stmt_total->bindParam(':user_id', $customer_id, PDO::PARAM_INT);
$stmt_total->execute();
$total_result = $stmt_total->fetch(PDO::FETCH_ASSOC);
$total_price = $total_result['total_price'] ? $total_result['total_price'] : 0;

echo json_encode([
    'success' => true,
    'total_items' => $total_items,
    'total_price' => $total_price
]);
?>
