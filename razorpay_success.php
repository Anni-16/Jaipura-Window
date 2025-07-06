<?php
include('gatway-config.php'); // Contains RAZORPAY_KEY_ID and RAZORPAY_KEY_SECRET
include('./admin/inc/config.php'); // PDO $pdo connection

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if payment details are provided via URL
if (!isset($_GET['payment_id']) || !isset($_GET['order_id']) || !isset($_GET['signature'])) {
    echo "Invalid payment data!";
    exit;
}

// Verify payment signature
require 'razorpay-php/Razorpay.php';
use Razorpay\Api\Api;

try {
    $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

    $payment_id = $_GET['payment_id'];
    $order_id = $_GET['order_id'];
    $signature = $_GET['signature'];

    $attributes = [
        'razorpay_order_id' => $order_id,
        'razorpay_payment_id' => $payment_id,
        'razorpay_signature' => $signature
    ];

    // Verify the payment signature
    $api->utility->verifyPaymentSignature($attributes);

    // Check if order details exist in session
    if (
        !isset($_SESSION['order_details']) ||
        !isset($_SESSION['order_details']['order_id']) ||
        $_SESSION['order_details']['order_id'] !== $order_id
    ) {
        file_put_contents('session_debug.log', date('Y-m-d H:i:s') . " - Session Data: " . print_r($_SESSION, true) . "\n", FILE_APPEND);
        echo "<script>alert('Order details not found or mismatch!'); window.location.href = 'cart.php';</script>";
        exit;
    }

    // Retrieve order and customer details from session
    $order_details = $_SESSION['order_details'];
    $user_id = $_SESSION['customer_id'];
    $customer_name = $order_details['customer_name'];
    $customer_email = $order_details['customer_email'];
    $customer_phone = $order_details['customer_phone'];
    $customer_address = $order_details['customer_address'];
    $product_info = $order_details['product_info'];
    $shipping_name = $order_details['shipping_name'];
    $shipping_cost = $order_details['shipping_cost'];
    $grand_total = $order_details['grand_total'];

    // Begin database transaction
    $pdo->beginTransaction();

    try {
        // Insert Payment Info
        $paymentStmt = $pdo->prepare("INSERT INTO tbl_payment (
            order_id,
            customer_id,
            customer_name,
            customer_email,
            customer_phone,
            customer_address,
            txnid,
            paid_amount,
            payment_status,
            payment_date
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

        $paymentStmt->execute([
            $order_id,
            $user_id,
            $customer_name,
            $customer_email,
            $customer_phone,
            $customer_address,
            $payment_id,
            $grand_total,
            'Success'
        ]);

        // Fetch cart items
        $cartStmt = $pdo->prepare("SELECT * FROM tbl_cart WHERE user_id = ?");
        $cartStmt->execute([$user_id]);
        $cart_items = $cartStmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if cart is not empty
        if (!empty($cart_items)) {
            foreach ($cart_items as $item) {
                $orderStmt = $pdo->prepare("INSERT INTO tbl_order (
                    order_id,
                    payment_id,
                    customer_id,
                    product_name,
                    paid,
                    size,
                    color,
                    quantity,
                    unit_price,
                    shipping_name,
                    shipping_cost,
                    total_price,
                    order_status,
                    created_on
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

                $total_price = $item['quantity'] * $item['product_price'];

                $orderStmt->execute([
                    $order_id,
                    $payment_id,
                    $user_id,
                    $item['product_name'],
                    'Success',
                    $item['product_size'] ?? '', // Handle null/undefined size
                    $item['product_color'] ?? '', // Handle null/undefined color
                    $item['quantity'],
                    $item['product_price'],
                    $shipping_name,
                    $shipping_cost,
                    $grand_total,
                    'Pending'
                ]);
            }

            // Clear cart after successful order insertion
            $clearCartStmt = $pdo->prepare("DELETE FROM tbl_cart WHERE user_id = ?");
            $clearCartStmt->execute([$user_id]);

            // Commit transaction
            $pdo->commit();
        } else {
            // Roll back if cart is empty
            $pdo->rollBack();
            echo "<script>alert('Cart is empty. No order placed!'); window.location.href = 'cart.php';</script>";
            exit;
        }
    } catch (Exception $e) {
        // Roll back transaction on error
        $pdo->rollBack();
        file_put_contents('db_error.log', date('Y-m-d H:i:s') . " - DB Error: " . $e->getMessage() . "\n", FILE_APPEND);
        echo "<script>alert('Error processing order: " . addslashes($e->getMessage()) . "'); window.location.href = 'cart.php';</script>";
        exit;
    }

    // Clear session data after successful processing
    unset($_SESSION['order_details']);
} catch (Exception $e) {
    file_put_contents('razorpay_error.log', date('Y-m-d H:i:s') . " - Payment verification failed: " . $e->getMessage() . "\n", FILE_APPEND);
    echo "<script>alert('Payment verification failed: " . addslashes($e->getMessage()) . "'); window.location.href = 'cart.php';</script>";
    exit;
}
?>

<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Payment Success - Welcome To Jaipur Window | Jaipur Window</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Chonburi&amp;display=swap&amp;family=Carattere&amp;display=swap&amp;family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet">
    <!--vipodha_megamenu css-->
    <link rel="stylesheet" href="assets/css/vipodha_megamenu.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /*Invoice*/
        #invoice {
            padding: 50px;
            overflow: hidden;
            border-radius: 20px;
        }

        #invoice .top-left {
            font-size: 65px;
            color: #3ba0ff;
        }

        #invoice .top-right {
            text-align: right;
            padding-right: 20px;
        }

        #invoice .table-row {
            margin-left: -15px;
            margin-right: -15px;
            margin-top: 25px;
        }

        #invoice .payment-info {
            font-weight: 500;
        }

        #invoice .table-row .table>thead {
            border-top: 1px solid #ddd;
        }

        #invoice .table-row .table>thead>tr>th {
            border-bottom: none;
        }

        #invoice .table>tbody>tr>td {
            padding: 8px 20px;
        }

        #invoice #invoice-total {
            margin-right: -10px;
            font-size: 16px;
        }

        #invoice .last-row {
            border-bottom: 1px solid #ddd;
        }

        #invoice-ribbon {
            width: 85px;
            height: 88px;
            overflow: hidden;
            position: absolute;
            top: -1px;
            right: 14px;
        }

        .ribbon-inner {
            text-align: center;
            -webkit-transform: rotate(45deg);
            -moz-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            -o-transform: rotate(45deg);
            position: relative;
            padding: 7px 0;
            left: 110px;
            top: 20px;
            width: 300px;
            background-color: #a01c8c;
            font-size: 15px;
            color: #fff;
        }

        .ribbon-inner:before,
        .ribbon-inner:after {
            content: "";
            position: absolute;
        }

        .ribbon-inner:before {
            left: 0;
        }

        .ribbon-inner:after {
            right: 0;
        }

        @media(max-width:575px) {

            #invoice .top-left,
            #invoice .top-right,
            #invoice .payment-details {
                text-align: center;
            }

            #invoice .from,
            #invoice .to,
            #invoice .payment-details {
                float: none;
                width: 100%;
                text-align: center;
                margin-bottom: 25px;
            }

            #invoice p.lead,
            #invoice .from p.lead,
            #invoice .to p.lead,
            #invoice .payment-details p.lead {
                font-size: 22px;
            }

            #invoice .btn {
                margin-top: 10px;
            }
        }

        @media print {
            #invoice {
                width: 900px;
                height: 800px;
            }
        }
    </style>
</head>

<body class="registerpage" style="background-image: url(./assets/images/banners/banner-main.jpeg); background-repeat: no-repeat; width: 100%; height: auto;  background-attachment: fixed; background-position: center; overflow-x: hidden !important">

    <!-- HEADER -->
    <?php include('include/header.php'); ?>
    <!-- .HEADER -->


    <section>
        <div class="breadcrumb-main">
            <div class="container">
                <div class="breadcrumb-container">
                    <h2 class="page-title">Payment Successfull</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>
                                Payment Successfull</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


    <div class="register-section">
        <div class="container">
            <div class="row">
                <div id="content" class="col-sm-12  all-blog my-account" style="padding-left: 20px;">
                    <div class="container bootstrap snippets bootdeys">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default invoice " id="invoice">
                                    <div class="panel-body content">
                                        <div class="invoice-ribbon" style="display: flex; justify-content: right;">
                                            <div class="ribbon-inner">PAID</div>
                                        </div>
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <h1 class="text-center">Payment Successfull</h1>
                                                <p class="text-center" style="color: #a01c8c;">Thank You For Your Purchase</p>
                                            </div>


                                        </div>
                                        <hr>

                                        <div class="row table-row">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center h6" style="width: 50%;">Payment Id : </td>
                                                        <td class="text-center h6" style="width: 50%; color: #a01c8c;"> <?php echo $payment_id; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center h6" style="width: 50%;">Order Id : </td>
                                                        <td class="text-center h6" style="width: 50%; color: #a01c8c;"><?php echo $order_id; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center h6" style="width: 50%;">Customer : </td>
                                                        <td class="text-center h6" style="width: 50%; color: #a01c8c;"><?php echo $customer_name; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center h6" style="width: 50%;">Email : </td>
                                                        <td class="text-center h6" style="width: 50%; color: #a01c8c;"><?php echo $customer_email; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center h6" style="width: 50%;">Phone : </td>
                                                        <td class="text-center h6" style="width: 50%; color: #a01c8c;"><?php echo $customer_phone; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center h6" style="width: 50%;">Address : </td>
                                                        <td class="text-center h6" style="width: 50%; color: #a01c8c;"><?php echo $customer_address; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center h6" style="width: 50%;">Products : </td>
                                                        <td class="text-center h6" style="width: 50%; color: #a01c8c;"> <?php echo $product_info; ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-center h6" style="width: 50%;">Total Amount: </td>
                                                        <td class="text-center h6" style="width: 50%; color: #a01c8c;">₹<?= number_format($order_details['sub_total'], 2) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center h6" style="width: 50%;">Shipping Name : </td>
                                                        <td class="text-center h6" style="width: 50%; color: #a01c8c;"><?php echo $shipping_name; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center h6" style="width: 50%;">Shipping Cost : </td>
                                                        <td class="text-center h6" style="width: 50%; color: #a01c8c;"> ₹<?php echo number_format($shipping_cost, 2); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center h6" style="width: 50%;">Grand Total : </td>
                                                        <td class="text-center h6" style="width: 50%; color: #a01c8c;">₹<?php echo number_format($grand_total, 2); ?></td>
                                                    </tr>


                                                </tbody>
                                            </table>

                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-lg-12 margintop">
                                                <div class="" style="display: flex; align-items: center;  justify-content: center; flex-direction: column;">
                                                    <p class="lead marginbottom mb-4">THANK YOU!</p>
                                                    <a href="dashboard.php" class="btn " id="invoice-print" style="background-color: #a01c8c;  margin: 0 auto;"><i class="fas fa-home"></i> Return Home</a>
                                                    <br>
                                                    <button type="button" class="print btn" id="invoice-print" style="background-color: #a01c8c; margin: 0 auto"><i class="fa fa-print"></i>Print!</button>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- footer -->
    <?php include('include/footer.php') ?>
    <!-- .footer -->

    <!--===X===X This Javascript used to print that table format and also add the style that Centred the Table on the Print Body page X===X===-->
    <script>
    document.querySelectorAll('.print').forEach(button => {
        button.addEventListener('click', function () {
            const printContent = document.querySelector('.register-section');
            const printWindow = window.open('', '', 'width=900,height=750');

            // Collect styles
            const styles = Array.from(document.querySelectorAll('link[rel="stylesheet"], style')).map(style => style.outerHTML).join('\n');

            // Write content into print window
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Invoice Print</title>
                        ${styles}
                        <style>
                            @media print {
                                @page {
                                    size: A4;
                                    margin: 20mm;
                                }

                                body {
                                    font-family: Arial, sans-serif;
                                    -webkit-print-color-adjust: exact;
                                    margin: 0;
                                    padding: 0;
                                    text-align: center;
                                }

                                .register-section {
                                    display: flex;
                                    flex-direction: column;
                                    align-items: center;
                                    justify-content: center;
                                    transform: scale(0.95); /* Adjust scale to fit one page */
                                    transform-origin: top center;
                                }

                                table {
                                    margin: 0 auto !important;
                                    width: auto;
                                }

                                .panel, .panel-body, .invoice {
                                    width: 100%;
                                }
                            }
                        </style>
                    </head>
                    <body onload="window.print(); window.close();">
                        <div class="register-section">
                            ${printContent.innerHTML}
                        </div>
                    </body>
                </html>
            `);

            printWindow.document.close();
        });
    });
</script>
 <!--===X===X This Javascript used to print that table format and also add the style that Centred the Table on the Print Body page X===X===-->


    <script src="assets/js/vendors/jquery-2.1.1.min.js" type="text/javascript"></script>
    <!-- bootstrap js -->
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <!-- owl-carousel js -->
    <script type="text/javascript" src="assets/js/owl.carousel.min.js"></script>
    <!-- js -->
    <script src="assets/js/vipodha_megamenu.js"></script>
    <!-- wow javascript -->
    <script src="./assets/cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        new WOW().init();
    </script>
    <link href="./assets/cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet" />
    <!-- Main js -->
    <script type="text/javascript" src="assets/js/theme.js"></script>
    <script type="text/javascript" src="assets/js/price-cart.js"></script>



</body>

</html>