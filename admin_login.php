<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin.php");
    exit();
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Replace with your actual credentials
    $admin_user = 'admin';
    $admin_pass = 'securepassword'; // Use a strong password in real cases

    if ($username === $admin_user && $password === $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;  // Store username in session
        header("Location: admin.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="admin_login.css">
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required maxlength="30">
            <input type="password" name="password" placeholder="Password" required maxlength="30">
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
