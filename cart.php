<?php
include('./admin/inc/config.php');
include('./admin/inc/functions.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user_id = $_SESSION['customer_id'];

// Check if user is logged in
if (!isset($_SESSION['customer_id'])) {
    echo "<script>
        alert('Please log in to view your cart.');
        window.location.href = 'login.php'; 
    </script>";
    exit;
}


$user_id = $_SESSION['customer_id'];

// Fetch shipping policy
$statement = $pdo->prepare("SELECT * FROM tbl_shipping_policy WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $heading = $row['heading'];
    $content = $row['content'];
}

// Fetch cart items from the database
$cart_items = [];
$sub_total = 0;

$cartStatement = $pdo->prepare("SELECT * FROM tbl_cart WHERE user_id = ?");
$cartStatement->execute([$user_id]);
$cart_items = $cartStatement->fetchAll(PDO::FETCH_ASSOC);


// Handle update and remove cart actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        $key = $_POST['update'];
        $quantity = $_POST['quantity'][$key];

        // Update cart item quantity in the database
        $updateStmt = $pdo->prepare("UPDATE tbl_cart SET quantity = ? WHERE id = ?");
        $updateStmt->execute([$quantity, $key]);
    } elseif (isset($_POST['remove'])) {
        $key = $_POST['remove'];

        // Remove item from the cart in the database
        $removeStmt = $pdo->prepare("DELETE FROM tbl_cart WHERE id = ?");
        $removeStmt->execute([$key]);
    }
    header("Location: cart.php"); // Redirect after update/remove
    exit;
}
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Cart - Jaipur-Window</title>
    <meta name="description" content="Vipodha">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="assets/images/my-image/logo.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css" media="all" />
    <link rel="stylesheet" href="./assets/cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="assets/fonts/vipodha-font.css" type="text/css" media="all">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="assets/css/mycss.css" type="text/css" media="all" />
    <link rel="stylesheet" href="assets/css/common-page-style.css" type="text/css" media="all" />
    <link href="https://fonts.googleapis.com/css2?family=Chonburi&amp;display=swap&amp;family=Carattere&amp;display=swap&amp;family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/vipodha_megamenu.css">
    
    <link rel="stylesheet" href="assets/css/my-cart.css" type="text/css" media="all" />
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
</head>

<body class="cartpage"
      style="background-image: url(./assets/images/banners/banner-main.jpeg); background-repeat: no-repeat; width: 100%; height: auto; background-attachment: fixed; background-position: center; overflow-x: hidden !important">
<!-- HEADER -->
<?php include('include/header.php'); ?>

<!-- Shopping Cart Section -->
<section>
    <div class="breadcrumb-main">
        <div class="container">
            <div class="breadcrumb-container">
                <h2 class="page-title">Shopping Cart</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="cart.php">Shopping cart</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<div class="blog-section">
    <div id="checkout-cart" class="container">
        <div class="row" style="background-color: white; padding: 20px 30px; border-radius: 20px;">
            <div id="content" class="col-sm-12 all-blog">
                <form action="cart.php" method="post" enctype="multipart/form-data">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td class="text-center">Image</td>
                                    <td class="text-center">Product Name</td>
                                    <td class="text-center">Color</td> <!-- Added -->
                                    <td class="text-center">Size</td>  <!-- Added -->
                                    <td class="text-center">Model</td>
                                    <td class="text-center">Quantity</td>
                                    <td class="text-center">Unit Price</td>
                                    <td class="text-center">Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // Query to get cart items with color and size names from the respective tables
                                $stmt_items = $pdo->prepare("
                                    SELECT 
                                        cart.*, 
                                        color.color_name, 
                                        size.size_name 
                                    FROM tbl_cart cart
                                    LEFT JOIN tbl_color color ON cart.product_color = color.color_id
                                    LEFT JOIN tbl_size size ON cart.product_size = size.size_id
                                    WHERE cart.user_id = :user_id
                                ");
                                $stmt_items->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                                $stmt_items->execute();
                                $cart_items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);

                                if (empty($cart_items)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">Your cart is empty.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($cart_items as $item): ?>
                                        <?php 
                                            $total_price = $item['product_price'] * $item['quantity'];
                                            $sub_total += $total_price;
                                        ?>
                                        <tr>
                                            <td class="text-center">
                                                <a href="#">
                                                    <?php
                                                    $image_path = 'assets/images/default-product.jpg'; // default image
                                                    
                                                    // Check for product image and try to find it in various directories
                                                    if (!empty($item['product_image'])) {
                                                        $image_accessories = "admin/uploads/accessroies/{$item['product_image']}";
                                                        $image_wear = "admin/uploads/wear/{$item['product_image']}";
                                                        $image_decorate = "admin/uploads/decorate/{$item['product_image']}";
                                                        
                                                        // Check if the image exists in any of the directories
                                                        if (file_exists($image_accessories)) {
                                                            $image_path = $image_accessories;
                                                        } elseif (file_exists($image_wear)) {
                                                            $image_path = $image_wear;
                                                        } elseif (file_exists($image_decorate)) {
                                                            $image_path = $image_decorate;
                                                        }
                                                    }
                                                    ?>
                                                    <img src="<?= $image_path; ?>"
                                                        alt="<?= ($item['product_name']); ?>"
                                                        title="<?= ($item['product_name']); ?>"
                                                        class="img-thumbnail checkout-img">
                                                </a>
                                            </td>
                                            <td class="text-center"><a href="#"><?= ($item['product_name']); ?></a></td>

                                            <td class="text-center"><?= ($item['color_name']); ?></td> <!-- Color Name -->
                                            <td class="text-center"><?= ($item['size_name']); ?></td>  <!-- Size Name -->

                                            <td class="text-center"><?= ($item['product_model']); ?></td>
                                            <td class="text-center">
                                                <div class="input-group cart_quantity">
                                                    <input type="number" name="quantity[<?= $item['id']; ?>]" value="<?= $item['quantity']; ?>" min="1" max="99" class="form-control" style="width:80px;">
                                                    <button type="submit" name="update" value="<?= $item['id']; ?>" class="btn btn-primary" title="Update"><i class="fa-solid fa-rotate"></i></button>
                                                    <button type="submit" name="remove" value="<?= $item['id']; ?>" class="btn btn-danger" title="Remove"><i class="fa-solid fa-circle-xmark"></i></button>
                                                </div>
                                            </td>
                                            <td class="text-center">Rs <?= number_format($item['product_price'], 2); ?></td>
                                            <td class="text-center">Rs <?= number_format($total_price, 2); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                            <tfoot id="checkout-cart-foot">
                                <?php
                                    
                                    $grand_total = $sub_total ;
                                ?>
                               
                                <tr>
                                    <td colspan="7" class="text-end">Total:</td>
                                    <td class="text-end">Rs <?= number_format($grand_total, 2); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>

                <div class="row">
                    <div class="buttons clearfix">
                        <div class="pull-left"><a href="index.php" class="btn btn-default">Continue Shopping</a></div>
                        <div class="pull-right"><a href="checkout.php" class="btn btn-primary">Checkout</a></div>
                    </div>
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
