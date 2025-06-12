<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_status'], $_POST['order_id'])) {
        $new_status = mysqli_real_escape_string($conn, $_POST['update_status']);
        $order_id = intval($_POST['order_id']);
        mysqli_query($conn, "UPDATE orders SET status='$new_status' WHERE id=$order_id");
    } elseif (isset($_POST['delete_order'])) {
        $order_id = intval($_POST['delete_order']);
        mysqli_query($conn, "DELETE FROM orders WHERE id=$order_id");
    }
}

// Filter orders by status
$filter = '';
if (isset($_GET['status']) && $_GET['status'] !== 'all') {
    $filter = mysqli_real_escape_string($conn, $_GET['status']);
    $query = "SELECT * FROM orders WHERE status='$filter' ORDER BY created_at DESC";
} else {
    $query = "SELECT * FROM orders ORDER BY created_at DESC";
}
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Orders</title>
    <link rel="stylesheet" href="vieworders.css">
</head>
<body>
    <div class="admin-header">
        <h1>Orders</h1>
        <a href="admin.php"><button class="back">Back</button></a>
    </div>

    <div class="admin-main">
        <h2>All Orders</h2>

        <form method="GET" style="margin-bottom: 20px;">
            <label for="status">Filter by Status:</label>
            <select name="status" onchange="this.form.submit()">
                <option value="all" <?= (!isset($_GET['status']) || $_GET['status'] == 'all') ? 'selected' : '' ?>>All</option>
                <option value="pending" <?= ($_GET['status'] ?? '') == 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="shipped" <?= ($_GET['status'] ?? '') == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                <option value="delivered" <?= ($_GET['status'] ?? '') == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                <option value="cancelled" <?= ($_GET['status'] ?? '') == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
            </select>
        </form>

        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>City</th>
                <th>Phone</th>
                <th>Shipping</th>
                <th>Payment</th>
                <th>Subtotal</th>
                <th>Shipping Cost</th>
                <th>Total</th>
                <th>Created</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['address']) ?></td>
                <td><?= htmlspecialchars($row['city']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= htmlspecialchars($row['shipping_method']) ?></td>
                <td><?= htmlspecialchars($row['payment_method']) ?></td>
                <td>PKR <?= number_format($row['subtotal'], 2) ?></td>
                <td>PKR <?= number_format($row['shipping'], 2) ?></td>
                <td>PKR <?= number_format($row['total'], 2) ?></td>
                <td><?= $row['created_at'] ?></td>
                <td>
                    <form method="POST" style="display:inline-block;">
                        <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                        <select name="update_status">
                            <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="shipped" <?= $row['status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                            <option value="delivered" <?= $row['status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                            <option value="cancelled" <?= $row['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                        <button type="submit">Update</button>
                    </form>
                </td>
                <td>
                    <form method="POST" onsubmit="return confirm('Delete this order?');">
                        <input type="hidden" name="delete_order" value="<?= $row['id'] ?>">
                        <button type="submit" style="color: red;">Delete</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
