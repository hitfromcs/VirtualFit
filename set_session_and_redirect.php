<?php
session_start();

// Define allowed sizes for security
$allowed_sizes = ['small', 'medium', 'large', 'xlarge'];

// Check that form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validate and set size in session if provided and allowed
    if (isset($_POST['size']) && in_array($_POST['size'], $allowed_sizes, true)) {
        $_SESSION['size'] = $_POST['size'];
    } else {
        // Optional: Set default size if invalid or missing
        $_SESSION['size'] = 'small';
    }

} else {
    // Optional: If accessed without POST, you can choose to set default or redirect
    // For safety, set default size:
    if (!isset($_SESSION['size'])) {
        $_SESSION['size'] = 'small';
    }
}

// Get product ID from GET, default to 1 if missing or invalid
$product_id = 1;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = (int) $_GET['id'];
}

// Redirect to 3D.php with product_id parameter
header("Location: 3D.php?product_id={$product_id}");
exit;
