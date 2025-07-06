<?php
include('./admin/inc/config.php');
include('./admin/inc/functions.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0;

if (isset($_GET['url'])) {
    $url = htmlspecialchars($_GET['url']);
    $statement = $pdo->prepare("SELECT * FROM tbl_blog WHERE url = ? AND status = 1");
    $statement->execute([$url]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Assign Service Details data
        $bol_name = $row['bol_name'];
        $bol_image = $row['bol_image'];
        $bol_desc = $row['bol_description'];
        $bol_link = $row['bol_link'];
        $bol_meta_title = $row['bol_meta_title'];
        $bol_meta_keyword = $row['bol_meta_keyword'];
        $bol_meta_desc = $row['bol_meta_desc'];
        $create_at = $row['create_at'];
        $formattedDate = date("j F Y", strtotime($create_at));
    } else {
        header('Location: blog.php');
        exit;
    }
} else {
    header('Location: blog.php');
    exit;
}
?>

<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Jaipur Window | Blog Details - <?= $bol_meta_title; ?> Jaipur-Window</title>
    <meta name="keyword" content="<?= $bol_meta_keyword; ?>">
    <meta name="description" content="<?= $bol_meta_desc; ?>">
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

    <!-- Banner Section -->
    <section>
        <div class="breadcrumb-main">
            <div class="container">
                <div class="breadcrumb-container">
                    <h2 class="page-title"><?= $bol_name; ?></h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="blog.php">
                                Blog</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a><?= $bol_name; ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>'
    <!-- Banner Section -->

    <!-- Blog  -->
    <div class="blog-section">
        <div class="container">
            <div class="row">
                <!-- Side Bar Menu -->
                <aside id="column-left" class="col-sm-3">
                    <div class="swiper-viewport">
                        <div id="banner0" class="swiper-container swiper-container-horizontal swiper-container-fade">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide swiper-slide-active"><a href="#"><img
                                            src="assets/images/banners/category_banner2.png" alt="Left Banner"
                                            class="img-responsive"></a></div>
                            </div>
                        </div>
                    </div>
                </aside>
                <!-- side Bar Menu -->

                <!-- Blog Details Section -->
                <div id="content" class="col-sm-9  all-blog" style="background:  #fcd9ec; padding:20px;">
                    <div class="article-blog">
                        <div class="blog-image" >
                            <img src="./admin/uploads/blog/<?= $bol_image; ?>" alt="<?= $bol_name; ?>"
                                class="img-responsive" style="width:100%; padding:20px; padding-top:0;" >
                        </div>
                        <div class="blog-description">
                            <div class="date-time">
                                <i class="fa-regular fa-calendar-days"></i>
                                <span><?= $formattedDate; ?></span>
                            </div>
                            <div class="blog_title"><?= $bol_name; ?></div>
                            <div class="blog-desc">
                                <p><?= $bol_desc; ?></p>
                            </div>
                            <div class="blog-desc">
                                <iframe width="100%" height="400" src="<?= $bol_link; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="comment-list" style=" background: #fff; ">
                        <fieldset class="block-title">
                            <legend>Your Comments</legend>
                        </fieldset>
                        <?php
                        $i = 0;
                        $statement = $pdo->prepare("SELECT * FROM tbl_blog_comment ORDER BY id DESC LIMIT 10");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            $i++;
                            $create_at = $row['create_at'];
                            $formattedDate = date("j F Y", strtotime($create_at));
                        ?>
                            <div class="view-comment">
                                <div class="view-comment-inner">
                                    <div class="user_icon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="comment_info">
                                        <div class="name"><?= $row['name']; ?></div>
                                        <div class="date"><?= $formattedDate; ?></div>
                                        <div class="comment-text"><?= $row['comment']; ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="comment-form">
                        <fieldset class="block-title">
                            <legend>Leave Comment</legend>
                        </fieldset>
                        <div class="" id="add-comment">
                            <form method="post" id="add_vipodha_comment" action="blog-comment.php" data-oc-toggle="ajax">
                                <div class="form-group required row mb-3">
                                    <label class="col-sm-3 control-label col-form-label"
                                        for="input-author">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" value="" id="input-author" placeholder="Author"
                                            class="form-control">
                                        <div id="error-author" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-group required row mb-3">
                                    <label class="col-sm-3 control-label col-form-label" for="input-email">E-Mail
                                        Address</label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" value="" id="input-email"
                                            placeholder="E-Mail Address" class="form-control">
                                        <div id="error-email" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-group required row mb-3">
                                    <label class="col-sm-3 control-label col-form-label"
                                        for="input-comment">Comments</label>
                                    <div class="col-sm-9">
                                        <textarea name="comment" rows="10" id="input-comment" placeholder="Comments"
                                            class="form-control"></textarea>
                                        <div id="error-comment" class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-group row form-group-captcha">
                                </div>
                                <input type="hidden" name="auto_approve" value="1">
                                <div class="buttons text-end">
                                    <button type="submit" data-bs-toggle="tooltip" name="submit" class="btn btn-primary">Add
                                        Comment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .Many Publishing Packages -->

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