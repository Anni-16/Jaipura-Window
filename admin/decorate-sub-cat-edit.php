<?php require_once('header.php'); ?>

<?php
if (!isset($_REQUEST['id'])) {
    header('location: decorate-sub-cat.php');
    exit;
} else {
    // Check if the ID is valid
    $statement = $pdo->prepare("SELECT * FROM tbl_decorate_sub_category WHERE sub_cat_id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    if ($total == 0) {
        header('location: decorate-sub-cat.php');
        exit;
    }
}

// Get current data
$statement = $pdo->prepare("SELECT * FROM tbl_decorate_sub_category WHERE sub_cat_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetch(PDO::FETCH_ASSOC);
$current_name = $result['sub_cat_name'];
$current_image = $result['sub_cat_image'];
$current_cat_id = $result['cat_id'];
$current_show_status = $result['show_status'];

if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    if (empty($_POST['sub_cat_name'])) {
        $valid = 0;
        $error_message .= "Sub Category Name cannot be empty<br>";
    } else {
        // Check for duplicate category name
        $statement = $pdo->prepare("SELECT * FROM tbl_decorate_sub_category WHERE sub_cat_name=? AND sub_cat_id!=?");
        $statement->execute(array($_POST['sub_cat_name'], $_REQUEST['id']));
        $total = $statement->rowCount();
        if ($total) {
            $valid = 0;
            $error_message .= "Sub Category Name already exists<br>";
        }
    }

    if ($valid == 1) {
        // Handle file upload
        if (isset($_FILES['sub_cat_image']['name']) && $_FILES['sub_cat_image']['name'] != '') {
            $path = $_FILES['sub_cat_image']['name'];
            $path_tmp = $_FILES['sub_cat_image']['tmp_name'];

            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($ext, $allowed_ext)) {
                $valid = 0;
                $error_message .= 'You must upload a JPG, JPEG, PNG, or GIF file<br>';
            } else {
                // Delete the existing image
                if ($current_image != '') {
                    unlink('./uploads/decorate/subcategory/' . $current_image);
                }

                // Upload new image
                $final_name = 'sub-category-' . time() . '.' . $ext;
                move_uploaded_file($path_tmp, './uploads/decorate/subcategory/' . $final_name);
            }
        } else {
            $final_name = $current_image;
        }

        // Generate a URL-friendly slug
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['sub_cat_name'])));
        $slug_url = rtrim($slug_url, '-');
        $url = $slug_url;

        // Ensure show_status is an integer
        $show_status = (int) $_POST['show_status'];

        // Update database
        $statement = $pdo->prepare("UPDATE tbl_decorate_sub_category SET sub_cat_name=?, url=?, sub_cat_image=?, cat_id=?, show_status=? WHERE sub_cat_id=?");
        $statement->execute(array($_POST['sub_cat_name'], $url, $final_name, $_POST['cat_id'], $show_status, $_REQUEST['id']));

        $success_message = 'Sub Category updated successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Sub Category</h1>
    </div>
    <div class="content-header-right">
        <a href="decorate-sub-cat.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php if (!empty($error_message)): ?>
                <div class="callout callout-danger">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($success_message)): ?>
                <div class="callout callout-success">
                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="cat_id" class="form-control select2">
                                    <option value="">Select Category</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_decorate_category ORDER BY cat_name ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        ?>
                                        <option value="<?php echo $row['cat_id']; ?>" <?php echo ($row['cat_id'] == $current_cat_id) ? 'selected' : ''; ?>>
                                            <?php echo $row['cat_name']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Sub Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="sub_cat_name" value="<?php echo $current_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Existing Image</label>
                            <div class="col-sm-4">
                                <img src="./uploads/decorate/subcategory/<?php echo $current_image; ?>" alt="<?php echo $current_name; ?>" style="width:100px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">New Image</label>
                            <div class="col-sm-4">
                                <input type="file" class="form-control" name="sub_cat_image">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="show_status" class="form-control" style="width:auto;">
                                    <option value="0" <?php echo ($current_show_status == 0) ? 'selected' : ''; ?>>No</option>
                                    <option value="1" <?php echo ($current_show_status == 1) ? 'selected' : ''; ?>>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
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
