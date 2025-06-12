<?php
session_start();

// Optional: Clear the cart after confirming the order
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmed - Virtual Fit</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #418078;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .confirmation-container {
            text-align: center;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 128, 0, 0.2);
        }

        .tick {
            font-size: 100px;
            color: #145750;
        }

        h1 {
            color: #145750;
            margin-top: 10px;
        }

        p {
            font-size: 18px;
            margin: 20px 0;
        }

        .continue-btn {
            padding: 12px 24px;
            font-size: 16px;
            background-color: #145750;
            color: white;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .continue-btn:hover {
            background-color: #145750;
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <div class="tick">✔</div>
        <h1>Order Confirmed!</h1>
        <p>Your order has been placed successfully. Thank you for shopping with us!</p>
        <a class="continue-btn" href="home.php">Continue Shopping</a>
    </div>
</body>
</html>
