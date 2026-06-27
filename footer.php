<?php
// Make sure session is started and DB connected
/*if (session_status() === PHP_SESSION_NONE) {
    session_start();
}*/
include 'db_connect.php';
?>

<html>
<head>
<meta charset="utf-8">
<style>
	/* Footer */
        .footer {
            background: #2c3e50;
            color: white;
            padding: 3rem 0;
            text-align: center;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer-section h3 {
            margin-bottom: 1rem;
            color: #3498db;
        }

        .footer-section a {
            color: #bdc3c7;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
        }

        .footer-section a:hover {
            color: #3498db;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .footer-content {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .footer-content {
                grid-template-columns: 1fr;
            }
        }
</style>
</head>
<body>
<!-- footer -->
<footer class="footer">
    <div class="footer-content">

        <!-- Section: About -->
        <div class="footer-section">
            <h3>MYTECH</h3>
            <p>Your trusted destination for the latest technology and electronics.</p>
        </div>

        <!-- Section: Quick Links -->
        <div class="footer-section">
            <h3>Quick Links</h3>
            <?php
            if (isset($_SESSION['userID'])) {
                $role = $_SESSION['role'];

                // Admin footer
                if ($role == 0) {
                    echo '
                        <a href="admin_dashboard.php">Home</a>
                        <a href="#tools">Tools</a>
                    ';
                }
                // Customer footer
                elseif ($role == 1) {
                    echo '
                        <a href="customer_home.php">Home</a>
                        <a href="product_cat.php">Products</a>
                        <a href="about.php">About Us</a>
                        <a href="contact.php">Contact Us</a>
                    ';
                }
            } else {
                // Guest footer
                echo '
                    <a href="index.php">Home</a>
                    <a href="product_cat.php">Products</a>
                    <a href="about.php">About Us</a>
                    <a href="contact.php">Contact Us</a>
                ';
            }
            ?>
        </div>

        <?php
		// Only show categories for guest or customer
		$showCategories = true;

		if (isset($_SESSION['userID']) && $_SESSION['role'] == 0) {
    		// Admin logged in then do not show categories
    		$showCategories = false;
		}

		if ($showCategories):
		?>
    	<div class="footer-section">
        	<h3>Categories</h3>
        	<?php
        	$sql = "SELECT categoryID, categoryName FROM category ORDER BY RAND() LIMIT 4";
        	$result = mysqli_query($conn, $sql);

        	if ($result && mysqli_num_rows($result) > 0) {
            	while ($row = mysqli_fetch_assoc($result)) {
					echo '<a href="product_listings.php?categoryID=' . $row['categoryID'] . '">'
                     	. htmlspecialchars($row['categoryName']) .
                     	'</a>';
            	}
        	} else {
            	echo '<p>No categories available.</p>';
        	}
        	?>
    	</div>
		<?php endif; ?>

        <!-- Section: Contact Info -->
        <div class="footer-section">
            <h3>Contact Info</h3>
            <p>Email: support@mytech.com</p>
            <p>Phone: +6011 1234 567</p>
            <p>Created by Wawa, Adam and Kai!</p>
        </div>
    </div>

    <div class="footer-container" style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #34495e;">
        <p>&copy; 2025 MYTECH. All rights reserved.</p>
    </div>
</footer>
	<script>
		function checkLogin() {
			<?php if (!isset($_SESSION['userID'])) { ?>
				alert("Please login first!");
				window.location.href = "login.php";
				return false; // Stop form submission
			<?php } else { ?>
				return true; // Allow submission to add_to_cart.php
			<?php } ?>
}
	</script>
</body>
</html>