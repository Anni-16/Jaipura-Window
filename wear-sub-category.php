<?php
include('./admin/inc/config.php');
include('./admin/inc/functions.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0;

if (isset($_GET['mcat_id'])) {
    $url = $_GET['mcat_id'];

    // Fetch the main category details
    $statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE mcat_id = ? AND status = 1");
    $statement->execute([$url]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        // Redirect if category not found
        header('location: wear.php');
        exit;
    }

    $mcat_id = $row['mcat_id'];
    $mcat_name = $row['mcat_name'];
} else {
    header('location: wear.php');
    exit;
}


// Fetch the top category details related to the mid-category
$statement = $pdo->prepare("
    SELECT t1.*, t2.tcat_name 
    FROM tbl_mid_category t1 
    JOIN tbl_top_category t2 ON t1.tcat_id = t2.tcat_id 
    WHERE t1.mcat_id = ? 
    ORDER BY t1.mcat_id DESC
");
$statement->execute([$mcat_id]);
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($categories as $category) {
    $tcat_name = $category['tcat_name'];
    $tcat_id = $category['tcat_id'];
    // Process your data here
}


?>

<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Welcome To Jaipur Window - Wear Sub Categories | Jaipur Window</title>
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
    <link rel="stylesheet" href="assets/css/product-filter.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                    <h2 class="page-title"><?= $mcat_name; ?></h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#"> Wear </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#"> <?= $tcat_name; ?> </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#"> <?= $mcat_name; ?> </a>
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

                <div id="content" class="col-sm-9  all-blog my-baby-pink" style="  padding: 20px 40px;">
                    <div class="category-refine">
                        <h1><strong>All Wear Sub Categories</strong></h1>
                    </div>
                    <br>
                    <?php include('short-by-2.php'); ?>

                    <div id="items-container">
                        <?php
                        // Fetch subcategories under the selected main category
                        $statement = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id = ? AND `show` = 1");
                        $statement->execute([$mcat_id]);
                        $subcategories = $statement->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($subcategories)) {
                            foreach ($subcategories as $subcategory) { ?>
                                <div class="item">
                                    <div class="product-layout   col-xs-12  ">
                                        <div class="food-cart-box" data-product-id="1">
                                            <div class="food-box">
                                                <div class="product-thumb">
                                                    <div class="image">
                                                        <a href="wear-end-category.php?ecat_id=<?= $subcategory['ecat_id']; ?>" class="thumb-image">
                                                            <?php if (!empty($subcategory['ecat_image']) && file_exists('./admin/uploads/wear/endcategory/' . $subcategory['ecat_image'])) : ?>
                                                                <img src="./admin/uploads/wear/endcategory/<?= ($subcategory['ecat_image']); ?>" alt="<?= ($subcategory['ecat_name']); ?>" title="<?= ($subcategory['ecat_name']); ?>" class="food-img" style="width:100%; height:auto; object-fit: cover;">
                                                            <?php else : ?>
                                                                <img src="assets/jaipur-new-logo.png" alt="<?= ($subcategory['ecat_name']); ?>" title="<?= ($subcategory['ecat_name']); ?>" class="food-img" style="width:100%; height:auto; object-fit: cover;">
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
                                                            <h4 class="product-title"><a class="food-title2" href="wear-end-category.php?ecat_id=<?= $subcategory['ecat_id']; ?>"><?= $subcategory['ecat_name']; ?></a></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                        } else {
                            echo "<p>No End Category available.</p>";
                        }
                        ?>
                    </div>
                </div>
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

    <script>
        let currentView = 'grid'; // Default view
        let allItems = [];

        window.onload = () => {
            const container = document.getElementById('items-container');
            allItems = Array.from(container.children); // Save original items
            updateFilter(); // Initial render
            bindViewButtons(); // Attach view toggle
        };

        function updateFilter() {
            const sortValue = document.getElementById('input-sort').value;
            const limitValue = parseInt(document.getElementById('input-limit').value);
            const container = document.getElementById('items-container');

            let filteredItems = [...allItems];

            // Sort using visible text (not data attributes)
            filteredItems.sort((a, b) => {
                const nameA = a.querySelector('.food-title')?.textContent.trim().toLowerCase() || '';
                const nameB = b.querySelector('.food-title')?.textContent.trim().toLowerCase() || '';
                const priceA = parseFloat(a.querySelector('.food-price')?.textContent.replace(/[^\d.]/g, '')) || 0;
                const priceB = parseFloat(b.querySelector('.food-price')?.textContent.replace(/[^\d.]/g, '')) || 0;

                switch (sortValue) {
                    case 'name-asc':
                        return nameA.localeCompare(nameB);
                    case 'name-desc':
                        return nameB.localeCompare(nameA);
                    case 'price-asc':
                        return priceA - priceB;
                    case 'price-desc':
                        return priceB - priceA;
                    default:
                        return 0;
                }
            });

            // Limit number of results
            filteredItems = filteredItems.slice(0, limitValue);

            // Clear and re-append
            container.innerHTML = '';
            filteredItems.forEach(item => container.appendChild(item));

            applyCurrentView(); // Reapply list/grid layout
        }

        function bindViewButtons() {
            document.getElementById('grid-view').addEventListener('click', () => switchView('grid'));
            document.getElementById('list-view').addEventListener('click', () => switchView('list'));
        }

        function switchView(view) {
            currentView = view;
            document.getElementById('grid-view').classList.toggle('active', view === 'grid');
            document.getElementById('list-view').classList.toggle('active', view === 'list');
            applyCurrentView(); // Refresh view
        }

        function applyCurrentView() {
            const items = document.querySelectorAll('#items-container .item');
            const isList = currentView === 'list';

            items.forEach(item => {
                item.classList.remove('product-grid', 'product-list');
                item.classList.add(isList ? 'product-list' : 'product-grid');

                const desc = item.querySelector('.description');
                if (desc) desc.style.display = isList ? 'block' : 'none';

                // Optional: align text/image for list view
                const foodBox = item.querySelector('.food-box');
                if (foodBox) {
                    foodBox.style.display = isList ? 'flex' : 'block';
                    foodBox.style.flexDirection = isList ? 'row' : 'column';
                    foodBox.style.alignItems = isList ? 'flex-start' : 'center';
                }

                const image = item.querySelector('.product-thumb');
                const descBlock = item.querySelector('.product-description');

                if (image && descBlock && isList) {
                    image.style.width = '30%';
                    descBlock.style.width = '70%';
                    descBlock.style.paddingLeft = '15px';
                } else if (image && descBlock) {
                    image.style.width = '';
                    descBlock.style.width = '';
                    descBlock.style.paddingLeft = '';
                }
            });
        }
    </script>


</body>

</html>