<?php
include('./admin/inc/config.php');
include('./admin/inc/functions.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0;


$statement = $pdo->prepare("SELECT * FROM tbl_about WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $heading = $row['heading'];
    $sub_heading = $row['sub_heading'];
    $short_desc = $row['short_desc'];
    $image = $row['image'];
    $content = $row['content'];
    $meta_title = $row['meta_title'];
    $meta_keyword = $row['meta_keyword'];
    $meta_desc = $row['meta_desc'];
}
?>
<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>About Us - <?= $meta_title; ?> Jaipur Window</title>
    <meta name="keyword" content="<?= $meta_keyword; ?>">
    <meta name="description" content="<?= $meta_desc; ?>">
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

    <!-- About Us -->
    <section id="about-page">
        <div class="breadcrumb-main">
            <div class="container">
                <div class="breadcrumb-container">
                    <h2 class="page-title">About us</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="about.php">
                                About us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Content Start -->
    <section id="about">
        <div class="container">
            <div class="row" style="background:  #fcd9ec; border-radius: 20px;">
                <div class="col-lg-6 col-md-12 col-sm-12 col-12" style="margin-top: 50px; padding: 30px;">
                    <div id="about-image">
                        <div class="image-1"></div>
                        <div class="image-1"></div>
                    </div>
                    <img src="./admin/uploads/about/<?= $image; ?>" alt="<?= $heading; ?>" width="100%">
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-12" style="margin-top: 50px;">
                    <div id="content">
                        <div class="information-information">
                            <div class="page-title toggled" style="background:  #fcd9ec	;">
                                <h6 style="font-size: 18px; font-style: italic; color: #a01c8c;"><?= $heading; ?></h6>
                                <h3 style="color: rgb(22, 22, 22); padding-bottom: 30px;  font-family: medieval-1;">
                                    <?= $sub_heading; ?></h3>
                            </div>
                            <p class="description">
                                <span style="color: #373737;"><?= $short_desc; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="about-list" style="padding: 0px 60px; padding-bottom:60px;">
                    <?= $content; ?>
                    <br>
                </div>
            </div>
        </div>
    </section>

    <!-- About us Content End -->

    <!-- Product Start -->
    <section id="vision">
        <div class="container" style="background:  #fcd9ec;">
            <div id="content" class="col-sm-12  all-blog">
                <div class="row">
                    <div class="page-title toggled" style="background:  #fcd9ec	;">
                        <h6 style="font-size: 18px; font-style: italic; color: #a01c8c; text-align: center;">Welcome to
                            jaipur
                            window</h6>
                        <h3 style="color: rgb(22, 22, 22); padding-bottom: 30px;  font-family: medieval-1;">
                            Features</h3>
                    </div>

                    <div class="product-block col-lg-3 col-md-6">
                        <div class="product-block-inner clearfix">
                            <div class="blog-left blog-left-content">
                                <div class="blog-image">
                                    <img src="assets/images/blog/1.png" alt="Blogs" title="Blogs"
                                        class="img-responsive">
                                    <div class="post-image-hover"></div>
                                   
                                </div>
                            </div>
                            <div class="blog-right blog-right-content">
                                <h5 class="blog_title"><a href="the-standard-lorem.html">Authentic & Affordable</a></h5>
                                <div class="blog-desc" style="height:150px;">"Authentic Indian Handicrafts at Prices You'll Love"
                                Celebrate the rich heritage of India with genuine, hand-crafted treasures—delivered to you without breaking the bank.</div>
                            </div>
                        </div>
                    </div>
                    <div class="product-block col-lg-3 col-md-6">
                        <div class="product-block-inner clearfix">
                            <div class="blog-left blog-left-content">
                                <div class="blog-image">
                                    <img src="assets/images/my-image/global.jpg" alt="Blogs" title="Blogs"
                                        class="img-responsive">
                                    <div class="post-image-hover"></div>
                                    
                                </div>
                            </div>
                            <div class="blog-right blog-right-content">
                                <h5 class="blog_title"><a href="many-publishing-packages.html">  Global Reach</a>
                                </h5>
                                <div class="blog-desc" style="height:150px;">"Shipping Worldwide – Bringing India to Your Doorstep"
                                No matter where you are, the warmth of Indian art and culture is just a click away.</div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="product-block col-lg-3 col-md-6">
                        <div class="product-block-inner clearfix">
                            <div class="blog-left blog-left-content">
                                <div class="blog-image">
                                    <img src="assets/images/blog/4.png" alt="Blogs" title="Blogs"
                                        class="img-responsive">
                                    <div class="post-image-hover"></div>
                                    
                                </div>
                            </div>
                            <div class="blog-right blog-right-content">
                                <h5 class="blog_title" ><a href="there-are-many-variations.html">Always Fresh, Always New</a>
                                </h5>
                                <div class="blog-desc" style="height:150px;">"New Collections Dropping Regularly"
                                Stay inspired with our ever-evolving catalog. Every visit brings something new to discover.</div>
                               
                            </div>
                        </div>
                    </div>
                    <div class="product-block col-lg-3 col-md-6">
                        <div class="product-block-inner clearfix">
                            <div class="blog-left blog-left-content">
                                <div class="blog-image">
                                    <img src="assets/images/my-image/saree.jpg" alt="Blogs" title="Blogs"
                                        class="img-responsive">
                                    <div class="post-image-hover"></div>
                                     
                                </div>
                            </div>
                            <div class="blog-right blog-right-content">
                                <h5 class="blog_title"><a href="there-are-many-variations.html">Fabrics You’ll Fall in Love With</a>
                                </h5>
                                <div class="blog-desc" style="height:150px;">"Feel the Fabric, Admire the Design"
                                Handwoven, hand-dyed, and handcrafted with precision—our textiles speak the language of timeless beauty.</div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product End -->

    <!-- Our Testimonials-->
    <div class="vipodha-testimonial-block top-margin-all wow fadeInUp" style="background-color: transparent;">
        <div class="vipodha-testimonial container box-module box-content"
            style="background-color:  #fcd9ec; padding: 30px 0; border-radius: 20px;">
            <div class="page-title customers-text" style="background: none;">
                <h3 style="color: black;">Our Testimonials</h3>
            </div>
            <div class="block_box">
                <div class="row">
                    <div class="category-box">
                        <div class="customers-said owl-carousel">
                            <?php
                            $i = 0;
                            $statement = $pdo->prepare("SELECT * FROM tbl_testimonial");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $i++;
                            ?>
                                <div class="row-items category-layout col-xs-12">
                                    <div class="tetimonial-image-content">
                                        <div class="vipodha-testimonial-images">
                                            <i class="icon-squarequote hidden"></i>
                                            <img src="./admin/uploads/testimonial/<?= $row['test_image']; ?>" alt="<?= $row['test_title']; ?>"
                                                class="img-circle img-responsive customers-img" style="width:200px; height:200px; object-fit:cover">
                                        </div>
                                        <div class="vipodha-testimonial-content">
                                            <div class="vipodha-testimonial-author"><?= $row['test_title']; ?></div>
                                            <div class="vipodha-testimonial-customer">Customer</div>
                                        </div>
                                    </div>
                                    <div class="vipodha-testimonial-text">
                                        <p><?= $row['test_description']; ?></p>
                                    </div>
                                    <i class="testimonial-quotes icon-quotes"></i>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Our Testimonials -->

    <!-- footer -->
    <?php include('include/footer.php') ?>
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