<?php require_once('header.php'); ?>

<section class="content-header">
    <div class="content-header-left">
        <h1>View Sub Categories</h1>
    </div>
    <div class="content-header-right">
        <a href="decorate-sub-cat-add.php" class="btn btn-primary btn-sm">Add Sub Categories</a>
    </div>
</section>


<section class="content">

    <div class="row">
        <div class="col-md-12">


            <div class="box box-info">

                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Sub Category Name</th>
                                <th>Category Name</th>
                                <th>Sub Category Image</th>
                                <th>Show In Menu?</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $statement = $pdo->prepare("SELECT * 
                                    FROM tbl_decorate_sub_category t1
                                    JOIN tbl_decorate_category t2
                                    ON t1.cat_id = t2.cat_id
                                    ORDER BY t1.sub_cat_id DESC");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $i++;
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['sub_cat_name']; ?></td>
                                    <td><?php echo $row['cat_name']; ?></td>
                                    <td>
                                        <img src="./uploads/decorate/subcategory/<?php echo $row['sub_cat_image']; ?>" alt="<?php echo $row['sub_cat_name']; ?>" width="70px" height="70px">
                                    </td>
                                    <td>
                                        <?php if ($row['show_status'] == 1) {
                                            echo '<span class="badge badge-success" style="background-color:green;">Yes</span>';
                                        } else {
                                            echo '<span class="badge badge-danger" style="background-color:red;">No</span>';
                                        } ?>
                                    </td>
                                    <td>
                                        <a href="decorate-sub-cat-edit.php?id=<?php echo $row['sub_cat_id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                                        <a href="#" class="btn btn-danger btn-xs" data-href="decorate-sub-cat-delete.php?id=<?php echo $row['sub_cat_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>


</section>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete this item?</p>
                <p style="color:red;">Be careful! All products and end level categories under this mid level category will be deleted from all the tables like order table, payment table, size table, color table, rating table etc.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>