<?php
session_start();
include('./admin/inc/config.php'); // PDO $pdo connection
include('gatway-config.php'); // Contains RAZORPAY_KEY_ID and RAZORPAY_KEY_SECRET

// Check if user is logged in
if (!isset($_SESSION['customer_id'])) {
    echo "<script>
        alert('Please log in to proceed with payment.');
        window.location.href = 'login.php';
    </script>";
    exit;
}

$user_id = $_SESSION['customer_id'];

// Debug: Log POST data for troubleshooting
file_put_contents('post_debug.log', date('Y-m-d H:i:s') . " - POST Data: " . print_r($_POST, true) . "\n", FILE_APPEND);

// Fetch order data from POST
$order_data = [
    'first_name' => $_POST['first_name'] ?? '',
    'email' => $_POST['email'] ?? '',
    'phone' => $_POST['phone'] ?? '',
    'street_address' => $_POST['street_address'] ?? '',
    'notes' => $_POST['notes'] ?? '',
    'shipping_cost' => floatval($_POST['selected_shipping_cost'] ?? 0),
    'shipping_name' => $_POST['selected_shipping_name'] ?? ''
];

// Validate required fields
$errors = [];
if (trim($order_data['first_name']) === '') {
    $errors[] = 'First name is required.';
}
if (trim($order_data['email']) === '') {
    $errors[] = 'Email is required.';
} elseif (!filter_var($order_data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format.';
}
if (trim($order_data['street_address']) === '') {
    $errors[] = 'Street address is required.';
}

if (!empty($errors)) {
    echo "<script>
        alert('" . implode('\\n', array_map('addslashes', $errors)) . "');
        window.location.href = 'confirm_order.php';
    </script>";
    $_SESSION['form_data'] = $order_data;
    exit;
}

// Fetch cart items
$cartStatement = $pdo->prepare("SELECT * FROM tbl_cart WHERE user_id = ?");
$cartStatement->execute([$user_id]);
$cart_items = $cartStatement->fetchAll(PDO::FETCH_ASSOC);

if (empty($cart_items)) {
    echo "<script>
        alert('Your cart is empty!');
        window.location.href = 'cart.php';
    </script>";
    exit;
}

// Calculate totals
$sub_total = 0;
$product_info = '';
foreach ($cart_items as $item) {
    $sub_total += $item['product_price'] * $item['quantity'];
    $product_info .= $item['product_name'] . ' (x' . $item['quantity'] . '), ';
}
$product_info = rtrim($product_info, ', ');

// Calculate grand total
$grand_total = $sub_total + $order_data['shipping_cost'];
$amount_paise = round($grand_total * 100); // Razorpay needs amount in paise

// Store order details in session for razorpay_success.php
$_SESSION['order_details'] = [
    'customer_name' => $order_data['first_name'],
    'customer_email' => $order_data['email'],
    'customer_phone' => $order_data['phone'],
    'customer_address' => $order_data['street_address'],
    'notes' => $order_data['notes'],
    'product_info' => $product_info,
    'sub_total' => $sub_total,
    'shipping_name' => $order_data['shipping_name'],
    'shipping_cost' => $order_data['shipping_cost'],
    'grand_total' => $grand_total,
    'cart_items' => $cart_items
];

// Razorpay order creation
require 'razorpay-php/Razorpay.php';
use Razorpay\Api\Api;

try {
    $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

    $orderData = [
        'receipt' => uniqid('order_'),
        'amount' => $amount_paise,
        'currency' => 'INR',
        'payment_capture' => 1
    ];

    $razorpayOrder = $api->order->create($orderData);
    $order_id = $razorpayOrder['id'];

    // Store Razorpay order ID in session
    $_SESSION['order_details']['order_id'] = $order_id;

    $razorpay_data = [
        'key' => RAZORPAY_KEY_ID,
        'amount' => $amount_paise,
        'currency' => 'INR',
        'name' => 'Jaipur Window',
        'description' => $product_info,
        'order_id' => $order_id,
        'prefill' => [
            'name' => $order_data['first_name'],
            'email' => $order_data['email'],
            'contact' => $order_data['phone']
        ],
        'notes' => [
            'address' => $order_data['street_address'],
            'shipping' => $order_data['shipping_name'],
            'notes' => $order_data['notes']
        ],
        'theme' => [
            'color' => '#0D94FB'
        ]
    ];
} catch (Exception $e) {
    file_put_contents('post_debug.log', date('Y-m-d H:i:s') . " - Razorpay Error: " . $e->getMessage() . "\n", FILE_APPEND);
    echo "<script>
        alert('Error creating Razorpay order: " . addslashes($e->getMessage()) . "');
        window.location.href = 'cart.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <script>
        function initiatePayment() {
            var options = <?php echo json_encode($razorpay_data); ?>;

            options.handler = function (response) {
                window.location.href = "razorpay_success.php?payment_id=" + 
                    encodeURIComponent(response.razorpay_payment_id) + 
                    "&order_id=" + encodeURIComponent(response.razorpay_order_id) + 
                    "&signature=" + encodeURIComponent(response.razorpay_signature);
            };

            options.modal = {
                ondismiss: function () {
                    window.location.href = "failure.php";
                }
            };

            var rzp = new Razorpay(options);
            rzp.open();
        }

        // Automatically initiate payment on page load
        window.onload = initiatePayment;
    </script>
</body>
</html>