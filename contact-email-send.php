<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $message = trim($_POST['message']);

    // Basic validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email address.'); window.location.href='contact.php';</script>";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'jaipurwindow@gmail.com'; // your Gmail
        $mail->Password = 'dvprgewwdegkarxr'; // Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        // $mail->SMTPDebug = 2;
        // $mail->Debugoutput = 'html';

        // 1. Send confirmation to user
        $mail->setFrom('jaipurwindow@gmail.com', 'Jaipur Window');
        $mail->addAddress($email); // Send to user
        $mail->isHTML(true);
        $mail->Subject = 'Contact Request Submitted by ' . $name;
        $mail->Body = "
            <h2>Thank You for Contacting Jaipur Window!</h2>
            <p>We have received your message and will get back to you shortly.</p>
            <p><b>Name:</b> {$name}</p>
            <p><b>Email:</b> {$email}</p>
            <p><b>Phone:</b> {$phone}</p>
            <p><b>Message:</b> {$message}</p>
        ";
        $mail->AltBody = "Name: {$name}\nEmail: {$email}\nPhone: {$phone}\nMessage: {$message}";

        $mail->send();

        // 2. Send notification to admin
        $mail->clearAddresses();
        $mail->addAddress('jaipurwindow@gmail.com'); // replace with your email
        $mail->Subject = 'New Enquiry Received from Website';
        $mail->Body = "
            <h2>New Contact Form Submission</h2>
            <p><b>Name:</b> {$name}</p>
            <p><b>Email:</b> {$email}</p>
            <p><b>Phone:</b> {$phone}</p>
            <p><b>Message:</b> {$message}</p>
        ";

        $mail->send();

        echo "<script>
                alert('Thanks! Your message has been sent successfully.');
                window.location.href = 'contact.php';
              </script>";

    } catch (Exception $e) {
        echo "<script>
                alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');
                window.location.href = 'contact.php';
              </script>";
    }
}
?>
