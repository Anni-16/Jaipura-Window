<?php require_once('header.php'); ?>

<section class="content-header">
    <div class="content-header-left">
        <h1>View Blogs</h1>
    </div>
    <div class="content-header-right">
        <a href="blog-add.php" class="btn btn-primary btn-sm">Add New</a>
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
                                <th width="5">#</th>
                                <th width="100">Name</th>
                                <th width="40">Image</th>
                                <th width="250">Descripton</th>
                                <th width="30">Date</th>
                                <th width="30">Show on Menu?</th>
                                <th width="30">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $statement = $pdo->prepare("SELECT * FROM tbl_blog ORDER BY bol_id DESC");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $i++;
                                $create_at = $row['create_at'];
                                $formattedDate = date("j F Y", strtotime($create_at));
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['bol_name']; ?></td>
                                    <td>
                                        <img src="./uploads/blog/<?php echo $row['bol_image']; ?>" alt="<?php echo $row['bol_name']; ?>" width="70px" height="70px">
                                    </td>
                                    <td><?php echo limit_words($row['bol_description'], 30) ?></td>
                                    <td><?php echo $formattedDate;  ?></td>
                                    <td>
                                        <?php if ($row['status'] == 1) {
                                            echo '<span class="badge badge-success" style="background-color:green;">Yes</span>';
                                        } else {
                                            echo '<span class="badge badge-danger" style="background-color:red;">No</span>';
                                        } ?>
                                    </td>
                                    <td>
                                        <a href="blog-edit.php?id=<?php echo $row['bol_id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                                        <a href="#" class="btn btn-danger btn-xs" data-href="blog-delete.php?id=<?php echo $row['bol_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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
                <p style="color:red;">Be careful! All products, mid level categories and end level categories under this top lelvel category will be deleted from all the tables like order table, payment table, size table, color table, rating table etc.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>