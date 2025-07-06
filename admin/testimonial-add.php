<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
	$valid = 1;
	$error_message = '';

	if (empty($_POST['test_title'])) {
		$valid = 0;
		$error_message .= 'Name cannot be empty<br>';
	}

	if (isset($_FILES['test_image']['name']) && $_FILES['test_image']['name'] != '') {
		$path = $_FILES['test_image']['name'];
		$path_tmp = $_FILES['test_image']['tmp_name'];

		$ext = pathinfo($path, PATHINFO_EXTENSION);
		if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
			$valid = 0;
			$error_message .= 'You must upload a JPG, JPEG, PNG, or GIF file<br>';
		}
	} else {
		$valid = 0;
		$error_message .= 'You must select a photo<br>';
	}

	if ($valid == 1) {
		// Generate a unique file name
		$final_name = 'customer-' . time() . '.' . $ext;
		move_uploaded_file($path_tmp, './uploads/testimonial/' . $final_name);

		// Insert the data into the database
		$statement = $pdo->prepare("INSERT INTO tbl_testimonial (test_title, test_description, test_image, status) VALUES (?, ?, ?, ?)");
		$statement->execute([
			$_POST['test_title'], 
			$_POST['test_description'], 
			$final_name, 
			$_POST['show_on_menu']
		]);

		$success_message = 'Testimonial is added successfully!';
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Testimonial</h1>
	</div>
	<div class="content-header-right">
		<a href="testimonial.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>

<section class="content">

	<div class="row">
		<div class="col-md-12">

			<?php if (!empty($error_message)): ?>
				<div class="callout callout-danger">
					<p><?php echo $error_message; ?></p>
				</div>
			<?php endif; ?>

			<?php if (!empty($success_message)): ?>
				<div class="callout callout-success">
					<p><?php echo $success_message; ?></p>
				</div>
			<?php endif; ?>

			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Customer Name <span>*</span></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="test_title" required>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Customer Image <span>*</span></label>
							<div class="col-sm-3">
								<input type="file" class="form-control" name="test_image" required>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Content <span>*</span></label>
							<div class="col-sm-9">
								<textarea class="form-control" name="test_description" id="editor1" style="height:200px;" required></textarea>
							</div>
						</div>
						<div class="form-group">
                            <label for="" class="col-sm-2 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="show_on_menu" class="form-control" style="width:auto;" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
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
