<?php
include('./admin/inc/config.php');
include('./admin/inc/functions.php');

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

$user_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0;


if (isset($_GET['cat_id'])) {
	$url = $_GET['cat_id'];

	// Fetch the subcategory details based on the URL parameter
	$statement = $pdo->prepare("SELECT * FROM tbl_accessroies_category WHERE cat_id = ? AND status = 1 ");
	$statement->execute([$url]);
	$row = $statement->fetch(PDO::FETCH_ASSOC);

	if (!$row) {
		// Redirect if subcategory not found
		header('location: accessorie-category.php');
		exit;
	}

	$cat_id = $row['cat_id'];
	$cat_name = $row['cat_name'];
	$cat_image = $row['cat_image'];

	// Fetch products belonging to this subcategory
	$statement = $pdo->prepare("SELECT * FROM tbl_accessroies WHERE cat_id = ?");
	$statement->execute([$cat_id]);
	$accessories = $statement->fetchAll(PDO::FETCH_ASSOC);
} else {
	header('location: accessorie-category.php');
	exit;
}
?>


<!DOCTYPE HTML>
<html lang="en-US">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Welcome To Jaipur Window - Accessories Category | Jaipur Window</title>
	<meta name="description" content="Welcome To Jaipur Window | Jaipur Window">
	<meta name="keyword" content="Welcome To Jaipur Window | Jaipur Window">
	<meta name="viewport" content="width=device-width, initial-scale=1">


	<link rel="icon" type="image/png" href="assets/images/my-image/logo.png">
	<!-- bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<!-- owl-carousel CSS -->
	<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css" media="all" />
	<!-- font-awesome CSS -->
	<link rel="stylesheet" href="./assets/cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
	<!-- icomoon CSS -->
	<link rel="stylesheet" href="assets/fonts/vipodha-font.css" type="text/css" media="all">
	<!-- Main Style CSS -->
	<link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all" />
	<link rel="stylesheet" href="assets/css/mycss.css" type="text/css" media="all" />
	<link rel="stylesheet" href="assets/css/common-page-style.css" type="text/css" media="all" />
	<link rel="stylesheet" href="assets/css/my-cart.css" type="text/css" media="all" />

	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<!-- Font -->
	<link href="https://fonts.googleapis.com/css2?family=Chonburi&amp;display=swap&amp;family=Carattere&amp;display=swap&amp;family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet">
	<!--vipodha_megamenu css-->
	<link rel="stylesheet" href="assets/css/vipodha_megamenu.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="assets/css/product-filter.css">



	<style>
		.accordion-button {
			background: #efefef !important;
		}

		.accordion-body {
			background: #efefef !important;
		}

		.my-baby-pink {
			background: #fcd9ec !important;
		}


		@media screen and (max-width:480px) {
			#list-view {
				visibility: hidden !important;
			}

			#grid-view {
				visibility: hidden !important;
			}

		}
	</style>
</head>

<body class="categorypage" style="background-image: url(./assets/images/banners/banner-main.jpeg); background-repeat: no-repeat; width: 100%; height: auto;  background-attachment: fixed; background-position: center; overflow-x: hidden !important">

	<!-- HEADER -->
	<?php include('include/header.php'); ?>
	<!-- .HEADER -->


	<section>
		<div class="breadcrumb-main">
			<div class="container">
				<div class="breadcrumb-container">
					<h2 class="page-title"><?= $cat_name; ?></h2>
					<ul class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="index.php">
								<i class="fas fa-home"></i>
							</a>
						</li>
						<li class="breadcrumb-item">
							<a href="accessorie.php">
								Accessories
							</a>
						</li>
						<li class="breadcrumb-item">
							<a href="accessorie-category.php"> <?= $cat_name; ?> </a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<div class="blog-section donuts">
		<div class="container">
			<div class="row">
				<aside id="column-left" class="col-sm-3">
					<div class="category-content">
						<div class="box-category ">
							<h3 class="toggled relative">Other Categories</h3>
							<ul class="list-unstyled parent my-baby-pink" id="select-category">
								<!-- Work on it -->
								<li class="has-more-category">
									<a href="wear.php" class="list-group-item main-item">To Wear<span class="toggled"><i class="fa fa-plus"></i></span>
									</a>
									<ul class="list-unstyled child-categories group">
										<!-- This is submenu item for jaipur window -->
										<div class="accordion accordion-flush" id="accordionFlushExample">
											<div class="accordion-item">
												<h2 class="accordion-header" id="flush-headingOne">
													<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
														<a href="#" class="list-group-item main-item">Men

														</a>
													</button>
												</h2>
												<div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
													<div class="accordion-body">
														<?php
														$i = 0;
														$statement = $pdo->prepare("SELECT *  FROM tbl_mid_category WHERE tcat_id = 1 AND status = 1 ORDER BY mcat_id DESC");
														$statement->execute();
														$result = $statement->fetchAll(PDO::FETCH_ASSOC);
														foreach ($result as $row1) {
															$i++;
														?>
															<li>
																<a href="wear-sub-category.php?mcat_id=<?= $row1['mcat_id']; ?>" class="list-group-item">&nbsp;&nbsp;
																	<?= $row1['mcat_name']; ?></a>
															</li>
														<?php } ?>
													</div>
												</div>
											</div>
											<div class="accordion-item">
												<h2 class="accordion-header" id="flush-headingTwo">
													<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
														Women
													</button>
												</h2>
												<div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
													<div class="accordion-body">
														<?php
														$i = 0;
														$statement = $pdo->prepare("SELECT *  FROM tbl_mid_category WHERE tcat_id = 2 AND status = 1 ORDER BY mcat_id DESC");
														$statement->execute();
														$result = $statement->fetchAll(PDO::FETCH_ASSOC);
														foreach ($result as $row1) {
															$i++;
														?>
															<li>
																<a href="wear-sub-category.php?mcat_id=<?= $row1['mcat_id']; ?>" class="list-group-item">&nbsp;&nbsp;
																	<?= $row1['mcat_name']; ?></a>
															</li>
														<?php } ?>
													</div>
												</div>
											</div>
										</div>
									</ul>
								</li>
								<!-- Work on it  -->
								<li class="has-more-category">
									<a href="decorate.php" class="list-group-item main-item">To Decorate<span class="toggled"><i class="fa fa-plus"></i></span>
									</a>
									<ul class="list-unstyled child-categories group">
										<?php
										$statement = $pdo->prepare("SELECT * FROM tbl_decorate_category WHERE status = 1 ORDER BY cat_id DESC");
										$statement->execute();
										$categories = $statement->fetchAll(PDO::FETCH_ASSOC);

										foreach ($categories as $category) { ?>
											<li>
												<a href="decorate-category.php?cat_id=<?= $category['cat_id']; ?>" class="list-group-item">&nbsp;&nbsp; <?= $category['cat_name']; ?></a>
											</li>
										<?php } ?>
									</ul>
								</li>
								<li class="has-more-category">
									<a href="accessorie.php" class="list-group-item main-item">To Accessories<span class="toggled"><i class="fa fa-plus"></i></span>
									</a>
									<ul class="list-unstyled child-categories group">
										<?php
										$i = 0;
										$statement = $pdo->prepare("SELECT * FROM tbl_accessroies_category WHERE status = 1 ORDER BY cat_name ASC");
										$statement->execute();
										$result = $statement->fetchAll(PDO::FETCH_ASSOC);
										foreach ($result as $row) {
											$i++;
										?>
											<li>
												<a href="accessorie-category.php?cat_id=<?= $row['cat_id']; ?>" class="list-group-item">&nbsp;&nbsp; <?= $row['cat_name']; ?></a>
											</li>
										<?php }
										?>
									</ul>
								</li>
							</ul>
						</div>
					</div>

					<!-- Banner image -->
					<div class="swiper-viewport">
						<div id="banner0" class="swiper-container swiper-container-horizontal swiper-container-fade">
							<div class="swiper-wrapper">
								<div class="swiper-slide swiper-slide-active"><a href="#">
										<img src="assets/images/banners/category_banner2.png" alt="Left Banner" class="img-responsive"></a>
								</div>
							</div>
						</div>
					</div>
					<!-- Banner Images -->

				</aside>


				<!-- Category -->
				<div id="content" class="col-sm-9  all-blog my-baby-pink" style="padding: 20px 40px;">
					<div class="category-refine">
						<h3><strong>Refine Search By Accessories Categories</strong></h3>
						<div class="row">
							<div class="col-sm-12">
								<ul>
									<?php
									$i = 0;
									$statement = $pdo->prepare("SELECT * FROM tbl_accessroies_category WHERE status = 1 ORDER BY cat_name ASC");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
										$i++;
									?>
										<li>
											<a href="accessorie-category.php?cat_id=<?= $row['cat_id']; ?>"><?= $row['cat_name']; ?></a>
										</li>
									<?php } ?>
								</ul>
							</div>
						</div>
					</div>
					<?php include('short-by.php'); ?>

					<div id="items-container">
						<?php if (!empty($accessories)) {
							foreach ($accessories as $accessorie) {
						?>


								<div class="item">
									<div class="product-layout   col-xs-12  ">
										<div class="food-cart-box" data-product-id="1">
											<div class="food-box">
												<div class="product-thumb">
													<div class="image">
														<a href="accessorie-details.php?a_id=<?= $accessorie['a_id']; ?>" class="thumb-image">
															<?php if (!empty($accessorie['a_photo']) && file_exists('./admin/uploads/accessroies/' . $accessorie['a_photo'])) : ?>
																<img src="./admin/uploads/accessroies/<?= ($accessorie['a_photo']); ?>" alt="<?= ($accessorie['a_name']); ?>" title="<?= ($accessorie['a_name']); ?>" class="food-img" style="width:100%; height:auto; object-fit: cover;">
															<?php else : ?>
																<img src="assets/jaipur-new-logo.png" alt="<?= ($accessorie['a_name']); ?>" title="<?= ($accessorie['a_name']); ?>" class="food-img" style="width:100%; height:auto; object-fit: cover;">
															<?php endif; ?>
														</a>
														<div class="button-group">
															<button title="Add to Cart"><ion-icon name="cart" class="add-cart"></ion-icon></button>
														</div>
													</div>
												</div>

												<div class="product-description">
													<div class="caption">
														<div class="title-rating clearfix">
															<h4 class="product-title"><a class="food-title2" href="accessorie-details.php?a_id=<?= $accessorie['a_id']; ?>"><?= $accessorie['a_name']; ?></a></h4>
														</div>
														<div class="price-cartbtn clearfix">
															<p class="food-price">
																Rs.<?= $accessorie['a_current_price']; ?>
															</p>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

						<?php }
						} else {
							echo "<p>No Product available in this Category.</p>";
						} ?>
					</div>
				</div>
				<!-- Category -->
			</div>
		</div>
	</div>




	<!-- footer -->
	<?php include('include/footer.php'); ?>
	<!-- .footer -->


	<script src="assets/js/vendors/jquery-2.1.1.min.js" type="text/javascript"></script>
	<!-- bootstrap js -->
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<!-- owl-carousel js -->
	<script type="text/javascript" src="assets/js/owl.carousel.min.js"></script>
	<!-- js -->
	<script src="assets/js/vipodha_megamenu.js"></script>
	<!-- wow javascript -->
	<script src="./assets/cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		new WOW().init();
	</script>
	<link href="./assets/cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet" />
	<!-- Main js -->

	<script type="text/javascript" src="assets/js/product-filter.js"></script>
	<script type="text/javascript" src="assets/js/price-cart.js"></script>


</body>


</html>