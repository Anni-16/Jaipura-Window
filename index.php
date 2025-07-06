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
    <title>Welcome To Jaipur Window | Jaipur Window</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Chonburi&amp;display=swap&amp;family=Carattere&amp;display=swap&amp;family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet">
    <!--vipodha_megamenu css-->
    <link rel="stylesheet" href="assets/css/vipodha_megamenu.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .accordion {
            padding: 30px;
            padding-bottom: 100px;
            border-radius: 20px;
        }

        .accordion .accordion-item {
            padding: 15px 20px;
            margin-top: 20px;
            border-radius: 10px;
        }

        .accordion h2 {
            position: relative;
            display: block;
            text-align: left;
            width: 100%;
            /*    padding: 1em 0; */
            color: #000;
            font-size: 1.15rem;
            font-weight: 400;
            border: none;
            background: none;
            outline: none;
            padding: 0px;
            line-height: 25px;
            margin: 0px;
            font-family: 'Open Sans', sans-serif;
        }

        .accordion h2:hover,
        .accordion h2:focus {
            cursor: pointer;
            color: #a01c8c;
        }

        .accordion h2:hover::after,
        .accordion h2:focus::after {
            cursor: pointer;
            color: #a01c8c;
            border: 1px solid #a01c8c;
        }

        .accordion h2 .accordion-title {
            padding: 1em 1.5em 1em 0;
        }

        .accordion h2 .icon {
            display: inline-block;
            position: absolute;
            top: 2px;
            right: 0;
            width: 22px;
            height: 22px;
            border: 1px solid;
            border-radius: 22px;
        }

        .faq-content {
            padding: 80px 0px;
        }

        .accordion h2 .icon::before {
            display: block;
            position: absolute;
            content: "";
            top: 9px;
            left: 5px;
            width: 10px;
            height: 2px;
            background: currentColor;
        }

        .accordion h2 .icon::after {
            display: block;
            position: absolute;
            content: "";
            top: 5px;
            left: 9px;
            width: 2px;
            height: 10px;
            background: currentColor;
        }

        .accordion h2[aria-expanded=true] {
            color: #a01c8c;
        }

        .accordion h2[aria-expanded=true] .icon::after {
            width: 0;
        }

        .accordion h2[aria-expanded=true]+.accordion-content {
            opacity: 1;
            max-height: 5000px;
            transition: all 200ms linear;
            will-change: opacity, max-height;
        }

        .accordion .accordion-content {
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            transition: opacity 200ms linear, max-height 200ms linear;
            will-change: opacity, max-height;
        }

        .accordion .accordion-content p {
            font-size: 1rem;
            font-weight: 300;
            margin: 0px;
            margin-top: 10px;
            font-family: 'Open Sans', sans-serif;
        }
        
        /*@media screen and (max-width:1440px){*/
        /*    #banner-padding-top{*/
        /*        margin-top:100px;*/
        /*    }*/
        /*}*/
    </style>


</head>

<body class="homepage" style="background-image: url(./assets/images/banners/banner-main.jpeg); background-repeat: no-repeat; width: 100%; height: auto;  background-attachment: fixed; background-position: center; overflow-x: hidden !important">
    <!-- <div class="loader"></div> -->
    <!-- HEADER -->
    <?php include('include/header.php'); ?>
    <!-- .HEADER -->

    <section class="main_section" style="overflow-x: hidden;">
        <!-- Main Banner -->
        <section id="banner-main" style="background-image: url(./assets/images/banners/banner-main.jpeg); background-repeat: no-repeat; width: 100%; height: 100vh;  background-attachment: fixed; background-position: center; ">
            <div class="banner-background-image;" style="margin-bottom: 200px;">
                <div class="container">
                    <div class="banner-text" id="banner-padding-top">
                        <div class="inner-text" style="background: #ff96ef;">
                            <div class="banner-title" style="text-align: center;">

                                "From loom to life


                                <br> — a journey in every thread."
                            </div>
                            <div class="banner-desc1" style="text-align: center;">In Bharat, our
                                diverse country, each
                                state boasts a wealth of unique cultural traditions, culinary delights, and vibrant
                                festivals that are cherished and celebrated by the people.
                            </div>
                            <a href="#product-wear">
                                <!-- <div class="btn btn-info">shop now</div> -->
                            </a>
                        </div>
                    </div>
                    <div class="container"></div>
                    <div class="banner-slider">
                        <!-- Top PRODUCT  -->
                        <div class="product-tab-block wow fadeInUp top-margin-all" style="border-radius: 20px;">
                            <div class="container">
                                <div class="main-tab" style="background: #fcd9ec; border-radius:20px;">
                                    <div class="block_box">
                                        <div class="row">
                                            <div class="category-box">
                                                <div class="category-feature-list ">
                                                    <div class="blog-carousel2 owl-carousel owl-theme" style="padding: 30px 50px;">
                                                        <?php
                                                        $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_featured = 1 ORDER BY p_name ASC LIMIT 10");
                                                        $statement->execute();
                                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($result as $row) {
                                                        ?>
                                                            <div class="single-column">
                                                                <div class="product-layout col-xs-12">
                                                                    <div class="product-thumb transition">
                                                                        <div class="image position-relative">
                                                                            <a href="wear-details.php?p_id=<?= $row['p_id']; ?>" class="thumb-image">
                                                                                <img src="assets/images/slider-window.png" alt="<?= ($row['p_name']); ?>" title="<?= ($row['p_name']); ?>" class="img-responsive" style="position: relative; z-index: 100;">
                                                                                <img src="./admin/uploads/wear/<?= ($row['p_featured_photo']); ?>" alt="<?= ($row['p_name']); ?>" style="position: absolute; top:15%; left: 50%; transform: translate(-50%); z-index: 99; width: 80%;">
                                                                            </a>
                                                                            <div class="button-group">
                                                                                <button class="addcart" type="button" title="Add to Cart" onclick="window.location.href = 'shopping-cart.html';">
                                                                                    <i class="icon-shopping-bag"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <div class="product-description">
                                                                            <div class="caption">
                                                                                <div class="title-rating clearfix">
                                                                                    <h4 class="product-title">
                                                                                        <a href="wear-details.php?p_id=<?= $row['p_id']; ?>"><?= ($row['p_name']); ?></a>
                                                                                    </h4>
                                                                                </div>
                                                                                <div class="price-cartbtn clearfix">
                                                                                    <p class="price">Rs. <?= ($row['p_current_price']); ?></p>
                                                                                </div>
                                                                            </div>
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
                                </div>
                            </div>
                            <!-- .Top PRODUCT  -->
                        </div>
                    </div>
                </div>
        </section>
        <!-- service Section -->
        <div class="service-box  wow fadeInUp top-margin-all " id="feature-service">
            <div class="container" style="background: #fcd9ec; padding: 50px 20px; border-radius: 20px;">
                <div class="promo-item ">
                    <div class="row row-cols-2 row-cols-sm-2 row-cols-lg-4">
                        <div class="service-item">
                            <div class="service" style="background: #fff ;">
                                <div class=" icon-shipping service-icon-foor"></div>
                                <div class="service-content">
                                    <h4 class="promo-title" style="color: #a01c8c;">Free shipping</h4> <span class="promo-desc">On order over
                                        Rs. 150</span>
                                </div>
                            </div>
                        </div>
                        <div class="service-item">
                            <div class="service" style="background: #fff ;">
                                <div class=" icon-wallet service-icon-foor"></div>
                                <div class="service-content">
                                    <h4 class="promo-title" style="color: #a01c8c;">Cash on delivery</h4> <span class="promo-desc">100% money
                                        back
                                        guarantee</span>
                                </div>
                            </div>
                        </div>
                        <div class="service-item">
                            <div class="service" style="background: #fff ;">
                                <div class="icon-gift service-icon-foor"></div>
                                <div class="service-content">
                                    <h4 class="promo-title" style="color: #a01c8c;">Special gift card</h4> <span class="promo-desc">Offer
                                        special
                                        bonuses with gift</span>
                                </div>
                            </div>
                        </div>
                        <div class="service-item">
                            <div class="service" style="background: #fff ;">
                                <div class="icon-customer-service service-icon-foor"></div>
                                <div class="service-content">
                                    <h4 class="promo-title" style="color: #a01c8c;">24*7 customer service</h4> <span class="promo-desc">Call us
                                        24*7 at <br> +91- 8005948153 <br> +91-9492932623</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- .service Section -->


        <!-- About us Section -->
        <section id="about">
            <?php
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
                                <div class="page-title toggled" style="background:  #fcd9ec 	;">
                                    <h6 style="font-size: 18px; font-style: italic; color: #a01c8c;"><?= $heading; ?></h6>
                                    <h3 style="color: rgb(22, 22, 22); padding-bottom: 30px;  font-family: medieval-1;">
                                        <?= $sub_heading; ?></h3>
                                </div>
                                <p class="description">
                                    <span style="color: #373737;"><?= $short_desc; ?></span>
                                    <a href="about.php">
                                        <div class="btn btn-info">Discover More</div>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About us Section End -->


        <!-- banner section -->
        <!-- <div class="html1">
            <div class="container">
                <div class="banner-all">
                    <div class="banner-outer">
                        <div class="banner1">
                            <div class="inner1"><a href="#"><img alt="" class="img-responsive w-100" src="assets/images/banners/banner1.png"> </a></div>
                            <div class="banner-desc">10% <span>off</span></div>
                            <div class="inner2">
                                <div class="banner-desc2">Tips to Choose a</div>
                                <div class="banner-title">Fancy Saree</div>
                                <div class="banner-desc1">as per your body shape</div>
                                <div class="btn btn-info">Shop now</div>
                            </div>
                        </div>
                    </div>
                    <div class="banner-outer">
                        <div class="banner2">
                            <div class="inner1"><a href="#"><img alt="" class="img-responsive w-100" src="assets/images/banners/banner2.png"> </a></div>
                            <div class="inner2">
                                <div class="banner-title">New collection</div>
                                <div class="banner-desc">saree</div>
                                <div class="btn btn-info">Shop now</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- .banner section -->


        <!-- Top  Wear PRODUCT  -->
        <div class="product-tab-block wow fadeInUp top-margin-all" id="product-wear">
            <div class="container">
                <div class="main-tab">
                    <div class="product-tabs box-content clearfix" id="products-top-gap">

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="latest" role="tabpanel" aria-labelledby="latest-tab">
                                <div class="block_box">
                                    <div class="row" style="background:  #fcd9ec; border-radius: 20px;">
                                        <h3 style="color: rgb(22, 22, 22); padding-top: 40px; text-align: center; font-size: 40px; ">
                                            To
                                            wear products</h3>
                                        <p style="text-align: center; padding-bottom: 40px;">Dress up in handmade
                                            elegance –
                                            discover unique artisanal
                                            wearables!</p>
                                        <div class="category-box">
                                            <div class="category-feature-list ">
                                                <div class="product-carousel owl-carousel">
                                                    <?php
                                                    $i = 0;
                                                    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_featured = 1 ORDER BY p_id DESC LIMIT 10");
                                                    $statement->execute();
                                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($result as $row) {
                                                        $i++;
                                                    ?>
                                                        <div class="single-column">
                                                            <div class="product-layout col-xs-12">
                                                                <div class="product-thumb transition">
                                                                    <div class="image">
                                                                        <a href="wear-details.php?p_id=<?= $row['p_id']; ?>" class="thumb-image">
                                                                            <img src="assets/images/slider-window.png" alt="<?= $row['p_name']; ?>" title="<?= $row['p_name']; ?>" class="img-responsive" style="position: relative; z-index: 100;">
                                                                            <img src="./admin/uploads/wear/<?= $row['p_featured_photo']; ?>" alt="<?= $row['p_name']; ?>" style="position: absolute;
                                                                                top:15%;
                                                                                left: 50%; transform: translate(-50%); z-index: 99; width: 80%;">
                                                                        </a>
                                                                        <div class="button-group">
                                                                            <button class="addcart" type="button" title="Add to Cart" onclick="window.location.href = 'shopping-cart.html';"><i class="icon-shopping-bag"></i></button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="caption">
                                                                            <div class="title-rating clearfix">
                                                                                <h4 class="product-title"><a href="wear-details.php?p_id=<?= $row['p_id']; ?>"><?= $row['p_name']; ?></a>
                                                                                </h4>

                                                                            </div>
                                                                            <div class="price-cartbtn clearfix">
                                                                                <p class="price">
                                                                                    Rs. <?= $row['p_current_price']; ?>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="display: flex; justify-content: center; margin-top: 20px; margin-bottom: 40px;">
                                            <a href="wear.php">
                                                <div class="btn btn-info">
                                                    View more</div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- .Top Wear PRODUCT  -->

        <!-- Top  Decorate PRODUCT  -->
        <div class="product-tab-block wow fadeInUp top-margin-all" id="product-wear">
            <div class="container">
                <div class="main-tab">
                    <div class="product-tabs box-content clearfix" id="products-top-gap">
                        <div class="page-title toggled">

                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="latest" role="tabpanel" aria-labelledby="latest-tab">
                                <div class="block_box">
                                    <div class="row" style="background:  #fcd9ec; border-radius: 20px;">
                                        <h3 style="color: rgb(22, 22, 22); padding-top: 40px; text-align: center; font-size: 40px; ">
                                            To
                                            decorate products</h3>
                                        <p style="text-align: center; padding-bottom: 40px;">Dress up in handmade
                                            elegance –
                                            discover unique artisanal
                                            wearables!</p>
                                        <div class="category-box">
                                            <div class="category-feature-list ">
                                                <div class="product-carousel owl-carousel">
                                                    <?php
                                                    $i = 0;
                                                    $statement = $pdo->prepare("SELECT * FROM tbl_decorate WHERE d_is_featured = 1 ORDER BY d_name ASC LIMIT 10");
                                                    $statement->execute();
                                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($result as $row) {
                                                        $i++;
                                                    ?>
                                                        <div class="single-column">
                                                            <div class="product-layout col-xs-12">
                                                                <div class="product-thumb transition">
                                                                    <div class="image">
                                                                        <a href="decorate-details.php?d_id=<?= $row['d_id']; ?>" class="thumb-image">
                                                                            <img src="assets/images/slider-window.png" alt="<?= $row['d_name']; ?>" title="<?= $row['d_name']; ?>" class="img-responsive" style="position: relative; z-index: 100;">
                                                                            <img src="./admin/uploads/decorate/<?= $row['d_photo']; ?>" alt="<?= $row['d_name']; ?>" style="position: absolute;
                                                                                top:15%;
                                                                                left: 50%; transform: translate(-50%); z-index: 99; width: 80%;">
                                                                        </a>
                                                                        <div class="button-group">
                                                                            <button class="addcart" type="button" title="Add to Cart" onclick="window.location.href = 'shopping-cart.html';"><i class="icon-shopping-bag"></i></button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="caption">
                                                                            <div class="title-rating clearfix">
                                                                                <h4 class="product-title"><a href="decorate-details.php?d_id=<?= $row['d_id']; ?>"><?= $row['d_name']; ?></a>
                                                                                </h4>

                                                                            </div>
                                                                            <div class="price-cartbtn clearfix">
                                                                                <p class="price">
                                                                                    Rs. <?= $row['d_current_price']; ?>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="display: flex; justify-content: center; margin-top: 20px; margin-bottom: 40px;">
                                            <a href="decorate.php">
                                                <div class="btn btn-info">
                                                    View more</div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- .Top Decorate PRODUCT  -->

        <!-- Top accessories PRODUCT  -->
        <div class="product-tab-block wow fadeInUp top-margin-all" id="product-wear">
            <div class="container">
                <div class="main-tab">
                    <div class="product-tabs box-content clearfix" id="products-top-gap">
                        <div class="page-title toggled">

                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="latest" role="tabpanel" aria-labelledby="latest-tab">
                                <div class="block_box">
                                    <div class="row" style="background:  #fcd9ec; border-radius: 20px;">
                                        <h3 style="color: rgb(22, 22, 22); padding-top: 40px; text-align: center; font-size: 40px; ">
                                            Accessories</h3>
                                        <p style="text-align: center; padding-bottom: 40px;">Dress up in handmade
                                            elegance –
                                            discover unique artisanal
                                            wearables!</p>
                                        <div class="category-box">
                                            <div class="category-feature-list ">
                                                <div class="product-carousel owl-carousel">
                                                    <?php
                                                    $i = 0;
                                                    $statement = $pdo->prepare("SELECT * FROM tbl_accessroies WHERE a_is_featured = 1 ORDER BY a_name ASC LIMIT 10");
                                                    $statement->execute();
                                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($result as $row) {
                                                        $i++;
                                                    ?>
                                                        <div class="single-column">
                                                            <div class="product-layout col-xs-12">
                                                                <div class="product-thumb transition">
                                                                    <div class="image">
                                                                        <a href="accessorie-details.php?a_id=<?= $row['a_id']; ?>" class="thumb-image">
                                                                            <img src="assets/images/slider-window.png" alt="<?= $row['a_name']; ?>" title="<?= $row['a_name']; ?>" class="img-responsive" style="position: relative; z-index: 100;">
                                                                            <img src="./admin/uploads/accessroies/<?= $row['a_photo']; ?>" alt="<?= $row['a_name']; ?>" style="position: absolute;
                                                                                top:15%;
                                                                                left: 50%; transform: translate(-50%); z-index: 99; width: 80%;">
                                                                        </a>
                                                                        <div class="button-group">
                                                                            <button class="addcart" type="button" title="Add to Cart" onclick="window.location.href = 'shopping-cart.html';"><i class="icon-shopping-bag"></i></button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="caption">
                                                                            <div class="title-rating clearfix">
                                                                                <h4 class="product-title"><a href="accessorie-details.php?a_id=<?= $row['a_id']; ?>"><?= $row['a_name']; ?></a>
                                                                                </h4>

                                                                            </div>
                                                                            <div class="price-cartbtn clearfix">
                                                                                <p class="price">
                                                                                    Rs. <?= $row['a_current_price']; ?>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="display: flex; justify-content: center; margin-top: 20px; margin-bottom: 40px;">
                                            <a href="accessorie.php">
                                                <div class="btn btn-info">
                                                    View more</div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- .Top  Accessories PRODUCT  -->


        <section style="margin-top:150px;" id="faq">
            <div class="container">
                <div class="accordion my-baby-pink">
                    <div class="page-title customers-text" style="background: none;">
                        <h3 style="color: black; padding-bottom:40px;">FAQ</h3>
                    </div>

                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_faq ORDER BY id ASC");
                    $statement->execute();
                    $faqs = $statement->fetchAll(PDO::FETCH_ASSOC);
                    $faqIndex = 0;

                    foreach ($faqs as $faq) {
                        $faqIndex++;
                        $title = ($faq['title']);
                        $answer = nl2br(($faq['answer'])); // preserves line breaks
                    ?>
                        <div class="accordion-item">
                            <h2 id="accordion-button-<?php echo $faqIndex; ?>" aria-expanded="false">
                                <span class="accordion-title"><?php echo $title; ?></span>
                                <span class="icon" aria-hidden="true"></span>
                            </h2>
                            <div class="accordion-content">
                                <p><?php echo $answer; ?>
                                <br>
                                    <a href="https://wa.me/+919492932623">
                                        <div class="btn btn-info" style="color: white !important;">
                                            WhatsApp Us </div>
                                    </a>
                                </p>
                            </div>
                        </div>
                    <?php
                    }

                    if ($faqIndex === 0) {
                        echo '<p>No FAQs found.</p>';
                    }
                    ?>
                </div>
            </div>
        </section>




        <!-- Our Testimonials  -->
        <div class="vipodha-testimonial-block top-margin-all wow fadeInUp" style="background-color: transparent;">
            <div class="vipodha-testimonial container box-module box-content" style="background-color:  #fcd9ec; padding: 30px 0; border-radius: 20px;">
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
                                                <img src="./admin/uploads/testimonial/<?= $row['test_image']; ?>" alt="<?= $row['test_title']; ?>" class="img-circle img-responsive customers-img" style="width:200px; height:200px;">
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
        <!-- Our Testimonials  End -->

        <!--  BLOG -->
        <div class="mt-50 category-featured wow fadeInUp ">
            <div class="container" style="background:  #fcd9ec; padding: 30px 20px; border-radius: 20px;">
                <div class=" page-title toggled">
                    <h3 style="color: rgb(22, 22, 22); padding-bottom: 30px;">Latest Blogs</h3>
                </div>
                <div class="block_box">
                    <div class="row">
                        <div class="category-box">
                            <div class="category-feature-list ">
                                <div class="blog-carousel owl-carousel owl-theme">
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
                                        <div class="product-block col-xs-12">
                                            <div class="product-block-inner">
                                                <div class="blog-left">
                                                    <div class="blog-image">
                                                        <img src="./admin/uploads/blog/<?= $row['bol_image']; ?>" alt="<?= $row['bol_name']; ?>" title="Latest Blog" class="img-responsive" style="width:100%; height:250px; object-fit:cover;">
                                                        <div class="post-image-hover"> </div>
                                                        <p class="post_hover">
                                                            <a class="icon readmore_link" title="Click to view Read More" href="bolg-details.php?url=<?= $row['url']; ?>"><i class="fa fa-link"></i></a>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="blog-right">
                                                    <div class="date-comment blog-date-comment">
                                                        <div class="date-time">
                                                            <i class="fa fa-calendar hidden"></i>
                                                            <div class="blog-date"><?= $formattedDate; ?></div>
                                                        </div>
                                                        <div class="comment-wrapper">
                                                            <div class="write-comment-count">
                                                                <a href="bolg-details.php?url=<?= $row['url']; ?>">
                                                                    <i class="fa-solid fa-user"></i>
                                                                    <span>BY Admin</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="blog-details">
                                                        <h4 class="blog_title"><a href="bolg-details.php?url=<?= $row['url']; ?>"><?= $row['bol_name']; ?></a> </h4>
                                                        <div class="blog-desc"><?= limit_words($row['bol_description'], 30); ?></div>
                                                        <div class="view-blog">
                                                            <div class="read-more">
                                                                <a href="bolg-details.php?url=<?= $row['url']; ?>" class="btn btn-info"><i class="fa fa-link hidden"></i>Read
                                                                    more</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="display: flex; justify-content: center; margin-top: 20px; margin-bottom: 40px;">
                                    <a href="blog.php">
                                        <div class="btn btn-info">
                                            View All</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BLOG -->

    </section>

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
    <script>
        const items = document.querySelectorAll(".accordion-item h2");

        function toggleAccordion() {
            const itemToggle = this.getAttribute('aria-expanded');

            for (i = 0; i < items.length; i++) {
                items[i].setAttribute('aria-expanded', 'false');
            }

            if (itemToggle == 'false') {
                this.setAttribute('aria-expanded', 'true');
            }
        }

        items.forEach(item => item.addEventListener('click', toggleAccordion));
    </script>
</body>

</html>