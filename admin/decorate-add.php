<?php require_once('header.php');

if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['cat_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a category<br>";
    }
    if (empty($_POST['sub_cat_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a Sub category<br>";
    }

    if (empty($_POST['d_name'])) {
        $valid = 0;
        $error_message .= "Product name can not be empty<br>";
    }

    if (empty($_POST['d_current_price'])) {
        $valid = 0;
        $error_message .= "Current Price can not be empty<br>";
    }

    if (empty($_POST['d_available'])) {
        $valid = 0;
        $error_message .= "Available can not be empty<br>";
    }

    $path = $_FILES['d_photo']['name'];
    $path_tmp = $_FILES['d_photo']['tmp_name'];

    if ($path != '') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_name = basename($path, '.' . $ext);
        if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif' && $ext != 'JPG' && $ext != 'JPEG' && $ext != 'PNG' && $ext != 'GIF') {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    } else {
        $valid = 0;
        $error_message .= 'You must have to select a featured photo<br>';
    }

    if ($valid == 1) {

        $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_decorate'");
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $ai_id = $row[10];
        }

        if (isset($_FILES['photo']["name"]) && isset($_FILES['photo']["tmp_name"])) {
            $photo = array();
            $photo = $_FILES['photo']["name"];
            $photo = array_values(array_filter($photo));

            $photo_temp = array();
            $photo_temp = $_FILES['photo']["tmp_name"];
            $photo_temp = array_values(array_filter($photo_temp));

            $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_decorate_photo'");
            $statement->execute();
            $result = $statement->fetchAll();
            foreach ($result as $row) {
                $next_id1 = $row[10];
            }
            $z = $next_id1;

            $m = 0;
            for ($i = 0; $i < count($photo); $i++) {
                $my_ext1 = pathinfo($photo[$i], PATHINFO_EXTENSION);
                if ($my_ext1 == 'jpg' || $my_ext1 == 'png' || $my_ext1 == 'jpeg' || $my_ext1 == 'gif' || $my_ext1 == 'JPG' || $my_ext1 == 'JPEG' || $my_ext1 == 'PNG' || $my_ext1 == 'GIF') {
                    $final_name1[$m] = $z . '.' . $my_ext1;
                    move_uploaded_file($photo_temp[$i], "./uploads/decorate/" . $final_name1[$m]);
                    $m++;
                    $z++;
                }
            }

            if (isset($final_name1)) {
                for ($i = 0; $i < count($final_name1); $i++) {
                    $statement = $pdo->prepare("INSERT INTO tbl_decorate_photo (photo,d_id) VALUES (?,?)");
                    $statement->execute(array($final_name1[$i], $ai_id));
                }
            }
        }

        $final_name = 'product-featured-' . $ai_id . '.' . $ext;
        move_uploaded_file($path_tmp, './uploads/decorate/' . $final_name);

        //Saving data into the main table tbl_product
        $statement = $pdo->prepare("INSERT INTO tbl_decorate(
									    -- a_code,
										d_name,
										d_old_price,
										d_current_price,
										d_available,
										d_stock_qty,
										d_photo,
										d_short_desc,
										d_content,
										d_is_featured,
										d_is_active,
										sub_cat_id
									) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $statement->execute(array(
            // $a_code,
            $_POST['d_name'],
            $_POST['d_old_price'],
            $_POST['d_current_price'],
            $_POST['d_available'],
            $_POST['d_stock_qty'],
            $final_name,
            $_POST['d_short_desc'],
            $_POST['d_content'],
            $_POST['d_is_featured'],
            $_POST['d_is_active'],
            $_POST['sub_cat_id']
        ));

        $ai_id = $pdo->lastInsertId();
        $d_code = 'DECOR-00' . $ai_id;

        // Create a URL-friendly slug
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['d_name'])));
        $slug_url = rtrim($slug_url, '-'); 
        $url = $slug_url ; 


        // Update the product with the generated a_code
        $statement = $pdo->prepare("UPDATE tbl_decorate SET d_code = ?, url=? WHERE d_id = ?");
        $statement->execute([$d_code,$url, $ai_id]);

        if (isset($_POST['size'])) {
            foreach ($_POST['size'] as $value) {
                $statement = $pdo->prepare("INSERT INTO tbl_decorate_size (size_id,d_id) VALUES (?,?)");
                $statement->execute(array($value, $ai_id));
            }
        }

        if (isset($_POST['color'])) {
            foreach ($_POST['color'] as $value) {
                $statement = $pdo->prepare("INSERT INTO tbl_decorate_color (color_id,d_id) VALUES (?,?)");
                $statement->execute(array($value, $ai_id));
            }
        }

        $success_message = 'Decorate Product is added successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Decorate</h1>
    </div>
    <div class="content-header-right">
        <a href="decorate.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>


<section class="content">

    <div class="row">
        <div class="col-md-12">

            <?php if ($error_message): ?>
                <div class="callout callout-danger">

                    <p>
                        <?php echo $error_message; ?>
                    </p>
                </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
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
                                <select name="cat_id" class="form-control select2 decorate-cat">
                                    <option value="">Select Category</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_decorate_category ORDER BY cat_name ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                    ?>
                                        <option value="<?php echo $row['cat_id']; ?>"><?php echo $row['cat_name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
							<label for="" class="col-sm-3 control-label">Sub Category Name <span>*</span></label>
							<div class="col-sm-4">
								<select name="sub_cat_id" class="form-control select2 decorate-sub-cat">
									<option value="">Select Sub Category</option>
								</select>
							</div>
						</div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Product Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="d_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Old Price <br><span style="font-size:10px;font-weight:normal;">(In Rupees)</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="d_old_price" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Current Price <span>*</span><br><span style="font-size:10px;font-weight:normal;">(In Rupees)</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="d_current_price" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Product QTY * </label>
                            <div class="col-sm-4">
                                <input type="text" name="d_stock_qty" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Available </label>
                            <div class="col-sm-8">
                                <select name="d_available" class="form-control" style="width:auto;">
                                    <option value="Out Of Stock">Out Of Stock</option>
                                    <option value="In Stock">In Stock</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Select Size</label>
                            <div class="col-sm-4">
                                <select name="size[]" class="form-control select2" multiple="multiple">
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_size ORDER BY size_id ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                    ?>
                                        <option value="<?php echo $row['size_id']; ?>"><?php echo $row['size_name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Select Color</label>
                            <div class="col-sm-4">
                                <select name="color[]" class="form-control select2" multiple="multiple">
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_color ORDER BY color_id ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                    ?>
                                        <option value="<?php echo $row['color_id']; ?>"><?php echo $row['color_name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Featured Photo <span>*</span></label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <input type="file" name="d_photo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Other Photos</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <table id="ProductTable" style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="upload-btn">
                                                    <input type="file" name="photo[]" style="margin-bottom:5px;">
                                                </div>
                                            </td>
                                            <td style="width:28px;"><a href="javascript:void()" class="Delete btn btn-danger btn-xs">X</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-2">
                                <input type="button" id="btnAddNew" value="Add Item" style="margin-top: 5px;margin-bottom:10px;border:0;color: #fff;font-size: 14px;border-radius:3px;" class="btn btn-warning btn-xs">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Short Description</label>
                            <div class="col-sm-8">
                                <textarea name="d_short_desc" class="form-control" cols="30" rows="10" id="editor1"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="d_content" class="form-control" cols="30" rows="10" id="editor2"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Is Featured?</label>
                            <div class="col-sm-8">
                                <select name="d_is_featured" class="form-control" style="width:auto;">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Is Active?</label>
                            <div class="col-sm-8">
                                <select name="d_is_active" class="form-control" style="width:auto;">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Add Product</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>


        </div>
    </div>

</section>

<?php require_once('footer.php'); ?>