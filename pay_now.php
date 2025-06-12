<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['cart'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$cart_items = $_SESSION['cart'];

$subtotal = 0;
$shipping = 250;
foreach ($cart_items as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$total = $subtotal + $shipping;

// Get form data
$email = $_POST['email'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$address = $_POST['address'];
$apartment = $_POST['apartment'];
$city = $_POST['city'];
$postal_code = $_POST['postal_code'];
$phone = $_POST['phone'];
$country = $_POST['country'];
$save_info = isset($_POST['save_info']) ? 1 : 0;
$payment_method = $_POST['payment_method'];

// Insert into orders table
$sql = "INSERT INTO orders (user_id, email, first_name, last_name, address, apartment, city, postal_code, country, phone, save_info, shipping_method, payment_method, subtotal, shipping, total)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Standard', ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssssssssissdd", $user_id, $email, $first_name, $last_name, $address, $apartment, $city, $postal_code, $country, $phone, $save_info, $payment_method, $subtotal, $shipping, $total);
$stmt->execute();
$order_id = $stmt->insert_id;

// Insert into order_items table
$item_sql = "INSERT INTO order_items (order_id, product_title, product_image, size, price, quantity)
             VALUES (?, ?, ?, ?, ?, ?)";
$item_stmt = $conn->prepare($item_sql);

foreach ($cart_items as $item) {
    $item_stmt->bind_param("isssdi", $order_id, $item['title'], $item['image'], $item['size'], $item['price'], $item['quantity']);
    $item_stmt->execute();
}

// Clear cart
unset($_SESSION['cart']);

// Redirect
header("Location: order-confirmation.php");
exit;
?>
