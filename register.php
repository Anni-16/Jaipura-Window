<?php
session_start();
include('./admin/inc/config.php');
include('./admin/inc/functions.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $cust_datetime = date('Y-m-d H:i:s');
    $active = '1';
    $user_id = 'USER-' . substr(str_shuffle("0123456789"), 0, 4);

    try {
        // Check if the email already exists
        $stmt = $pdo->prepare("SELECT cust_email FROM tbl_customer WHERE cust_email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['message'] = "Login Email Already Exists! Please Register with Another Email ID.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            // Uncomment to send emails

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->Username = 'jaipurwindow@gmail.com';
            $mail->Password = 'dvprgewwdegkarxr';

            // User email
            $mail->setFrom('jaipurwindow@gmail.com', 'Jaipur-Window');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Thank you for Registering with Jaipur Window';
            $mail->Body = "
            <html>
            <body>
                <p>Congratulations $name, your request for registration has been received. <b>Thank you for registering on Jaipur Window. You will be able to login once we approve your request.</b></p>
                <p>For questions, contact: jaipurwindow@gmail.com</p>
            </body>
            </html>";
            $mail->send();

            // Admin notification
            $mail->clearAddresses();
            $mail->addAddress('jaipurwindow@gmail.com');
            $mail->Subject = 'New User Registration';
            $mail->Body = "
            <html>
            <body>
                <p>New user registered:</p>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Phone:</strong> $phone</p>
                <p><strong>Address:</strong> $address</p>
                <p><a href='jaipurwindow.com/admin/login.php'>Activate Account</a></p>
            </body>
            </html>";
            $mail->send();


            // Insert user data into the database
            $stmt = $pdo->prepare("INSERT INTO tbl_customer (user_id, cust_name, cust_email, cust_phone, cust_address, password, cust_datetime, cust_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $name, $email, $phone, $address, $password, $cust_datetime, $active]);

            $_SESSION['messagess'] = "Congratulations $name, your registration is successful!";
            header("Location: login.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Mailer error: " . $mail->ErrorInfo;
    }
}
?>

<!-- Show Alerts Based on Session Messages -->
<script>
    <?php if (isset($_SESSION['message'])) : ?>
        alert('<?php echo $_SESSION['message']; ?>');
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['messagess'])) : ?>
        alert('<?php echo $_SESSION['messagess']; ?>');
        <?php unset($_SESSION['messagess']); ?>
    <?php endif; ?>
</script>

<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Welcome To Jaipur Window - Regsiter Page| Jaipur Window</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Chonburi&display=swap&family=Carattere&display=swap&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!--vipodha_megamenu css-->
    <link rel="stylesheet" href="assets/css/vipodha_megamenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .password-wrapper {
            position: relative;
        }

        .toggle-button {
            display: inline-flex;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: unset;
            right: 12px;
            cursor: pointer;
        }

        .eye-icon {
            width: 20px;
            height: 20px;
        }
    </style>
</head>

<body class="registerpage" style="background-image: url(./assets/images/banners/banner-main.jpeg); background-repeat: no-repeat; width: 100%; height: auto;  background-attachment: fixed; background-position: center; overflow-x: hidden !important">


    <!-- HEADER -->
    <?php include('include/header.php'); ?>
    <!-- .HEADER -->

    <!-- My Account -->
    <section>
        <div class="breadcrumb-main">
            <div class="container">
                <div class="breadcrumb-container">
                    <h2 class="page-title">Register account</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="login.php">
                                Login</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">
                                Register</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Regsiter Form -->
    <div class="register-section">
        <div class="container">
            <div class="row">
                <div id="content" class="col-sm-12  all-blog my-account" style="padding-left: 20px;">
                    <div class="row">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal well" style="border-radius: 20px; padding: 20px 30px; background: #fcd9ec;">
                            <h4>If you already have an account with us, please login at the
                                <span class="h5"> <a href="login.php">login</a></span> .
                            </h4>
                            <fieldset id="account">
                                <legend>Your personal details</legend>
                                <div class="form-group required row">
                                    <label class="col-sm-2 control-label" for="input-firstname">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" value="" placeholder=" Name" id="input-firstname" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group required row">
                                    <label class="col-sm-2 control-label" for="input-email">E-Mail</label>
                                    <div class="col-sm-10">
                                        <input type="email" name="email" value="" placeholder="E-Mail" id="input-email" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group required row">
                                    <label class="col-sm-2 control-label" for="input-phone">Phone No.</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="phone" value="" placeholder="Phone No." id="input-phone" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group required row">
                                    <label class="col-sm-2 control-label" for="input-phone">Address</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="address" value="" placeholder="Address" id="input-address" class="form-control" required>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset id="password">
                                <legend>Your password</legend>
                                <div class="form-group required row">
                                    <label class="col-sm-2 control-label" for="input-password">Password</label>
                                    <div class="col-sm-10 position-relative">
                                        <div class="password-wrapper" style="position: relative;">
                                            <input type="password" name="password" id="input-password" class="form-control" placeholder="Password" required />
                                            <button type="button" class="toggle-button" onclick="togglePassword()" style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                                                <svg xmlns="http://www.w3.org/2000/svg" id="eyeIcon" viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
                                                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                                    <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </fieldset>

                            <div class="buttons clearfix">
                                <div class="float-end text-right">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">I have read and agree to the <a href="privacy-policy.php" class="modal-link"><b>Privacy Policy</b></a></label> <input type="checkbox" name="agree" value="1" class="form-check-input" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Regsiter Form -->


    <!-- footer -->
    <?php include('include/footer.php'); ?>
    <!-- .footer -->

    <script>
        function togglePasswordVisibility(inputId, eyeIcon) {
            var input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
                eyeIcon.classList.add('active'); // Add 'active' class to eye icon
            } else {
                input.type = "password";
                eyeIcon.classList.remove('active'); // Remove 'active' class from eye icon
            }
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
    <script type="text/javascript" src="assets/js/product-filter.js"></script>

    <script>
        /*eye-password-mode*/
        const eyeIcons = {
            open: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="eye-icon"><path d="M12 15a3 3 0 100-6 3 3 0 000 6z" /><path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" /></svg>',
            closed: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="eye-icon"><path d="M3.53 2.47a.75.75 0 00-1.06 1.06l18 18a.75.75 0 101.06-1.06l-18-18zM22.676 12.553a11.249 11.249 0 01-2.631 4.31l-3.099-3.099a5.25 5.25 0 00-6.71-6.71L7.759 4.577a11.217 11.217 0 014.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113z" /><path d="M15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0115.75 12zM12.53 15.713l-4.243-4.244a3.75 3.75 0 004.243 4.243z" /><path d="M6.75 12c0-.619.107-1.213.304-1.764l-3.1-3.1a11.25 11.25 0 00-2.63 4.31c-.12.362-.12.752 0 1.114 1.489 4.467 5.704 7.69 10.675 7.69 1.5 0 2.933-.294 4.242-.827l-2.477-2.477A5.25 5.25 0 016.75 12z" /></svg>'
        };

        function addListeners() {
            const toggleButtons = document.querySelectorAll(".toggle-button");

            if (toggleButtons.length === 0) {
                return;
            }

            toggleButtons.forEach((toggleButton) => {
                toggleButton.addEventListener("click", togglePassword);
            });
        }

        function togglePassword(event) {
            const toggleButton = event.currentTarget;
            const passwordField = toggleButton.previousElementSibling; // Assuming password field is before toggle button

            if (!passwordField || !toggleButton) {
                return;
            }

            toggleButton.classList.toggle("open");

            const isEyeOpen = toggleButton.classList.contains("open");

            toggleButton.innerHTML = isEyeOpen ? eyeIcons.closed : eyeIcons.open;
            passwordField.type = isEyeOpen ? "text" : "password";
        }

        document.addEventListener("DOMContentLoaded", addListeners);
    </script>

</body>

</html>