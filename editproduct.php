<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: manageproducts.php");
    exit;
}

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "Product not found.";
    exit;
}

// Update product
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    // Handle image update if uploaded
    if (!empty($_FILES['image']['name'])) {
        $image = basename($_FILES['image']['name']);
        $targetPath = "uploads/" . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
        $update = "UPDATE products SET name='$name', description='$desc', price=$price, category='$category', image='$image' WHERE id=$id";
    } else {
        $update = "UPDATE products SET name='$name', description='$desc', price=$price, category='$category' WHERE id=$id";
    }

    mysqli_query($conn, $update);
    header("Location: manageproducts.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <h2>Edit Product</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea><br><br>

        <label>Price:</label><br>
        <input type="number" name="price" step="0.01" value="<?= $product['price'] ?>" required><br><br>

        <label>Category:</label><br>
        <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>"><br><br>

        <label>Change Image (optional):</label><br>
        <input type="file" name="image"><br>
        <img src="uploads/<?= $product['image'] ?>" width="100" height="100"><br><br>

        <button type="submit">Update Product</button>
    </form>
</body>
</html>
