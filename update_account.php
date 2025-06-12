<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Get POST data safely
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$height = (int)($_POST['height'] ?? 0);
$chest = (int)($_POST['chest'] ?? 0);
$waist = (int)($_POST['waist'] ?? 0);
$skin_tone = $_POST['skin_tone'] ?? '';
$gender = $_POST['gender'] ?? '';

// Validate inputs
$errors = [];

if (strlen($name) > 100 || strlen($email) > 100) {
    $errors[] = "Name or email too long.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}

if ($height < 12 || $height > 83) {
    $errors[] = "Height must be between 12 and 83 inches.";
}

if ($chest < 34 || $chest > 48) {
    $errors[] = "Chest must be between 34 and 48 inches.";
}

if ($waist < 28 || $waist > 38) {
    $errors[] = "Waist must be between 28 and 38 inches.";
}

if (!in_array($skin_tone, ['light', 'dark'])) {
    $errors[] = "Invalid skin tone.";
}

if (!in_array($gender, ['male', 'female'])) {
    $errors[] = "Invalid gender.";
}

if (!empty($errors)) {
    // Display errors and stop processing
    echo "<h3>There were errors processing your request:</h3><ul>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul><a href='account.php'>Go back</a>";
    exit;
}

// Update users table
$stmt1 = $conn->prepare("UPDATE users SET name=?, email=? WHERE id=?");
$stmt1->bind_param("ssi", $name, $email, $user_id);
$stmt1->execute();

// Check if body_metrics exists
$check = $conn->prepare("SELECT user_id FROM body_metrics WHERE user_id=?");
$check->bind_param("i", $user_id);
$check->execute();
$res = $check->get_result();

if ($res->num_rows > 0) {
    // Update existing body_metrics
    $stmt2 = $conn->prepare("UPDATE body_metrics SET height_inches=?, chest=?, waist=?, skin_tone=?, gender=? WHERE user_id=?");
    $stmt2->bind_param("iiissi", $height, $chest, $waist, $skin_tone, $gender, $user_id);
} else {
    // Insert new body_metrics
    $stmt2 = $conn->prepare("INSERT INTO body_metrics (user_id, height_inches, chest, waist, skin_tone, gender) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt2->bind_param("iiisss", $user_id, $height, $chest, $waist, $skin_tone, $gender);
}

$stmt2->execute();

// Redirect after successful update
header("Location: account.php");
exit;
?>
