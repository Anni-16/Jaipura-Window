<?php
session_start();
include('./admin/inc/config.php');
include('./admin/inc/functions.php');


$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error_message = "Email and password are required.";
    } else {
        // Get the user by email
        $stmt = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($user['cust_status'] == 0) {
                $error_message = "Your account is inactive. Please contact support.";
            } else {
                // Plain-text password match (NOT secure)
                if ($password === $user['password']) {
                    // Set session
                    $_SESSION['customer_id'] = $user['id']; // or use 'user_id' if that's the primary key
                    $_SESSION['customer_name'] = $user['cust_name'];
                    $_SESSION['customer_email'] = $user['cust_email'];

                    header("Location: dashboard.php");
                    exit;
                } else {
                    $error_message = "Incorrect password.";
                }
            }
        } else {
            $error_message = "No account found with this email.";
        }
    }
}
?>


<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Welcome To Jaipur Window - Login Page| Jaipur Window</title>
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

<body class="accountpage" style="background-image: url(./assets/images/banners/banner-main.jpeg); background-repeat: no-repeat; width: 100%; height: auto;  background-attachment: fixed; background-position: center; overflow-x: hidden !important">
</body>
<!-- HEADER -->
<?php include('include/header.php'); ?>
<!-- .HEADER -->

<!-- My Account -->
<section>
    <div class="breadcrumb-main">
        <div class="container">
            <div class="breadcrumb-container">
                <h2 class="page-title">Login </h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">
                            Login </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<div class="blog-section">
    <div class="container">
        <div class="row">
            <div id="content" class="col-sm-12  all-blog my-account">
                <div class="row">
                    <div class="col-md-6">
                        <div class="well" style="border-radius: 20px; padding: 20px 30px; background: #fcd9ec">
                            <h2>New customer</h2>
                            <p><strong>Register account</strong></p>
                            <p>By creating an account you will be able to shop faster, be up to date on an order's
                                status, and keep track of the orders you have previously made.</p>
                            <a href="register.php" class="btn btn-primary">Continue</a>
                        </div>
                    </div>

                    <!-- login Info -->
                    <div class="col-md-6">
                        <div class="well" style="border-radius: 20px; padding: 20px 30px; background: #fcd9ec">
                            <h2>Returning Customer</h2>
                            <p><strong>I am a returning customer</strong></p>

                            <!-- Display Error Message -->
                            <?php if (!empty($error_message)): ?>
                                <div class="alert alert-danger"><?php echo $error_message; ?></div>
                            <?php endif; ?>

                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="input-email">E-Mail Address</label>
                                    <input type="text" name="email" placeholder="E-Mail Address"
                                        id="input-email" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="input-password">Password</label>
                                    <input type="password" name="password" placeholder="Password"
                                        id="input-password" class="form-control" required>
                                    <a href="forgot-password.php">Forgot Password?</a>
                                </div>

                                <input type="submit" name="login" value="Login" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                    <!-- Login Info -->

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

</body>

</html>