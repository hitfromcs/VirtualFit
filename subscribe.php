<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mail/src/Exception.php';
require 'mail/src/PHPMailer.php';
require 'mail/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $subscriberEmail = trim($_POST['newsletter-email']);

    // Basic validation
    if (empty($subscriberEmail)) {
        echo "<script>alert('Email is required.'); window.history.back();</script>";
        exit;
    }

    if (strlen($subscriberEmail) > 100) {
        echo "<script>alert('Email must be less than 100 characters.'); window.history.back();</script>";
        exit;
    }

    if (!filter_var($subscriberEmail, FILTER_VALIDATE_EMAIL) || !str_ends_with($subscriberEmail, '.com')) {
        echo "<script>alert('Please enter a valid email ending in .com'); window.history.back();</script>";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'arhamahmed8699@gmail.com';
        $mail->Password = 'password'; // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email content
        $mail->setFrom('arhamahmed8699@gmail.com', 'VirtualFit Newsletter');
        $mail->addAddress('arhamahmed8699@gmail.com'); // Receiver

        $mail->isHTML(true);
        $mail->Subject = 'New Newsletter Subscription';
        $mail->Body    = "A user has subscribed to your newsletter.<br><br><strong>Email:</strong> " . htmlspecialchars($subscriberEmail);

        $mail->send();

        echo "<script>alert('Thank you for subscribing!'); window.location.href='home.php';</script>";
        exit;
    } catch (Exception $e) {
        echo "<script>alert('Email could not be sent. Please try again later.'); window.history.back();</script>";
        exit;
    }
}
?>
