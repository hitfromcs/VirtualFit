
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate size
    $allowed_sizes = ['S', 'M', 'L', 'XL'];
    if (isset($_POST['size']) && in_array($_POST['size'], $allowed_sizes, true)) {
        // Map frontend sizes to lowercase session format if you want
        $size_map = ['S' => 'small', 'M' => 'medium', 'L' => 'large', 'XL' => 'xlarge'];
        $_SESSION['size'] = $size_map[$_POST['size']];
    }
}
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$suggestedShirtSize = '';
$suggestedPantsSize = '';

require_once 'db.php'; // Replace with your actual DB connection file

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT chest, waist FROM body_metrics WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $chest = $row['chest'];
    $waist = $row['waist'];

    // Shirt suggestion based on chest
    if ($chest <= 36) $suggestedShirtSize = 'S';
    elseif ($chest <= 42) $suggestedShirtSize = 'M';
    elseif ($chest <= 46) $suggestedShirtSize = 'L';
    else $suggestedShirtSize = 'XL';

    // Pants suggestion based on waist
    if ($waist <= 28) $suggestedPantsSize = 'S';
    elseif ($waist <= 30) $suggestedPantsSize = 'M';
    elseif ($waist <= 34) $suggestedPantsSize = 'L';
    else $suggestedPantsSize = 'XL';}



// Sample product data (this should ideally come from a database)
$products = [
    1 => [
        "title" => "White Tee",
        "sku" => "tee2345162",
        "price" => "2100",
        "description" => "Our oversized White Tee is made from a premium cotton blend for ultimate comfort and a relaxed fit. Ideal for layering and cozy casual looks.",
        "images" => ["shirt1.jpeg"],
        "sizes" => ["S", "M", "L", "XL"],
        "sizeChart" => [
            ["Size", "Chest (in)", "Length (in)", "Sleeve (in)"],
            ["Small", "34", "26", "23"],
            ["Medium", "40", "28", "24"],
            ["Large", "44", "30", "25"],
            ["XL", "48", "31", "26"]
        ]
    ],
    2 => [
        "title" => "Black Tee",
        "sku" => "tee987654",
        "price" => "2200",
        "description" => "Our oversized black Tee is made from a premium cotton blend for ultimate comfort and a relaxed fit. Ideal for layering and cozy casual looks.",
        "images" => ["shirt2.jpeg"],
        "sizes" => ["S", "M", "L", "XL"],
        "sizeChart" => [
            ["Size", "Chest (in)", "Length (in)", "Sleeve (in)"],
            ["Small", "34", "26", "23"],
            ["Medium", "40", "28", "24"],
            ["Large", "44", "30", "25"],
            ["XL", "48", "31", "26"]
        ]
    ],
    3 => [
        "title" => "Blue Jeans",
        "sku" => "pants234",
        "price" => "1799",
        "description" => "Our oversized black hoodie is made from a premium cotton blend for ultimate comfort and a relaxed fit. Ideal for layering and cozy casual looks.",
        "images" => ["blue jeans.jpeg"],
        "sizes" => ["S", "M", "L", "XL"],
        "sizeChart" => [
            ["Size", "Waist (in)", "Inseam Length (in)"],
            ["Small", "28", "29"],
            ["Medium", "30", "30"],
            ["Large", "34", "30"],
            ["XL", "38", "31"]
        ]
    ],
    4 => [
        "title" => "Black Jeans",
        "sku" => "pants4534",
        "price" => "2099",
        "description" => "Our oversized black hoodie is made from a premium cotton blend for ultimate comfort and a relaxed fit. Ideal for layering and cozy casual looks.",
        "images" => ["black jeans.jpeg"],
        "sizes" => ["S", "M", "L", "XL"],
        "sizeChart" => [
            ["Size", "Waist (in)", "Inseam Length (in)"],
            ["Small", "28", "29"],
            ["Medium", "30", "30"],
            ["Large", "34", "30"],
            ["XL", "38", "31"]
        ]
    ]
];

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!isset($products[$product_id])) {
    echo "<h2 style='text-align:center; padding: 2rem;'>Product not found. Please go back and select again.</h2>";
    exit;
}

$product = $products[$product_id];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo htmlspecialchars($product['title']); ?> - Product Description</title>
  <link rel="stylesheet" href="product.css" />
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

<div class="container">
    <div class="left-section">
        <img src="<?php echo htmlspecialchars($product['images'][0]); ?>" alt="Product Image" class="main-image" />
        <div class="thumbnail-row">
            <?php foreach ($product['images'] as $img): ?>
                <img src="<?php echo htmlspecialchars($img); ?>" alt="Thumbnail" />
            <?php endforeach; ?>
        </div>
    </div>



    <div class="right-section">
        <div class="product-title"><?php echo htmlspecialchars($product['title']); ?></div>
        <div class="sku"><b>SKU:</b> <?php echo htmlspecialchars($product['sku']); ?></div>
        <div class="price"><b>Price:</b> <?php echo htmlspecialchars($product['price']); ?> PKR</div>
<?php if (in_array($product_id, [1, 2]) && $suggestedShirtSize): ?>
    <p class="suggestion-text"><strong>Suggested Shirt Size:</strong> <?php echo $suggestedShirtSize; ?></p>
<?php elseif (in_array($product_id, [3, 4]) && $suggestedPantsSize): ?>
    <p class="suggestion-text"><strong>Suggested Pants Size:</strong> <?php echo $suggestedPantsSize; ?></p>
<?php endif; ?>
        <div>
            <label><strong>Size:</strong></label>
            <div class="size-options">
                <?php foreach ($product['sizes'] as $size): ?>
                    <button type="button" class="size-btn" onclick="selectSize(this)"><?php echo htmlspecialchars($size); ?></button>
                <?php endforeach; ?>
            </div>
        </div>

        <form method="POST" action="add_to_cart.php" onsubmit="return checkSizeSelected()">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <input type="hidden" name="title" value="<?php echo htmlspecialchars($product['title']); ?>">
            <input type="hidden" name="price" value="<?php echo htmlspecialchars($product['price']); ?>">
            <input type="hidden" name="image" value="<?php echo htmlspecialchars($product['images'][0]); ?>">
            <input type="hidden" name="size" id="selectedSizeInput" value="">

            <button class="btn btn-virtual" type="submit" name="add_to_cart">Add to Cart</button>
        </form>

        <form method="POST" action="3D.php" onsubmit="return checkSizeSelected()">
    <input type="hidden" name="skin_tone" value="<?php echo $_SESSION['skin_tone'] ?? ''; ?>">
    <input type="hidden" name="gender" value="<?php echo $_SESSION['gender'] ?? ''; ?>">
    <input type="hidden" name="size" id="tryonSizeInput">
    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
    <button type="submit" class="btn btn-virtual">Try Virtually</button>
</form>


        <div class="product-description">
            <h3>Description</h3>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
        </div>
    </div>
</div>

<div class="size-chart-toggle">
    <button id="toggle-chart-btn" class="toggle-btn">
        <img src="ruler.png" alt="Size Chart" class="ruler-icon" />
        Size Chart
    </button>

    <div id="size-chart-content" class="size-chart-dropdown hidden">
        <table class="size-chart-table">
            <?php foreach ($product['sizeChart'] as $index => $row): ?>
                <tr>
                    <?php foreach ($row as $cell): ?>
                        <<?php echo $index === 0 ? 'th' : 'td'; ?>><?php echo htmlspecialchars($cell); ?></<?php echo $index === 0 ? 'th' : 'td'; ?>>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
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

<script>
    document.getElementById('toggle-chart-btn').addEventListener('click', function () {
        document.getElementById('size-chart-content').classList.toggle('hidden');
    });

function selectSize(button) {
    document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('selected'));
    button.classList.add('selected');

    const selected = button.textContent.trim();
    document.getElementById('selectedSizeInput').value = selected;  // For cart
    document.getElementById('tryonSizeInput').value = selected;     // For 3D.php
}


    function checkSizeSelected() {
        const size = document.getElementById('selectedSizeInput').value;
        if (!size) {
            alert("Please select a size before adding to cart.");
            return false;
        }
        return true;
    }

    
</script>


</body>
</html>
