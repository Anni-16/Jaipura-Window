<style>
    ul.vipodha_megamenu li .sub-menu .content .static-menu>.menu>ul>li {
        padding-top: 0px !important;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
        /* Optional: Removes top gap */
    }

    .dropdown-toggle::after {
        display: none;
        /* Optional: hides default caret */
    }


    #login-mobile-show {
        display: none !important;
    }
    
    
    /*  */
    @media screen and (max-width:480px) {
        
        #top-header-numbers{
            flex-direction:column;
        }
        
        #login-mobile-show {
            display: inline-block !important;
        }

        .login-mobile-hide {
            display: none !important;
        }
        
         #my-padding-all{
            height:40px;
            color:#a01c8c;
         }
         
    }
    
    @media screen and (max-width:320px){
        #top-footer-column{
            flex-direction:column;  
        }
    }
</style>
<nav id="top"  >
    <div class="container" id="top-header-numbers">
        <div class="top-left">
            <div class="website-data">
            </div>
            <div class="contact-info">
                <a style="color: white">
                    "Unveil the timeless elegance of indian handicrafts at JW - where artistry blooms!"</a>
            </div>
        </div>
        <div class="top-right">
            <div class="pull-left" style="display: flex; justify-content: center; align-items: center; gap:0 5px;" id="top-footer-column">
               <a class="" href="tel:+91 8005948153 ">
                    <i class="fa fa-phone" style="color: white ;"></i>
                <span class="" style="color: white">&nbsp; +91 - 8005948153 </span> 
               </a>
                 <a class="" href="tel: +91 9492932623 ">
                    <i class="fa fa-phone" style="color: white ;"></i>
              <span class="" style="color: white">&nbsp;  +91 - 9492932623</span>
               </a>
               
            </div>
        </div>
        
       
        
    </div>
     <div id"my-padding-all " style="color:#a01c8c;">df</div>
</nav>
<header>
    <div class="container">
        <div class="header-inner">
            <div class="header-left">
                <div id="logo">
                    <a href="index.php">
                        <img src="assets/jaipur-new-logo.png" title="Your Store" alt="Jaipur-Window" class="">
                    </a>
                </div>

            </div>
            <div class="header-center">
                <div class="vipodha_megamenu-style-dev">
                    <div class="responsive vipodha_default">
                        <nav class="navbar-default">
                            <div class=" container-vipodha_megamenu   horizontal ">
                                <div class="navbar-header">
                                    <button type="button" id="show-vipodha_megamenu" data-toggle="collapse" class="navbar-toggle">
                                        <span class="icon-bar" style="color: black; color: black;"></span>
                                        <span class="icon-bar" style="color: black; color: black;"></span>
                                        <span class="icon-bar" style="color: black; color: black;"></span>
                                    </button>
                                </div>
                                <div class="vipodha_megamenu-wrapper megamenu_typeheader">
                                    <span id="remove-vipodha_megamenu" class="fa fa-times"></span>
                                    <div class="vipodha_megamenu-pattern">
                                        <div class="container">
                                            <ul class="vipodha_megamenu" data-megamenuid="55" data-transition="slide" data-animationtime="500">



                                                <li class="home current-active active-first">
                                                    <a href="index.php">
                                                        <span><strong> Home </strong></span>
                                                    </a>
                                                </li>
                                                <li class="home">
                                                    <a href="about.php">
                                                        <span><strong> About </strong></span>
                                                    </a>
                                                </li>
                                                <li class="with-sub-menu click">
                                                    <p class="close-menu"></p>
                                                    <a class="clearfix" style="cursor: pointer;">
                                                        <strong>
                                                            To wear
                                                        </strong>
                                                        <b class="fa fa-angle-down"></b>
                                                    </a>
                                                    <div class="sub-menu" id="my-menu">
                                                        <div class="content">
                                                            <div class="row">
                                                                <div class="col-lg-6" style="border-right: 1px solid #a01c8c; margin: 0;">
                                                                    <div class="categories hot">
                                                                        <div class="col-lg-12 static-menu">
                                                                            <div class="row">
                                                                                <div class="col-lg-12">
                                                                                    <h2 href="#" class="main-menu" style="font-size: 20px; color: #a01c8c; text-align: center; ">
                                                                                        Women:</h2>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <?php $i = 0;
                                                                                    $statement = $pdo->prepare("SELECT *  FROM tbl_mid_category WHERE tcat_id = 2 AND status = 1 ORDER BY mcat_id DESC");
                                                                                    $statement->execute();
                                                                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                                                    foreach ($result as $row1) {
                                                                                        $i++;
                                                                                    ?>
                                                                                        <div class="col-lg-6">
                                                                                            <div class="menu">
                                                                                                <ul>
                                                                                                    <li>
                                                                                                        <a href="wear-sub-category.php?mcat_id=<?= $row1['mcat_id']; ?>" class="main-menu"><strong><?= $row1['mcat_name']; ?></strong></a>
                                                                                                        <ul style="list-style: square;">
                                                                                                            <?php $i = 0;
                                                                                                            $statement = $pdo->prepare("SELECT *  FROM tbl_end_category WHERE mcat_id=? AND `show` = 1 ORDER BY ecat_id DESC LIMIT 4");
                                                                                                            $statement->execute([$row1['mcat_id']]);
                                                                                                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                                                                            foreach ($result as $row) {
                                                                                                                $i++;
                                                                                                            ?>
                                                                                                                <li><a href="wear-end-category.php?ecat_id=<?= $row['ecat_id']; ?>"><?= $row['ecat_name']; ?></a>
                                                                                                                </li>
                                                                                                            <?php
                                                                                                            } ?>
                                                                                                            <li class="current-active active-first" style="list-style: none; ">
                                                                                                                <a href="wear-sub-category.php?mcat_id=<?= $row1['mcat_id']; ?>" style="color: #a01c8c;">View
                                                                                                                    More</a>
                                                                                                            </li>
                                                                                                        </ul>
                                                                                                    </li>
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php } ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6" style="border-right: 1px solid #a01c8c; margin: 0;">
                                                                    <div class="categories hot">
                                                                        <div class="col-lg-12 static-menu">
                                                                            <div class="row">
                                                                                <div class="col-lg-12">
                                                                                    <h2 href="#" class="main-menu" style="font-size: 20px; color: #a01c8c; text-align: center; ">
                                                                                        Men:</h2>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <?php $i = 0;
                                                                                    $statement = $pdo->prepare("SELECT *  FROM tbl_mid_category WHERE tcat_id = 1 AND status = 1 ORDER BY mcat_id DESC");
                                                                                    $statement->execute();
                                                                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                                                    foreach ($result as $row1) {
                                                                                        $i++;
                                                                                    ?>
                                                                                        <div class="col-lg-6">
                                                                                            <div class="menu">
                                                                                                <ul>
                                                                                                    <li>
                                                                                                        <a href="wear-sub-category.php?mcat_id=<?= $row1['mcat_id']; ?>" class="main-menu"><strong><?= $row1['mcat_name']; ?></strong></a>
                                                                                                        <ul style="list-style: square;">
                                                                                                            <?php $i = 0;
                                                                                                            $statement = $pdo->prepare("SELECT *  FROM tbl_end_category WHERE mcat_id=? AND `show` = 1 ORDER BY ecat_id DESC LIMIT 4");
                                                                                                            $statement->execute([$row1['mcat_id']]);
                                                                                                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                                                                            foreach ($result as $row) {
                                                                                                                $i++;
                                                                                                            ?>
                                                                                                                <li><a href="wear-sub-category.php?mcat_id=<?= $row['mcat_id']; ?>"><?= $row['ecat_name']; ?></a>
                                                                                                                </li>
                                                                                                            <?php
                                                                                                            } ?>
                                                                                                            <li class="current-active active-first" style="list-style: none; ">
                                                                                                                <a href="wear-sub-category.php?mcat_id=<?= $row1['mcat_id']; ?>" style="color: #a01c8c;">View
                                                                                                                    More</a>
                                                                                                            </li>
                                                                                                        </ul>
                                                                                                    </li>
                                                                                                </ul>
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
                                                    </div>
                                                </li>
                                                <li class="with-sub-menu click">
                                                    <p class="close-menu"></p>
                                                    <a class="clearfix" style="cursor: pointer;">
                                                        <strong>
                                                            To decorate
                                                        </strong>
                                                        <b class="fa fa-angle-down"></b>
                                                    </a>
                                                    <div class="sub-menu">
                                                        <div class="content">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="categories hot">
                                                                        <div class="row">
                                                                            <div class="col-sm-12 static-menu">
                                                                                <div class="menu">
                                                                                    <ul id="my-menu-cat">
                                                                                        <?php
                                                                                        $statement = $pdo->prepare("SELECT * FROM tbl_decorate_category WHERE status = 1 ORDER BY cat_id DESC");
                                                                                        $statement->execute();
                                                                                        $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

                                                                                        foreach ($categories as $category) { ?>
                                                                                            <li>
                                                                                                <a href="decorate-category.php?cat_id=<?= $category['cat_id']; ?>" class="main-menu">
                                                                                                    <strong><?= $category['cat_name']; ?></strong>
                                                                                                </a>
                                                                                                <ul style="list-style: square;">
                                                                                                    <?php
                                                                                                    $statement = $pdo->prepare("SELECT * FROM tbl_decorate_sub_category WHERE cat_id=? AND show_status = 1 ORDER BY sub_cat_id DESC LIMIT 4");
                                                                                                    $statement->execute([$category['cat_id']]);
                                                                                                    $sub_categories = $statement->fetchAll(PDO::FETCH_ASSOC);

                                                                                                    foreach ($sub_categories as $sub_category) { ?>
                                                                                                        <li>
                                                                                                            <a href="decorate-filter.php?sub_cat_id=<?= $sub_category['sub_cat_id']; ?>">
                                                                                                                <?= $sub_category['sub_cat_name']; ?>
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    <?php } ?>

                                                                                                    <li class="current-active active-first" style="list-style: none;">
                                                                                                        <a href="decorate-category.php?cat_id=<?= $category['cat_id']; ?>" style="color: #a01c8c;">View
                                                                                                            More</a>
                                                                                                    </li>
                                                                                                </ul>
                                                                                            </li>
                                                                                        <?php } ?>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="with-sub-menu click">
                                                    <p class="close-menu"></p>
                                                    <a class="clearfix" style="cursor: pointer;">
                                                        <strong>
                                                            Accessories
                                                        </strong>
                                                        <b class="fa fa-angle-down"></b>
                                                    </a>
                                                    <div class="sub-menu">
                                                        <div class="content">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="categories hot">
                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                                <div class="row">
                                                                                    <div class="col-sm-12 static-menu">
                                                                                        <div class="menu">
                                                                                            <ul>
                                                                                                <li>
                                                                                                    <ul style="list-style: square;" id="my-menu-cat">
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
                                                                                                </li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="">
                                                    <p class="close-menu"></p>
                                                    <a href="blog.php" class="clearfix">
                                                        <strong>
                                                            Blog
                                                        </strong>
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <p class="close-menu"></p>
                                                    <a href="contact.php" class="clearfix">
                                                        <strong>
                                                            Contact
                                                        </strong>
                                                    </a>
                                                </li>

                                                <li id="login-mobile-show">
                                                    <div id="header_ac">
                                                        <!-- User Account Dropdown -->
                                                        <div class="dropdown">
                                                            <?php if (isset($_SESSION['customer_id'])) : ?>
                                                                <!-- User is logged in -->
                                                                <a href="dashboard.php" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                                                                    <i class="icon-user dropdown-icon" style="color: black; font-size: 20px;"></i>
                                                                    <span class="ms-2">Account</span>
                                                                </a>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item" href="dashboard.php">My Account</a></li>
                                                                    <li>
                                                                        <hr class="dropdown-divider">
                                                                    </li>
                                                                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                                                </ul>
                                                            <?php else : ?>
                                                                <!-- User is not logged in -->
                                                                <a href="#" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                                                                    <i class="icon-user dropdown-icon" style="color: black; font-size: 20px;"></i>
                                                                    <span class="ms-2">Login</span>
                                                                </a>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item" href="login.php">Login</a></li>
                                                                    <li><a class="dropdown-item" href="register.php">Register</a></li>
                                                                </ul>
                                                            <?php endif; ?>
                                                        </div>

                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <div class="search-content">
                    <div class="search-btn-outer">
                        <i class="icon-search" style="color:black;"></i>
                    </div>
                    <div class="header-search">
                        <form method="GET" action="search.php">
                            <div id="vipodhaSearch" class="input-group vipodha-search">
                                <input type="text" id="autocomplete" name="query" value="" placeholder="Search..." class="form-control input-lg" />
                                <span class="btn-search input-group-btn">
                                    <button type="submit" class="btn btn-default btn-lg"><i class="search-icon icon-search" style="color:black;"></i></button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="header_ac" class="login-mobile-hide">
                    <!-- User Account Dropdown -->
                    <div class="dropdown">
                        <?php if (isset($_SESSION['customer_id'])) : ?>
                            <!-- User is logged in -->
                            <a href="dashboard.php" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                                <i class="icon-user dropdown-icon" style="color: black; font-size: 20px;"></i>
                                <span class="ms-2">Account</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="dashboard.php">My Account</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        <?php else : ?>
                            <!-- User is not logged in -->
                            <a href="#" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                                <i class="icon-user dropdown-icon" style="color: black; font-size: 20px;"></i>
                                <span class="ms-2">Login</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="login.php">Login</a></li>
                                <li><a class="dropdown-item" href="register.php">Register</a></li>
                            </ul>
                        <?php endif; ?>
                    </div>

                </div>

                <?php
                include('./admin/inc/config.php');
               
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }


                // Get total item count
                $stmt_count = $pdo->prepare("SELECT SUM(quantity) AS total_items FROM tbl_cart WHERE user_id = :user_id");
                $stmt_count->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt_count->execute();
                $count_result = $stmt_count->fetch(PDO::FETCH_ASSOC);
                $total_items = $count_result['total_items'] ?? 0;
                ?>

                <div id="cart-my">
                    <div class="nav">
                        <div class="box">
                            <div class="cart-count"><?= $total_items; ?></div> <!-- This will update live after add to cart -->
                            <a href="#">
                                <ion-icon name="cart" id="cart-icon" style="color: black; margin-top: -5px;"></ion-icon>
                            </a>
                        </div>
                    </div>
                </div>


                    <style>
                        .cart-item {
                            padding: 10px 0;
                            border-bottom: 1px solid #ccc;
                        }

                        .cart-item img {
                            width: 120px;
                        }

                        .cart-item .btn-remove {
                            padding: 4px 10px;
                            color: #e5289c;
                            margin-left: 10px;
                            border: 0;
                            background-color: #fff;
                            box-shadow: rgba(99, 99, 99, 0.1) 0px 2px 4px 0px;
                            border-radius: 10px;
                        }

                        .btn-update {
                            background-color: #e5289c;
                            color: #fff;
                            padding: 10px 20px;
                            border-radius: 10px;
                            border: 0;
                        }

                        .total .total-price {
                            color: #e5289c;
                        }

                        .btn-buy {
                            background: #e5289c;
                            color: #fff;
                            outline: none;
                            border: none;
                            border-radius: 100px;
                            padding: 15px 30px;
                            line-height: 20px;
                            font-size: 16px;
                            font-weight: 400;
                        }
                    </style>

                    <div class="cart">
                        <div class="cart-title">Cart Items</div>
                        <div class="cart-content">
                            <?php
                            // Query to display cart items
                            $stmt_items = $pdo->prepare("SELECT * FROM tbl_cart WHERE user_id = :user_id");
                            $stmt_items->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                            $stmt_items->execute();
                            $cart_items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);

                            $total_price = 0;

                            if ($cart_items) {
                                foreach ($cart_items as $item) {
                                    // Default image path
                                    $image_path = 'assets/images/default-product.jpg';

                                    // Check for product image
                                    if (!empty($item['product_image'])) {
                                        $image_accessories = "admin/uploads/accessroies/{$item['product_image']}";
                                        $image_wear = "admin/uploads/wear/{$item['product_image']}";
                                        $image_decorate = "admin/uploads/decorate/{$item['product_image']}";

                                        if (file_exists($image_accessories)) {
                                            $image_path = $image_accessories;
                                        } elseif (file_exists($image_wear)) {
                                            $image_path = $image_wear;
                                        } elseif (file_exists($image_decorate)) {
                                            $image_path = $image_decorate;
                                        }
                                    }

                                    $subtotal = $item['product_price'] * $item['quantity'];
                                    $total_price += $subtotal; // <-- ADD subtotal into total price
                            ?>
                                    <div class="cart-item" data-cart-id="<?= $item['id']; ?>">
                                        <div class="item-details" style="display: flex; gap: 15px;">
                                            <img src="<?= $image_path; ?>" alt="<?= $item['product_name']; ?>">
                                            <div class="product-info">
                                                <span class="product-name"><?= $item['product_name']; ?> (x<span class="quantity"><?= $item['quantity']; ?></span>)</span>
                                                <br>
                                                <span class="item-subtotal" style="font-weight: bold;">Rs.<?= number_format($subtotal, 2); ?></span>

                                                <div style="display: flex; margin-top: 5px;">
                                                    <form class="update-cart-form" style="display: flex; align-items: center;">
                                                        <input type="hidden" name="cart_id" value="<?= $item['id']; ?>"> <!-- hidden input for cart id -->
                                                        <input type="number" name="quantity" value="<?= $item['quantity']; ?>" min="1" style="width: 50px; padding: 5px; margin-right: 10px; text-align: center;">
                                                        <button type="submit" class="btn-update">Update</button>
                                                    </form>

                                                    <button class="btn-remove" data-cart-id="<?= $item['id']; ?>" style="margin-left: 10px;">
                                                        <div class="fa fa-trash"></div>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            } else {
                                echo "<p>Your cart is empty.</p>";
                            }
                            ?>
                        </div>

                        <div class="total">
                            <div class="total-title">Total
                                <span class="total-price h4">Rs.<span id="total-price"><?= number_format($total_price, 2); ?></span></span>
                            </div>
                        </div>

                        <div style="display: flex; justify-content: flex-start; gap: 0 10px; margin-top:20px;">
                            <a href="checkout.php">
                                <button class="btn-buy">Checkout</button>
                            </a>
                            <a href="cart.php">
                                <button class="btn-buy">View Cart</button>
                            </a>
                        </div>
                        <ion-icon name="close" id="cart-close"></ion-icon>
                        </div>

                    <script>
                        // Create a function to show success message
                        function showMessage(message, type = 'success') {
                        let msgBox = document.createElement('div');
                        msgBox.textContent = message;
                        msgBox.style.position = 'fixed';
                        msgBox.style.top = '20px';
                        msgBox.style.right = '20px';
                        msgBox.style.padding = '10px 20px';
                        msgBox.style.backgroundColor = (type === 'success') ? '#4CAF50' : '#f44336';
                        msgBox.style.color = '#fff';
                        msgBox.style.borderRadius = '5px';
                        msgBox.style.boxShadow = '0 2px 5px rgba(0,0,0,0.3)';
                        msgBox.style.zIndex = 1000;
                        document.body.appendChild(msgBox);

                        // Auto remove after 2 seconds
                        setTimeout(() => {
                            msgBox.remove();
                        }, 2000);
                    }

                    // Update quantity
                    document.querySelectorAll('.update-cart-form').forEach(function(form) {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();

                            const cartId = form.querySelector('input[name="cart_id"]').value;
                            const quantity = form.querySelector('input[name="quantity"]').value;

                            const xhr = new XMLHttpRequest();
                            xhr.open('POST', 'update_cart.php', true);
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                            xhr.onload = function() {
                                if (xhr.status === 200) {
                                    const response = JSON.parse(xhr.responseText);

                                    if (response.success) {
                                        const cartItem = document.querySelector(`.cart-item[data-cart-id="${cartId}"]`);
                                        cartItem.querySelector('.quantity').textContent = quantity;
                                        cartItem.querySelector('.item-subtotal').textContent = "Rs." + parseFloat(response.item_total).toFixed(2);

                                        document.getElementById('total-price').textContent = parseFloat(response.total_price).toFixed(2);

                                        // ✅ Show success message
                                        showMessage('Quantity updated successfully!');
                                    } else {
                                        showMessage('Error: ' + response.message, 'error');
                                    }
                                } else {
                                    showMessage('Error connecting to server!', 'error');
                                }
                            };

                            xhr.send(`cart_id=${cartId}&quantity=${quantity}`);
                        });
                    });

                        // Remove item
                        document.querySelectorAll('.btn-remove').forEach(function(button) {
                            button.addEventListener('click', function() {
                                const cartId = button.getAttribute('data-cart-id');

                                const xhr = new XMLHttpRequest();
                                xhr.open('POST', 'remove_cart_item.php', true);
                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                                xhr.onload = function() {
                                    if (xhr.status === 200) {
                                        location.reload();
                                    } else {
                                        alert('Error removing item from cart!');
                                    }
                                };

                                xhr.send(`cart_id=${cartId}`);
                            });
                        });
                    </script>

                </div>



            </div>
        </div>
    </div>
</header>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery UI for autocomplete -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
    $(function() {
        $("#autocomplete").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "search.php",
                    method: "GET",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                // Redirect to selected item's URL
                if (ui.item && ui.item.url) {
                    window.location.href = ui.item.url;
                }
            }
        });
    });
</script>
