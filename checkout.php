<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Use actual cart from session
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$subtotal = 0;
$shipping = 250;
foreach ($cart_items as $item) {
    // Using same keys as cart.php: 'price' and 'quantity'
    $subtotal += $item['price'] * $item['quantity'];
}
$total = $subtotal + $shipping;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Virtual Fit</title>
    <link rel="stylesheet" href="checkout.css">
</head>
<body>

<header class="sticky-header">
<nav class="navbar">
            <div class="vrlogo">
                <a href="home.php"><img src="VFlogo.png" id="logo" width="160px" height="50px" alt="Logo"></a>
            </div>
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li class="dropdown">
                    <a href="shop.php">Shop</a>
                </li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="about.php">About Us</a></li>
            </ul>
            <div class="icons">
                <a href="cart.php"><img src="cart.png" width="20px" height="20px" alt="Cart" id="cartIcon"></a>
                <a href="account.php"><img src="userr.png" width="20px" height="20px" alt="User"></a>
                <a href="logout.php"><img src="logouticon.png" width="20px" height="20px" alt="Logout"></a>
            </div>
        </nav>
</header>

<!-- Replace inside <body> -->
<form action="pay_now.php" method="POST">
<div class="checkout-container">
    <div class="checkout-left">
        <h2>Contact</h2>
        <div class="form-group">
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <h2>Delivery</h2>
        <div class="form-group">
            <select name="country"><option>Pakistan</option></select>
            <div class="input-group">
                <input type="text" name="first_name" placeholder="First name" required>
                <input type="text" name="last_name" placeholder="Last name" required>
            </div>
            <input type="text" name="address" placeholder="Address" required>
            <input type="text" name="apartment" placeholder="Apartment, suite, etc. (optional)">
            <div class="input-group">
                <input type="text" name="city" placeholder="City" required>
                <input type="text" name="postal_code" placeholder="Postal code (optional)">
            </div>
            <input type="text" name="phone" placeholder="Phone" required>
            
        </div>

        <h2>Shipping method</h2>
        <div class="shipping-box">
            <p>Shipping Charges</p>
            <p>Rs <?= number_format($shipping) ?>.00</p>
        </div>

        <h2>Payment</h2>
        <p class="secure-text">All transactions are secure and encrypted.</p>
        <div class="payment-methods">
            <label class="payment-option">
                <input type="radio" name="payment_method" value="Cash On Delivery" checked> Cash On Delivery (COD)
            </label>
        </div>
    </div>

    <div class="checkout-right">
        <div id="order-items-container">
            <?php if (count($cart_items) > 0): ?>
                <?php foreach ($cart_items as $item): ?>
                    <div class="order-item">
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Product" width="100">
                        <p><strong><?= htmlspecialchars($item['title']) ?></strong></p>
                        <p>Size: <?= htmlspecialchars($item['size']) ?></p>
                        <p>Price: Rs <?= number_format($item['price']) ?></p>
                        <p>Qty: <?= (int)$item['quantity'] ?></p>
                        <hr>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No items in your cart.</p>
            <?php endif; ?>
        </div>

        <div class="order-summary">
            <p>Subtotal <span>Rs <?= number_format($subtotal) ?></span></p>
            <p>Shipping <span>Rs <?= number_format($shipping) ?></span></p>
            <hr>
            <p class="total">Total <span>PKR Rs <?= number_format($total) ?></span></p>
            <button type="submit" class="pay-now">Pay now</button>
        </div>
    </div>
</div>
</form>

</body>
</html>
