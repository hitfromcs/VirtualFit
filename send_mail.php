<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'mail/src/PHPMailer.php';
require 'mail/src/SMTP.php';
require 'mail/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first = $_POST['first-name'] ?? '';
    $last = $_POST['last-name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $message = $_POST['message'] ?? '';

    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'arhamahmed8699@gmail.com';       // ✅ your Gmail
        $mail->Password = 'password';                // ✅ Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email headers
        $mail->setFrom('arhamahmed8699@gmail.com', 'Virtual Fit Contact'); //sender name
        $mail->addAddress('arhamahmed8699@gmail.com');       // ✅ Receiving email

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body = "
            <h2>New Contact Message</h2>
            <p><strong>Name:</strong> $first $last</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Telephone:</strong> $telephone</p>
            <p><strong>Message:</strong><br>$message</p>
        ";

        // Send mail
        if ($mail->send()) {
            echo "<script>alert('Email sent successfully!'); window.location.href='contact.php';</script>";
        } else {
            echo "<script>alert('Mailer Error: " . $mail->ErrorInfo . "'); window.history.back();</script>";
        }
    } catch (Exception $e) {
        echo "<script>alert('Exception: {$mail->ErrorInfo}'); window.history.back();</script>";
    }
}
?>
