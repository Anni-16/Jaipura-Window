<?php
session_start();
include('./admin/inc/config.php');

if (!isset($_SESSION['customer_id']) || !isset($_GET['order_id'])) {
    header('Location: login.php');
    exit;
}

$customer_id = $_SESSION['customer_id'];
$order_id = $_GET['order_id'];

// Fetch order details
$stmt = $pdo->prepare("SELECT * FROM tbl_order WHERE customer_id = ? AND order_id = ? ORDER BY id");
$stmt->execute([$customer_id, $order_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($orders)) {
    echo '<div class="alert alert-danger">Order not found or you do not have permission to view this order.</div>';
    exit;
}

// Fetch payment details
$stmt = $pdo->prepare("SELECT paid_amount, payment_date FROM tbl_payment WHERE order_id = ? AND customer_id = ?");
$stmt->execute([$order_id, $customer_id]);
$payment = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Order Confirmation -  Welcome To Jaipur Window | Jaipur Window</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="assets/images/my-image/logo.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="assets/css/mycss.css" type="text/css" media="all" />
    <link rel="stylesheet" href="assets/css/common-page-style.css" type="text/css" media="all" />
</head>
<body style="background-image: url(./assets/images/banners/banner-main.jpeg); background-repeat: no-repeat; width: 100%; height: auto; background-attachment: fixed; background-position: center; overflow-x: hidden !important">
    <?php include('include/header.php'); ?>

    <section>
        <div class="breadcrumb-main">
            <div class="container">
                <div class="breadcrumb-container">
                    <h2 class="page-title">Order Confirmation</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html"><i class="fas fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="my-account.php">My Account</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Order Confirmation</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container my-5">
            <h3>Thank You for Your Order!</h3>
            <p>Your order has been successfully placed. Below are the details of your order.</p>
            <h4>Order ID: <?php echo ($order_id); ?></h4>
            <?php if ($payment) { ?>
                <p>Payment Amount: <?php echo $payment['paid_amount']; ?></p>
                <p>Payment Date: <?php echo $payment['payment_date']; ?></p>
            <?php } ?>

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Amount</th>
                            <th>Size</th>
                            <th>Color</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        $total_amount = 0;
                        foreach ($orders as $order) {
                            $i++;
                            $total_amount += $order['amount'];
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $order['product_name']; ?></td>
                                <td><?php echo $order['quantity']; ?></td>
                                <td><?php echo $order['unit_price']; ?></td>
                                <td><?php echo $order['amount']; ?></td>
                                <td><?php echo $order['size'] ?: 'N/A'; ?></td>
                                <td><?php echo $order['color'] ?: 'N/A'; ?></td>
                                <td><?php echo $order['status']; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Total:</strong></td>
                            <td><strong><?php echo ($total_amount); ?></strong></td>
                            <td colspan="3"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <a href="my-account.php" class="btn btn-primary">View My Orders</a>
            <a href="index.html" class="btn btn-secondary">Continue Shopping</a>
        </div>
    </section>

    <?php include('include/footer.php'); ?>
    <script src="assets/js/vendors/jquery-2.1.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>