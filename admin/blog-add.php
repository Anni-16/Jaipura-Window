<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    if(empty($_POST['bol_name'])) {
        $valid = 0;
        $error_message .= "BLog Name cannot be empty<br>";
    } else {
        // Duplicate Category checking
        $statement = $pdo->prepare("SELECT * FROM tbl_blog WHERE bol_name=?");
        $statement->execute(array($_POST['bol_name']));
        $total = $statement->rowCount();
        if($total) {
            $valid = 0;
            $error_message .= "Blog Name already exists<br>";
        }
    }

    if(isset($_FILES['bol_image']['name']) && $_FILES['bol_image']['name'] != '') {
        $path = $_FILES['bol_image']['name'];
        $path_tmp = $_FILES['bol_image']['tmp_name'];

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_name = basename($path, '.' . $ext);
        if($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
            $valid = 0;
            $error_message .= 'You must upload a jpg, jpeg, gif, or png file<br>';
        }
    } else {
        $valid = 0;
        $error_message .= 'You must select a photo<br>';
    }

    if($valid == 1) {
        // Generate a unique file name
        $final_name = 'blog-' . time() . '.' . $ext;
        move_uploaded_file($path_tmp, './uploads/blog/' . $final_name);

        // Insert data into the main table
        $statement = $pdo->prepare("INSERT INTO tbl_blog (bol_name, bol_image, bol_description, bol_link,bol_meta_title, bol_meta_keyword, bol_meta_desc,status) VALUES (?,?,?,?,?,?,?,?)");
        $statement->execute(array($_POST['bol_name'], $final_name,$_POST['bol_description'], $_POST['bol_link'], $_POST['bol_meta_title'], $_POST['bol_meta_keyword'], $_POST['bol_meta_desc'], $_POST['status']));


        
        $bol_id = $pdo->lastInsertId();
        
        // Create a URL-friendly slug
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['bol_name'])));
        $slug_url = rtrim($slug_url, '-'); 
        $url = $slug_url ; 

        // Update the category with the generated slug
        $statement = $pdo->prepare("UPDATE tbl_blog SET url=? WHERE bol_id=?");
        $statement->execute(array($url, $bol_id));

        $success_message = 'Blog added successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Blog</h1>
    </div>
    <div class="content-header-right">
        <a href="blog.php" class="btn btn-primary btn-sm">View All</a>
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
                            <label for="" class="col-sm-3 control-label">Blog Name <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="bol_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Blog YouTube Video URL <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="bol_link">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Image <span>*</span></label>
                            <div class="col-sm-3">
                                <input type="file" class="form-control" name="bol_image">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Description <span>*</span></label>
							<div class="col-sm-8">
                                <textarea name="bol_description" class="form-control" cols="30" rows="10" id="editor2"></textarea>
							</div>
						</div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Title <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="bol_meta_title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Keyword <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="bol_meta_keyword">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Description <span>*</span></label>
							<div class="col-sm-8">
                                <textarea name="bol_meta_desc" class="form-control" cols="30" rows="10" ></textarea>
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
