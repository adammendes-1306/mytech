<?php
session_start();
include 'db_connect.php';

// Make sure user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

$userID = $_SESSION['userID'];

// Fetch all orders with their products using JOIN
$sqlOrders = "
    SELECT o.orderID, o.datetime, o.totalAmount, 
           s.productID, s.quantity, s.totalPrice, p.productName, o.orderStatus
    FROM orders o
    JOIN sales s ON o.orderID = s.orderID
    JOIN product p ON s.productID = p.productID
    WHERE o.userID = '$userID'
    ORDER BY o.datetime DESC, o.orderID DESC
";

$resultOrders = mysqli_query($conn, $sqlOrders);

// Process results to group by orderID
$orders = [];
while ($row = mysqli_fetch_assoc($resultOrders)) {
    $oid = $row['orderID'];
    if (!isset($orders[$oid])) {
        $orders[$oid] = [
            'datetime' => $row['datetime'],
            'totalAmount' => $row['totalAmount'],
            'items' => []
        ];
    }
    $orders[$oid]['items'][] = [
        'productName' => $row['productName'],
        'quantity' => $row['quantity'],
        'totalPrice' => $row['totalPrice'],
		'orderStatus' => $row['orderStatus']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Orders</title>
<style>
	.order-box { background: #fff; padding: 20px; border-radius: 8px; margin: 20px auto; max-width: 1000px;
	box-shadow: 0 0 8px rgba(0,0,0,0.1); }
	.order-box h2 { text-align: center; margin: 1.0rem auto; color: #2c3e50; }
	.order-header { display: flex; justify-content: space-between; margin-bottom: 15px; }
	table { width: 100%; border-collapse: separate; border-spacing: 0; border: 1px solid #ccc; 
	border-radius: 15px; overflow: hidden; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
	margin-bottom: 1.5rem; }
    th, td { padding: 1rem; border-bottom: 1px solid #ddd; text-align: center; }
   	th { background: #3498db; color: white; }
	.print-btn { padding: 10px 20px; background: #3498db; color: #fff; border: none; border-radius: 8px; 
	cursor: pointer; font-size: 1rem; }
    .print-btn:hover {
    background: #217EBC; }
</style>
</head>
<body>
<!-- Navigation -->
<?php require 'nav.php' ?>

<?php if (!empty($orders)): ?>
    <div class="order-box">
        <h2>My Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date/Time</th>
                    <th>Total Amount (RM)</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Total Price (RM)</th>
					<th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $orderID => $order): ?>
                <?php foreach ($order['items'] as $index => $item): ?>
                    <tr>
                        <?php if ($index === 0): ?>
                            <!-- Show order summary only on first product row -->
                            <td rowspan="<?= count($order['items']) ?>"><?= $orderID ?></td>
                            <td rowspan="<?= count($order['items']) ?>"><?= $order['datetime'] ?></td>
                            <td rowspan="<?= count($order['items']) ?>"><?= number_format($order['totalAmount'],2) ?></td>
                        <?php endif; ?>
                        <td><?= htmlspecialchars($item['productName']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['totalPrice'],2) ?></td>
						<td><?= htmlspecialchars($item['orderStatus']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
		<div style="text-align: center; margin-top: 20px;">
    	<button class="print-btn" onclick="window.print()">
        Print
    	</button>
		</div>
    </div>
<?php else: ?>
    <p align="center" style="margin: 30px auto; font-weight: bold; padding: 30px;">You haven’t placed any orders yet.</p>
<?php endif; ?>
<!-- Footer -->
<?php require 'footer.php' ?>
</body>
</html>
