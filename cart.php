<?php
session_start();

// Handle item removal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_item'])) {
    $key = $_POST['item_key'];
    if (isset($_SESSION['cart'][$key])) {
        unset($_SESSION['cart'][$key]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // reindex array
    }
    header("Location: cart.php");
    exit;
}

// Handle quantity update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantity'])) {
    $key = $_POST['item_key'];
    $new_quantity = max(1, intval($_POST['new_quantity']));
    if (isset($_SESSION['cart'][$key])) {
        $_SESSION['cart'][$key]['quantity'] = $new_quantity;
    }
    header("Location: cart.php");
    exit;
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart - Virtual Fit</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>

<header>
    <h1>🛒 Your Shopping Cart</h1>
    <nav>
        <a href="home.php">🏠 Home</a>
        <a href="shop.php">🛍️ Continue Shopping</a>
    </nav>
</header>

<main>
    <?php if (empty($cart)) : ?>
        <b><p class="text">Your cart is empty.</p></b>
    <?php else : ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Price (PKR)</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $index => $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Product" width="70"></td>
                        <td><?php echo htmlspecialchars($item['title']); ?></td>
                        <td><?php echo htmlspecialchars($item['size']); ?></td>
                        <td><?php echo number_format($item['price']); ?></td>
                        <td>
                            <form method="POST" action="cart.php" style="display:inline;">
                                <input type="hidden" name="item_key" value="<?php echo $index; ?>">
                                <input type="number" name="new_quantity" value="<?php echo $item['quantity']; ?>" min="1" style="width: 50px;">
                                <button type="submit" name="update_quantity">Update</button>
                            </form>
                        </td>
                        <td><?php echo number_format($subtotal); ?></td>
                        <td>
                            <form method="POST" action="cart.php" style="display:inline;">
                                <input type="hidden" name="item_key" value="<?php echo $index; ?>">
                                <button type="submit" name="remove_item">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="cart-total">
            <h3>Total: PKR <?php echo number_format($total); ?></h3>
            <a href="checkout.php" class="btn-checkout">Proceed to Checkout</a>
        </div>
    <?php endif; ?>
</main>

</body>
</html>
