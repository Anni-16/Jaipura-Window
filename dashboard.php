<?php
session_start();
include('./admin/inc/config.php');
include('./admin/inc/functions.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Redirect to login if not logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['customer_id'];
$stmt = $pdo->prepare("SELECT * FROM tbl_customer WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit();
}

$success_message = '';
$error_message = '';

// Handle Account Update
if (isset($_POST['form_type']) && $_POST['form_type'] === 'account_update') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($address)) {
        $error_message = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format!";
    } else {
        $full_name = $first_name . ' ' . $last_name;
        $stmt = $pdo->prepare("UPDATE tbl_customer SET cust_name = ?, cust_email = ?, cust_phone = ?, cust_address = ? WHERE id = ?");
        $stmt->execute([$full_name, $email, $phone, $address, $user_id]);

        $success_message = "Account updated successfully!";
    }
}

// Handle Password Update
if (isset($_POST['form_type']) && $_POST['form_type'] === 'password_update') {
    $new_password = $_POST['new_password'] ?? '';

    if (empty($new_password)) {
        $error_message = "New password is required!";
    } else {
        // UNSAFE: saving plain text password
        $stmt = $pdo->prepare("UPDATE tbl_customer SET password = ? WHERE id = ?");
        $stmt->execute([$new_password, $user_id]);

        $success_message = "Password updated successfully!";
    }
}

?>

<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>My Account </title>
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

<body class="accountpage" style="background-image: url(./assets/images/banners/banner-main.jpeg); background-repeat: no-repeat; width: 100%; height: auto;  background-attachment: fixed; background-position: center; overflow-x: hidden !important">
</body>
<!-- <div class="loader"></div> -->
<!-- HEADER -->
<?php include('include/header.php'); ?>
<!-- .HEADER -->

<!-- My Account -->
<section>
    <div class="breadcrumb-main">
        <div class="container">
            <div class="breadcrumb-container">
                <h2 class="page-title">My account</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="about.html">
                            My account</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>



<div class="blog-section">
    <div class="container">
        <div class="row">
            <aside id="column-left" class="col-sm-3">
                <div class="account-content list-group">
                    <div class="box-content">
                        <h3 class="toggled relative">Account</h3>
                        <ul class="list-unstyled nav nav-pills " id="dahboard-tabs" style="background-color: #fff; height: auto;">
                            <li class="nav-item" role="presentation" style="width: 100%;">
                                <a class="fw-semibold active position-relative" id="pills-dashboard-tab" data-bs-toggle="pill" data-bs-target="#pills-dashboard" type="button" role="tab" aria-controls="pills-dashboard" aria-selected="true">Dashboard</a>
                            </li>
                            <li class="nav-item" role="presentation" style="width: 100%;">
                                <a class="fw-semibold position-relative" id="pills-orders-tab" data-bs-toggle="pill" data-bs-target="#pills-orders" type="button" role="tab" aria-controls="pills-orders" aria-selected="false">Orders</a>
                            </li>
                            <li class="nav-item" role="presentation" style="width: 100%;">
                                <a class="fw-semibold position-relative" id="pills-payment-tab" data-bs-toggle="pill" data-bs-target="#pills-payment" type="button" role="tab" aria-controls="pills-orders" aria-selected="false">Payment</a>
                            </li>
                            <li class="nav-item" role="presentation" style="width: 100%;">
                                <a class="fw-semibold position-relative" id="pills-account-tab" data-bs-toggle="pill" data-bs-target="#pills-account" type="button" role="tab" aria-controls="pills-account" aria-selected="false">Account Detail</a>
                            </li>
                            <li><a href="logout.php" class="list-group-item">Log Out</a></li>

                        </ul>
                    </div>
                </div>

            </aside>
            <div id="content" class="col-sm-9 all-blog my-account" style="padding: 0;">
                <div class="tab-content w-100" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-dashboard" role="tabpanel" aria-labelledby="pills-dashboard-tab">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="well p-5">
                                    <h2>Welcome, <?= ($user['cust_name']) ?>!</h2>
                                    <p><strong>Email:</strong> <?= ($user['cust_email']) ?></p>
                                    <p><strong>Phone:</strong> <?= ($user['cust_phone']) ?></p>
                                    <p><strong>Address:</strong> <?= ($user['cust_address']) ?></p>
                                    <p>From your account dashboard, you can view your recent orders, manage your shipping and billing addresses, and edit your password and account details.</p>
                                    <a href="logout.php" class="btn btn-danger">Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }

                    // Check if user is logged in
                    if (!isset($_SESSION['customer_id'])) {
                        echo '<div class="alert alert-danger">Please log in to view your orders.</div>';
                        exit;
                    }
                    ?>

                    <div class="tab-pane fade" id="pills-orders" role="tabpanel" aria-labelledby="pills-orders-tab">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="well p-5">
                                    <h2>Orders</h2>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Order ID</th>
                                                    <th>Payment ID</th>
                                                    <th>Product Name</th>
                                                    <th>Paid</th>
                                                    <th>Size</th>
                                                    <th>Color</th>
                                                    <th>Quantity</th>
                                                    <th>Amount</th>
                                                    <th>Shipping Name</th>
                                                    <th>Shipping Cost</th>
                                                    <th>Total</th>
                                                    <th>Status</th>
                                                    <th>Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Fetch order information with color and size names
                                                $stmt = $pdo->prepare("
                                SELECT o.*, c.color_name, s.size_name
                                FROM tbl_order o
                                LEFT JOIN tbl_color c ON o.color = c.color_id
                                LEFT JOIN tbl_size s ON o.size = s.size_id
                                WHERE o.customer_id = ?
                                ORDER BY o.created_on DESC
                            ");
                                                $stmt->execute([$_SESSION['customer_id']]);
                                                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                if (empty($orders)) {
                                                    echo '<tr><td colspan="12" class="text-center">No orders found.</td></tr>';
                                                } else {
                                                    $i = 0;
                                                    foreach ($orders as $order) {
                                                        $i++;
                                                ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td><?php echo ($order['order_id']); ?></td>
                                                            <td><?php echo ($order['payment_id']); ?></td>
                                                            <td><?php echo ($order['product_name']); ?></td>
                                                            <td><?php echo $order['paid'] ? 'Success' : 'Unpaid'; ?></td>
                                                            <td><?php echo ($order['size_name'] ?: 'N/A'); ?></td>
                                                            <td><?php echo ($order['color_name'] ?: 'N/A'); ?></td>
                                                            <td><?php echo ($order['quantity']); ?></td>
                                                            <td><?php echo ($order['unit_price']); ?></td>
                                                            <td><?php echo ($order['shipping_name']); ?></td>
                                                            <td><?php echo ($order['shipping_cost']); ?></td>
                                                            <td><?php echo ($order['total_price']); ?></td>
                                                            <td><?php echo ($order['order_status']); ?></td>
                                                            <td>
                                                                <a href="order_details.php?order_id=<?php echo urlencode($order['order_id']); ?>" title="View Details">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }

                    // Check if user is logged in
                    if (!isset($_SESSION['customer_id'])) {
                        echo '<div class="alert alert-danger">Please log in to view your orders.</div>';
                        exit;
                    }
                    ?>

                    <div class="tab-pane fade" id="pills-payment" role="tabpanel" aria-labelledby="pills-payment-tab">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="well p-5">
                                    <h2>Payment</h2>
                                    <div class="table-responsive" id="payments-table">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Order ID</th>
                                                    <th>Customer Name</th>
                                                    <th>Customer Phone</th>
                                                    <th>Customer Email</th>
                                                    <th>Customer Address</th>
                                                    <th>Payment ID</th>
                                                    <th>Paid Amount</th>
                                                    <th>Payment Status</th>
                                                    <th>Payment Date</th>
                                                    <th>Size</th>
                                                    <th>Color</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Fetch payment information with color and size names
                                                $stmt = $pdo->prepare("
                                SELECT p.*, o.size, o.color, c.color_name, s.size_name
                                FROM tbl_payment p
                                INNER JOIN tbl_order o ON p.order_id = o.order_id
                                LEFT JOIN tbl_color c ON o.color = c.color_id
                                LEFT JOIN tbl_size s ON o.size = s.size_id
                                WHERE p.customer_id = ?
                                ORDER BY p.created_on DESC
                            ");
                                                $stmt->execute([$_SESSION['customer_id']]);
                                                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                if (empty($orders)) {
                                                    echo '<tr><td colspan="14" class="text-center">No payments found.</td></tr>';
                                                } else {
                                                    $i = 1;
                                                    foreach ($orders as $order) {
                                                        echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        echo '<td>' . ($order['order_id']) . '</td>';
                                                        echo '<td>' . ($order['customer_name']) . '</td>';
                                                        echo '<td>' . ($order['customer_phone']) . '</td>';
                                                        echo '<td>' . ($order['customer_email']) . '</td>';
                                                        echo '<td>' . ($order['customer_address']) . '</td>';
                                                        echo '<td>' . ($order['txnid']) . '</td>';
                                                        echo '<td>' . ($order['paid_amount']) . '</td>';
                                                        echo '<td>' . ($order['payment_status']) . '</td>';
                                                        echo '<td>' . ($order['payment_date']) . '</td>';
                                                        echo '<td>' . ($order['size_name'] ?: 'N/A') . '</td>';
                                                        echo '<td>' . ($order['color_name'] ?: 'N/A') . '</td>';
                                                        echo '<td><i class="fa fa-print" onclick="printPaymentRow(' . $i . ')" class="btn btn-sm btn-primary"></i></td>';
                                                        echo '</tr>';
                                                        $i++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>






                    <div class="tab-pane fade" id="pills-account" role="tabpanel" aria-labelledby="pills-account-tab">
                        <?php if (!empty($error_message)) : ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php endif; ?>

                        <?php if (!empty($success_message)) : ?>
                            <div class="alert alert-success"><?php echo $success_message; ?></div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="well p-5">
                                    <h2>Account Details</h2>
                                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                        <input type="hidden" name="form_type" value="account_update">
                                        <fieldset>
                                            <div class="form-group required row">
                                                <div class="col-lg-6 pt-3">
                                                    <label for="input-firstname">First Name</label>
                                                    <input type="text" id="input-firstname" class="form-control" name="first_name" value="<?php echo (explode(' ', $user['cust_name'])[0] ?? ''); ?>" required placeholder="Sumit">
                                                </div>
                                                <div class="col-lg-6 pt-3">
                                                    <label for="input-lastname">Last Name</label>
                                                    <input type="text" id="input-lastname" class="form-control" name="last_name" value="<?php echo (explode(' ', $user['cust_name'])[1] ?? ''); ?>" required placeholder="Rathore">
                                                </div>
                                                <div class="col-lg-12 pt-3">
                                                    <label for="input-email">Email</label>
                                                    <input type="email" id="input-email" class="form-control" name="email" value="<?php echo ($user['cust_email']); ?>" required>
                                                </div>
                                                <div class="col-lg-12 pt-3">
                                                    <label for="input-phone">Phone No.</label>
                                                    <input type="number" id="input-phone" class="form-control" name="phone" value="<?php echo ($user['cust_phone']); ?>" required>
                                                </div>
                                                <div class="col-lg-12 pt-3">
                                                    <label for="input-address">Billing Address</label>
                                                    <input type="text" id="input-address" class="form-control" name="address" value="<?php echo ($user['cust_address']); ?>" required>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-info">Save Changes</button>
                                        </fieldset>
                                    </form>
                                </div>

                                <div class="well p-5" style="padding-top: 0 !important;">
                                    <h2>Password Change</h2>
                                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                        <input type="hidden" name="form_type" value="password_update">
                                        <fieldset>
                                            <div class="form-group required row">
                                                <div class="col-lg-6 pt-3">
                                                    <label for="input-new-password">New Password</label>
                                                    <input type="password" id="input-new-password" class="form-control" name="new_password" required />
                                                </div>
                                                <div class="col-lg-12 pt-3">
                                                    <button type="submit" class="btn btn-info">Save Changes</button>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<!-- .My Account -->


<!-- footer -->
<?php include('include/footer.php'); ?>
<!-- .footer -->



<!-- JavaScript for Print Function -->
<script>
    function printPaymentRow(rowIndex) {
        try {
            // Get the table inside the payments-table div
            var table = document.querySelector('#payments-table table');
            if (!table) {
                console.error('Table not found');
                alert('Error: Table not found');
                return;
            }

            // Adjust rowIndex (1-based from PHP) to account for header row (index 0 in DOM)
            var row = table.getElementsByTagName('tr')[rowIndex];
            if (!row) {
                console.error('Row not found at index: ' + rowIndex);
                alert('Error: Row not found');
                return;
            }

            var cells = row.getElementsByTagName('td');
            if (cells.length < 13) {
                console.error('Insufficient cells in row: ' + cells.length);
                alert('Error: Invalid row data');
                return;
            }

            // Extract data from the row (excluding the last cell with the Print button)
            var data = {
                sno: cells[0].innerText || 'N/A',
                orderId: cells[1].innerText || 'N/A',
                customerName: cells[2].innerText || 'N/A',
                customerPhone: cells[3].innerText || 'N/A',
                customerEmail: cells[4].innerText || 'N/A',
                customerAddress: cells[5].innerText || 'N/A',
                paymentId: cells[6].innerText || 'N/A',
                paidAmount: cells[7].innerText || 'N/A',
                paymentStatus: cells[8].innerText || 'N/A',
                paymentDate: cells[10].innerText || 'N/A',
                size: cells[11].innerText || 'N/A',
                color: cells[12].innerText || 'N/A'
            };

            // Try to create a new window for printing
            var printWindow = window.open('', '_blank', 'width=800,height=600');
            if (!printWindow) {
                console.warn('Failed to open print window, falling back to current window');
                // Fallback: Create a hidden div in the current document and print it
                var printDiv = document.createElement('div');
                printDiv.style.display = 'none';
                printDiv.innerHTML = `
                <div class="header">
                    <h2>Payment Details</h2>
                    <p>Printed on: ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}</p>
                </div>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border: 1px solid #ddd; background-color: #f2f2f2;">
                            <th style="padding: 8px; text-align: left;">S.No</th>
                            <th style="padding: 8px; text-align: left;">Order ID</th>
                            <th style="padding: 8px; text-align: left;">Customer Name</th>
                            <th style="padding: 8px; text-align: left;">Customer Phone</th>
                            <th style="padding: 8px; text-align: left;">Customer Email</th>
                            <th style="padding: 8px; text-align: left;">Customer Address</th>
                            <th style="padding: 8px; text-align: left;">Payment ID</th>
                            <th style="padding: 8px; text-align: left;">Paid Amount</th>
                            <th style="padding: 8px; text-align: left;">Payment Status</th>
                            <th style="padding: 8px; text-align: left;">Payment Date</th>
                            <th style="padding: 8px; text-align: left;">Size</th>
                            <th style="padding: 8px; text-align: left;">Color</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border: 1px solid #ddd;">
                            <td style="padding: 8px;">${data.sno}</td>
                            <td style="padding: 8px;">${data.orderId}</td>
                            <td style="padding: 8px;">${data.customerName}</td>
                            <td style="padding: 8px;">${data.customerPhone}</td>
                            <td style="padding: 8px;">${data.customerEmail}</td>
                            <td style="padding: 8px;">${data.customerAddress}</td>
                            <td style="padding: 8px;">${data.paymentId}</td>
                            <td style="padding: 8px;">${data.paidAmount}</td>
                            <td style="padding: 8px;">${data.paymentStatus}</td>
                            <td style="padding: 8px;">${data.paymentDate}</td>
                            <td style="padding: 8px;">${data.size}</td>
                            <td style="padding: 8px;">${data.color}</td>
                        </tr>
                    </tbody>
                </table>
            `;
                document.body.appendChild(printDiv);

                // Use media query to hide everything except the print content
                var style = document.createElement('style');
                style.innerHTML = `
                @media print {
                    body > *:not(#print-content) { display: none; }
                    #print-content { display: block !important; }
                }
            `;
                document.head.appendChild(style);
                printDiv.id = 'print-content';
                printDiv.style.display = 'block';

                window.print();

                // Clean up
                document.body.removeChild(printDiv);
                document.head.removeChild(style);
                return;
            }

            // Write the row data to the new window with styling
            printWindow.document.write(`
            <html>
            <head>
                <title>Print Payment Details</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; }
                    .header { margin-bottom: 20px; }
                </style>
            </head>
            <body>
                <div class="header">
                    <h2>Payment Details</h2>
                    <p>Printed on: ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}</p>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Customer Phone</th>
                            <th>Customer Email</th>
                            <th>Customer Address</th>
                            <th>Payment ID</th>
                            <th>Paid Amount</th>
                            <th>Payment Status</th>
                            <th>Payment Date</th>
                            <th>Size</th>
                            <th>Color</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>${data.sno}</td>
                            <td>${data.orderId}</td>
                            <td>${data.customerName}</td>
                            <td>${data.customerPhone}</td>
                            <td>${data.customerEmail}</td>
                            <td>${data.customerAddress}</td>
                            <td>${data.paymentId}</td>
                            <td>${data.paidAmount}</td>
                            <td>${data.paymentStatus}</td>
                            <td>${data.paymentDate}</td>
                            <td>${data.size}</td>
                            <td>${data.color}</td>
                        </tr>
                    </tbody>
                </table>
            </body>
            </html>
        `);

            printWindow.document.close();
            printWindow.focus();
            // Delay print to ensure content renders
            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 500);
        } catch (error) {
            console.error('Error in printPaymentRow:', error);
            alert('Error: Unable to print. Please check if popups are enabled and try again.');
        }
    }
</script>
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