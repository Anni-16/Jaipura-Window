<?php require_once('header.php'); ?>

<?php
if (!isset($_REQUEST['id'])) {
    header('location: blog.php');
    exit;
} else {
    // Check if ID is valid
    $statement = $pdo->prepare("SELECT * FROM tbl_blog WHERE bol_id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    if ($total == 0) {
        header('location: blog.php');
        exit;
    } else {
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $current_name = $result['bol_name'];
        $current_image = $result['bol_image'];
        $current_desc = $result['bol_description'];
        $current_link = $result['bol_link'];
        $current_bol_meta_title = $result['bol_meta_title'];
        $current_bol_meta_keyword = $result['bol_meta_keyword'];
        $current_bol_meta_desc = $result['bol_meta_desc'];
    }
}

if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    if (empty($_POST['bol_name'])) {
        $valid = 0;
        $error_message .= "Blog Name cannot be empty<br>";
    } else {
        // Check for duplicate name
        $statement = $pdo->prepare("SELECT * FROM tbl_blog WHERE bol_name=? AND bol_id!=?");
        $statement->execute(array($_POST['bol_name'], $_REQUEST['id']));
        $total = $statement->rowCount();
        if ($total) {
            $valid = 0;
            $error_message .= "Blog Name already exists<br>";
        }
    }

    $path = $_FILES['bol_image']['name'];
    $path_tmp = $_FILES['bol_image']['tmp_name'];

    if ($path != '') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
            $valid = 0;
            $error_message .= 'You must upload a jpg, jpeg, gif, or png file<br>';
        }
    }

    if ($valid == 1) {
        // If a new image is uploaded, replace the old one
        if ($path != '') {
            $final_name = 'blog-' . time() . '.' . $ext;
            move_uploaded_file($path_tmp, './uploads/blog/' . $final_name);

            // Remove old image
            if (file_exists('./uploads/blog/' . $current_image) && $current_image != '') {
                unlink('./uploads/blog/' . $current_image);
            }
        } else {
            $final_name = $current_image;
        }


        // Create a URL-friendly slug
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['bol_name'])));
        $slug_url = rtrim($slug_url, '-');
        $url = $slug_url;

        // Update the database
        $statement = $pdo->prepare("UPDATE tbl_blog SET bol_name=?,url=?, bol_image=?, bol_description=?, bol_link=?, bol_meta_title=?, bol_meta_keyword=?, bol_meta_desc=?,status=? WHERE bol_id=?");
        $statement->execute(array($_POST['bol_name'],$url, $final_name, $_POST['bol_description'], $_POST['bol_link'], $_POST['bol_meta_title'], $_POST['bol_meta_keyword'], $_POST['bol_meta_desc'], $_POST['status'], $_REQUEST['id']));


        $success_message = 'Blog is updated successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Blog</h1>
    </div>
    <div class="content-header-right">
        <a href="blog.php" class="btn btn-primary btn-sm">View All</a>
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
                            <label for="" class="col-sm-3 control-label">Blog Name <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="bol_name" value="<?php echo $current_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Blog YouTube Video URL <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="bol_link" value="<?php echo $current_link; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Existing Image</label>
                            <div class="col-sm-4">
                                <img src="./uploads/blog/<?php echo $current_image; ?>" alt="<?php echo $current_name; ?>" style="width:100px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">New Image</label>
                            <div class="col-sm-3">
                                <input type="file" class="form-control" name="bol_image">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Description <span>*</span></label>
                            <div class="col-sm-8">
                                <textarea name="bol_description" class="form-control" cols="30" rows="10" id="editor2"><?php echo $current_desc; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Title <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="bol_meta_title" value="<?php echo $current_bol_meta_title; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Keyword <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="bol_meta_keyword" value="<?php echo $current_bol_meta_keyword; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Description <span>*</span></label>
                            <div class="col-sm-8">
                                <textarea name="bol_meta_desc" class="form-control" cols="30" rows="10"><?php echo $current_bol_meta_desc; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="status" class="form-control" style="width:auto;">
                                    <option value="0" <?php if ($result['status'] == 0) echo 'selected'; ?>>No</option>
                                    <option value="1" <?php if ($result['status'] == 1) echo 'selected'; ?>>Yes</option>
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