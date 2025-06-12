<?php
include 'db.php';

// Sanitize and validate inputs
$email = trim($_POST['email']);
$height_feet = filter_input(INPUT_POST, 'height_feet', FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 6]]);
$height_inches = filter_input(INPUT_POST, 'height_inches', FILTER_VALIDATE_INT, ["options" => ["min_range" => 0, "max_range" => 11]]);
$waist = filter_input(INPUT_POST, 'waist', FILTER_VALIDATE_INT, ["options" => ["min_range" => 28, "max_range" => 38]]);
$chest = filter_input(INPUT_POST, 'chest', FILTER_VALIDATE_INT, ["options" => ["min_range" => 34, "max_range" => 48]]);
$skin_tone = $_POST['skin_tone'];
$gender = $_POST['gender'];

$valid_skin_tones = ['light', 'dark'];
$valid_genders = ['male', 'female'];

// Validate
if (
    !$email || !$height_feet || $height_feet === false || !$height_inches || $height_inches === false ||
    !$waist || $waist === false || !$chest || $chest === false ||
    !in_array($skin_tone, $valid_skin_tones) || !in_array($gender, $valid_genders)
) {
    die("Invalid input data.");
}

// Convert height to inches
$total_height = ($height_feet * 12) + $height_inches;

// Get user ID
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("User not found.");
}

$user = $result->fetch_assoc();
$user_id = $user['id'];
$stmt->close();

// Insert body metrics
$insert = $conn->prepare("INSERT INTO body_metrics (user_id, height_inches, waist, chest, skin_tone, gender) VALUES (?, ?, ?, ?, ?, ?)");
$insert->bind_param("iiisss", $user_id, $total_height, $waist, $chest, $skin_tone, $gender);

if ($insert->execute()) {
    header("Location: home.php");
    exit;
} else {
    die("Error: " . htmlspecialchars($insert->error));
}

$insert->close();
$conn->close();
?>
