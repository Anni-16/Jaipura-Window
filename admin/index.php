<?php require_once('header.php'); ?>

<section class="content-header">
	<h1>Dashboard</h1>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_top_category");
$statement->execute();
$total_top_category = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_mid_category");
$statement->execute();
$total_mid_category = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_end_category");
$statement->execute();
$total_end_category = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_product");
$statement->execute();
$total_product = $statement->rowCount();


$statement = $pdo->prepare("SELECT * FROM tbl_decorate_category");
$statement->execute();
$total_cat = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_decorate_sub_category");
$statement->execute();
$total_sub_cat = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_decorate");
$statement->execute();
$total_decorate = $statement->rowCount();


$statement = $pdo->prepare("SELECT * FROM tbl_accessroies_category");
$statement->execute();
$total_cat_accessroies = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_accessroies");
$statement->execute();
$total_accessories = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_status='1'");
$statement->execute();
$total_customers = $statement->rowCount();


$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
$statement->execute(array('Success'));
$total_order_completed = $statement->rowCount();


$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE order_status=?");
$statement->execute(array('Pending'));
$total_order_pending = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE order_status=?");
$statement->execute(array('Shipped'));
$total_order_Shipped = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE order_status=?");
$statement->execute(array('Delivered'));
$total_order_Complete= $statement->rowCount();

?>

<section class="content">
	<div class="row">

		<!-- To Wear -->
		<div class="col-lg-12 col-xs-6">
			<h3>To Wear Deatils</h3>
		</div>
		<a href="wear.php">
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-primary">
					<div class="inner">
						<h3><?php echo $total_product; ?></h3>
						<p>To Wear Products</p>
					</div>
					<div class="icon">
						<i class="ionicons ion-android-cart"></i>
					</div>

				</div>
			</div>
		</a>
		<a href="wear-category.php">
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-primary">
					<div class="inner">
						<h3><?php echo $total_top_category; ?></h3>
						<p>To Wear Category</p>
					</div>
					<div class="icon">
						<i class="ionicons ion-android-cart"></i>
					</div>

				</div>
			</div>
		</a>
		<a href="wear-sub-category.php">
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-primary">
					<div class="inner">
						<h3><?php echo $total_mid_category; ?></h3>
						<p>To Wear Sub Category</p>
					</div>
					<div class="icon">
						<i class="ionicons ion-android-cart"></i>
					</div>

				</div>
			</div>
		</a>
		<a href="wear-end-category.php">
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-primary">
					<div class="inner">
						<h3><?php echo $total_end_category; ?></h3>
						<p>To Wear End Category</p>
					</div>
					<div class="icon">
						<i class="ionicons ion-android-cart"></i>
					</div>

				</div>
			</div>
		</a>


		<!-- To Decorate -->
		<div class="col-lg-12 col-xs-6">
			<h3>To Decorate Deatils</h3>
		</div>
		<a href="decorate.php">
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-maroon">
					<div class="inner">
						<h3><?php echo $total_decorate; ?></h3>
						<p>To Decorate Products</p>
					</div>
					<div class="icon">
						<i class="ionicons ion-android-cart"></i>
					</div>

				</div>
			</div>
		</a>
		<a href="decorate-cat.php">
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-maroon">
					<div class="inner">
						<h3><?php echo $total_cat; ?></h3>
						<p>To Decorate Category</p>
					</div>
					<div class="icon">
						<i class="ionicons ion-android-cart"></i>
					</div>

				</div>
			</div>
		</a>
		<a href="decorate-sub-cat.php">
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-maroon">
					<div class="inner">
						<h3><?php echo $total_sub_cat; ?></h3>
						<p>To Decorate Sub Category</p>
					</div>
					<div class="icon">
						<i class="ionicons ion-android-cart"></i>
					</div>

				</div>
			</div>
		</a>


		<!-- To Accessories -->
		<div class="col-lg-12 col-xs-6">
			<h3>To Accessories Deatils</h3>
		</div>
		<a href="accessories.php">
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-maroon">
					<div class="inner">
						<h3><?php echo $total_accessories; ?></h3>
						<p>To Accessories Products</p>
					</div>
					<div class="icon">
						<i class="ionicons ion-android-cart"></i>
					</div>

				</div>
			</div>
		</a>
		<a href="accessroies-cat.php">
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-maroon">
					<div class="inner">
						<h3><?php echo $total_cat_accessroies; ?></h3>
						<p>To Accessories Category</p>
					</div>
					<div class="icon">
						<i class="ionicons ion-android-cart"></i>
					</div>

				</div>
			</div>
		</a>
	</div>

	<br>
	<br>

	<div class="row">
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-gray">
				<div class="inner">
					<h3><?php echo $total_order_pending; ?></h3>

					<p>Pending Orders</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-clipboard"></i>
				</div>

			</div>
		</div>

		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3><?php echo $total_order_Shipped; ?></h3>

					<p>Shipped Orders</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-clipboard"></i>
				</div>

			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-orange">
				<div class="inner">
					<h3><?php echo $total_order_Complete; ?></h3>

					<p>Complete Orders</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-clipboard"></i>
				</div>

			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-green">
				<div class="inner">
					<h3><?php echo $total_order_completed; ?></h3>

					<p>Payment Complete</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-android-checkbox-outline"></i>
				</div>

			</div>
		</div>
		


		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-red">
				<div class="inner">
					<h3><?php echo $total_customers; ?></h3>

					<p>Active Customers</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-person-stalker"></i>
				</div>

			</div>
		</div>

		
	</div>

</section>

<?php require_once('footer.php'); ?>