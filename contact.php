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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us</title>
  <link rel="stylesheet" href="contact.css" />
  <script src="cart.js" defer></script>
</head>
<body>
  <header class="sticky-header">
    <nav class="navbar">
      <div class="vrlogo">
        <a href="home.php"><img src="VFlogo.png" id="logo" width="160px" height="50px" alt="Logo"/></a>
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
        <a href="account.php"><img src="userr.png" width="20px" height="20px" alt="User"/></a>
        <a href="logout.php"><img src="logouticon.png" width="20px" height="20px" alt="img"></a>
      </div>
    </nav>
  </header>

  <div class="contact-container">
    <h2>Contact Us</h2>
    <form class="contact-form" id="contactForm" method="POST" action="send_mail.php">
      <div class="row">
        <div class="input-box">
          <label for="first-name">First Name</label>
          <input type="text" id="first-name" name="first-name" placeholder="Hassan" />
          <span class="error-message"></span>
        </div>
        <div class="input-box">
          <label for="last-name">Last Name</label>
          <input type="text" id="last-name" name="last-name" placeholder="Afzal"/>
          <span class="error-message"></span>
        </div>
      </div>

      <div class="input-box">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="abc@gmail.com" />
        <span class="error-message"></span>
      </div>

      <div class="row">
        <div class="input-box">
          <label for="phone">Phone Number</label>
          <input type="text" id="phone" name="phone" placeholder="03451234567" />
          <span class="error-message"></span>
        </div>
        <div class="input-box">
          <label for="telephone">Telephone Number</label>
          <input type="text" id="telephone" name="telephone" placeholder="(Optional)"/>
          <span class="error-message"></span>
        </div>
      </div>

      <div class="input-box">
        <label for="message">Message</label>
        <textarea id="message" name="message" placeholder="Enter your message..."></textarea>
        <span class="error-message"></span>
      </div>

      <button type="submit">Send</button>
    </form>
  </div>

  <footer>
    <div class="footer-content">
      <div class="about">
        <img src="VFlogo.png" alt="Virtual Fit Logo" class="footer-logo"/>
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

  <script>
    document.querySelector(".contact-form").addEventListener("submit", function (e) {
      e.preventDefault();
      const form = e.target;
      let isValid = true;

      form.querySelectorAll(".error-message").forEach(el => el.textContent = "");
      form.querySelectorAll(".error").forEach(el => el.classList.remove("error"));

      const showError = (input, message) => {
        input.classList.add("error");
        input.parentElement.querySelector(".error-message").textContent = message;
        isValid = false;
      };

      const firstName = form.querySelector("#first-name");
      const lastName = form.querySelector("#last-name");
      const email = form.querySelector("#email");
      const phone = form.querySelector("#phone");
      const telephone = form.querySelector("#telephone");
      const message = form.querySelector("#message");

      if (!firstName.value.trim() || !/^[A-Za-z\s]+$/.test(firstName.value)) {
        showError(firstName, "Enter a valid first name (alphabetic only)");
      }

      if (!lastName.value.trim() || !/^[A-Za-z\s]+$/.test(lastName.value)) {
        showError(lastName, "Enter a valid last name (alphabetic only)");
      }

      if (!email.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
        showError(email, "Enter a valid email address");
      }

      if (!phone.value.trim() || !/^\d+$/.test(phone.value)) {
        showError(phone, "Enter a valid phone number (numeric only)");
      }

      if (telephone.value.trim() && !/^\d+$/.test(telephone.value)) {
        showError(telephone, "Enter a valid telephone number (numeric only)");
      }

      if (!message.value.trim()) {
        showError(message, "Please enter your message");
      }

      if (isValid) {
        form.submit(); // Submit to send_mail.php if all validations pass
      }
    });
  </script>
</body>
</html>
