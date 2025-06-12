<?php
include 'db.php';

// Sanitize and validate inputs
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = $_POST['password'];

// Server-side validation
if (empty($name) || empty($email) || empty($password)) {
    die("All fields are required.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, '.com')) {
    die("Please enter a valid email ending in .com");
}

if (strlen($password) < 6) {
    die("Password must be at least 6 characters long.");
}

// Check if email already exists
$check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    $check_stmt->close();
    die("An account with this email already exists.");
}
$check_stmt->close();

// Secure password hashing
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user
$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $hashed_password);

if ($stmt->execute()) {
    // Success, move to step 2
    header("Location: signup2.php?email=" . urlencode($email));
    exit;
} else {
    die("Error: " . htmlspecialchars($stmt->error));
}

$stmt->close();
$conn->close();
?>
