<?php
require_once('header.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

if (!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    // Check if the ID is valid
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE id=?");
    $statement->execute([$_REQUEST['id']]);
    $total = $statement->rowCount();

    if ($total == 0) {
        header('location: logout.php');
        exit;
    } else {
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $cust_status = $result['cust_status'];
        $cust_email = $result['cust_email'];
        $cust_name = $result['cust_name'];
        $password = $result['password'];
    }
}

// Change status
$final = ($cust_status == 0) ? 1 : 0;
$statement = $pdo->prepare("UPDATE tbl_customer SET cust_status=? WHERE id=?");
$statement->execute([$final, $_REQUEST['id']]);

// Send Email if status is activated
if ($final == 1) {
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'jaipurwindow@gmail.com';
        $mail->Password = 'your_smtp_password';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender and recipient settings
        $mail->setFrom('jaipurwindow@gmail.com', 'Jaipur-Window');
        $mail->addAddress($cust_email);
        $mail->isHTML(true);
        $mail->Subject = 'Your Account is Now Active!';

        $mail->Body = "
        <html>
        <body>
            <p>Dear $cust_name,</p>
            <p>We are pleased to inform you that your account with Jaipur Window has been <b>activated</b>. You can now log in and start using our services.The Login Infomation is Given Below</p>
			<p>Thank you for choosing us!</p>
			<h4>Log In Information : </h4>
			<p>Email Id : - $cust_email </p>
			<p>Password : - $password </p>
            <p><a href='https://yourwebsite.com/login.php'>Click here to Login</a></p>
            <p>If you have any questions, feel free to contact us at jaipurwindow@gmail.com.</p>
            <br>
            <p>Regards,<br>Jaipur Window Team</p>
        </body>
        </html>";

        $mail->send();
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
    }
}

// Set session message
$_SESSION['messagess'] = "Congratulations $cust_name, Activation was successful!";
?>

<script>
    <?php if (isset($_SESSION['messagess'])): ?>
        alert('<?php echo $_SESSION['messagess']; ?>');
        <?php unset($_SESSION['messagess']); ?>
        window.location.href = 'customer.php';
    <?php endif; ?>
</script>
