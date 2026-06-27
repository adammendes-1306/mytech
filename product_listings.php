<?php
session_start();
include 'db_connect.php';

// Check if categoryID is passed from the previous page
if (isset($_GET['categoryID'])) {
    $categoryID = intval($_GET['categoryID']); // sanitize input

    // Fetch category name (optional – for page title)
    $catQuery = "SELECT categoryName FROM category WHERE categoryID = $categoryID";
    $catResult = mysqli_query($conn, $catQuery);
    $categoryName = ($catResult && mysqli_num_rows($catResult) > 0) 
        ? mysqli_fetch_assoc($catResult)['categoryName']
        : "Unknown Category";

    // Fetch all products under that category
	$sql = "SELECT p.*, b.brandName
        FROM product p
        LEFT JOIN brand b ON p.brandID = b.brandID
        WHERE p.categoryID = $categoryID";
	$result = mysqli_query($conn, $sql);
} else {
    // If no category selected, fetch all products (optional fallback)
    $sql = "SELECT p.*, b.brandName 
        FROM product p
        LEFT JOIN brand b ON p.brandID = b.brandID";
	$result = mysqli_query($conn, $sql);
	$categoryName = "All Products";
}

// If any filter/search is applied, use $sql2; otherwise use base $sql
if (!empty($_GET['search']) || !empty($_GET['price']) || !empty($_GET['categoryID']) || !empty($_GET['brandID'])) {
    // Filtered query
    $sql2 = "SELECT p.*, b.brandName FROM product p
         INNER JOIN brand b ON p.brandID = b.brandID
         WHERE 1";

if (!empty($_GET['categoryID'])) {
    $categoryID = intval($_GET['categoryID']);
    $sql2 .= " AND p.categoryID = $categoryID";
}

if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $sql2 .= " AND p.productName LIKE '%$search%'";
}
	
if (!empty($_GET['brandID'])) {
    $brandID = intval($_GET['brandID']);
    $sql2 .= " AND p.brandID = $brandID";
}

if (!empty($_GET['price'])) {
    $sql2 .= $_GET['price'] === 'low' ? " ORDER BY p.price ASC" : " ORDER BY p.price DESC";
}
    $result = mysqli_query($conn, $sql2); // Use $result for display
} else {
    // No filter, use base query
    $result = mysqli_query($conn, $sql); // Use $result for display
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($categoryName); ?> - MYTECH</title>
    <style>
		.container {
      		max-width: 1200px;
    		margin: 0 auto;
     		padding: 0 20px;
		}
		/* Products Grid */
        .products {
            padding: 4rem 0;
            background: #f8f9fa;
        }

        .products h2 {
            text-align: center;
            margin-bottom: 3rem;
            color: #2c3e50;
            font-size: 2rem;
            font-weight: bold;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }

        .product-card {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: contain;
            margin-bottom: 1.5rem;
            background: #f8f9fa;
            border-radius: 5px;
            padding: 1rem;
        }

        .product-card .product-name {
            font-size: 1.3rem;
            color: #2c3e50;
            font-weight: 400;
			margin-bottom: 10px;
        }
		.product-card .brand {
			font-size: 1.3rem;
            color: #2c3e50;
            font-weight: bold;
		}

        .product-description {
            color: #666;
            margin-bottom: 1rem;
            line-height: 1.5;
            font-size: 0.9rem;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 600;
            color: #e74c3c;
            margin-bottom: 1.5rem;
        }
		.product-actions {
    		display: flex;
    		flex-direction: column; /* stack vertically */
    		gap: 10px; /* spacing between buttons */
		}

        .add-to-cart, .view-btn {
            background: #3498db;
            color: white;
			text-decoration: none;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 1rem;
			display: inline-block;		/* ensures equal box model */
			line-height: normal;		/* fixes text height differences */
    		box-sizing: border-box; 	/* consistent padding behavior */
        }
        .add-to-cart:hover,
		.view-btn:hover {
            background: #2980b9;
            transform: translateY(-2px);
		}
		.search-filter {
    		display: flex;
    		flex-wrap: wrap;
    		gap: 10px;
    		margin-bottom: 20px;
    		align-items: center;
		}
		.search-filter input,
		.search-filter select {
    		padding: 8px 12px;
    		border-radius: 5px;
    		border: 1px solid #ccc;
    		font-size: 1rem;
		}
		.search-filter button {
    		padding: 10px 15px;
    		background: #3498db;
    		color: white;
    		border: none;
    		border-radius: 6px;
    		cursor: pointer;
    		transition: 0.3s;
			margin-top: 10px;  
			font-size: 1rem;
		}
		.search-filter button:hover {
    		background: #2980b9;
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
    </style>
</head>
<body>
	<!-- Navigation -->
	<?php require 'nav.php'; ?>

	<section id="products" class="products">
    <div class="container">
        <h2><?php echo htmlspecialchars($categoryName); ?></h2>
		<!-- Search & Filter Section -->
		<div class="search-filter">
    		<form method="GET" action="product_listings.php">
        		<!-- Search by keyword -->
        		<input type="text" name="search" placeholder="Search products..." 
               				value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
				
				<!-- Filter by brand -->
        		<select name="brandID">
            	<option value="">-- Filter by Brand --</option>
            	<?php
            		$brandSql = "SELECT brandID, brandName FROM brand ORDER BY brandName";
            		$brandRes = mysqli_query($conn, $brandSql);
            		while ($brand = mysqli_fetch_assoc($brandRes)) {
                		$selected = (isset($_GET['brandID']) && $_GET['brandID'] == $brand['brandID']) ? 'selected' : '';
                		echo "<option value='{$brand['brandID']}' $selected>{$brand['brandName']}</option>";
            		}
            	?>
        		</select>
				
				<!-- Filter by price -->
        		<select name="price">
            		<option value="">-- Filter by Price --</option>
            		<option value="low" <?= (isset($_GET['price']) && $_GET['price']=='low') ? 
								'selected' : '' ?>>Lowest to Highest</option>
    				<option value="high" <?= (isset($_GET['price']) && $_GET['price']=='high') ? 
								'selected' : '' ?>>Highest to Lowest</option>
        		</select>
				<button type="submit">Apply</button>
    		</form>
		</div>
        <div class="product-grid">

            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '
                    <div class="product-card">
                        <img src="images/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['productName']) . '" class="product-image">
						<h3 class="brand">Brand: ' . htmlspecialchars($row['brandName']) . '</h3>
                        <h3 class="product-name">' . htmlspecialchars($row['productName']) . '</h3>
                        <p class="product-description">' . htmlspecialchars($row['description']) . '</p>
                        <p class="product-price">RM ' . number_format($row['price'], 2) . '</p>
						
						<div class="product-actions">
							<!-- View button -->
        					<a href="product_details.php?id=' . $row['productID'] . '" class="view-btn">View</a>
						
							<!-- Add to cart button -->
                        	<form method="POST" action="add_to_cart.php" onsubmit="return checkLogin();">
                            <input type="hidden" name="productID" value="' . $row['productID'] . '">
							<input type="hidden" name="return_url" value="' .$_SERVER['REQUEST_URI'] . '">
                            <button type="submit" class="add-to-cart">Add to Cart</button>
                        	</form>
						</div>
                    </div>';
                }
            } else {
                echo '<p>No products found in this category.</p>';
            }
            ?>
        </div>
    </div>
	</section>
	
	<!-- Footer -->
	<?php require 'footer.php'; ?>
</body>
</html>
