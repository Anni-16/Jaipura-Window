<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['tcat_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a top level category<br>";
    }

    if (empty($_POST['mcat_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a mid level category<br>";
    }

    if (empty($_POST['ecat_id'])) {
        $valid = 0;
        $error_message .= "You must have to select an end level category<br>";
    }

    if (empty($_POST['p_name'])) {
        $valid = 0;
        $error_message .= "Product name can not be empty<br>";
    }

    if (empty($_POST['p_current_price'])) {
        $valid = 0;
        $error_message .= "Current Price can not be empty<br>";
    }

    if (empty($_POST['p_available'])) {
        $valid = 0;
        $error_message .= "Stock can not be empty<br>";
    }

    $path = $_FILES['p_featured_photo']['name'];
    $path_tmp = $_FILES['p_featured_photo']['tmp_name'];

    if ($path != '') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_name = basename($path, '.' . $ext);
        if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
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

            $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_product_photo'");
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
                    move_uploaded_file($photo_temp[$i], "./uploads/wear/" . $final_name1[$m]);
                    $m++;
                    $z++;
                }
            }

            if (isset($final_name1)) {
                for ($i = 0; $i < count($final_name1); $i++) {
                    $statement = $pdo->prepare("INSERT INTO tbl_product_photo (photo,p_id) VALUES (?,?)");
                    $statement->execute(array($final_name1[$i], $_REQUEST['id']));
                }
            }
        }

        if ($path == '') {
            // Generate a URL-friendly slug
            $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['p_name'])));
            $slug_url = rtrim($slug_url, '-');
            $url = $slug_url;
            $statement = $pdo->prepare("UPDATE tbl_product SET 
        							p_name=?, 
                                    url=?,
        							p_old_price=?, 
        							p_current_price=?, 
        							p_available=?, 
        							p_qty=?,
        							p_description=?,
        							p_short_description=?,
        							p_is_featured=?,
        							p_is_active=?,
        							ecat_id=?
        							WHERE p_id=?");
            $statement->execute(array(
                $_POST['p_name'],
                $url,
                $_POST['p_old_price'],
                $_POST['p_current_price'],
                $_POST['p_available'],
                $_POST['p_qty'],
                $_POST['p_description'],
                $_POST['p_short_description'],
                $_POST['p_is_featured'],
                $_POST['p_is_active'],
                $_POST['ecat_id'],
                $_REQUEST['id']
            ));
        } else {

            unlink('./uploads/wear/' . $_POST['current_photo']);

            $safe_file_name = preg_replace('/[^A-Za-z0-9\-\_\.]/', '', $path); // clean filename
            move_uploaded_file($path_tmp, './uploads/wear/' . $safe_file_name);


            $statement = $pdo->prepare("UPDATE tbl_product SET 
        							p_name=?, 
        							p_old_price=?, 
        							p_current_price=?, 
        							p_available=?, 
        							p_qty=?,
        							p_featured_photo=?,
        							p_description=?,
        							p_short_description=?,
       							p_is_featured=?,
        							p_is_active=?,
        							ecat_id=?
        							WHERE p_id=?");
            $statement->execute(array(
                $_POST['p_name'],
                $_POST['p_old_price'],
                $_POST['p_current_price'],
                $_POST['p_available'],
                $_POST['p_qty'],
                $safe_file_name,
                $_POST['p_description'],
                $_POST['p_short_description'],
                $_POST['p_is_featured'],
                $_POST['p_is_active'],
                $_POST['ecat_id'],
                $_REQUEST['id']
            ));
        }


        if (isset($_POST['size'])) {

            $statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
            $statement->execute(array($_REQUEST['id']));

            foreach ($_POST['size'] as $value) {
                $statement = $pdo->prepare("INSERT INTO tbl_product_size (size_id,p_id) VALUES (?,?)");
                $statement->execute(array($value, $_REQUEST['id']));
            }
        } else {
            $statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
            $statement->execute(array($_REQUEST['id']));
        }

        if (isset($_POST['color'])) {

            $statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id=?");
            $statement->execute(array($_REQUEST['id']));

            foreach ($_POST['color'] as $value) {
                $statement = $pdo->prepare("INSERT INTO tbl_product_color (color_id,p_id) VALUES (?,?)");
                $statement->execute(array($value, $_REQUEST['id']));
            }
        } else {
            $statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id=?");
            $statement->execute(array($_REQUEST['id']));
        }

        $success_message = 'Product is updated successfully.';
        header('Location: wear-add.php');
    }
}
?>

<?php
if (!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    // Check the id is valid or not
    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
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
        <h1>Edit wear</h1>
    </div>
    <div class="content-header-right">
        <a href="wear.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $p_name = $row['p_name'];
    $p_old_price = $row['p_old_price'];
    $p_current_price = $row['p_current_price'];
    $p_available = $row['p_available'];
    $p_qty = $row['p_qty'];
    $p_featured_photo = $row['p_featured_photo'];
    $p_description = $row['p_description'];
    $p_short_description = $row['p_short_description'];
    $p_is_featured = $row['p_is_featured'];
    $p_is_active = $row['p_is_active'];
    $ecat_id = $row['ecat_id'];
}

$statement = $pdo->prepare("SELECT * 
                            FROM tbl_end_category t1
                            JOIN tbl_mid_category t2 ON t1.mcat_id = t2.mcat_id
                            JOIN tbl_top_category t3 ON t2.tcat_id = t3.tcat_id
                            WHERE t1.ecat_id = ?");
$statement->execute([$ecat_id]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
if ($result) {
    $ecat_id = $result['ecat_id'];
    $mcat_id = $result['mcat_id'];
    $tcat_id = $result['tcat_id'];
}



$statement = $pdo->prepare("SELECT * FROM tbl_product_size WHERE p_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $size_id[] = $row['size_id'];
}

$statement = $pdo->prepare("SELECT * FROM tbl_product_color WHERE p_id=?");
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
                            <label for="tcat_id" class="col-sm-3 control-label">Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="tcat_id" id="tcat_id" class="form-control select2 top-cat">
                                    <option value="">Select Category</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_top_category ORDER BY tcat_name ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($result as $row) {
                                        $selected = (isset($tcat_id) && $row['tcat_id'] == $tcat_id) ? 'selected' : '';
                                        echo '<option value="' . htmlspecialchars($row['tcat_id']) . '" ' . $selected . '>' . htmlspecialchars($row['tcat_name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"> Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="mcat_id" class="form-control select2 mid-cat">
                                    <option value="">Select Mid Level Category</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id = ? ORDER BY mcat_name ASC");
                                    $statement->execute(array($tcat_id));
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                    ?>
                                        <option value="<?php echo $row['mcat_id']; ?>" <?php if ($row['mcat_id'] == $mcat_id) {
                                                                                            echo 'selected';
                                                                                        } ?>>
                                            <?php echo $row['mcat_name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"> Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="ecat_id" class="form-control select2 end-cat">
                                    <option value="">Select End Level Category</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id = ? ORDER BY ecat_name ASC");
                                    $statement->execute(array($mcat_id));
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                    ?>
                                        <option value="<?php echo $row['ecat_id']; ?>" <?php if ($row['ecat_id'] == $ecat_id) {
                                                                                            echo 'selected';
                                                                                        } ?>>
                                            <?php echo $row['ecat_name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Product Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="p_name" class="form-control" value="<?php echo $p_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Old Price<br><span style="font-size:10px;font-weight:normal;">(In Rupees)</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="p_old_price" class="form-control" value="<?php echo $p_old_price; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Current Price <span>*</span><br><span style="font-size:10px;font-weight:normal;">(In Rupees)</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="p_current_price" class="form-control" value="<?php echo $p_current_price; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Quantity <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="p_qty" class="form-control" value="<?php echo $p_qty; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Avaiable Stock?</label>
                            <div class="col-sm-8">
                                <select name="p_available" class="form-control" style="width:auto;">
                                    <option value="Out Of Stock" <?php if ($p_available == 'Out Of Stock') {
                                                                        echo 'selected';
                                                                    } ?>>Out Of Stock</option>
                                    <option value="In Stock" <?php if ($p_available == 'In Stock') {
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
                                        <option value="<?php echo $row['size_id']; ?>" <?php echo $is_select; ?>>
                                            <?php echo $row['size_name']; ?></option>
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
                                        <option value="<?php echo $row['color_id']; ?>" <?php echo $is_select; ?>>
                                            <?php echo $row['color_name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Existing Featured Photo</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <img src="./uploads/wear/<?php echo $p_featured_photo; ?>" alt="" style="width:150px;">
                                <input type="hidden" name="current_photo" value="<?php echo $p_featured_photo; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Change Featured Photo </label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <input type="file" name="p_featured_photo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Other Photos</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <table id="ProductTable" style="width:100%;">
                                    <tbody>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
                                        $statement->execute(array($_REQUEST['id']));
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <img src="./uploads/wear/<?php echo $row['photo']; ?>" alt="" style="width:150px;margin-bottom:5px;">
                                                </td>
                                                <td style="width:28px;">
                                                    <a onclick="return confirmDelete();" href="wear-other-photo-delete.php?id=<?php echo $row['pp_id']; ?>&id1=<?php echo $_REQUEST['id']; ?>" class="btn btn-danger btn-xs">X</a>
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
                                <textarea name="p_short_description" class="form-control" cols="30" rows="10" id="editor1"><?php echo $p_short_description; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="p_description" class="form-control" cols="30" rows="10" id="editor2"><?php echo $p_description; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Is Featured?</label>
                            <div class="col-sm-8">
                                <select name="p_is_featured" class="form-control" style="width:auto;">
                                    <option value="0" <?php if ($p_is_featured == '0') {
                                                            echo 'selected';
                                                        } ?>>No</option>
                                    <option value="1" <?php if ($p_is_featured == '1') {
                                                            echo 'selected';
                                                        } ?>>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Is Active?</label>
                            <div class="col-sm-8">
                                <select name="p_is_active" class="form-control" style="width:auto;">
                                    <option value="0" <?php if ($p_is_active == '0') {
                                                            echo 'selected';
                                                        } ?>>No</option>
                                    <option value="1" <?php if ($p_is_active == '1') {
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