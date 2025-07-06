<?php
include('./admin/inc/config.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

$user_id = $_SESSION['customer_id'] ?? 0;

if ($user_id == 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'You must be logged in to add to cart.'
    ]);
    exit;
}

$product_id = $_POST['product_id'] ?? '';
$product_name = $_POST['product_name'] ?? '';
$product_model = $_POST['product_model'] ?? '';
$product_image = $_POST['product_image'] ?? '';
$product_price = $_POST['product_price'] ?? '';
$product_size = $_POST['product_size_id'] ?? '';  // receiving from form
$product_color = $_POST['product_color_id'] ?? ''; // receiving from form
$quantity = $_POST['quantity'] ?? 1;

// Check if product with same options already exists
$checkStmt = $pdo->prepare("SELECT id, quantity FROM tbl_cart WHERE user_id = ? AND product_id = ? AND product_size = ? AND product_color = ?");
$checkStmt->execute([$user_id, $product_id, $product_size, $product_color]);
$existing = $checkStmt->fetch(PDO::FETCH_ASSOC);

if ($existing) {
    $newQty = $existing['quantity'] + $quantity;
    $updateStmt = $pdo->prepare("UPDATE tbl_cart SET quantity = ? WHERE id = ?");
    $updateStmt->execute([$newQty, $existing['id']]);
} else {
    $insertStmt = $pdo->prepare("INSERT INTO tbl_cart (user_id, product_id, product_name, product_model, product_image, product_price, product_size, product_color, quantity, added_on)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $insertStmt->execute([$user_id, $product_id, $product_name, $product_model, $product_image, $product_price, $product_size, $product_color, $quantity]);
}

// Fetch updated cart count
$stmt = $pdo->prepare("SELECT SUM(quantity) AS total_items FROM tbl_cart WHERE user_id = ?");
$stmt->execute([$user_id]);
$count_result = $stmt->fetch(PDO::FETCH_ASSOC);
$total_items = $count_result['total_items'] ?? 0;

echo json_encode([
    'status' => 'success',
    'message' => 'Product added to cart successfully.',
    'cart_count' => $total_items
]);
exit;
?>
