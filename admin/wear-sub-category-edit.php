<?php require_once('header.php'); ?>

<?php
if (!isset($_REQUEST['id'])) {
    header('location: mid-category.php');
    exit;
} else {
    // Check if the ID is valid
    $statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE mcat_id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    if ($total == 0) {
        header('location: mid-category.php');
        exit;
    }
}

// Get current data
$statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE mcat_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetch(PDO::FETCH_ASSOC);
$current_name = $result['mcat_name'];
$current_image = $result['mcat_image'];
$current_tcat_id = $result['tcat_id'];
$current_status = $result['status'];

if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    if (empty($_POST['mcat_name'])) {
        $valid = 0;
        $error_message .= "Sub Category Name cannot be empty<br>";
    }

    if ($valid == 1) {
        // Handle file upload
        if (isset($_FILES['mcat_image']['name']) && $_FILES['mcat_image']['name'] != '') {
            $path = $_FILES['mcat_image']['name'];
            $path_tmp = $_FILES['mcat_image']['tmp_name'];

            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($ext, $allowed_ext)) {
                $valid = 0;
                $error_message .= 'You must upload a JPG, JPEG, PNG, or GIF file<br>';
            } else {
                // Delete the existing image
                if ($current_image != '') {
                    unlink('./uploads/wear/subcategory/' . $current_image);
                }

                // Upload new image
                $final_name = 'sub-category-' . time() . '.' . $ext;
                move_uploaded_file($path_tmp, './uploads/wear/subcategory/' . $final_name);
            }
        } else {
            $final_name = $current_image;
        }

        
        // Generate a URL-friendly slug
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['mcat_name'])));
        $slug_url = rtrim($slug_url, '-');
        $url = $slug_url;

        // Update database
        $statement = $pdo->prepare("UPDATE tbl_mid_category SET mcat_name=?,url=?, mcat_image=?, tcat_id=?, status=? WHERE mcat_id=?");
        $statement->execute(array($_POST['mcat_name'], $url,$final_name, $_POST['tcat_id'], $_POST['status'], $_REQUEST['id']));

        $success_message = 'Sub Category updated successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Sub Category</h1>
    </div>
    <div class="content-header-right">
        <a href="wear-sub-category.php" class="btn btn-primary btn-sm">View All</a>
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
                                <select name="tcat_id" class="form-control select2">
                                    <option value="">Select Category</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_top_category ORDER BY tcat_name ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        ?>
                                        <option value="<?php echo $row['tcat_id']; ?>" <?php echo ($row['tcat_id'] == $current_tcat_id) ? 'selected' : ''; ?>>
                                            <?php echo $row['tcat_name']; ?>
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
                                <input type="text" class="form-control" name="mcat_name" value="<?php echo $current_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Existing Image</label>
                            <div class="col-sm-4">
                                <img src="./uploads/wear/subcategory/<?php echo $current_image; ?>" alt="<?php echo $current_name; ?>" style="width:100px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">New Image</label>
                            <div class="col-sm-4">
                                <input type="file" class="form-control" name="mcat_image">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="status" class="form-control" style="width:auto;">
                                    <option value="0" <?php echo ($current_status == 0) ? 'selected' : ''; ?>>No</option>
                                    <option value="1" <?php echo ($current_status == 1) ? 'selected' : ''; ?>>Yes</option>
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
