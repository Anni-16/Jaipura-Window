<?php require_once('header.php'); ?>

<?php
$error_message = '';
$success_message = '';

if(isset($_POST['form1'])) {
    $valid = 1;

    if(empty($_POST['tcat_id'])) {
        $valid = 0;
        $error_message .= "You must select a category<br>";
    }

    if(empty($_POST['mcat_id'])) {
        $valid = 0;
        $error_message .= "You must select a sub-category<br>";
    }

    if(empty($_POST['ecat_name'])) {
        $valid = 0;
        $error_message .= "End category name cannot be empty<br>";
    }

    if(isset($_FILES['ecat_image']['name']) && $_FILES['ecat_image']['name'] != '') {
        $path = $_FILES['ecat_image']['name'];
        $path_tmp = $_FILES['ecat_image']['tmp_name'];

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array(strtolower($ext), $allowed_ext)) {
            $valid = 0;
            $error_message .= "You must upload a JPG, JPEG, PNG, or GIF file<br>";
        }
    } else {
        $valid = 0;
        $error_message .= "You must select an image<br>";
    }

    if($valid == 1) {
        // Generate a unique file name
        $final_name = 'end-category-' . time() . '.' . $ext;
        move_uploaded_file($path_tmp, './uploads/wear/endcategory/' . $final_name);

        // Insert into database
        $statement = $pdo->prepare("INSERT INTO tbl_end_category (ecat_name, ecat_image, `show`, mcat_id) VALUES (?, ?, ?, ?)");
        $statement->execute([
            $_POST['ecat_name'],
            $final_name, // Corrected: Use uploaded file name
            $_POST['show'],
            $_POST['mcat_id']
        ]);


        $ecat_id = $pdo->lastInsertId();
        
        // Create a URL-friendly slug
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['ecat_name'])));
        $slug_url = rtrim($slug_url, '-'); 
        $url = $slug_url ; 

        // Update the category with the generated slug
        $statement = $pdo->prepare("UPDATE tbl_end_category SET url=? WHERE ecat_id=?");
        $statement->execute(array($url, $ecat_id));

        $success_message = "End Category added successfully.";
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add End Category</h1>
    </div>
    <div class="content-header-right">
        <a href="wear-end-category.php" class="btn btn-primary btn-sm">View All</a>
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
                            <label for="" class="col-sm-3 control-label">Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="tcat_id" class="form-control select2 top-cat">
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
                                <select name="mcat_id" class="form-control select2 mid-cat">
                                    <option value="">Select Sub Category</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">End Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="ecat_name" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">End Category Image <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="file" class="form-control" name="ecat_image" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="show" class="form-control" style="width:auto;">
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
