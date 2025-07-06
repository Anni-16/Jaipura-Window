<?php
// Include Razorpay PHP SDK and configuration
include('gatway-config.php');
include('./admin/inc/config.php');
// Verify payment signature
require 'razorpay-php/Razorpay.php';

use Razorpay\Api\Api;

// Initialize Razorpay API with your key ID and secret
$keyId = RAZORPAY_KEY_ID; // Defined in config.php
$keySecret = RAZORPAY_KEY_SECRET; // Defined in config.php
$api = new Api($keyId, $keySecret);

// Start session to access order ID if stored
session_start();

// Check if failure data is received via POST
if (!empty($_POST['error'])) {
    $error = $_POST['error'];

    // Extract error details
    $error_code = isset($error['code']) ? $error['code'] : 'UNKNOWN_ERROR';
    $error_description = isset($error['description']) ? $error['description'] : 'Payment failed due to an unknown error.';
    $error_source = isset($error['source']) ? $error['source'] : 'N/A';
    $error_step = isset($error['step']) ? $error['step'] : 'N/A';
    $error_reason = isset($error['reason']) ? $error['reason'] : 'N/A';
    $error_metadata = isset($error['metadata']) ? $error['metadata'] : [];

    // Optionally, retrieve payment ID and order ID from metadata
    $payment_id = isset($error_metadata['payment_id']) ? $error_metadata['payment_id'] : 'N/A';
    $order_id = isset($error_metadata['order_id']) ? $error_metadata['order_id'] : (isset($_SESSION['razorpay_order_id']) ? $_SESSION['razorpay_order_id'] : 'N/A');

    // Log the error details (e.g., to a file or database for debugging)
    $log_message = "Payment Failed: Code: $error_code, Description: $error_description, Source: $error_source, Step: $error_step, Reason: $error_reason, Payment ID: $payment_id, Order ID: $order_id\n";
    file_put_contents('payment_errors.log', $log_message, FILE_APPEND);

    // Display user-friendly message
    $user_message = "We’re sorry, your payment could not be processed. Reason: $error_description. Please try again or use a different payment method.";
} else {
    // Fallback if no error data is received
    $user_message = "Payment failed, but no error details were provided. Please try again or contact support.";
    $log_message = "Payment Failed: No error details received.\n";
    file_put_contents('payment_errors.log', $log_message, FILE_APPEND);
}
?>

<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Payment Failed - Welcome To Jaipur Window | Jaipur Window</title>
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
    <link rel="stylesheet" href="./assets/css/mycss.css" type="text/css" media="all">
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
            background-color: red;
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
                    <h2 class="page-title">Payment Failed</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>
                                Payment Failed</a>
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
                                <div class="panel panel-default invoice" id="invoice">
                                    <div class="panel-body">
                                        <div class="invoice-ribbon" style="display: flex; justify-content: right;">
                                            <div class="ribbon-inner">Failed</div>
                                        </div>
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <h1 class="text-center">Payment Failed</h1>
                                            </div>



                                        </div>
                                        <hr>

                                        <div class="row table-row">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center h6" style="background-color: #ffcaf7;">
                                                            Payment Failed, but no error details were provided. Please try again or Contact Support. </td>
                                                    </tr>

                                                </tbody>
                                            </table>

                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-lg-12 margintop">
                                                <div class="" style="display: flex; align-items: center;  justify-content: center; flex-direction: column;">
                                                    <p class="lead marginbottom"> <a href="checkout.php" class="btn  " id="invoice-print" style="background-color: #a01c8c;  margin: 0 auto;"> Try Again</a> </p>

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

<?php
// Optionally, unset session variables related to the order
if (isset($_SESSION['razorpay_order_id'])) {
    unset($_SESSION['razorpay_order_id']);
}
?>