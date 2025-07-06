<?php
session_start(); // make sure session is started

include('./admin/inc/config.php');

header('Content-Type: application/json');

// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    echo json_encode(['success' => false, 'message' => 'User is not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cart_id']) && isset($_POST['quantity'])) {
        $cart_id = intval($_POST['cart_id']);
        $quantity = intval($_POST['quantity']);

        if ($quantity > 0) {
            // Update quantity in tbl_cart
            $stmt = $pdo->prepare("UPDATE tbl_cart SET quantity = :quantity WHERE id = :cart_id");
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Get updated item total
                $stmt_item = $pdo->prepare("SELECT product_price, quantity FROM tbl_cart WHERE id = :cart_id");
                $stmt_item->execute(['cart_id' => $cart_id]);
                $item = $stmt_item->fetch(PDO::FETCH_ASSOC);

                $item_total = $item['product_price'] * $item['quantity'];

                // Get updated total cart price for the current customer
                $customer_id = $_SESSION['customer_id']; 
                $stmt_total = $pdo->prepare("SELECT SUM(product_price * quantity) AS total_price FROM tbl_cart WHERE user_id = :customer_id");
                $stmt_total->execute(['customer_id' => $customer_id]);
                $cart = $stmt_total->fetch(PDO::FETCH_ASSOC);

                echo json_encode([
                    'success' => true,
                    'item_total' => $item_total,
                    'total_price' => $cart['total_price']
                ]);
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update cart']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid quantity']);
            exit;
        }
    }
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
exit;
?>
