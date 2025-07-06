<?php
include('./admin/inc/config.php');
include('./admin/inc/functions.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0;
?>

<!DOCTYPE HTML>
<html lang="en-US">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Jaipur Window Blog - Jaipur | Jaipur-Window </title>
	<meta name="description" content="Vipodha">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Favicon -->
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
    <link
        href="https://fonts.googleapis.com/css2?family=Chonburi&amp;display=swap&amp;family=Carattere&amp;display=swap&amp;family=Roboto:wght@400;500;700&amp;display=swap"
        rel="stylesheet">
    <!--vipodha_megamenu css-->
    <link rel="stylesheet" href="assets/css/vipodha_megamenu.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="blogpage" style="background-image: url(./assets/images/banners/banner-main.jpeg); background-repeat: no-repeat; width: 100%; height: auto;  background-attachment: fixed; background-position: center; overflow-x: hidden !important">

	<!-- HEADER -->
	<?php include('include/header.php'); ?>
	<!-- .HEADER -->

	<section>
		<div class="breadcrumb-main">
			<div class="container">
				<div class="breadcrumb-container">
					<h2 class="page-title">Our Blog</h2>
					<ul class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="index.php">
								<i class="fas fa-home"></i>
							</a>
						</li>
						<li class="breadcrumb-item">
							<a>
								Our Blog</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<!-- blog -->
	<div class="blog-section">
		<div class="container">
			<div class="row" style="background:  #fcd9ec; border-radius: 20px;">

				<div class=" page-title toggled">
					<h6
						style=" font-size: 18px; font-style: italic; color: #a01c8c; text-align: center; padding-top: 30px;">
						Welcome to
						jaipur
						window</h6>
					<h3 style="color: rgb(22, 22, 22); font-family: medieval-1;">
						Our Blog</h3>
				</div>

				<div id="content" class="col-sm-12  all-blog">
					<div class="row" id="padding-style">
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
							<div class="product-block col-md-4">
								<div class="product-block-inner clearfix">
									<div class="blog-left blog-left-content">
										<div class="blog-image">
											<img src="./admin/uploads/blog/<?= $row['bol_image']; ?>" alt="<?= $row['bol_name']; ?>"
												class="img-responsive" style="width: 100%; height: 250px; object-fit:cover;">
											<div class="post-image-hover"></div>
											<p class="post_hover">
												<a class="icon readmore_link" title="Click to view Read More"
													href="blog-details.php?url=<?= $row['url']; ?>"><i class="fa fa-link"></i></a>
											</p>
										</div>
									</div>
									<div class="blog-right blog-right-content">
										<div class="date-comment blog-date-comment">
											<div class="date-time">
												<i class="fa fa-calendar hidden"></i>
												<div class="blog-date"><?= $formattedDate; ?></div>
											</div>
											<div class="comment-wrapper">
												<div class="write-comment-count">
													<a href="blog-details.html">
														<i class="fa-solid fa-user"></i>
														<span>By Admin</span>
													</a>
												</div>
											</div>
										</div>
										<h5 class="blog_title"><a href="blog-details.php?url=<?= $row['url']; ?>"><?= $row['bol_name']; ?></a></h5>
										<div class="blog-desc"><?= limit_words($row['bol_description'], 30) ?></div>
										<div class="read-more">
											<a href="blog-details.php?url=<?= $row['url']; ?>" class="btn btn-info"><i
													class="fa fa-link hidden"></i>Read More</a>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- .blog -->

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
    <script type="text/javascript">new WOW().init();</script>
    <link href="./assets/cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet" />
    <!-- Main js -->
    <script type="text/javascript" src="assets/js/theme.js"></script>
    <script type="text/javascript" src="assets/js/price-cart.js"></script> 


    <script>
        /*----------
    Top Header Slider
    ----------*/
        $(".blog-carousel2").owlCarousel({
            loop: false,
            dots: false,
            nav: true,
            rewind: false,
            navText: [
                '<i class="fa fa-angle-left" aria-hidden="true">',
                '<i class="fa fa-angle-right" aria-hidden="true">',
            ],
            autoplay: false,
            autoplayTimeout: 3000,
            animateOut: "fadeOut",
            items: 1,
            responsiveClass: false,
            responsive: {
                320: {
                    items: 1,
                },
                768: {
                    items: 3,
                    margin: 10,
                },
                992: {
                    items: 4,
                    margin: 30,
                },
                1200: {
                    items: 4,
                    margin: 30,
                },
            },
        });

    </script>

</body>

</html>