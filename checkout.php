<?php
session_start();
include('./admin/inc/config.php');
include('./admin/inc/functions.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : null;

// Check if user is logged in
if (!isset($_SESSION['customer_id'])) {
    echo "<script>
        alert('Please log in to view your cart.');
        window.location.href = 'login.php';
    </script>";
    exit;
}

// Fetch shipping policy
$statement = $pdo->prepare("SELECT * FROM tbl_shipping_policy WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $heading = $row['heading'];
    $content = $row['content'];
}

// Fetch cart items from the database
$cart_items = [];
$sub_total = 0;

$cartStatement = $pdo->prepare("SELECT * FROM tbl_cart WHERE user_id = ?");
$cartStatement->execute([$user_id]);
$cart_items = $cartStatement->fetchAll(PDO::FETCH_ASSOC);

// Handle update and remove cart actions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update') {
        $key = $_POST['update'];
        $quantity = $_POST['quantity'][$key];

        // Update cart item quantity in the database
        $updateStmt = $pdo->prepare("UPDATE tbl_cart SET quantity = ? WHERE id = ?");
        $updateStmt->execute([$quantity, $key]);
        header("Location: cart.php");
        exit;
    } elseif ($_POST['action'] === 'remove') {
        $key = $_POST['remove'];

        // Remove item from the cart in the database
        $removeStmt = $pdo->prepare("DELETE FROM tbl_cart WHERE id = ?");
        $removeStmt->execute([$key]);
        header("Location: cart.php");
        exit;
    }
}
?>

<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Cart - Jaipur-Window</title>
    <meta name="description" content="Vipodha">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="assets/images/my-image/logo.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css" media="all" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="assets/fonts/vipodha-font.css" type="text/css" media="all">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="assets/css/mycss.css" type="text/css" media="all" />
    <link rel="stylesheet" href="assets/css/common-page-style.css" type="text/css" media="all" />
    <link href="https://fonts.googleapis.com/css2?family=Chonburi&display=swap&family=Carattere&display=swap&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/vipodha_megamenu.css">
    <link rel="stylesheet" href="assets/css/my-cart.css" type="text/css" media="all" />
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="cartpage" style="background-image: url(./assets/images/banners/banner-main.jpeg); background-repeat: no-repeat; width: 100%; height: auto; background-attachment: fixed; background-position: center; overflow-x: hidden !important">
    <!-- HEADER -->
    <?php include('include/header.php'); ?>

    <!-- Breadcrumb Section -->
    <section>
        <div class="breadcrumb-main">
            <div class="container">
                <div class="breadcrumb-container">
                    <h2 class="page-title">Checkout</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="cart.php">Checkout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Shopping Cart Section -->
    <section id="cart">
        <div class="container">
            <div class="row">
                <?php
                $customer_id = $_SESSION['customer_id'] ?? null;
                $customer = null;

                if ($customer_id) {
                    $stmt = $pdo->prepare("SELECT * FROM tbl_customer WHERE id = ? LIMIT 1");
                    $stmt->execute([$customer_id]);
                    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
                }
                ?>

                <form id="combinedForm" method="post" action="confirm_order.php" enctype="multipart/form-data" class="form-horizontal"  >
                   <div class="row">
                     <!-- Billing Details -->
                     <div class="col-lg-7 col-md-8 col-sm-12 col-xs-12"  >
                       <div class="" style="background-color: #fff; padding: 20px 30px; border-radius: 20px; ">
                       <fieldset>
                            <legend class="contact-title">Billing Details</legend>

                            <!-- Full Name -->
                            <div class="form-group required row">
                                <div class="col-sm-12">
                                    <label for="first_name">Full Name</label>
                                    <input type="text" id="first_name" name="first_name" class="form-control" required placeholder="Full Name" value="<?= ($customer['cust_name'] ?? '') ?>">
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group required row">
                                <div class="col-sm-12">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" required placeholder="Email" value="<?= ($customer['cust_email'] ?? '') ?>">
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="form-group required row">
                                <div class="col-sm-12">
                                    <label for="phone">Phone No.</label>
                                    <input type="text" id="phone" name="phone" class="form-control" required placeholder="Phone No." value="<?= ($customer['cust_phone'] ?? '') ?>">
                                </div>
                            </div>

                            <!-- Billing Address -->
                            <div class="form-group required row">
                                <div class="col-sm-12">
                                    <label for="street_address">Billing Address</label>
                                    <input type="text" id="street_address" name="street_address" class="form-control" required placeholder="House number and street name" value="<?= ($customer['cust_address'] ?? '') ?>">
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="notes">Order Notes (Optional)</label>
                                    <textarea id="notes" name="notes" class="form-control" placeholder="Order notes"><?= ($customer['notes'] ?? '') ?></textarea>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                        <!-- Submit Button -->
                            <div class="col-lg-12">
                                <div class="buttons clearfix" style="margin-top: 20px;">
                                    <div class="pull-left">
                                        <input class="btn btn-primary" type="submit" name="submit" value="Place Order">
                                    </div>
                                </div>
                            </div>

                        </fieldset>
                       </div>
                    </div>
 
                     <!-- Cart Summary -->
                    <div class="col-lg-5 col-md-4 col-sm-12 col-xs-12" style="  padding: 20px 30px; border-radius: 20px; ">
                    <div class="" style="background-color: #fff; padding: 20px 30px; border-radius: 20px; ">
                        <fieldset>
                            <legend class="contact-title">Order Summary</legend>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td class="text-left">Product Name</td>
                                        <td class="text-left">Total</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($cart_items)) : ?>
                                        <tr>
                                            <td colspan="2" class="text-center">Your cart is empty.</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($cart_items as $item) : ?>
                                            <?php
                                            $total_price = $item['product_price'] * $item['quantity'];
                                            $sub_total += $total_price;
                                            ?>
                                            <tr>
                                                <td class="text-left"><a href="#"><?= ($item['product_name']) ?> &nbsp; x &nbsp; <?= $item['quantity'] ?></a></td>
                                                <td class="text-left">Rs <?= number_format($total_price, 2) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot id="checkout-cart-foot">
                                    <?php
                                    $grand_total = $sub_total;

                                    // Fetch shipping options from database
                                    $shipping_options = [];
                                    $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost ORDER BY shipping_cost_id DESC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                                    if ($result && count($result) > 0) {
                                        $shipping_options = $result;
                                    } else {
                                        // Fallback if no options found
                                        $shipping_options = [
                                            ['shipping_cost_id' => 1, 'name' => 'Standard Shipping', 'amount' => 0],
                                            ['shipping_cost_id' => 2, 'name' => 'Express Shipping', 'amount' => 200],
                                        ];
                                    }
                                    ?>

                                    <?php foreach ($shipping_options as $index => $option) : ?>
                                        <tr>
                                            <td class="text-start"><?= ($option['name']) ?></td>
                                            <td class="text-end">
                                                <div class="d-flex" style="gap:0 10px;">
                                                    <input type="radio" id="shipping<?= $option['shipping_cost_id'] ?>" name="shipping_cost" value="<?= $option['amount'] ?>" data-name="<?= ($option['name']) ?>" <?= $index === 0 ? 'checked' : '' ?> onchange="updateTotal()">
                                                    <label for="shipping<?= $option['shipping_cost_id'] ?>">
                                                        ₹<?= number_format($option['amount'], 2) ?>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <tr>
                                        <td class="text-start"><strong>Total:</strong></td>
                                        <td class="text-end">
                                            <strong>Rs <span id="total"><?= number_format($sub_total + $shipping_options[0]['amount'], 2) ?></strong>
                                            <input type="hidden" id="baseTotal" value="<?= $sub_total ?>">
                                            <input type="hidden" id="selectedShippingCost" name="selected_shipping_cost" value="<?= $shipping_options[0]['amount'] ?>">
                                            <input type="hidden" id="selectedShippingName" name="selected_shipping_name" value="<?= ($shipping_options[0]['name']) ?>">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </fieldset>
                        </div>
                    </div>
                   </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include('include/footer.php'); ?>

    <!-- JavaScript -->
    <script src="assets/js/vendors/jquery-2.1.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/vipodha_megamenu.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/price-cart.js"></script>

    <script>
        function updateTotal() {
            const shippingRadios = document.getElementsByName('shipping_cost');
            let shippingCost = 0;
            let shippingName = '';

            for (let radio of shippingRadios) {
                if (radio.checked) {
                    shippingCost = parseFloat(radio.value);
                    shippingName = radio.getAttribute('data-name');
                    break;
                }
            }

            const baseTotal = parseFloat(document.getElementById('baseTotal').value);
            const finalTotal = baseTotal + shippingCost;
            document.getElementById('total').innerText = finalTotal.toFixed(2);

            // Update hidden inputs
            document.getElementById('selectedShippingCost').value = shippingCost;
            document.getElementById('selectedShippingName').value = shippingName;
        }

        // Owl Carousel for blog (if any)
        $(".blog-carousel2").owlCarousel({
            loop: false,
            dots: false,
            nav: true,
            rewind: false,
            navText: [
                '<i class="fa fa-angle-left" aria-hidden="true"></i>',
                '<i class="fa fa-angle-right" aria-hidden="true"></i>'
            ],
            autoplay: false,
            autoplayTimeout: 3000,
            animateOut: 'fadeOut',
            items: 1,
            responsiveClass: false,
            responsive: {
                320: { items: 1 },
                768: { items: 3, margin: 10 },
                992: { items: 4, margin: 30 },
                1200: { items: 4, margin: 30 }
            }
        });
    </script>
</body>
</html>