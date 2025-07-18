<?php require_once('header.php'); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Deacorate</h1>
	</div>
	<div class="content-header-right">
		<a href="decorate-add.php" class="btn btn-primary btn-sm">Add Decorate</a>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-hover table-striped">
					<thead class="thead-dark">
							<tr>
								<th width="10">S.No</th>
								<th>Product Id</th>
								<th>Photo</th>
								<th width="160">Product Name</th>
								<th width="60">Old Price</th>
								<th width="60">(C) Price</th>
								<th width="60">Stock</th>
								<th>QTY</th>
								<th>Featured?</th>
								<th>Active?</th>
								<th>Category</th>
								<th width="80">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=0;
							$statement = $pdo->prepare("SELECT * FROM tbl_decorate t1
							                           	JOIN tbl_decorate_sub_category t2
							                           	ON t1.sub_cat_id = t2.sub_cat_id
							                           	JOIN tbl_decorate_category t3
							                           	ON t2.cat_id = t3.cat_id
							                           	ORDER BY t1.d_id DESC
							                           	");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
							foreach ($result as $row) {
								$i++;
								?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $row['d_code']; ?></td>
									<td style="width:82px;"><img src="./uploads/decorate/<?php echo $row['d_photo']; ?>" alt="<?php echo $row['d_name']; ?>" style="width:80px;"></td>
									<td><?php echo $row['d_name']; ?></td>
									<td>₹<?php echo $row['d_old_price']; ?></td>
									<td>₹<?php echo $row['d_current_price']; ?></td>
									<td>
										<?php echo $row['d_available']; ?>
									</td>
									<td>
										<?php echo $row['d_stock_qty']; ?>
									</td>
									<td>
										<?php if($row['d_is_featured'] == 1) {echo '<span class="badge badge-success" style="background-color:green;">Yes</span>';} else {echo '<span class="badge badge-success" style="background-color:red;">No</span>';} ?>
									</td>
									<td>
										<?php if($row['d_is_active'] == 1) {echo '<span class="badge badge-success" style="background-color:green;">Yes</span>';} else {echo '<span class="badge badge-danger" style="background-color:red;">No</span>';} ?>
									</td>
									<td><?php echo $row['cat_name'] . '<br> ' . $row['sub_cat_name']; ?></td>
									<td>										
										<a href="decorate-edit.php?id=<?php echo $row['d_id']; ?>" class="btn btn-primary btn-xs">Edit</a>
										<a href="#" class="btn btn-danger btn-xs" data-href="decorate-delete.php?id=<?php echo $row['d_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>  
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
                <p style="color:red;">Be careful! This product will be deleted from the order table, payment table, size table, color table and rating table also.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>