<?php require_once('header.php'); ?>

<?php
if (!isset($_REQUEST['id'])) {
    header('location: shipping-cost.php');
    exit;
} else {
    // Check if ID is valid
    $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE shipping_cost_id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    if ($total == 0) {
        header('location: shipping-cost.php');
        exit;
    } else {
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $current_name = $result['name'];
        $current_amount = $result['amount'];
    }
}

if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    if (empty($_POST['name'])) {
        $valid = 0;
        $error_message .= "Name cannot be empty<br>";
    } else {
        // Check for duplicate name
        $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE name=? AND shipping_cost_id!=?");
        $statement->execute(array($_POST['name'], $_REQUEST['id']));
        $total = $statement->rowCount();
        if ($total) {
            $valid = 0;
            $error_message .= "Name already exists<br>";
        }
    }


    if ($valid == 1) {


        // Generate a URL-friendly slug
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['name'])));
        $slug_url = rtrim($slug_url, '-');
        $url = $slug_url;

        // Update the database
        $statement = $pdo->prepare("UPDATE tbl_shipping_cost SET name=?,url=? , amount=? WHERE shipping_cost_id=?");
        $statement->execute(array($_POST['name'], $url, $_POST['amount'], $_REQUEST['id']));

        $success_message = 'Shipping Cost is updated successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Shiiping Cost</h1>
    </div>
    <div class="content-header-right">
        <a href="shipping-cost.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-12">

            <?php if (!empty($error_message)) : ?>
                <div class="callout callout-danger">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($success_message)) : ?>
                <div class="callout callout-success">
                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Shipping Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="name" value="<?php echo $current_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Amount Rs. <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="amount" value="<?php echo $current_amount; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

</section>

<?php require_once('footer.php'); ?>