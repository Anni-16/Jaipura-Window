<?php require_once('header.php'); ?>

<?php
// Validate and sanitize cust_id from URL
$cust_id = isset($_GET['cust_id']) ? filter_var($_GET['cust_id'], FILTER_VALIDATE_INT) : 0;
if (!$cust_id) {
    echo "<script>alert('Invalid customer ID.'); window.location.href='view_orders.php';</script>";
    exit;
}

// Get Customer Details
$statement = $pdo->prepare("SELECT cust_name, cust_email FROM tbl_customer WHERE cust_id = ?");
$statement->execute(array($cust_id));
$customer = $statement->fetch(PDO::FETCH_ASSOC);
if (!$customer) {
    echo "<script>alert('Customer not found.'); window.location.href='view_orders.php';</script>";
    exit;
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Orders for <?php echo ($customer['cust_name']); ?> (<?php echo ($customer['cust_email']); ?>)</h1>
    </div>
    <div class="content-header-right">
        <a href="view_orders.php" class="btn btn-primary btn-sm">Back to Orders</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>ID</th>
                                <th>Order ID</th>
                                <th>Payment ID</th>
                                <th>Product Name</th>
                                <th>Status</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Unit Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $statement = $pdo->prepare("SELECT o.id, o.order_id, o.payment_id, o.product_name, o.status, o.size, o.color, o.quantity, o.amount, o.unit_price 
                                                        FROM tbl_order o 
                                                        LEFT JOIN tbl_payment p ON o.payment_id = p.payment_id 
                                                        WHERE p.customer_id = ? 
                                                        ORDER BY o.id DESC");
                            $statement->execute(array($cust_id));
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            if ($result) {
                                foreach ($result as $row) {
                                    $i++;
                            ?>
                                    <tr class="<?php echo ($row['status'] == 'Placed') ? 'bg-r' : ($row['status'] == 'Shipped' ? 'bg-y' : 'bg-g'); ?>">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo ($row['id']); ?></td>
                                        <td><?php echo ($row['order_id']); ?></td>
                                        <td><?php echo ($row['payment_id']); ?></td>
                                        <td><?php echo ($row['product_name']); ?></td>
                                        <td><?php echo ($row['status']); ?></td>
                                        <td><?php echo ($row['size'] ?? 'N/A'); ?></td>
                                        <td><?php echo ($row['color'] ?? 'N/A'); ?></td>
                                        <td><?php echo ($row['quantity']); ?></td>
                                        <td><?php echo ($row['amount']); ?></td>
                                        <td><?php echo ($row['unit_price'] ?? 'N/A'); ?></td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="11">No orders found for this customer.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>