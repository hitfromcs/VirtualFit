<?php
// insert_admin.php
$pdo = new PDO("mysql:host=localhost;dbname=your_db", "your_user", "your_pass");

$username = 'admin';
$password = 'YourSuperSecurePassword';
$hash = password_hash($password, PASSWORD_BCRYPT);

$stmt = $pdo->prepare("INSERT INTO admins (username, password_hash) VALUES (?, ?)");
$stmt->execute([$username, $hash]);

echo "Admin added!";
