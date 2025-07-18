<?php require_once('header.php'); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Testimonial</h1>
	</div>
	<div class="content-header-right">
		<a href="testimonial-add.php" class="btn btn-primary btn-sm">Add Testimonial</a>
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
								<th width="80">Customer Name</th>
								<th width="250">Descrpition</th>
								<th width="70">Image</th>
								<th  width="30">Status</th>
								<th width="30">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=0;
							$statement = $pdo->prepare("SELECT * FROM tbl_testimonial");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
							foreach ($result as $row) {
								$i++;
								?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $row['test_title']; ?></td>
									<td><?php echo $row['test_description']; ?></td>
									<td>
										<img src="./uploads/testimonial/<?php echo $row['test_image']; ?>" alt="<?php echo $row['test_title']; ?>" width="90" height="70">
									</td>
									<td>
                                        <?php
                                        if ($row['status'] == 1) {
                                            echo 'Yes';
                                        } else {
                                            echo 'No';
                                        }
                                        ?>
                                    </td>
									<td>										
										<a href="testimonial-edit.php?id=<?php echo $row['test_id']; ?>" class="btn btn-primary btn-xs">Edit</a>
										<a href="#" class="btn btn-danger btn-xs" data-href="testimonial-delete.php?id=<?php echo $row['test_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>  
									</td>
								</tr>
								<?php
							}
							?>							
						</tbody>
					</table>
				</div>
			</div>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>