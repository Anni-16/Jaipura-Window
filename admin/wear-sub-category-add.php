<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    if (empty($_POST['tcat_id'])) {
        $valid = 0;
        $error_message .= "You must select a category<br>";
    }

    if (empty($_POST['mcat_name'])) {
        $valid = 0;
        $error_message .= "Sub Category Name cannot be empty<br>";
    } 

    if (isset($_FILES['mcat_image']['name']) && $_FILES['mcat_image']['name'] != '') {
        $path = $_FILES['mcat_image']['name'];
        $path_tmp = $_FILES['mcat_image']['tmp_name'];

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($ext, $allowed_ext)) {
            $valid = 0;
            $error_message .= 'You must upload a JPG, JPEG, PNG, or GIF file<br>';
        }
    } else {
        $valid = 0;
        $error_message .= 'You must select an image<br>';
    }

    if ($valid == 1) {
        // Generate a unique file name
        $final_name = 'sub-category-' . time() . '.' . $ext;
        move_uploaded_file($path_tmp, './uploads/wear/subcategory/' . $final_name);

        // Insert data into the table
        $statement = $pdo->prepare("INSERT INTO tbl_mid_category (mcat_name, mcat_image, tcat_id, status) VALUES (?, ?, ?, ?)");
        $statement->execute(array($_POST['mcat_name'], $final_name, $_POST['tcat_id'], $_POST['status']));


        $mcat_id = $pdo->lastInsertId();
        
        // Create a URL-friendly slug
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['mcat_name'])));
        $slug_url = rtrim($slug_url, '-'); 
        $url = $slug_url ; 

        // Update the category with the generated slug
       $statement = $pdo->prepare("UPDATE tbl_mid_category SET url=? WHERE mcat_id=?");
        $statement->execute(array($url, $mcat_id));

        $success_message = 'Sub Category added successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Sub Category</h1>
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
                                        echo '<option value="' . $row['tcat_id'] . '">' . $row['tcat_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Sub Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="mcat_name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Sub Category Image <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="file" class="form-control" name="mcat_image" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="status" class="form-control" style="width:auto;">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
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
