<?php require_once('header.php'); ?>

<?php
if (!isset($_REQUEST['id'])) {
    header('location: accessroies-cat.php');
    exit;
} else {
    // Check if ID is valid
    $statement = $pdo->prepare("SELECT * FROM tbl_accessroies_category WHERE cat_id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    if ($total == 0) {
        header('location: accessroies-cat.php');
        exit;
    } else {
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $current_name = $result['cat_name'];
        $current_image = $result['cat_image'];
    }
}

if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    if (empty($_POST['cat_name'])) {
        $valid = 0;
        $error_message .= "Category Name cannot be empty<br>";
    } else {
        // Check for duplicate name
        $statement = $pdo->prepare("SELECT * FROM tbl_accessroies_category WHERE cat_name=? AND cat_id!=?");
        $statement->execute(array($_POST['cat_name'], $_REQUEST['id']));
        $total = $statement->rowCount();
        if ($total) {
            $valid = 0;
            $error_message .= "Category Name already exists<br>";
        }
    }

    $path = $_FILES['cat_image']['name'];
    $path_tmp = $_FILES['cat_image']['tmp_name'];

    if ($path != '') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif' && $ext != 'JPG' && $ext != 'JPEG' && $ext != 'PNG' && $ext != 'GIF') {
            $valid = 0;
            $error_message .= 'You must upload a jpg, jpeg, gif, or png file<br>';
        }
    }

    if ($valid == 1) {
        // If a new image is uploaded, replace the old one
        if ($path != '') {
            $final_name = 'category-' . $current_name . '.' . $ext;
            move_uploaded_file($path_tmp, './uploads/accessroies/category/' . $final_name);

            // Remove old image
            if (file_exists('./uploads/accessroies/category/' . $current_image) && $current_image != '') {
                unlink('./uploads/accessroies/category/' . $current_image);
            }
        } else {
            $final_name = $current_image;
        }

        // Generate a URL-friendly slug
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['cat_name'])));
        $slug_url = rtrim($slug_url, '-');
        $url = $slug_url;

        // Update the database
        $statement = $pdo->prepare("UPDATE tbl_accessroies_category SET cat_name=?, url=?,cat_image=?, status=? WHERE cat_id=?");
        $statement->execute(array($_POST['cat_name'], $url, $final_name, $_POST['status'], $_REQUEST['id']));

        $success_message = 'Category is updated successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Categories</h1>
    </div>
    <div class="content-header-right">
        <a href="accessroies-cat.php" class="btn btn-primary btn-sm">View All</a>
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
                                <input type="text" class="form-control" name="cat_name" value="<?php echo $current_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Existing Image</label>
                            <div class="col-sm-4">
                                <img src="./uploads/accessroies/category/<?php echo $current_image; ?>" alt="<?php echo $current_name; ?>" style="width:100px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">New Image</label>
                            <div class="col-sm-4">
                                <input type="file" class="form-control" name="cat_image">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="status" class="form-control" style="width:auto;">
                                    <option value="0" <?php if ($result['status'] == 0) echo 'selected'; ?>>No</option>
                                    <option value="1" <?php if ($result['status'] == 1) echo 'selected'; ?>>Yes</option>
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