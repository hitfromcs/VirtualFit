<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'db.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT users.name, users.email, body_metrics.height_inches, body_metrics.chest, body_metrics.waist, body_metrics.skin_tone, body_metrics.gender 
        FROM users 
        LEFT JOIN body_metrics ON users.id = body_metrics.user_id 
        WHERE users.id = ?";


$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Account</title>
    <link rel="stylesheet" href="account.css" />
    <script>
        function enableEditing() {
            document.getElementById('full-name').removeAttribute('readonly');
            document.getElementById('email').removeAttribute('readonly');
            document.getElementById('height').removeAttribute('readonly');
            document.getElementById('chest').removeAttribute('readonly');
            document.getElementById('waist').removeAttribute('readonly');
            document.querySelectorAll('input[name="skin_tone"]').forEach(input => input.disabled = false);
            document.getElementById('save-btn').style.display = 'inline-block';
            document.getElementById('gender').disabled = false;

        }
    </script>
</head>
<body>
    <header class="sticky-header">
        <nav class="navbar">
            <div class="vrlogo">
                <img src="VFlogo.png" id="logo" width="160px" height="50px" alt="Logo" />
            </div>
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li class="dropdown"><a href="shop.php">Shop</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="about.php">About Us</a></li>
            </ul>
            <div class="icons">
                <a href="cart.php"><img src="cart.png" width="20px" height="20px" alt="Cart" id="cartIcon"></a>
                <img src="userr.png" width="20px" height="20px" alt="img" />
                <a href="logout.php"><img src="logouticon.png" width="20px" height="20px" alt="img" /></a>
            </div>
        </nav>
    </header>

    <div class="user-account">
        <form action="update_account.php" method="post" class="account-info-box">
            <div class="edit-button">
                <button type="button" onclick="enableEditing()" style="background:none; border:none; cursor:pointer;">
                    <img src="pen.png" alt="Edit" width="50px" height="50px" />
                </button>
            </div>

            <div class="personal-info">
                <h2>Personal Information</h2>
                <div class="input-group">
                    <label for="full-name">Full Name</label>
<input type="text" id="full-name" name="name" maxlength="100"
    value="<?php echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'); ?>" readonly />

                </div>

                <div class="input-group">
                    <label for="email">Email</label>
<input type="email" id="email" name="email" maxlength="100"
    value="<?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?>" readonly />
                </div>
            </div>

            <div class="measurements">
                <h2>Measurements</h2>
                <div class="input-group">
                    <label for="height">Height (in inches)</label>
<input type="number" id="height" name="height" min="12" max="83"
    value="<?php echo htmlspecialchars($user['height_inches'], ENT_QUOTES, 'UTF-8'); ?>" readonly />
                </div>

                <div class="input-group">
                    <label for="chest">Chest (in inches)</label>
<input type="number" id="chest" name="chest" min="34" max="48"
    value="<?php echo htmlspecialchars($user['chest'], ENT_QUOTES, 'UTF-8'); ?>" readonly />
                </div>

                <div class="input-group">
                    <label for="waist">Waist (in inches)</label>
<input type="number" id="waist" name="waist" min="28" max="38"
    value="<?php echo htmlspecialchars($user['waist'], ENT_QUOTES, 'UTF-8'); ?>" readonly />
                </div>

<div class="input-group">
    <label for="gender">Gender</label>
    <select id="gender" name="gender" disabled>
        <option value="male" <?php if ($user['gender'] == 'male') echo 'selected'; ?>>Male</option>
        <option value="female" <?php if ($user['gender'] == 'female') echo 'selected'; ?>>Female</option>

    </select>
</div>

                <label>Skin Tone</label>
                <div class="skin-tone-options">
                    <input type="radio" id="light" name="skin_tone" value="light" <?php if ($user['skin_tone'] == 'light') echo 'checked'; ?> disabled />
                    <label for="light" class="skin-tone light"></label>

                    <input type="radio" id="dark" name="skin_tone" value="dark" <?php if ($user['skin_tone'] == 'dark') echo 'checked'; ?> disabled />
                    <label for="dark" class="skin-tone dark"></label>
                </div>
            </div>

            <div style="text-align:center; margin-top: 20px;">
                <button type="submit" id="save-btn" class="btn" style="display: none;">Save</button>
            </div>

        </form>
    </div>
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
