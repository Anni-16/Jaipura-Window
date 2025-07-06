<?php
session_start();
include('./admin/inc/config.php');

if (!isset($_SESSION['customer_id']) || !isset($_GET['order_id'])) {
    header('Location: login.php');
    exit;
}

$customer_id = $_SESSION['customer_id'];
$order_id = $_GET['order_id'];

// Fetch order items
$stmt = $pdo->prepare("
    SELECT o.*, c.color_name, s.size_name
    FROM tbl_order o
    LEFT JOIN tbl_color c ON o.color = c.color_id
    LEFT JOIN tbl_size s ON o.size = s.size_id
    WHERE o.customer_id = ? AND o.order_id = ?
    ORDER BY o.id
");
$stmt->execute([$customer_id, $order_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($orders)) {
    echo '<div class="alert alert-danger">Order not found or you do not have permission to view this order.</div>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>My Account Order Details - Welcome To Jaipur Window | Jaipur Window</title>
    <meta name="description" content="Vipodha">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/my-image/logo.png">

    <!-- bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- owl-carousel CSS -->
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css" media="all" />
    <!-- font-awesome CSS -->
    <link rel="stylesheet" href="./assets/cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <!-- icomoon CSS -->
    <link rel="stylesheet" href="assets/fonts/vipodha-font.css" type="text/css" media="all">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="assets/css/mycss.css" type="text/css" media="all" />
    <link rel="stylesheet" href="assets/css/common-page-style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="assets/css/my-cart.css" type="text/css" media="all" />
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <!-- Font -->

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Chonburi&amp;display=swap&amp;family=Carattere&amp;display=swap&amp;family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet">
    <!--vipodha_megamenu css-->
    <link rel="stylesheet" href="assets/css/vipodha_megamenu.css">

</head>

<body style="background-image: url(./assets/images/banners/banner-main.jpeg); background-repeat: no-repeat; width: 100%; height: auto;  background-attachment: fixed; background-position: center; overflow-x: hidden !important">
    <?php include('include/header.php'); ?>

    <section>
        <div class="breadcrumb-main">
            <div class="container">
                <div class="breadcrumb-container">
                    <h2 class="page-title">Order Details</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html"><i class="fas fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="my-account.php">My Account</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Order Details</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container my-5" style="background-color: white; padding: 20px;">
            <div class="printout">
                <h3>Order ID: <?php echo ($order_id); ?></h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Status</th>
                                <th>Ordered On</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $total_amount = 0;
                            foreach ($orders as $order) {
                                $i++;
                                $total_amount += $order['total_price'];
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo ($order['product_name']); ?></td>
                                    <td><?php echo ($order['quantity']); ?></td>
                                    <td><?php echo ($order['unit_price']); ?></td>
                                    <td><?php echo ($order['size_name'] ?: 'N/A'); ?></td>
                                    <td><?php echo ($order['color_name'] ?: 'N/A'); ?></td>
                                    <td><?php echo ($order['order_status']); ?></td>
                                    <td><?php echo ($order['created_on'] ?: 'N/A'); ?></td>
                                    <td><?php echo ($order['total_price']); ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td colspan="9" class="text-end"><strong>Total:</strong></td>
                                <td><strong><?php echo ($total_amount); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <a href="dashboard.php" class="btn btn-primary">Back to My Account</a>
                <button type="button" class="print btn" ><i class="fa fa-print"></i>Print!</button>

            </div>
        </div>
    </section>

    <?php include('include/footer.php'); ?>

    <script>
        function printContent(el) {
            var restorepage = document.body.innerHTML; // save original page html to variable
            var printcontent = document.querySelector(el).innerHTML; // save content to be printed to variable
            document.body.innerHTML = printcontent; // display only content to be printed in document body
            window.print(); // print commands
            document.body.innerHTML = restorepage; // restore original page content
        }

        document.querySelector(".print").addEventListener("click", function() {
            // bind event to print button
            printContent(".printout"); // initial print function on selector for content to be printed
        });
    </script>
    <script src="assets/js/vendors/jquery-2.1.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>