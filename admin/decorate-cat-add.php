<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    if (empty($_POST['cat_name'])) {
        $valid = 0;
        $error_message .= "Category Name cannot be empty<br>";
    } else {
        // Duplicate Category checking
        $statement = $pdo->prepare("SELECT * FROM tbl_decorate_category WHERE cat_name=?");
        $statement->execute(array($_POST['cat_name']));
        $total = $statement->rowCount();
        if ($total) {
            $valid = 0;
            $error_message .= "Category Name already exists<br>";
        }
    }

    if (isset($_FILES['cat_image']['name']) && $_FILES['cat_image']['name'] != '') {
        $path = $_FILES['cat_image']['name'];
        $path_tmp = $_FILES['cat_image']['tmp_name'];

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_name = basename($path, '.' . $ext);
        if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif' && $ext != 'JPG' && $ext != 'JPEG' && $ext != 'PNG' && $ext != 'GIF') {
            $valid = 0;
            $error_message .= 'You must upload a jpg, jpeg, gif, or png file<br>';
        }
    } else {
        $valid = 0;
        $error_message .= 'You must select a photo<br>';
    }

    if ($valid == 1) {
        // Generate a unique file name
        $final_name = 'category-' . $_POST['cat_name'] . '.' . $ext;
        move_uploaded_file($path_tmp, './uploads/decorate/category/' . $final_name);

        // Insert data into the main table
        $statement = $pdo->prepare("INSERT INTO tbl_decorate_category (cat_name, cat_image,status) VALUES (?, ?, ?)");
        $statement->execute(array($_POST['cat_name'], $final_name, $_POST['status']));

        
        $cat_id = $pdo->lastInsertId();
        
        // Create a URL-friendly slug
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['cat_name'])));
        $slug_url = rtrim($slug_url, '-'); 
        $url = $slug_url ; 

        // Update the category with the generated slug
        $statement = $pdo->prepare("UPDATE tbl_decorate_category SET url=? WHERE cat_id=?");
        $statement->execute(array($url, $cat_id));

        $success_message = 'Category added successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Categories</h1>
    </div>
    <div class="content-header-right">
        <a href="decorate-cat.php" class="btn btn-primary btn-sm">View All</a>
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
                            <label for="" class="col-sm-2 control-label">Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="cat_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Category Image <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="file" class="form-control" name="cat_image">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="status" class="form-control" style="width:auto;">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
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