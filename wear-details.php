<?php
include('./admin/inc/config.php');
include('./admin/inc/functions.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0;

// Check if the 'p_id' parameter exists in the URL, if not, redirect to 'wear.php'
if (!isset($_GET['p_id']) || !is_numeric($_GET['p_id'])) {
    header('Location: wear.php');
    exit;
}

$url = $_GET['p_id']; // The product ID passed via URL

// Fetch product details using the product ID
$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id = ? AND p_is_active = 1");
$statement->execute([$url]);
$row = $statement->fetch(PDO::FETCH_ASSOC);

// If no product is found, redirect to 'wear.php'
if (!$row) {
    header('Location: wear.php');
    exit;
}

// Assigning the fetched data to variables
$p_id = $row['p_id'];
$p_code = $row['p_code'];
$p_name = $row['p_name'];
$p_old_price = $row['p_old_price'];
$p_current_price = $row['p_current_price'];
$p_available = $row['p_available'];
$p_qty = $row['p_qty'];
$p_featured_photo = $row['p_featured_photo'];
$p_description = $row['p_description'];
$p_short_description = $row['p_short_description'];
$p_is_featured = $row['p_is_featured'];
$p_is_active = $row['p_is_active'];
$ecat_id = $row['ecat_id']; // Corrected variable name

// Get category details for breadcrumb
$statement = $pdo->prepare("SELECT * 
                            FROM tbl_end_category t1
                            JOIN tbl_mid_category t2 ON t1.mcat_id = t2.mcat_id
                            JOIN tbl_top_category t3 ON t2.tcat_id = t3.tcat_id
                            WHERE t1.ecat_id = ?");
$statement->execute([$ecat_id]);
$result = $statement->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $tcat_id = $result['tcat_id'];
    $tcat_name = $result['tcat_name'];
    $mcat_name = $result['mcat_name'];
    $ecat_name = $result['ecat_name'];
} else {
    $tcat_id = null;
    $tcat_name = null;
    $mcat_name = null;
    $ecat_name = null;
}

// Fetch product sizes
$statement = $pdo->prepare("SELECT size_id FROM tbl_product_size WHERE p_id = ?");
$statement->execute([$p_id]);
$size = array_column($statement->fetchAll(PDO::FETCH_ASSOC), 'size_id');

// Fetch product colors
$statement = $pdo->prepare("SELECT color_id FROM tbl_product_color WHERE p_id = ?");
$statement->execute([$p_id]);
$color = array_column($statement->fetchAll(PDO::FETCH_ASSOC), 'color_id');

// Fetch contact information
$statement = $pdo->prepare("SELECT * FROM tbl_contact WHERE id = 1");
$statement->execute();
$contact = $statement->fetch(PDO::FETCH_ASSOC);

if ($contact) {
    $heading = $contact['heading'];
    $address = $contact['address'];
    $phone_no_1 = $contact['phone_no_1'];
    $phone_no_2 = $contact['phone_no_2'];
    $email = $contact['email'];
    $map_links = $contact['map_links'];
    $shop_time = $contact['shop_time'];
} else {
    $heading = $address = $phone_no_1 = $phone_no_2 = $email = $map_links = $shop_time = null;
}

?>



<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Welcome To Jaipur Window - Accessories Details <?= $p_name; ?> | Jaipur Window</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        .my-baby-pink {
            background: #fcd9ec !important;
        }



        /* iMAGE ZOOM CSS */
        #img-1 {
            position: relative;
            overflow: hidden;
        }

        #img-1 .zoom-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: none;
            background-repeat: no-repeat;
            background-size: 200%;
            /* Adjust zoom level */
            z-index: 10;
            cursor: crosshair;
        }

        #prozoom {
            display: block;
            width: 100%;
            height: auto;
            transition: opacity 0.2s ease;
        }

        header.header-fixed {
            position: fixed;
            background: var(--secondary-color);
            top: 0;
            left: 0;
            right: 0;
            animation: fadeInDown 1s ease-out forwards;
            z-index: 9000 !important;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
        }
    </style>

</head>

<body class="productpage" style="background-image: url(./assets/images/banners/banner-main.jpeg); background-repeat: no-repeat; width: 100%; height: auto;  background-attachment: fixed; background-position: center; overflow-x: hidden !important">
    <!-- HEADER -->
    <?php include('include/header.php'); ?>
    <!-- .HEADER -->

    <section>
        <div class="breadcrumb-main">
            <div class="container">
                <div class="breadcrumb-container">
                    <h2 class="page-title"><?= $p_name; ?></h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Wear</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">
                                <?= $tcat_name; ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">
                                <?= $mcat_name; ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">
                                <?= $ecat_name; ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">
                                <?= $p_name; ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="blog-section Chikankari Saree" style="overflow-x: hidden;">
        <div class="container">
            <div class="row">
                <div id="content" class="col-sm-12">
                    <div class="food-cart-box" data-product-id="1">
                        <div class="food-box">
                            <div class="pro-deatil product-content my-baby-pink">
                                <div class="row" style=" border-radius: 20px; padding: 30px 30px;">
                                    <div class="col-md-6 product-left">
                                        <div class="thumbnails">
                                            <div class="pro-image" id="img-1">
                                                <a class="thumbnail" href="#">
                                                    <img src="./admin/uploads/wear/<?= $p_featured_photo; ?>" title="<?= $p_name; ?>" id="prozoom" alt="<?= $p_name; ?>" data-zoom-image="./admin/uploads/wear/<?= $p_featured_photo; ?>" class="food-img">
                                                </a>
                                            </div>
                                            <div id="additional-carousel" class="additional-carousel owl-carousel">
                                                <?php
                                                $statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
                                                $statement->execute(array($p_id));
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($result as $row) {
                                                ?>
                                                    <div class="category-layout col-xs-12">
                                                        <div class="image-additional">
                                                            <a href="#" title="<?= $p_name; ?>" class="elevatezoom-gallery" data-image="./admin/uploads/wear/<?= $row['photo']; ?>" data-zoom-image="./admin/uploads/wear/<?= $row['photo']; ?>">
                                                                <?php if (!empty($row['photo']) && file_exists('./admin/uploads/wear/' . $row['photo'])) : ?>
                                                                    <img src="./admin/uploads/wear/<?= ($row['photo']); ?>" alt="<?= ($p_name); ?>" title="<?= ($p_name); ?>" class="w-100">
                                                                <?php else : ?>
                                                                    <img src="assets/jaipur-new-logo.png" alt="<?= ($p_name); ?>" title="<?= ($p_name); ?>" class="w-100">
                                                                <?php endif; ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 product-right">
                                        <h1 class="food-title"><?= $p_name; ?></h1>
                                        <hr>
                                        <ul class="list-unstyled manufacturer-listpro">
                                            <!-- <li><span class="disc">Brand:</span> <a class="disc1" href="#">Blue
                                                    Baker</a></li> -->
                                            <li><span class="disc">Product Code:</span> <span class="disc1"><?= $p_code; ?></span>
                                            </li>
                                            <li><span class="disc">Availability:</span> <span class="disc1"><?= $p_available; ?></span></li>
                                        </ul>
                                        <hr>
                                        <ul class="list-unstyled">
                                            <li>
                                                <h2 class="food-price">Rs. <span class="text-decoration-line-through" style="color:grey;"><?= $p_old_price; ?></span>
                                                    <?= $p_current_price; ?></h2>
                                            </li>
                                        </ul>
                                        <hr>

                                        <!-- Size -->
                                        <?php if (!empty($size)) : ?>
                                            <div class="mt-3">
                                                <strong>Size:</strong>
                                                <?php
                                                $stmt = $pdo->prepare("SELECT * FROM tbl_size");
                                                $stmt->execute();
                                                $first = true;
                                                foreach ($stmt as $s) {
                                                    if (in_array($s['size_id'], $size)) {
                                                        $checked = $first ? 'checked' : '';
                                                        echo "<label><input type='radio' name='size_id' value='{$s['size_id']}' class='size-radio' {$checked}> {$s['size_name']}</label> ";
                                                        $first = false;
                                                    }
                                                }
                                                ?>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Color -->
                                        <?php if (!empty($color)) : ?>
                                            <div class="mt-3">
                                                <strong>Color:</strong>
                                                <?php
                                                $stmt = $pdo->prepare("SELECT * FROM tbl_color");
                                                $stmt->execute();
                                                $first = true;
                                                foreach ($stmt as $c) {
                                                    if (in_array($c['color_id'], $color)) {
                                                        $checked = $first ? 'checked' : '';
                                                        echo "<label><input type='radio' name='color_id' value='{$c['color_id']}' class='color-radio' {$checked}> {$c['color_name']}</label> ";
                                                        $first = false;
                                                    }
                                                }
                                                ?>
                                            </div>
                                        <?php endif; ?>

                                        <div id="product" class="product-option">
                                            <div class="form-group">
                                                <div class="quantity-addcart">
                                                    <form id="add-to-cart-form" method="POST" onsubmit="return captureAttributes()">
                                                        <input type="hidden" name="product_id" value="<?= $p_id; ?>">
                                                        <input type="hidden" name="product_name" value="<?= $p_name; ?>">
                                                        <input type="hidden" name="product_model" value="<?= $p_code; ?>">
                                                        <input type="hidden" name="product_image" value="<?= $p_featured_photo; ?>">
                                                        <input type="hidden" name="product_price" value="<?= $p_current_price ?>">
                                                        <input type="hidden" name="product_size_id" id="selected_size" value="">
                                                        <input type="hidden" name="product_color_id" id="selected_color" value="">
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button type="submit" id="button-cart" data-loading-text="Loading..." class="btn btn-primary btn-lg btn-block add-cart" name="cart">
                                                            <i class="icon-bag"></i><span>Add To Cart</span>
                                                        </button>
                                                    </form>
                                                    <script>
                                                        $('#add-to-cart-form').on('submit', function(e) {
                                                            e.preventDefault();

                                                            $.ajax({
                                                                type: 'POST',
                                                                url: 'add-to-cart.php',
                                                                data: $(this).serialize(),
                                                                dataType: 'json',
                                                                success: function(response) {
                                                                    if (response.status === 'success') {
                                                                        alert(response.message);

                                                                        // Update the cart count live
                                                                        if (response.cart_count !== undefined) {
                                                                            $('.cart-count').text(response.cart_count);
                                                                        }
                                                                    } else {
                                                                        alert(response.message);
                                                                    }
                                                                },
                                                                error: function() {
                                                                    alert('An error occurred. Please try again.');
                                                                }
                                                            });
                                                        });
                                                    </script>

                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <span><?= $p_short_description; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="tabs_1" class="propage-tab top-margin-all">
                        <ul class="nav nav-tabs" id="myTab" role="tablist" style="padding-bottom: 60px;">
                            <li class="nav-item" role="presentation">
                                <a href="#latest" class="nav-link active hscp-hover" id="latest-tab" data-bs-toggle="tab" data-bs-target="#latest" role="tab" aria-controls="latest" aria-selected="true"><span>Description </span></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#contact" class="nav-link hscp-hover" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" role="tab" aria-controls="contact" aria-selected="false"><span>Contact</span></a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content my-baby-pink" id="myTabContent" style=" padding: 30px 30px; border-radius: 20px">
                        <div class="tab-pane fade show active" id="latest" role="tabpanel" aria-labelledby="latest-tab">
                            <div class="tab-pane ">
                                <span><?= $p_description; ?></span>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <form class="form-horizontal my-baby-pink" id="form-review">
                                <h2 style="text-align: center;">Have a question? Always Happy to
                                    help :
                                    <br>
                                    <span style="font-size: 14px; text-align: center;">Mon-Friday - 11 AM TO 6.30 PM
                                        (IST)</span>
                                </h2>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="col-lg-12" style="margin-top: 20px;">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 contact-left">
                                                    <div class="panel panel-default" style="border-radius: 20px;">
                                                        <div class="panel-body my-baby-pink">
                                                            <div class="store-address">
                                                                <i class="fa-brands fa-whatsapp"></i>
                                                                <div class="store-title">Whatsapp Us</div>
                                                                <div class="store-detail">
                                                                    <a href="https://wa.me/+91<?= $phone_no_1; ?>">+91-<?= $phone_no_1; ?></a>
                                                                </div>
                                                                <a href="https://wa.me/+91<?= $phone_no_1; ?>" target="_blank" class="btn btn-info"><i class="fa-brands fa-whatsapp"></i> Click
                                                                    Here</a>
                                                            </div>
                                                            <div class="store-telephone">
                                                                <i class="fa fa-phone"></i>
                                                                <div class="store-title">Call Us</div>
                                                                <div class="store-detail">
                                                                    <a href="tel:+91<?= $phone_no_2; ?>">+91-<?= $phone_no_2; ?></a>
                                                                </div>
                                                            </div>
                                                            <div class="store-open">
                                                                <i class="fa-regular fa-envelope"></i>
                                                                <div class="store-title">Email</div>
                                                                <div class="store-detail"> <a href="mailto:<?= $email; ?>"><?= $email; ?></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php include('include/footer.php'); ?>
    <!-- .footer -->

    <script>
        function captureAttributes() {
            // Get the selected size
            const selectedSize = document.querySelector('input[name="size_id"]:checked');
            if (selectedSize) {
                document.getElementById('selected_size').value = selectedSize.value;
            } else {
                document.getElementById('selected_size').value = ''; // Set to empty if not selected
            }

            // Get the selected color
            const selectedColor = document.querySelector('input[name="color_id"]:checked');
            if (selectedColor) {
                document.getElementById('selected_color').value = selectedColor.value;
            } else {
                document.getElementById('selected_color').value = ''; // Set to empty if not selected
            }

            return true; // Always allow form submission
        }
    </script>


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


    <!-- IMAGE ZOOM JS  -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const container = document.getElementById("img-1");
            const mainImage = document.getElementById("prozoom");
            let zoomSrc = mainImage.getAttribute("data-zoom-image") || mainImage.src;

            // Create zoom overlay
            const overlay = document.createElement("div");
            overlay.classList.add("zoom-overlay");
            overlay.style.backgroundImage = `url('${zoomSrc}')`;
            container.appendChild(overlay);

            // Zoom behavior
            container.addEventListener("mouseenter", () => {
                overlay.style.display = "block";
                mainImage.style.opacity = 0;
            });

            container.addEventListener("mouseleave", () => {
                overlay.style.display = "none";
                mainImage.style.opacity = 1;
            });

            container.addEventListener("mousemove", function(e) {
                const rect = container.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;
                overlay.style.backgroundPosition = `${x}% ${y}%`;
            });

            // Handle thumbnail clicks
            document.querySelectorAll('.elevatezoom-gallery').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const newImage = this.getAttribute('data-image');
                    const newZoom = this.getAttribute('data-zoom-image');

                    mainImage.src = newImage;
                    mainImage.setAttribute('data-zoom-image', newZoom);
                    overlay.style.backgroundImage = `url('${newZoom}')`;
                });
            });
        });
    </script>
</body>

</html>