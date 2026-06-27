<?php
session_start();
include 'db_connect.php';

// If user not logged in, redirect
if (!isset($_SESSION['userID'])) {
    echo "<script>
        alert('Please login first to view your cart.');
        window.location.href='login.php';
    </script>";
    exit();
}

$userID = $_SESSION['userID'];

// Fetch cart items joined with product info
$sql = "SELECT c.cartID, p.productName, p.price, c.quantity, p.image 
        FROM cart c 
        JOIN product p ON c.productID = p.productID 
        WHERE c.userID = '$userID'";
$result = mysqli_query($conn, $sql);

$totalAmount = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Cart</title>
    <style>
		/* styles */
        .cart-container {
            max-width: 1000px;
            margin: 20px auto;
			background: #fff;
			padding: 30px; 
			border-radius: 10px;
			box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
		
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 2rem;
        }
        table {
            width: 100%;
    		border-collapse: separate;   /* needed for border-radius */
    		border-spacing: 0;           /* remove gaps between cells */
    		border: 1px solid #ccc;      /* optional: outer border */
    		border-radius: 15px;         /* round corners */
    		overflow: hidden;            /* clip inner content to corners */
    		background: #fff;
			box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 1rem;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #3498db;
            color: white;
        }
        img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }
        .total {
            text-align: right;
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 1rem;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-remove {
            background: #e74c3c;
			border-radius: 25px;
        }
        .btn-remove:hover {
            background: #c0392b;
        }
        .btn-checkout {
            background: #27ae60;
			padding: 10px 15px; 
			margin-top: 10px; 
			border-radius: 6px; 
			border: 1px solid #ccc; 
			font-size: 1rem;
        }
        .btn-checkout:hover {
            background: #1e8449;
        }
        .empty {
            text-align: center;
            color: #777;
            font-size: 1.1rem;
            padding: 2rem 0;
        }
		.btn-back {
    		background: #9B9B9B;
    		margin-bottom: 1.5rem;
			border-radius: 6px; 
		}
		.btn-back:hover {
    		background: #7f8c8d;
		}
		.checkout-btn-container {
			display: flex;
    		justify-content: flex-end; /* moves the button to the right */
			margin-top: 10px;
    		clear: both; /* ensures it doesn't overlap previous floats */
		}
    </style>
</head>
<body>
	<!-- Navigation -->
	<?php require 'nav.php'; ?>
	
    <div class="cart-container">
        <h2>Your Shopping Cart</h2>
		<button class="btn btn-back" onclick="window.location.href='customer_home.php'">Back</button>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <tr>
                    <th>Product</th>
                    <th></th>
                    <th>Price (RM)</th>
                    <th>Quantity</th>
                    <th>Total (RM)</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)): 
                    $subtotal = $row['price'] * $row['quantity'];
                    $totalAmount += $subtotal;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['productName']); ?></td>
                    <td><img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt=""></td>
                    <td><?php echo number_format($row['price'], 2); ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo number_format($subtotal, 2); ?></td>
                    <td>
                        <form method="POST" action="remove_from_cart.php" style="display:inline;">
                            <input type="hidden" name="cartID" value="<?php echo $row['cartID']; ?>">
                            <button type="submit" class="btn btn-remove">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
            <div class="total">Total Amount: RM <?php echo number_format($totalAmount, 2); ?></div>
		
			<div class="checkout-btn-container">
            	<button class="btn btn-checkout" onclick="window.location.href='checkout.php'">
				Proceed to Checkout
				</button>
			</div>

        <?php else: ?>
            <div class="empty">Your cart is empty.</div>
        <?php endif; ?>
    </div>

	<!-- Footer -->
	<?php require 'footer.php'; ?>
</body>
</html>
