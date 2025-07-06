<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    if(empty($_POST['name'])) {
        $valid = 0;
        $error_message .= "Name cannot be empty<br>";
    } else {
        // Duplicate Category checking
        $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE name=?");
        $statement->execute(array($_POST['name']));
        $total = $statement->rowCount();
        if($total) {
            $valid = 0;
            $error_message .= " Name already exists<br>";
        }
    }

    if($valid == 1) {
        
        // Insert data into the main table
        $statement = $pdo->prepare("INSERT INTO tbl_shipping_cost (name, amount) VALUES (?, ?)");
        $statement->execute(array($_POST['name'], $_POST['amount']));

        
        $tcat_id = $pdo->lastInsertId();
        
        // Create a URL-friendly slug
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['name'])));
        $slug_url = rtrim($slug_url, '-'); 
        $url = $slug_url ; 

        // Update the category with the generated slug
        $statement = $pdo->prepare("UPDATE tbl_shipping_cost SET url=? WHERE shipping_cost_id=?");
        $statement->execute(array($url, $tcat_id));

        $success_message = 'Shipping Cost added successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Shipping Cost</h1>
    </div>
    <div class="content-header-right">
        <a href="shipping-cost.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if(!empty($error_message)): ?>
            <div class="callout callout-danger">
                <p><?php echo $error_message; ?></p>
            </div>
            <?php endif; ?>

            <?php if(!empty($success_message)): ?>
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
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Amount Rs.  <span>*</span></label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control" name="amount">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
