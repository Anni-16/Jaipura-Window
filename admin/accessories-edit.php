<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['cat_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a top-level category<br>";
    }

    if (empty($_POST['a_name'])) {
        $valid = 0;
        $error_message .= "Product name cannot be empty<br>";
    }

    if (empty($_POST['a_current_price'])) {
        $valid = 0;
        $error_message .= "Current Price cannot be empty<br>";
    }

    if (empty($_POST['a_available'])) {
        $valid = 0;
        $error_message .= "Availability cannot be empty<br>";
    }

    $path = $_FILES['a_photo']['name'];
    $path_tmp = $_FILES['a_photo']['tmp_name'];

    if ($path != '') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_name = basename($path, '.' . $ext);
        if (!in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif'])) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if ($valid == 1) {

        if (isset($_FILES['photo']["name"]) && isset($_FILES['photo']["tmp_name"])) {

            $photo = array();
            $photo = $_FILES['photo']["name"];
            $photo = array_values(array_filter($photo));

            $photo_temp = array();
            $photo_temp = $_FILES['photo']["tmp_name"];
            $photo_temp = array_values(array_filter($photo_temp));

            $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_accessroies_photo'");
            $statement->execute();
            $result = $statement->fetchAll();
            foreach ($result as $row) {
                $next_id1 = $row[10];
            }
            $z = $next_id1;

            $m = 0;
            for ($i = 0; $i < count($photo); $i++) {
                $my_ext1 = pathinfo($photo[$i], PATHINFO_EXTENSION);
                if ($my_ext1 == 'jpg' || $my_ext1 == 'png' || $my_ext1 == 'jpeg' || $my_ext1 == 'gif') {
                    $final_name1[$m] = $z . '.' . $my_ext1;
                    move_uploaded_file($photo_temp[$i], "./uploads/accessroies/" . $final_name1[$m]);
                    $m++;
                    $z++;
                }
            }

            if (isset($final_name1)) {
                for ($i = 0; $i < count($final_name1); $i++) {
                    $statement = $pdo->prepare("INSERT INTO tbl_accessroies_photo (photo,a_id) VALUES (?,?)");
                    $statement->execute(array($final_name1[$i], $_REQUEST['id']));
                }
            }
        }

        if ($path == '') {
            // Generate a URL-friendly slug
            $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['a_name'])));
            $slug_url = rtrim($slug_url, '-');
            $url = $slug_url;
            $statement = $pdo->prepare("UPDATE tbl_accessroies SET 
        							a_name=?, 
                                    url=?,
        							a_old_price=?, 
        							a_current_price=?, 
        							a_available=?,
        							a_stock_qty=?,
        							a_short_desc=?,
        							a_content=?,
        							a_is_featured=?,
        							a_is_active=?,
        							cat_id=?
        							WHERE a_id=?");
            $statement->execute(array(
                $_POST['a_name'],
                $url,
                $_POST['a_old_price'],
                $_POST['a_current_price'],
                $_POST['a_available'],
                $_POST['a_stock_qty'],
                $_POST['a_short_desc'],
                $_POST['a_content'],
                $_POST['a_is_featured'],
                $_POST['a_is_active'],
                $_POST['cat_id'],
                $_REQUEST['id']
            ));
        } else {

            unlink('./uploads/accessroies/' . $_POST['current_photo']);

            // here change : use original file name instead of 'product-featured-ID'
            $final_name = $file_name . '.' . $ext;
            move_uploaded_file($path_tmp, './uploads/accessroies/' . $final_name);

            $statement = $pdo->prepare("UPDATE tbl_accessroies SET 
        							a_name=?, 
        							a_old_price=?, 
        							a_current_price=?, 
        							a_available=?,
        							a_stock_qty=?,
                                    a_photo=?,
        							a_short_desc=?,
        							a_content=?,
        							a_is_featured=?,
        							a_is_active=?,
        							cat_id=?
        							WHERE a_id=?");
            $statement->execute(array(
                $_POST['a_name'],
                $_POST['a_old_price'],
                $_POST['a_current_price'],
                $_POST['a_available'],
                $_POST['a_stock_qty'],
                $final_name,
                $_POST['a_short_desc'],
                $_POST['a_content'],
                $_POST['a_is_featured'],
                $_POST['a_is_active'],
                $_POST['cat_id'],
                $_REQUEST['id']
            ));
        }

        if (isset($_POST['size'])) {

            $statement = $pdo->prepare("DELETE FROM tbl_accessroies_size WHERE a_id=?");
            $statement->execute(array($_REQUEST['id']));

            foreach ($_POST['size'] as $value) {
                $statement = $pdo->prepare("INSERT INTO tbl_accessroies_size (size_id,a_id) VALUES (?,?)");
                $statement->execute(array($value, $_REQUEST['id']));
            }
        } else {
            $statement = $pdo->prepare("DELETE FROM tbl_accessroies_size WHERE a_id=?");
            $statement->execute(array($_REQUEST['id']));
        }

        if (isset($_POST['color'])) {

            $statement = $pdo->prepare("DELETE FROM tbl_accessroies_color WHERE a_id=?");
            $statement->execute(array($_REQUEST['id']));

            foreach ($_POST['color'] as $value) {
                $statement = $pdo->prepare("INSERT INTO tbl_accessroies_color (color_id,a_id) VALUES (?,?)");
                $statement->execute(array($value, $_REQUEST['id']));
            }
        } else {
            $statement = $pdo->prepare("DELETE FROM tbl_accessroies_color WHERE a_id=?");
            $statement->execute(array($_REQUEST['id']));
        }

        $success_message = 'Accessories Product is updated successfully.';
        header('Location: accessories-add.php');
    }
}
?>


<?php
if (!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    // Check the id is valid or not
    $statement = $pdo->prepare("SELECT * FROM tbl_accessroies WHERE a_id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ($total == 0) {
        header('location: logout.php');
        exit;
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Product</h1>
    </div>
    <div class="content-header-right">
        <a href="accessories.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_accessroies WHERE a_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $a_name = $row['a_name'];
    $a_old_price = $row['a_old_price'];
    $a_current_price = $row['a_current_price'];
    $a_available = $row['a_available'];
    $a_stock_qty = $row['a_stock_qty'];
    $a_photo = $row['a_photo'];
    $a_short_desc = $row['a_short_desc'];
    $a_content = $row['a_content'];
    $a_is_featured = $row['a_is_featured'];
    $a_is_active = $row['a_is_active'];
    $cat_id = $row['cat_id'];
}

$statement = $pdo->prepare("SELECT * FROM tbl_accessroies_category WHERE cat_id=?");
$statement->execute(array($cat_id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $cat_name = $row['cat_name'];
    $cat_id = $row['cat_id'];
}

$statement = $pdo->prepare("SELECT * FROM tbl_accessroies_size WHERE a_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $size_id[] = $row['size_id'];
}

$statement = $pdo->prepare("SELECT * FROM tbl_accessroies_color WHERE a_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $color_id[] = $row['color_id'];
}
?>


<section class="content">

    <div class="row">
        <div class="col-md-12">

            <?php if ($error_message) : ?>
                <div class="callout callout-danger">

                    <p>
                        <?php echo $error_message; ?>
                    </p>
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
                            <label for="" class="col-sm-3 control-label">Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="cat_id" class="form-control select2 top-cat">
                                    <option value="">Select Category</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_accessroies_category ORDER BY cat_name ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                    ?>
                                        <option value="<?php echo $row['cat_id']; ?>" <?php if ($row['cat_id'] == $cat_id) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $row['cat_name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Product Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="a_name" class="form-control" value="<?php echo $a_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Old Price<br><span style="font-size:10px;font-weight:normal;">(In Rupees)</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="a_old_price" class="form-control" value="<?php echo $a_old_price; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Current Price <span>*</span><br><span style="font-size:10px;font-weight:normal;">(In Rupees)</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="a_current_price" class="form-control" value="<?php echo $a_current_price; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Product QTY <span>*</span><br><span style="font-size:10px;font-weight:normal;">(In Rupees)</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="a_stock_qty" class="form-control" value="<?php echo $a_stock_qty; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Avaiable Stock?</label>
                            <div class="col-sm-8">
                                <select name="a_available" class="form-control" style="width:auto;">
                                    <option value="Out Of Stock" <?php if ($a_available == 'Out Of Stock') {
                                                                        echo 'selected';
                                                                    } ?>>Out Of Stock</option>
                                    <option value="In Stock" <?php if ($a_available == 'In Stock') {
                                                                    echo 'selected';
                                                                } ?>>In Stock</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Select Size</label>
                            <div class="col-sm-4">
                                <select name="size[]" class="form-control select2" multiple="multiple">
                                    <?php
                                    $is_select = '';
                                    $statement = $pdo->prepare("SELECT * FROM tbl_size ORDER BY size_id ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        if (isset($size_id)) {
                                            if (in_array($row['size_id'], $size_id)) {
                                                $is_select = 'selected';
                                            } else {
                                                $is_select = '';
                                            }
                                        }
                                    ?>
                                        <option value="<?php echo $row['size_id']; ?>" <?php echo $is_select; ?>><?php echo $row['size_name']; ?></option>
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
                                    $is_select = '';
                                    $statement = $pdo->prepare("SELECT * FROM tbl_color ORDER BY color_id ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        if (isset($color_id)) {
                                            if (in_array($row['color_id'], $color_id)) {
                                                $is_select = 'selected';
                                            } else {
                                                $is_select = '';
                                            }
                                        }
                                    ?>
                                        <option value="<?php echo $row['color_id']; ?>" <?php echo $is_select; ?>><?php echo $row['color_name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Existing Featured Photo</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <img src="./uploads/accessroies/<?php echo $a_photo; ?>" alt="" style="width:150px;">
                                <input type="hidden" name="current_photo" value="<?php echo $a_photo; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Change Featured Photo </label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <input type="file" name="a_photo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Other Photos</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <table id="ProductTable" style="width:100%;">
                                    <tbody>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_accessroies_photo WHERE a_id=?");
                                        $statement->execute(array($_REQUEST['id']));
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <img src="./uploads/accessroies/<?php echo $row['photo']; ?>" alt="<?= $a_name; ?>" style="width:150px;margin-bottom:5px;">
                                                </td>
                                                <td style="width:28px;">
                                                    <a onclick="return confirmDelete();" href="accessroies-other-photo-delete.php?id=<?php echo $row['aa_id']; ?>&id1=<?php echo $_REQUEST['id']; ?>" class="btn btn-danger btn-xs">X</a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
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
                                <textarea name="a_short_desc" class="form-control" cols="30" rows="10" id="editor1"><?php echo $a_short_desc; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="a_content" class="form-control" cols="30" rows="10" id="editor2"><?php echo $a_content; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Is Featured?</label>
                            <div class="col-sm-8">
                                <select name="a_is_featured" class="form-control" style="width:auto;">
                                    <option value="0" <?php if ($a_is_featured == '0') {
                                                            echo 'selected';
                                                        } ?>>No</option>
                                    <option value="1" <?php if ($a_is_featured == '1') {
                                                            echo 'selected';
                                                        } ?>>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Is Active?</label>
                            <div class="col-sm-8">
                                <select name="a_is_active" class="form-control" style="width:auto;">
                                    <option value="0" <?php if ($a_is_active == '0') {
                                                            echo 'selected';
                                                        } ?>>No</option>
                                    <option value="1" <?php if ($a_is_active == '1') {
                                                            echo 'selected';
                                                        } ?>>Yes</option>
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