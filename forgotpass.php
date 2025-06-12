<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Check if user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(16)); // 32 char token
        $stmt = $conn->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        
    } else {
        echo "<script>alert('No user found with that email.');</script>";
    }
}
?>


<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mail/src/PHPMailer.php';
require 'mail/src/Exception.php';
require 'mail/src/SMTP.php';
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(16));
        $stmt = $conn->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Set reset link
        $resetLink = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/resetpass.php?token=$token";

        // Send email
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // or your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'arhamahmed8699@gmail.com'; // Your Gmail address
            $mail->Password = 'password';   // Use Gmail App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('arhamahmed8699@gmail.com', 'Virtual Fit');
            $mail->addAddress($email); 

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Virtual Fit Password Reset';
            $mail->Body    = "Click the link to reset your password:<br><a href='$resetLink'>$resetLink</a>";

            $mail->send();
            echo "<script>alert('Reset link sent to your email.');</script>";
        } catch (Exception $e) {
            echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
        }
    } else {
        echo "<script>alert('No user found with that email.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <img src="VFlogo.png" width="160px" height="80px" alt="logo">
            <h2>Reset Password</h2>
            <form method="post" action="">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <button type="submit" class="btn">Submit</button>
            </form>

            <div class="extra-links">
                <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
            </div>
        </div>
    </div>
</body>
</html>