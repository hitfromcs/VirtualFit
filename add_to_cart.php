<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
    $image = isset($_POST['image']) ? trim($_POST['image']) : '';
    $size = isset($_POST['size']) ? trim($_POST['size']) : '';

    // Validate required fields
    if ($product_id <= 0 || $title === '' || $price <= 0 || $image === '' || $size === '') {
        // Redirect back with error
        header("Location: product.php?id=" . $product_id . "&error=missing_fields");
        exit;
    }

    // Prepare product array
    $product = [
        'id' => $product_id,
        'title' => $title,
        'price' => $price,
        'image' => $image,
        'size' => $size,
        'quantity' => 1
    ];

    // Initialize cart
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $cart = &$_SESSION['cart'];
    $found = false;

    // Check for duplicates
    foreach ($cart as &$item) {
        if ($item['id'] === $product_id && $item['size'] === $size) {
            $item['quantity'] += 1;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $cart[] = $product;
    }

    // Redirect to cart page
    header("Location: cart.php?added=true");
    exit;
} else {
    // Direct access prevention
    header("Location: home.php");
    exit;
}
