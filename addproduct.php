<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = basename($_FILES['image']['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . $image;

        // Optional: check for allowed image types
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedTypes)) {
            $error = "Only JPG, JPEG, PNG & GIF files are allowed.";
        } else {
            move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
        }
    } else {
        $image = ""; // no image uploaded
    }

    if (!isset($error)) {
        $query = "INSERT INTO products (name, description, price, category, image) VALUES ('$name', '$desc', $price, '$category', '$image')";
        mysqli_query($conn, $query);
        header("Location: manageproducts.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="addproduct.css">
</head>
<body>
   <a href="manageproducts.php" class="back-button">Back</a>
    <div class="form-container">
        <h2>Add New Product</h2>
        <form action="addproduct.php" method="POST" enctype="multipart/form-data">
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" required></textarea><br><br>

        <label>Price:</label><br>
        <input type="number" name="price" step="0.01" required><br><br>

        <label>Category:</label><br>
        <input type="text" name="category"><br><br>

        <label>Image:</label><br>
        <input type="file" name="image" accept="image/*"><br><br>

        <button type="submit">Add Product</button>
    </form>
        </form>
    </div>
</body>


</html>
