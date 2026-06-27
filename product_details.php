<?php
session_start();
include 'db_connect.php';

if (isset($_GET['id'])) {
    $productID = ($_GET['id']);	// productID is VARCHAR
    $sql = "SELECT p.*, b.brandName FROM product p
	LEFT JOIN brand b ON p.brandID = b.brandID
	WHERE productID = '$productID'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "<p>Product not found.</p>";
        exit;
    }
} else {
    echo "<p>No product selected.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($row['productName']); ?> - MYTECH</title>
    <style>
        .add-to-cart,
		.back-btn {
            color: white;
			text-decoration: none;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: fit-content;
            font-size: 1rem;
			display: inline-block;		/* ensures equal box model */
			line-height: normal;		/* fixes text height differences */
    		box-sizing: border-box; 	/* consistent padding behavior */
        }
		.add-to-cart {
			background: #3498db;
		}

        .add-to-cart:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }
		.back-btn {
			background: #9B9B9B;
		}
		.back-btn:hover {
            background: #CDCDCD;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .custom-options,
            .category-grid,
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .hero-content h2 {
                font-size: 2.5rem;
            }
        }
        @media (max-width: 480px) {
            .custom-options,
            .category-grid,
            .product-grid {
                grid-template-columns: 1fr;
            }
            .hero-content h2 {
                font-size: 2rem;
            }
        }
		.product-details-container {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            gap: 40px;
            padding: 40px;
            max-width: 1000px;
            margin: 50px auto;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .product-image {
			flex: 1;
    		width: 100%;            /* fill the flex container width */
    		max-width: 400px;       /* optional: cap the width */
    		height: 300px;          /* set a fixed height */
    		border-radius: 10px;
    		object-fit: contain;
    		object-position: center; /* center the image if cropped */
        }

        .product-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .product-info h2 {
            font-size: 1.8rem;
            color: #333;
        }
		
		.product-info h3 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 5px;
        }

        .product-info p {
            font-size: 1rem;
            color: #555;
            line-height: 1.6;
        }

        .product-price {
            font-size: 1.4rem;
            color: #27ae60;
            font-weight: bold;
        }

        .product-stock {
            font-size: 1rem;
            color: #777;
        }
	</style>
</head>
<body>
	<!-- Navigation -->
	<?php require 'nav.php'; ?>
	
	<!-- Product information -->
	<div class="product-details-container">
    <!-- Left: Image -->
    <img src="images/<?php echo htmlspecialchars($row['image']); ?>" 
         alt="<?php echo htmlspecialchars($row['productName']); ?>" 
         class="product-image">

    <!-- Right: Info -->
    <div class="product-info">
		<h2>Brand: <?php echo htmlspecialchars($row['brandName']); ?></h2>
        <h3><?php echo htmlspecialchars($row['productName']); ?></h3>
        <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
        <p class="product-price">RM <?php echo number_format($row['price'], 2); ?></p>
        <p class="product-stock">
            Stock: <?php echo ($row['stock'] > 0) ? $row['stock'] . ' available' : 'Out of stock'; ?>
        </p>

        <form method="POST" action="add_to_cart.php" onsubmit="return checkLogin();">
            <input type="hidden" name="productID" value="<?php echo $row['productID']; ?>">
			<input type="hidden" name="return_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
            <button type="submit" class="add-to-cart">Add to Cart</button>
        </form>

        <a href="javascript:history.back()" class="back-btn">Back</a>
    </div>
</div>
	
	<!-- Footer -->
	<?php require 'footer.php'; ?>
</body>
</html>
	