<?php
session_start();
include('./admin/inc/config.php');
include('./admin/inc/functions.php');

if (!isset($_SESSION['customer_id'])) {
    echo "<script>
        alert('Please log in to view your order confirmation.');
        window.location.href = 'login.php';
    </script>";
    exit();
}

// Fetch cart items for the user
$user_id = $_SESSION['customer_id'];
$cartStatement = $pdo->prepare("SELECT * FROM tbl_cart WHERE user_id = ?");
$cartStatement->execute([$user_id]);
$cart_items = $cartStatement->fetchAll(PDO::FETCH_ASSOC);

$sub_total = 0;
$product_info = '';
foreach ($cart_items as $item) {
    $sub_total += $item['product_price'] * $item['quantity'];
    $product_info .= $item['product_name'] . ' (x' . $item['quantity'] . '), ';
}
$product_info = rtrim($product_info, ', ');


$customer_id = $_SESSION['customer_id'] ?? null;
$customer = null;

if ($customer_id) {
    $stmt = $pdo->prepare("SELECT * FROM tbl_customer WHERE id = ? LIMIT 1");
    $stmt->execute([$customer_id]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch order data from POST (if redirected back) or initialize defaults
$order_data = [
    'first_name' => $customer['first_name'] ?? '',
    'email' => $customer['email'] ?? '',
    'phone' => $customer['phone'] ?? '',
    'street_address' => $customer['street_address'] ?? '',
    'notes' => $_POST['notes'] ?? '',
    'shipping_cost' => floatval($_POST['selected_shipping_cost'] ?? 0),
    'shipping_name' => $_POST['selected_shipping_name'] ?? 'Standard Shipping'
];

// Calculate grand total
$grand_total = $sub_total + $order_data['shipping_cost'];
?>

<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Confirm Order - Jaipur-Window</title>
    <meta name="description" content="Vipodha">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="assets/images/my-image/logo.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css" media="all" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/fonts/vipodha-font.css" type="text/css" media="all">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="assets/css/mycss.css" type="text/css" media="all" />
    <link rel="stylesheet" href="assets/css/common-page-style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="assets/css/my-cart.css" type="text/css" media="all" />
    <link href="https://fonts.googleapis.com/css2?family=Chonburi&display=swap&family=Carattere&display=swap&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/vipodha_megamenu.css">
    <style>
        .order-summary-container {
            padding: 20px;
            border-radius: 8px;
        }

        .order-summary-row {
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }

        .order-summary-label {
            font-weight: bold;
            color: #333;
            width: 30%;
            font-size: 1.1em;
        }

        .order-summary-value {
            color: #555;
            width: 65%;
            font-size: 1.1em;
            text-align: left;
        }

        h2 {
            text-align: center;
            font-size: 2em;
            margin-bottom: 20px;
        }

        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>

<body class="cartpage" style="background-image: url(./assets/images/banners/banner-main.jpeg); background-repeat: no-repeat; width: 100%; height: auto; background-attachment: fixed; background-position: center; overflow-x: hidden !important">
    <?php include('include/header.php'); ?>

    <section>
        <div class="breadcrumb-main">
            <div class="container">
                <div class="breadcrumb-container">
                    <h2 class="page-title">Confirm Order</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="cart.php">Checkout</a></li>
                        <li class="breadcrumb-item">Confirm Order</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="cart">
        <div class="container">
            <form action="pay.php" method="post" enctype="multipart/form-data" class="form-horizontal w-100" onsubmit="return validateForm()">
                <div class="row">
                    <!-- Billing Details -->
                    <div class="col-lg-7 col-md-8 col-sm-12 col-xs-12" style="background-color: white; padding: 20px 30px; border-radius: 20px;">
                        <legend class="contact-title">Order Confirmation</legend>
                        <div id="orderSummary"></div>
                        <!-- Hidden inputs to send order data -->
                        <input type="hidden" name="first_name" id="form_first_name" value="<?= htmlspecialchars($order_data['first_name']) ?>">
                        <input type="hidden" name="email" id="form_email" value="<?= htmlspecialchars($order_data['email']) ?>">
                        <input type="hidden" name="phone" id="form_phone" value="<?= htmlspecialchars($order_data['phone']) ?>">
                        <input type="hidden" name="street_address" id="form_street_address" value="<?= htmlspecialchars($order_data['street_address']) ?>">
                        <input type="hidden" name="notes" id="form_notes" value="<?= htmlspecialchars($order_data['notes']) ?>">
                        <input type="hidden" name="selected_shipping_cost" id="form_shipping_cost" value="<?= htmlspecialchars($order_data['shipping_cost']) ?>">
                        <input type="hidden" name="selected_shipping_name" id="form_shipping_name" value="<?= htmlspecialchars($order_data['shipping_name']) ?>">
                    </div>

                    <!-- Order Summary -->
                    <div class="offset-lg-1 col-lg-4 col-md-4 col-sm-12 col-xs-12" style="background-color: white; padding: 20px 30px; border-radius: 20px;">
                        <fieldset>
                            <legend class="contact-title">Order Summary</legend>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart_items as $item) : ?>
                                        <tr>
                                            <td><?= htmlspecialchars($item['product_name']) ?></td>
                                            <td><?= $item['quantity'] ?></td>
                                            <td>Rs <?= number_format($item['product_price'], 2) ?></td>
                                            <td>Rs <?= number_format($item['product_price'] * $item['quantity'], 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">Subtotal</td>
                                        <td>Rs <?= number_format($sub_total, 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" id="shipping_name"><?= htmlspecialchars($order_data['shipping_name']) ?></td>
                                        <td id="shipping_cost">Rs <?= number_format($order_data['shipping_cost'], 2) ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><strong>Grand Total</strong></td>
                                        <td><strong>Rs <span id="grand_total"><?= number_format($grand_total, 2) ?></span></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </fieldset>
                        <div class="buttons clearfix">
                            <div class="pull-left">
                                <input class="btn btn-primary" type="submit" name="submit" value="Place Order">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <?php include('include/footer.php'); ?>

    <script src="assets/js/vendors/jquery-2.1.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/vipodha_megamenu.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script type="text/javascript">
        new WOW().init();
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet" />
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/price-cart.js"></script>

    <script>
        // Top Header Slider
        $(".blog-carousel2").owlCarousel({
            loop: false,
            dots: false,
            nav: true,
            rewind: false,
            navText: ['<i class="fa fa-angle-left" aria-hidden="true">', '<i class="fa fa-angle-right" aria-hidden="true">'],
            autoplay: false,
            autoplayTimeout: 3000,
            animateOut: "fadeOut",
            items: 1,
            responsiveClass: false,
            responsive: {
                320: {
                    items: 1
                },
                768: {
                    items: 3,
                    margin: 10
                },
                992: {
                    items: 4,
                    margin: 30
                },
                1200: {
                    items: 4,
                    margin: 30
                }
            }
        });

        // Display order summary from localStorage and update hidden inputs
        const data = JSON.parse(localStorage.getItem('orderData')) || {};
        const summaryContainer = document.getElementById('orderSummary');
        const rows = [{
                label: 'Full Name',
                value: data.first_name || 'N/A'
            },
            {
                label: 'Email',
                value: data.email || 'N/A'
            },
            {
                label: 'Phone',
                value: data.phone || 'N/A'
            },
            {
                label: 'Address',
                value: data.street_address || 'N/A'
            },
            {
                label: 'Shipping Address',
                value: data.shipping_address || 'Same as address'
            },
            {
                label: 'Order Notes',
                value: data.notes || 'None'
            }
        ];

        let html = '<div class="order-summary-container">';
        rows.forEach(row => {
            html += `
        <div class="order-summary-row">
            <div class="order-summary-label">${row.label}:</div>
            <div class="order-summary-value">${row.value}</div>
        </div>
    `;
        });
        html += '</div>';
        summaryContainer.innerHTML = html;

        // Populate hidden inputs with localStorage or PHP data
        document.getElementById('form_first_name').value = data.first_name || '<?= htmlspecialchars($order_data['first_name']) ?>';
        document.getElementById('form_email').value = data.email || '<?= htmlspecialchars($order_data['email']) ?>';
        document.getElementById('form_phone').value = data.phone || '<?= htmlspecialchars($order_data['phone']) ?>';
        document.getElementById('form_street_address').value = data.street_address || '<?= htmlspecialchars($order_data['street_address']) ?>';
        document.getElementById('form_notes').value = data.notes || '<?= htmlspecialchars($order_data['notes']) ?>';
        document.getElementById('form_shipping_cost').value = data.selected_shipping_cost || '<?= htmlspecialchars($order_data['shipping_cost']) ?>';
        document.getElementById('form_shipping_name').value = data.selected_shipping_name || '<?= htmlspecialchars($order_data['shipping_name']) ?>';

        // Update shipping and grand total display
        document.getElementById('shipping_name').textContent = data.selected_shipping_name || '<?= htmlspecialchars($order_data['shipping_name']) ?>';
        document.getElementById('shipping_cost').textContent = 'Rs ' + (parseFloat(data.selected_shipping_cost || '<?= $order_data['shipping_cost'] ?>') || 0).toFixed(2);
        const subTotal = parseFloat('<?= $sub_total ?>') || 0;
        const shippingCost = parseFloat(data.selected_shipping_cost || '<?= $order_data['shipping_cost'] ?>') || 0;
        document.getElementById('grand_total').textContent = 'Rs ' + (subTotal + shippingCost).toFixed(2);

        // Client-side validation
        function validateForm() {
            const data = JSON.parse(localStorage.getItem('orderData')) || {};
            const firstName = document.getElementById('form_first_name').value.trim();
            const email = document.getElementById('form_email').value.trim();
            const streetAddress = document.getElementById('form_street_address').value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!firstName) {
                alert('Full Name is required.');
                return false;
            }
            if (!email) {
                alert('Email is required.');
                return false;
            }
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address.');
                return false;
            }
            if (!streetAddress) {
                alert('Address is required.');
                return false;
            }
            return true;
        }
    </script>
</body>

</html>