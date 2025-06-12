<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
//This Project is made collectively by Arham Ahmed & Hassan Afzal. We are students of 'The University of Faisalabad' and our batch is 2021-2025 (BSCS). Hassan has made the entire front-end design and helped with a the backend integration of cart, checkout page and Admin panel. Arham has contributed to the entire backend and 3D model implementation for this website. Our third member, Ayesha Shakeel has integrated Stripe Payment API via an external member, thus we have decided to not include it in this version. Anyone reading this can reach Arham Ahmed on "arhamahmed8699@gmail.com" and Hassan Afzal on "hassanafzal2701@gmail.com". Regards ~ arham ahmed
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Fit</title>
    <link rel="stylesheet" href="home.css">
    <link rel="preconnect" href="home.css">
    <link href="https://fonts.googleapis.com/css2?family=Jaro:opsz@6..72&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" defer></script>

</head>

<body>
    <header class="sticky-header">
        <div class="top-bar">
            <p class="desc"></p>
            <b><p>You are logged in as <strong><?php echo htmlspecialchars($_SESSION['user_email']); ?></strong>.</p></b>
        </div>
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
    
    <main>
        <section class="homemain">
            <div class="maincontent">
                <img src="vrphoto.png" width="1288px" height="654px" alt="Virtual Try-on">
                <a href="learn.html"><button class="btn">Learn More →</button></a>
            </div>
        </section>

        <section class="collection">
            <div class="collection-item shirt">
                <img src="men rastah.png" alt="Shirts">
                <div class="text-overlay">
                    <h2>Tee's Collection</h2>
                    <a href="shop.php">Shop Now</a>
                </div>
            </div>
            <div class="collection-item hoodies">
                <img src="cargo_pants.jpg" alt="Pants">
                <div class="text-overlay">
                    <h2>Pants Collection</h2>
                    <a href="shop.php">Shop Now</a>
                </div>
            </div>
        </section>

        <div class="line"></div>

        <section class="best-sellers">
            <h2>Best Sellers</h2>
            <div class="products">
                <div class="product">
                    <img src="shirt1.jpeg" alt="White T-shirt" />
                    <p>White Tee</p>
                    <p>RS. 2,100</p>
                    <a href="product.php?id=1"><button class="buy-now">View</button></a>
                </div>
                
                <div class="product">
                    <img src="shirt2.jpeg" alt="Black T-shirt" />
                    <p>Black Tee</p>
                    <p>RS. 2,200/-</p>
                    <a href="product.php?id=2"><button class="buy-now">View</button></a>
                </div>

                <div class="product">
                    <img src="blue jeans.jpeg" alt="Blue Jeans" />
                    <p>Blue Jeans</p>
                    <p>RS. 2,200/-</p>
                    <a href="product.php?id=3"><button class="buy-now">View</button></a>
                </div>
            </div>
        </section>

        <div class="line"></div>

        <section class="testimonials">
            <h2>Testimonials</h2>
            <div class="reviews">
                <div class="review">
                    <img src="badar.jpeg" alt="Customer 1" />
                    <p>I will give you five star</p>
                </div>
                <div class="review">
                    <img src="moiz.jpeg" alt="Customer 2" />
                    <p>Amazing quality and service!</p>
                </div>
                <div class="review">
                    <img src="moeez.jpeg" alt="Customer 3" />
                    <p>Highly recommend this store!</p>
                </div>
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

        <p class="copyright">Copyright © 2025 All rights reserved</p>
    </footer> 
</body>
</html>
