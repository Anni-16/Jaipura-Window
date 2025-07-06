<?php require_once('header.php'); ?>

<?php
$error_message = '';
$success_message = '';
$current_image = '';
$current_name = '';
$current_status = '';
$current_tcat_id = '';

if (!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    // Fetch existing category data
    $statement = $pdo->prepare("SELECT * FROM tbl_end_category WHERE ecat_id=?");
    $statement->execute([$_REQUEST['id']]);
    $total = $statement->rowCount();
    if ($total == 0) {
        header('location: logout.php');
        exit;
    } else {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $ecat_name = $row['ecat_name'];
        $current_image = $row['ecat_image'];
        $mcat_id = $row['mcat_id'];
        $current_status = $row['show'];

        // Fetch associated top-level category
        $statement = $pdo->prepare("SELECT tcat_id FROM tbl_mid_category WHERE mcat_id=?");
        $statement->execute([$mcat_id]);
        $mid_category = $statement->fetch(PDO::FETCH_ASSOC);
        $current_tcat_id = $mid_category['tcat_id'] ?? '';
    }
}

if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['tcat_id'])) {
        $valid = 0;
        $error_message .= "You must select a top-level category.<br>";
    }
    if (empty($_POST['mcat_id'])) {
        $valid = 0;
        $error_message .= "You must select a mid-level category.<br>";
    }
    if (empty($_POST['ecat_name'])) {
        $valid = 0;
        $error_message .= "End level category name cannot be empty.<br>";
    }

    if ($valid == 1) {
        $final_name = $current_image;

        if (isset($_FILES['ecat_image']['name']) && $_FILES['ecat_image']['error'] == 0) {
            $file_name = basename($_FILES['ecat_image']['name']);
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($file_ext, $allowed_ext)) {
                $valid = 0;
                $error_message .= "You must upload a JPG, JPEG, PNG, or GIF file.<br>";
            } else {
                if (!empty($current_image) && file_exists('./uploads/wear/endcategory/' . $current_image)) {
                    unlink('./uploads/wear/endcategory/' . $current_image);
                }
                $final_name = 'end-category-' . time() . '.' . $file_ext;
                move_uploaded_file($_FILES['ecat_image']['tmp_name'], './uploads/wear/endcategory/' . $final_name);
            }
        }

        if ($valid == 1) {
            // Generate slug
            $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['ecat_name'])));
            $slug_url = rtrim($slug_url, '-');
            $url = $slug_url;
            $statement = $pdo->prepare("UPDATE tbl_end_category SET ecat_name=?, url=?, ecat_image=?, `show`=?, mcat_id=? WHERE ecat_id=?");

            $update = $statement->execute([
                $_POST['ecat_name'],
                $url,
                $final_name,
                $_POST['show'],
                $_POST['mcat_id'],
                $_REQUEST['id']
            ]);
            

            if ($update) {
                $success_message = "End Category updated successfully.";
            } else {
                $errorInfo = $statement->errorInfo();
                $error_message .= "Database update failed: " . $errorInfo[2] . "<br>";
            }
        }
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit End Level Category</h1>
    </div>
    <div class="content-header-right">
        <a href="wear-end-category.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if ($error_message) : ?>
                <div class="callout callout-danger">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>
            <?php if ($success_message) : ?>
                <div class="callout callout-success">
                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Category Name <span>*</span></label>
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
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Mid-Level Category <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="mcat_id" class="form-control select2">
                                    <option value="">Select Sub Category</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=? ORDER BY mcat_name ASC");
                                    $statement->execute([$current_tcat_id]);
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                    ?>
                                        <option value="<?php echo $row['mcat_id']; ?>" <?php echo ($row['mcat_id'] == $mcat_id) ? 'selected' : ''; ?>>
                                            <?php echo $row['mcat_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">End Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="ecat_name" value="<?php echo htmlspecialchars($ecat_name); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Existing Image</label>
                            <div class="col-sm-4">
                                <img src="./uploads/wear/endcategory/<?php echo $current_image; ?>" style="width:100px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">New Image</label>
                            <div class="col-sm-4">
                                <input type="file" class="form-control" name="ecat_image">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="show" class="form-control" style="width:auto;">
                                    <option value="0" <?php echo ($current_status == 0) ? 'selected' : ''; ?>>No</option>
                                    <option value="1" <?php echo ($current_status == 1) ? 'selected' : ''; ?>>Yes</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-success" name="form1">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
