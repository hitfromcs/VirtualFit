<?php
include 'db.php';

$token = $_GET['token'] ?? '';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $newpass = $_POST['password'];
    $hashed = password_hash($newpass, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL WHERE reset_token = ?");
    $stmt->bind_param("ss", $hashed, $token);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $success = "Password reset successful. <a href='login.php'>Login</a>";
    } else {
        $error = "Invalid or expired token.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Enter New Password</h2>
            <?php if ($error): ?><p style="color:red;"><?php echo $error; ?></p><?php endif; ?>
            <?php if ($success): ?><p style="color:green;"><?php echo $success; ?></p><?php endif; ?>
            <?php if (!$success): ?>
            <form method="post" action="">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <div class="input-group">
                    <label>New Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="btn">Reset Password</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
