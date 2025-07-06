<?php
include('./admin/inc/config.php');
include('./admin/inc/functions.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0;

$statement = $pdo->prepare("SELECT * FROM tbl_contact WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $heading = $row['heading'];
    $address = $row['address'];
    $phone_no_1 = $row['phone_no_1'];
    $phone_no_2 = $row['phone_no_2'];
    $email = $row['email'];
    $map_links = $row['map_links'];
    $shop_time = $row['shop_time'];
}
?>
<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Welcome To Jaipur Window Contact Us - Jaipur | Jaipur Window</title>
    <meta name="description" content="Welcome To Jaipur Window | Jaipur Window">
    <meta name="keyword" content="Welcome To Jaipur Window | Jaipur Window">
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

<body class="contactpage" style="background-image: url(./assets/images/banners/banner-main.jpeg); background-repeat: no-repeat; width: 100%; height: auto;  background-attachment: fixed; background-position: center; overflow-x: hidden !important">
    <!-- HEADER -->
    <?php include('include/header.php'); ?>
    <!-- .HEADER -->

    <!--  Contact_Us -->
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
    <div class="Contact_Us">
        <div class="container">
            <div class="row">
                <div id="content" class="col">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 contact-left">
                            <div class="panel panel-default" style="border-radius: 20px; background: #fcd9ec">
                                <div class="panel-body">
                                    <h2 class="contact-title">Our locations</h2>
                                    <div class="store-address">
                                        <i class="fa fa-home"></i>
                                        <div class="store-title">Address</div>
                                        <div class="store-detail"><?= $address; ?></div>
                                        <a href="<?= $map_links; ?>" target="_blank" class="btn btn-info"><i class="fa-solid fa-location-dot"></i> View
                                            Google Map</a>
                                    </div>
                                    <div class="store-telephone">
                                        <i class="fa fa-phone"></i>
                                        <div class="store-title">Telephone</div>
                                        <div class="store-detail"><a href="tel:+91<?= $phone_no_1; ?>">+91 - <?= $phone_no_1; ?></a></div>
                                        <div class="store-detail"><a href="tel:+91<?= $phone_no_2; ?>">+91 - <?= $phone_no_2; ?></a></div>
                                    </div>
                                    <div class="store-open">
                                        <i class="fa-regular fa-clock"></i>
                                        <div class="store-title">Opening Times</div>
                                        <div class="store-detail"><?= $shop_time; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 contact-right"
                            style="background-color:  #fcd9ec; padding: 20px 30px; border-radius: 20px;">
                            <form action="contact-email-send.php"
                                method="post" enctype="multipart/form-data" class="form-horizontal">
                                <fieldset>
                                    <legend class="contact-title">Contact form</legend>
                                    <div class="form-group required row">
                                        <label class="col-sm-2 control-label" for="input-name">Your Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="input-name" name="name" class="form-control" required="">
                                        </div>
                                    </div>
                                    <div class="form-group required row">
                                        <label class="col-sm-2 control-label" for="input-email">E-Mail
                                            Address</label>
                                        <div class="col-sm-10">
                                            <input type="email" name="email" id="input-email" class="form-control" required="">
                                        </div>
                                    </div>
                                    <div class="form-group required row">
                                        <label class="col-sm-2 control-label" for="input-number">Phone Number</label>
                                        <div class="col-sm-10">
                                            <input type="number" name="phone" id="input-number" class="form-control" required="">
                                        </div>
                                    </div>
                                    <div class="form-group required row">
                                        <label class="col-sm-2 control-label" for="input-enquiry">Enquiry</label>
                                        <div class="col-sm-10">
                                            <textarea name="message" rows="10" id="input-enquiry" class="form-control"
                                                required=""></textarea>
                                        </div>
                                    </div>
                                  
                                </fieldset>
                                <div class="buttons clearfix">
                                    <div class="pull-right">
                                        <input class="btn btn-primary" type="submit" name="submit" value="Submit">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .Contact_Us -->

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