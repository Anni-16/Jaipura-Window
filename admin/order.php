<?php require_once('header.php'); ?>

<?php
$error_message = '';
$success_message = '';

// Handle Status Update
if (isset($_POST['form_status'])) {
    $valid = 1;
    $order_id = filter_var($_POST['order_id'], FILTER_VALIDATE_INT);
    $new_status = trim($_POST['status']);

    // Validate status
    $allowed_statuses = ['Pending', 'Shipped', 'Delivered'];
    if (!in_array($new_status, $allowed_statuses)) {
        $valid = 0;
        $error_message = "Invalid status selected.";
    }

    if (!$order_id) {
        $valid = 0;
        $error_message = "Invalid order ID.";
    }

    if ($valid == 1) {
        try {
            // Begin transaction
            $pdo->beginTransaction();

            // Update tbl_order
            $statement = $pdo->prepare("UPDATE tbl_order SET order_status = ? WHERE id = ?");
            $statement->execute([$new_status, $order_id]);

            // Commit transaction
            $pdo->commit();
            $success_message = "Order status updated successfully in both tables.";
        } catch (Exception $e) {
            // Rollback transaction on error
            $pdo->rollBack();
            $error_message = "Failed to update status: " . $e->getMessage();
        }
    }
}

// Handle Message Sending (unchanged)
if (isset($_POST['form1'])) {
    $valid = 1;
    if (empty($_POST['subject_text'])) {
        $valid = 0;
        $error_message .= 'Subject cannot be empty\n';
    }
    if (empty($_POST['message_text'])) {
        $valid = 0;
        $error_message .= 'Message cannot be empty\n';
    }
    if ($valid == 1) {
        $subject_text = strip_tags($_POST['subject_text']);
        $message_text = strip_tags($_POST['message_text']);
        $cust_id = filter_var($_POST['cust_id'], FILTER_VALIDATE_INT);
        $payment_id = isset($_POST['payment_id']) ? preg_replace('/[^a-zA-Z0-9-_]/', '', trim($_POST['payment_id'])) : '';

        if (!$cust_id || !$payment_id) {
            $error_message = "Invalid customer or payment ID.";
        } else {
            // Getting Customer Email Address
            $statement = $pdo->prepare("SELECT cust_email, cust_name FROM tbl_customer WHERE cust_id = ?");
            $statement->execute([$cust_id]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                $error_message = "Customer not found.";
            } else {
                $cust_email = $result['cust_email'];
                $cust_name = $result['cust_name'];

                // Getting Admin Email Address
                $statement = $pdo->prepare("SELECT contact_email FROM tbl_settings WHERE id = 1");
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                $admin_email = $result['contact_email'] ?? '';

                // Fetch Order Details with Size and Color Names
                $order_detail = '';
                $statement = $pdo->prepare("
                    SELECT o.*, s.size_name, c.color_name
                    FROM tbl_order o
                    LEFT JOIN tbl_size s ON o.size = s.size_id
                    LEFT JOIN tbl_color c ON o.color = c.color_id
                    WHERE o.payment_id = ?
                ");
                $statement->execute([$payment_id]);
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                if ($result) {
                    $i = 0;
                    foreach ($result as $row) {
                        $i++;
                        $order_detail .= '
                            <br><b><u>Product Item ' . $i . '</u></b><br>
                            Order ID: ' . ($row['order_id'] ?? 'N/A') . '<br>
                            Product Name: ' . ($row['product_name'] ?? 'N/A') . '<br>
                            Status: ' . ($row['order_status'] ?? 'N/A') . '<br>
                            Size: ' . ($row['size_name'] ?? 'N/A') . '<br>
                            Color: ' . ($row['color_name'] ?? 'N/A') . '<br>
                            Quantity: ' . ($row['quantity'] ?? 'N/A') . '<br>
                            Unit Price: ' . ($row['unit_price'] ?? 'N/A') . '<br>
                            Total Price: ' . ($row['total_price'] ?? 'N/A') . '<br>';
                    }

                    // Insert Message into Database
                    $statement = $pdo->prepare("INSERT INTO tbl_customer_message (subject, message, order_detail, cust_id) VALUES (?, ?, ?, ?)");
                    $statement->execute([$subject_text, $message_text, $order_detail, $cust_id]);

                    // Sending Email
                    $to_customer = $cust_email;
                    $message = '
<html><body>
<h3>Message: </h3>
' . ($message_text) . '
<h3>Order Details: </h3>
' . $order_detail . '
</body></html>';
                    $headers = 'From: ' . $admin_email . "\r\n" .
                               'Reply-To: ' . $admin_email . "\r\n" .
                               'X-Mailer: PHP/' . phpversion() . "\r\n" .
                               "MIME-Version: 1.0\r\n" .
                               "Content-Type: text/html; charset=UTF-8\r\n";

                    if (mail($to_customer, $subject_text, $message, $headers)) {
                        $success_message = 'Your email to the customer was sent successfully.';
                    } else {
                        $error_message = 'Failed to send email to the customer.';
                    }
                } else {
                    $error_message = "Order not found.";
                }
            }
        }
    }
}
?>

<?php
if ($error_message != '') {
    echo "<script>alert('" . addslashes($error_message) . "')</script>";
}
if ($success_message != '') {
    echo "<script>alert('" . addslashes($success_message) . "')</script>";
}
?>

<!-- Rest of the HTML remains unchanged -->
<section class="content-header">
    <div class="content-header-left">
        <h1>View Orders</h1>
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
                                <th>Order ID</th>
                                <th>Payment ID</th>
                                <th>Product Name</th>
                                <th>Product Size</th>
                                <th>Product Color</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Shipping Name</th>
                                <th>Shipping Cost</th>
                                <th>Total Price</th>
                                <th>Payment Status</th>
                                <th>Date And Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $statement = $pdo->prepare("
                                SELECT o.id, o.order_id, o.payment_id, o.product_name, o.order_status, o.quantity, o.unit_price,o.shipping_name,o.shipping_cost, o.total_price, o.created_on, 
                                       p.customer_id AS cust_id, p.payment_status, 
                                       c.cust_name, s.size_name, cl.color_name
                                FROM tbl_order o
                                LEFT JOIN tbl_payment p ON o.payment_id = p.txnid
                                LEFT JOIN tbl_customer c ON p.customer_id = c.user_id
                                LEFT JOIN tbl_size s ON o.size = s.size_id
                                LEFT JOIN tbl_color cl ON o.color = cl.color_id
                                ORDER BY o.id DESC
                            ");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $i++;
                            ?>
                                <tr class="<?php echo ($row['order_status'] == 'Pending') ? 'bg-r' : ($row['order_status'] == 'Shipped' ? 'bg-y' : 'bg-g'); ?>">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo ($row['order_id'] ?: 'N/A'); ?></td>
                                    <td><?php echo ($row['payment_id'] ?: 'N/A'); ?></td>
                                    <td><?php echo ($row['product_name'] ?: 'N/A'); ?></td>
                                    <td><?php echo ($row['size_name'] ?: 'N/A'); ?></td>
                                    <td><?php echo ($row['color_name'] ?: 'N/A'); ?></td>
                                    <td><?php echo ($row['quantity'] ?: 'N/A'); ?></td>
                                    <td><?php echo ($row['unit_price'] ?: 'N/A'); ?></td>
                                    <td><?php echo ($row['shipping_name'] ?: 'N/A'); ?></td>
                                    <td><?php echo ($row['shipping_cost'] ?: 'N/A'); ?></td>
                                    <td><?php echo ($row['total_price'] ?: 'N/A'); ?></td>
                                    <td class="<?php echo ($row['payment_status'] == 'Paid') ? 'text-success' : 'text-danger'; ?>">
                                        <?php echo ($row['payment_status'] ?: 'N/A'); ?>
                                    </td>
                                    <td><?php echo ($row['created_on'] ?: 'N/A'); ?></td>
                                    <td>
                                        <form action="" method="post" style="margin-bottom:4px;">
                                            <input type="hidden" name="order_id" value="<?php echo ($row['id']); ?>">
                                            <select name="status" onchange="this.form.submit()" class="form-control" style="width:100%;">
                                                <option value="Pending" <?php echo ($row['order_status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                <option value="Shipped" <?php echo ($row['order_status'] == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
                                                <option value="Delivered" <?php echo ($row['order_status'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                                            </select>
                                            <input type="hidden" name="form_status">
                                        </form>
                                        <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#model-<?php echo $i; ?>">Send Message</button>
                                        <!-- Message Modal -->
                                        <div id="model-<?php echo $i; ?>" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                                        <h4 class="modal-title" style="font-weight: bold;">Send Message</h4>
                                                    </div>
                                                    <div class="modal-body" style="font-size: 14px">
                                                        <form action="" method="post">
                                                            <input type="hidden" name="cust_id" value="<?php echo ($row['cust_id']); ?>">
                                                            <input type="hidden" name="payment_id" value="<?php echo ($row['payment_id']); ?>">
                                                            <table class="table table-bordered">
                                                                <tr>
                                                                    <td>Subject</td>
                                                                    <td>
                                                                        <input type="text" name="subject_text" class="form-control" style="width: 100%;">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Message</td>
                                                                    <td>
                                                                        <textarea name="message_text" class="form-control" cols="30" rows="10" style="width:100%;height: 200px;"></textarea>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><input type="submit" value="Send Message" name="form1"></td>
                                                                </tr>
                                                            </table>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>