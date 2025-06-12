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
    <title>About Us</title>
    <link rel="stylesheet" href="about.css">
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
                    </div>
                </li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="about.php">About Us</a></li>
            </ul>
            <div class="icons">
                <a href="cart.php"><img src="cart.png" width="20px" height="20px" alt="Cart" id="cartIcon"></a>
                <a href="account.php"><img src="userr.png" width="20px" height="20px" alt="img"></a>
                <a href="logout.php"><img src="logouticon.png" width="20px" height="20px" alt="img"></a>
            </div>
        </nav>
    </header>

    <section class="about-hero">
    <div class="hero-container">
        <div class="hero-image">
            <img src="vrtry.jpg" alt="Team Collaboration">
        </div>
        <div class="hero-text">
            <h1>Try Before You Buy — Virtually</h1>
            <p>Experience a smarter way to shop with our cutting-edge virtual fitting room. No more guesswork, no more returns — just the perfect fit, every time.</p>
        </div>
    </div>
</section>


    <section class="mission-vision">
        <div class="mission-vision">
            <div class="box">
              <h2>Our Mission</h2>
              <p>To revolutionize the online shopping experience by eliminating guesswork and uncertainty, offering a cutting-edge virtual fitting solution that seamlessly connects the comfort of digital convenience with the confidence of in-store trials — empowering customers to make smarter, personalized fashion choices like never before.</p>
            </div>
            <div class="box">
              <h2>Our Vision</h2>
              <p>To redefine the future of online fashion retail by becoming the most trusted and advanced platform for virtual apparel fitting — where technology meets style to create a seamless, personalized, and risk-free shopping journey. We envision a world where every customer shops with confidence, knowing their perfect fit is just a click away.</p>
            </div>
          </div>          
    </section>

    <section class="team">
        <h2>Meet Our Team</h2>
        <div class="team-container">
            <div class="team-member">
                <img src="hassan.jpeg" alt="Team Member">
                <h3>Hassan Afzal</h3>
                <p>UI/UX Designer & Front-End Developer <br><br> hassanafzal2701@gmail.com</p>
                <!-- hassan also helped with cart,payment gateway and admin panel  -->
            </div>
            <div class="team-member">
                <img src="arham.jpeg" alt="Team Member">
                <h3>Arham Ahmed </h3>
                <p>Backend & 3D Models <br><br> arhamahmed8699@gmail.com</p>
            </div>
            <div class="team-member">
                <img src="ayesha.jpeg" alt="Team Member">
                <h3>Ayesha Shakeel</h3>
                <p>Stripe Payment Gateway</p>
            </div>
        </div>
    </section>

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
