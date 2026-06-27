<?php
session_start();
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ADMIN - View Customer Orders</title>
<style>
	.orders-container {
    	background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        max-width: 1200px;
        margin: 50px auto;
	}
	.orders-container h2 {
		text-align: center;
		margin: 20px auto;
	}
	.order-box {
    	background: #fff;
    	padding: 15px;
    	border-radius: 10px;
    	margin-bottom: 20px;
    	box-shadow: 0 2px 10px rgba(0,0,0,0.1);
	}
    table {
    	width: 100%;
    	border-collapse: separate;
    	border-spacing: 0;
    	border-radius: 10px;
    	overflow: hidden;
    	margin-top: 10px;
		box-shadow: 0 2px 8px rgba(0,0,0,0.1);
	}

	table th, table td {
    	padding: 10px;
    	border-bottom: 1px solid #ddd;
	}

	table th {
    	background: #3498db;
    	color: white;
    	text-align: left;
	}

	.print-btn {
    	padding: 10px 20px;
		background: #3498db; 
		color: #fff; 
		border: none; 
		border-radius: 8px; 
		cursor: pointer; 
		font-size: 1rem;
}
    .print-btn:hover {
        background: #217EBC;
    }
	select {
		width: 200px;
		padding: 10px; 
		border: 1px solid #ddd; 
		border-radius: 5px;
		font-size: 1rem;
	}
	.update-btn {
    	padding: 8px 20px;
		background: #3498db; 
		color: #fff; 
		border: none; 
		border-radius: 8px; 
		cursor: pointer; 
		font-size: 1rem;
}
	.update-btn:hover {
        background: #217EBC;
    }
	.status-badge {
    	padding: 4px 10px;
    	border-radius: 8px;
    	font-size: 13px;
    	font-weight: bold;
    	color: #fff;
	}
	.status-pending    { background: #f0ad4e; }
	.status-processing { background: #0275d8; }
	.status-shipped    { background: #5bc0de; }
	.status-delivered  { background: #5cb85c; }
	.status-cancelled  { background: #d9534f; }
</style>
</head>
<body>
<!-- Navigation -->
<?php require 'nav.php'; ?>
<div class="orders-container">
    <h2>All Orders</h2>

    <?php
    // Fetch all orders with customer info + status
    $ordersSQL = "
        SELECT o.orderID, o.datetime, o.totalAmount, o.orderStatus,
               c.name AS customerName
        FROM orders o
        JOIN customer c ON o.userID = c.userID
        ORDER BY o.orderID DESC
    ";
    $resultOrders = mysqli_query($conn, $ordersSQL);
    ?>

    <?php if (mysqli_num_rows($resultOrders) > 0): ?>
        <?php while ($order = mysqli_fetch_assoc($resultOrders)): ?>
            <div class="order-box">
                <h3>
                    Order ID: <?= $order['orderID'] ?> |
                    Customer: <?= htmlspecialchars($order['customerName']) ?> |
                    Date: <?= $order['datetime'] ?> |
                    Total: RM <?= number_format($order['totalAmount'], 2) ?> | 
					Status: <span class="status-badge status-<?= strtolower($order['orderStatus']); ?>">
    								<?= $order['orderStatus']; ?>
								</span>
                </h3>

                <?php
                // Fetch items for this order
                $itemsSQL = "
                    SELECT p.productName, s.quantity, s.totalPrice
                    FROM sales s
                    JOIN product p ON s.productID = p.productID
                    WHERE s.orderID = '{$order['orderID']}'
                ";
                $resultItems = mysqli_query($conn, $itemsSQL);
                ?>

                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Total Price (RM)</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($item = mysqli_fetch_assoc($resultItems)): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['productName']) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($item['totalPrice'], 2) ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
	<!-- Order Status (one per order) -->
	<form action="update_status.php" method="POST">
    <input type="hidden" name="orderID" value="<?= $order['orderID']; ?>">
	<br><h3>Update Status: </h3>
    <select name="orderStatus">
        <option value="Pending"     <?= $order['orderStatus']=='Pending'?'selected':''; ?>>Pending</option>
        <option value="Processing"  <?= $order['orderStatus']=='Processing'?'selected':''; ?>>Processing</option>
        <option value="Shipped"     <?= $order['orderStatus']=='Shipped'?'selected':''; ?>>Shipped</option>
        <option value="Delivered"   <?= $order['orderStatus']=='Delivered'?'selected':''; ?>>Delivered</option>
        <option value="Cancelled"   <?= $order['orderStatus']=='Cancelled'?'selected':''; ?>>Cancelled</option>
    </select>

    <button class="update-btn" type="submit">Update</button>
	</form>
            </div>
        <?php endwhile; ?>

        <div style="text-align: center; margin-top: 20px;">
            <button class="print-btn" onclick="window.print()">Print</button>
        </div>

    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
</div>
<!-- Footer -->
<?php require 'footer.php'; ?>
</body>
</html>
