<?php
session_start();
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MYTECH - Your Tech Destination</title>
    <style>
		.container {
      		max-width: 1200px;
    		margin: 0 auto;
     		padding: 0 20px;
		}
        /* Hero Section - Like BOKITTA's Palestine Collection */
        .hero {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 120px 0;
            text-align: center;
        }

        .hero-content h2 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            font-weight: 300;
        }

        .hero-content p {
            font-size: 1.3rem;
            max-width: 600px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }

        .cta-button {
            display: inline-block;
            background: #e74c3c;
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 30px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .cta-button:hover {
            background: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        /* Customization Section - Like BOKITTA's CHOOSE STYLE */
        .customization {
            background: #f8f9fa;
            padding: 60px 0;
            text-align: center;
        }

        .customization h3 {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            color: #2c3e50;
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .custom-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .option {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .option h4 {
            color: #e74c3c;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .option p {
            color: #666;
            font-size: 0.9rem;
        }

        /* Categories Section */
        .categories {
            padding: 4rem 0;
            background: white;
        }

        .categories h2 {
            text-align: center;
            margin-bottom: 3rem;
            color: #2c3e50;
            font-size: 2rem;
            font-weight: 300;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }

        .category-item {
            text-align: center;
            padding: 2rem;
            background: #f8f9fa;
            border-radius: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #e9ecef;
        }

        .category-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .category-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .category-item h3 {
            color: #2c3e50;
            font-weight: 400;
        }

        /* Featured Products */
        .featured-products {
            padding: 4rem 0;
            background: #f8f9fa;
        }

        .featured-products h2 {
            text-align: center;
            margin-bottom: 3rem;
            color: #2c3e50;
            font-size: 2rem;
            font-weight: 300;
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

        .product-card h3 {
            font-size: 1.3rem;
            color: #2c3e50;
            font-weight: 400;
			margin-bottom: 10px;
        }
		
		.product-card h2 {
            font-size: 1.4rem;
            color: #2c3e50;
            font-weight: bold;
			margin: 0 auto;
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

        .add-to-cart {
            background: #3498db;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 1rem;
        }

        .add-to-cart:hover {
            background: #2980b9;
            transform: translateY(-2px);
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
	
    <!-- hero section  -->
    <section class="hero">
        <div class="hero-content">
            <h2>Apple iPhone 17 Pro Max</h2>
            <p>Experience power, clarity, and craftsmanship like never before with the iPhone 17 Pro Max. Designed for creators, dreamers, and anyone who wants the absolute best, this 
				is the upgrade that transforms the way you capture, work, and live.</p>
            <a href="#products" class="cta-button">Shop Now</a>
        </div>
    </section>

    <!-- customization part -->
    <section class="customization">
        <div class="container">
            <h3>CUSTOMIZE YOUR DEVICE</h3>
            <div class="custom-options">
                <div class="option">
                    <h4>COLOR</h4>
                    <p>Silver | Cosmic Orange | Deep Blue</p>
                </div>
                <div class="option">
                    <h4>STORAGE</h4>
                    <p>256GB | 512GB | 1TB | 2TB</p>
                </div>
                <div class="option">
                    <h4>CONNECTIVITY</h4>
                    <p>5G | Wi-Fi + Cellular</p>
                </div>
            </div>
        </div>
    </section>

    <!-- categories part -->
    <section class="categories">
        <div class="container">
            <h2>Shop by Category</h2>
            <div class="category-grid">
				<?php
				
				// Fetch only 4 categories
				$sql = "SELECT * FROM category ORDER BY RAND() LIMIT 4";
				$result = mysqli_query($conn, $sql);
				
				if (mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						echo '
						<div class="category-item">
							<div class="category-icon"></div>
							<h3>' . htmlspecialchars($row['categoryName']) . '</h3>
						</div>';
					}
				} else {
					echo '<p>No category available.</p>';
				}
				?>
            </div>
        </div>
    </section>

    <!-- featured products -  -->
    <section id="products" class="featured-products">
        <div class="container">
            <h2>Featured Products</h2>
            <div class="product-grid">
				<?php
				
				// Fetch products (Limit to 4 products)
				$query = "SELECT p.*, b.* FROM product p
							LEFT JOIN brand b ON p.brandID = b.brandID
							ORDER BY RAND() LIMIT 4";
				$result = mysqli_query($conn, $query);
				
				// Check if any product found
				if (mysqli_num_rows($result) > 0) {
					while($row = mysqli_fetch_assoc($result)) {
						echo '
						<div class="product-card">
							<img src="images/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['productName']) . '" class="product-image">
							<h2>Brand: '. htmlspecialchars($row['brandName']) . '</h2>
							<h3>' . htmlspecialchars($row['productName']) . '</h3>
							
                        	<p class="product-description">' . htmlspecialchars($row['description']) . '</p>
							
                        	<p class="product-price">RM ' . number_format($row['price'], 2) . '</p>
							
                        	<form method="POST" action="add_to_cart.php" onsubmit="return checkLogin();">
								<input type="hidden" name="productID" value="' . $row['productID'] . '">
								<input type="hidden" name="return_url" value="' .$_SERVER['REQUEST_URI'] . '">
								<button type="submit" class="add-to-cart">Add to Cart</button>
							</form>
						</div>';
					}
				} else {
					echo '<div class="category-item"><p style="text-align: center;">No category available.</p></div>';
				}
				?>
            </div>
        </div>
    </section>
	
	<!-- Footer -->
	<?php require 'footer.php'; ?>
</body>
</html>