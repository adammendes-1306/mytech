<?php
session_start();

// Ensure orderID + totalAmount exist
if (!isset($_GET['orderID']) || !isset($_GET['total'])) {
    header("Location: customer_home.php");
    exit;
}

$orderID = $_GET['orderID'];
$total = $_GET['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Success</title>
    <style>
        .box {
            max-width: 1000px;
            margin: 30px auto;
            background: #fff;
            padding: 100px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 { color: #28a745; }
        .btn-viewmyorders a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 18px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover{ opacity: .8; background: #2980b9; }
		.box p { margin: 8px; }
    </style>
</head>
<body>
	<!-- Navigation -->
	<?php require 'nav.php'; ?>

	<div class="box">
    	<h2>Order Successful!</h2>
    	<p>Your order has been placed successfully.</p>

    	<p><strong>Order ID:</strong> <?= htmlspecialchars($orderID) ?></p>
    	<p><strong>Total Paid:</strong> RM <?= htmlspecialchars(number_format($total, 2)) ?></p>
		
		<div class="btn-viewmyorders">
    	<a href="orders.php">View My Orders</a>
		</div>
	</div>
	<!-- Footer -->
	<?php require 'footer.php'; ?>

</body>
</html>
