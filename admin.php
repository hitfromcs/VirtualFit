<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db.php'; // Your database connection file

// Fetch total orders
$totalOrdersQuery = "SELECT COUNT(*) AS total_orders FROM orders";
$totalOrdersResult = mysqli_query($conn, $totalOrdersQuery);
$totalOrders = mysqli_fetch_assoc($totalOrdersResult)['total_orders'] ?? 0;

// Fetch pending orders
$pendingOrdersQuery = "SELECT COUNT(*) AS pending_orders FROM orders WHERE status = 'pending'";
$pendingOrdersResult = mysqli_query($conn, $pendingOrdersQuery);
$pendingOrders = mysqli_fetch_assoc($pendingOrdersResult)['pending_orders'] ?? 0;

// Fetch total sales
$totalSalesQuery = "SELECT SUM(total) AS total_sales FROM orders";
$totalSalesResult = mysqli_query($conn, $totalSalesQuery);
$totalSales = mysqli_fetch_assoc($totalSalesResult)['total_sales'] ?? 0;
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Virtual Fit</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <img src="VFlogo.png" id="logo" width="160px" height="50px" alt="Logo"></a>
        </div>
        <a href="logout_admin.php" class="logout-btn">Logout</a>
    </header>

    <div class="admin-container">
        <aside class="admin-sidebar">
            <ul>
                <li><a href="admin.php" class="active">Dashboard</a></li>
                <li><a href="manageproducts.php">Manage Products</a></li>
                <li><a href="vieworders.php">View Orders</a></li>
            </ul>
        </aside>

        <main class="admin-main">
            <section class="dashboard">
                <h2>Welcome, Admin!</h2>
                <h2>Dashboard</h2>
                <div class="stats">
                <div class="card">
                    <h3>Total Orders</h3>
                    <p><?php echo $totalOrders; ?></p>
                </div>

                <div class="card">
                    <h3>Pending Orders</h3>
                    <p><?php echo $pendingOrders; ?></p>
                </div>

                <div class="card">
                    <h3>Total Sales</h3>
                    <p>Rs. <?php echo number_format($totalSales, 2); ?></p>
                </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
