<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Virtual Fit</title>
    <link rel="stylesheet" href="shop.css">
    <link href="https://fonts.googleapis.com/css2?family=Jaro:opsz@6..72&display=swap" rel="stylesheet">
</head>
<body>
    <header class="sticky-header">
        <nav class="navbar">
            <div class="vrlogo">
                <a href="home.php"><img src="VFlogo.png" id="logo" width="160px" height="50px" alt="Logo"></a>
            </div>
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li class="dropdown"><a href="shop.php">Shop</a></li>
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

    <main>
        <section class="product-grid">
            <div class="product">
                <img src="shirt1.jpeg" alt="White Tee">
                <p>White Tee</p>
                <p>RS. 2,100</p>
                <a href="product.php?id=1"><button class="buy-now">View</button></a>
            </div>

            <div class="product">
                <img src="shirt2.jpeg" alt="Black Tee">
                <p>Black Tee</p>
                <p>RS. 2,200</p>
                <a href="product.php?id=2"><button class="buy-now">View</button></a>
            </div>

            <div class="product">
                <img src="blue jeans.jpeg" alt="Blue Jeans">
                <p>Blue Jeans</p>
                <p>RS. 1,799</p>
                <a href="product.php?id=3"><button class="buy-now">View</button></a>
            </div>

            <div class="product">
                <img src="black jeans.jpeg" alt="Black Jeans">
                <p>Black Jeans</p>
                <p>RS. 2,099</p>
                <a href="product.php?id=4"><button class="buy-now">View</button></a>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="about">
                <img src="VFlogo.png" alt="Virtual Fit Logo" class="footer-logo">
                <p>The customer is at the heart of our unique business model.</p>
            </div>

<div class="subscribe">
                <h3>Subscribe to Our Newsletter</h3>
                <form action="subscribe.php" method="POST">
                    <input type="email" name="newsletter-email" placeholder="Enter your email" required maxlength="100">
                    <button type="submit">Subscribe</button>
                </form>
            </div>

            <div class="contact-info">
                <h3>Contact Us</h3>
                <p>Address: Faisalabad, Pakistan</p>
                <p>Email: support@virtualfit.com</p>
            </div>
        </div>

        <p class="copyright">Copyright © 2024 All rights reserved</p>
    </footer>
</body>
</html>
