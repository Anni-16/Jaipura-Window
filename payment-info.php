<?php
include('./admin/inc/config.php');
include('./admin/inc/functions.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0;

$statement = $pdo->prepare("SELECT * FROM tbl_payment_policy WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$heading = $row['heading'];
	$content = $row['content'];
}

?>
<!DOCTYPE HTML>
<html lang="en-US">

<head>
<meta charset="UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Jaipur Window Payments Policy - Jaipur | Jaipur Window</title>
    <meta name="keyword" content="Jaipur Window Terms & Conditions - Jaipur | Jaipur Window">
    <meta name="description" content="Jaipur Window Terms & Conditions - Jaipur | Jaipur Window">
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

<body class="aboutpage" style="background-image: url(./assets/images/banners/banner-main.jpeg); background-repeat: no-repeat; width: 100%; height: auto;  background-attachment: fixed; background-position: center; overflow-x: hidden !important">
    <!-- HEADER -->
	<?php include('include/header.php'); ?>
	<!-- .HEADER -->

	<!-- Terms & Conditions -->
	<section>
		<div class="breadcrumb-main">
			<div class="container">
				<div class="breadcrumb-container">
					<h2 class="page-title"><?= $heading; ?></h2>
					<ul class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="index.php">
								<i class="fas fa-home"></i>
							</a>
						</li>
						<li class="breadcrumb-item">
							<a><?= $heading; ?></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<div class="privacy-section">
		<div class="container">
			<div class="row" style="background-color:  #fcd9ec; border-radius: 20px; padding: 10px 30px;">
				<div id="content" class="col-sm-12  all-blog">
					<div class="information-information">
						<?= $content;  ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- .Terms & Conditions -->

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