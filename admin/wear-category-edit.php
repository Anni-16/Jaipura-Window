<?php require_once('header.php'); ?>

<?php
if (!isset($_REQUEST['id'])) {
    header('location: wear-category.php');
    exit;
} else {
    // Check if ID is valid
    $statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE tcat_id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    if ($total == 0) {
        header('location: wear-category.php');
        exit;
    } else {
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $current_name = $result['tcat_name'];
    }
}

if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    if (empty($_POST['tcat_name'])) {
        $valid = 0;
        $error_message .= "Category Name cannot be empty<br>";
    } else {
        // Check for duplicate name
        $statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE tcat_name=? AND tcat_id!=?");
        $statement->execute(array($_POST['tcat_name'], $_REQUEST['id']));
        $total = $statement->rowCount();
        if ($total) {
            $valid = 0;
            $error_message .= "Category Name already exists<br>";
        }
    }


    if ($valid == 1) {


        // Generate a URL-friendly slug
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['tcat_name'])));
        $slug_url = rtrim($slug_url, '-');
        $url = $slug_url;

        // Update the database
        $statement = $pdo->prepare("UPDATE tbl_top_category SET tcat_name=?,url=? , show_on_menu=? WHERE tcat_id=?");
        $statement->execute(array($_POST['tcat_name'],$url, $_POST['show_on_menu'], $_REQUEST['id']));

        $success_message = 'Category is updated successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Categories</h1>
    </div>
    <div class="content-header-right">
        <a href="wear-category.php" class="btn btn-primary btn-sm">View All</a>
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
                            <label for="" class="col-sm-2 control-label">Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="tcat_name" value="<?php echo $current_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="show_on_menu" class="form-control" style="width:auto;">
                                    <option value="0" <?php if ($result['show_on_menu'] == 0) echo 'selected'; ?>>No</option>
                                    <option value="1" <?php if ($result['show_on_menu'] == 1) echo 'selected'; ?>>Yes</option>
                                </select>
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