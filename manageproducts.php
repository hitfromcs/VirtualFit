<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Delete product
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    header("Location: manageproducts.php");
    exit;
}

// Fetch all products
$result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
    <link rel="stylesheet" href="manageproducts.css">
</head>
<body>
    <h2>Manage Products</h2>
    <div><a href="admin.php"><button class="back">Back</button></a></div>

    <a href="addproduct.php" class="button">+ Add New Product</a>


    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price (PKR)</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><img src="uploads/<?= $row['image'] ?>" width="60" height="60"></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= number_format($row['price'], 2) ?></td>
            <td><?= htmlspecialchars($row['category']) ?></td>
            <td>
                <a href="editproduct.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="manageproducts.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this product?')" class="delete">Delete</a>

            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
