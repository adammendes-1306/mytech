<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['userID'];

// Fetch cart items for this user (assuming you have a cart table)
$sql = "SELECT c.productID, c.quantity, p.productName, p.price 
        FROM cart c
        JOIN product p ON c.productID = p.productID
        WHERE c.userID = '$userID'";
$result = mysqli_query($conn, $sql);

$cartItems = [];
$totalAmount = 0;

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cartItems[] = $row;
        $totalAmount += $row['price'] * $row['quantity'];
    }
} else {
    echo "<p>Your cart is empty.</p>";
    exit();
}

// When form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $payment_method = $_POST['payment_method'];

    // Get all cart items for this user
    $sqlCart = "
    SELECT c.productID, c.quantity, p.price
    FROM cart c
    JOIN product p ON c.productID = p.productID
    WHERE c.userID = '$userID'
	";
	$resultCart = mysqli_query($conn, $sqlCart);
	
    if (mysqli_num_rows($resultCart) > 0) {

        $totalAmount = 0;

        // Calculate total amount
        while ($row = mysqli_fetch_assoc($resultCart)) {
            $totalAmount += $row['price'] * $row['quantity'];
        }

        // Insert new order
        $sqlOrder = "INSERT INTO orders (userID, datetime, totalAmount)
                     VALUES ('$userID', NOW(), '$totalAmount')";
        mysqli_query($conn, $sqlOrder);

        // Get the auto-generated orderID
        $orderID = mysqli_insert_id($conn);

        // Reset result pointer
        mysqli_data_seek($resultCart, 0);

        // Insert order details into sales table
        while ($row = mysqli_fetch_assoc($resultCart)) {
            $productID = $row['productID'];
            $qty = $row['quantity'];
            $totalPrice = $row['price'] * $qty;

            $sqlSales = "INSERT INTO sales (orderID, productID, quantity, totalPrice)
                         VALUES ('$orderID', '$productID', '$qty', '$totalPrice')";
            mysqli_query($conn, $sqlSales);
		
		// Update stock in product table
    	$sqlUpdateStock = "UPDATE product 
                       SET stock = stock - $qty 
                       WHERE productID = '$productID' 
                       AND stock >= $qty"; // prevents negative stock
    	mysqli_query($conn, $sqlUpdateStock);
	}

        // Empty the cart for this user
        mysqli_query($conn, "DELETE FROM cart WHERE userID = '$userID'");

			
		// Insert notification for customer
    	$msg = "Thank you! Your order #$orderID has been placed successfully. Total paid: RM " . number_format($totalAmount, 2);
    	mysqli_query($conn, "
        		INSERT INTO notifications (userID, orderID, message)
        		VALUES ('$userID', '$orderID', '$msg')
    	");
		
        // Redirect user
		echo '<script>
    	alert("Order placed successfully!");
    	window.location.href = "order_success.php?orderID=' . $orderID . '&total=' . $totalAmount . '";
		</script>';
        exit();
    }
}

// Fetch address from customer table
$sqlAdd = "SELECT address FROM customer WHERE userID = '$userID' LIMIT 1";
$resultAdd = mysqli_query($conn, $sqlAdd);

$address = '';
if ($resultAdd && mysqli_num_rows($resultAdd) > 0) {
    $row = mysqli_fetch_assoc($resultAdd);
    $address = $row['address'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout</title>
<style>
    .checkout-container { max-width: 800px; margin: 20px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    h2 { margin-bottom: 20px; color: #333; text-align: center; }
    table { width: 100%; border-collapse: separate; border-spacing: 0; border-radius: 15px; overflow: hidden;
	box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
	thead th { background: #3498db; color: white; padding: 12px; text-align: left; }
	thead th:first-child { border-top-left-radius: 15px; }
	thead th:last-child { border-top-right-radius: 15px; }
	tbody td { padding: 12px; border-bottom: 1px solid #ddd; }
	tbody tr:last-child td:first-child { border-bottom-left-radius: 15px; }
	tbody tr:last-child td:last-child { border-bottom-right-radius: 15px; }
    th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
    th { background: #3498db; color: white; }
    .total { text-align: right; font-weight: bold; background: #f7f7f7; }
    select, button, .back-btn { padding: 10px 15px; margin-top: 10px; border-radius: 6px;
	border: 1px solid #ccc; font-size: 1rem; }
    button, .back-btn { background: #3498db; color: white; border: none; cursor: pointer; transition: all 0.3s;
	display: inline-block; line-height: normal; box-sizing: border-box; text-decoration: none; }
    button:hover { background: #2980b9; }
	.back-btn, .place-order { width: fit-content; /* or 100% if you want full width */ }
	.back-btn { background: gray; }
	.back-btn:hover { background: #CECECE; }
	.button-group { display: flex; gap: 20px; justify-content: flex-end; /* space between buttons */ }
	/* Optional: make responsive — stack buttons on small screens */
	@media (max-width: 480px) { .button-group { flex-direction: column; } }
	.icon {	width: 30px; height: 30px;	}
	.payment-method h3 { margin-bottom: 10px; }
	.checkout-address { background: #f1f1f1; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; }
	.checkout-address h3 { margin-bottom: 10px; }
	.checkout-address p { margin: 0; font-size: 1rem; }
	.checkout-voucher { margin-top: 15px;  padding: 15px 0; border-radius: 8px; }
	.checkout-voucher h3 { margin-bottom: 10px; }
	.voucher-input { padding: 10px 15px; border-radius: 6px; border: 1px solid #ccc; width: 200px;
	margin-right: 10px; }
	.btn-apply { padding: 10px 20px; border-radius: 26px; border: none; background: #3498db; color: white;
	cursor: pointer; transition: 0.3s; }
	.btn-apply:hover { background: #2980b9; }
</style>
</head>
<body>
	<!-- Navigation -->
	<?php require 'nav.php'; ?>

	<div class="checkout-container">
    <h2>Checkout</h2>
		
	<div class="checkout-address">
    <h3>Shipping Address</h3>
    <?php if (!empty($address)): ?>
        <p><?php echo htmlspecialchars($address); ?></p>
    <?php else: ?>
        <p>No address found. <a href="account.php">Add your address in profile.</a></p>
    <?php endif; ?>
	</div>
		
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Price (RM)</th>
                <th>Quantity</th>
                <th>Total (RM)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartItems as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['productName']); ?></td>
                <td><?php echo number_format($item['price'], 2); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td><?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" class="total">Total Amount:</td>
                <td><?php echo number_format($totalAmount, 2); ?></td>
            </tr>
        </tbody>
    </table>
		
	<div class="checkout-voucher">
    <h3>Apply Voucher</h3>
    	<form onsubmit="return false;">
        	<input type="text" placeholder="Enter voucher code" class="voucher-input">
        	<button type="submit" class="btn btn-apply">Apply</button>
    	</form>
	</div>
	
	<div class="payment-method">
    <form method="POST">
		<br><label for="payment_method"><h3>Payment Method:</h3></label>
        <select name="payment_method" id="payment_method" required>
            <option value="">-- Select Payment Method --</option>
            <option value="credit_card">Credit/Debit Card</option>
            <option value="fpx">FPX</option>
            <option value="atome">Atome</option>
        </select></div><br><br>
		
        <div class="button-group">
			<button type="submit" class="place-order">Place Order</button>
    		<a href="javascript:history.back()" class="back-btn">Back</a>
		</div>
    </form>
	</div>

	<!-- Footer -->
	<?php require 'footer.php'; ?>
</body>
</html>
