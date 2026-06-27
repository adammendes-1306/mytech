<html>
<head>
<meta charset="utf-8">
<style>
	/* Basic style */
	* {
		font-family: 'Arial', sans-serif;
		margin: 0;
        padding: 0;
        box-sizing: border-box;
	}
	body {
		font-family: 'Arial', sans-serif;
        line-height: 1.6;
        color: #333;
       	background: #f8f9fa;
	}
	 /* Navigation */
        .navbar {
            background: #2c3e50;
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo a {
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
            padding: 0.5rem 0.5rem;
            border-radius: 5px;
			font-weight: bold;
        }

        .nav-menu a:hover {
            color: #3498db;
            background: rgba(255,255,255,0.1);
        }

        .icon {
            width: 30px;
            height: 30px;
			
        }
	       /* Responsive Design */
        @media (max-width: 768px) {
            .nav-menu {
                flex-direction: column;
                gap: 1rem;
            }
	}
</style>
</head>
<body>
	<!-- Navigation  -->
    <header>
        <nav class="navbar">
            <div class="nav-container">
                <div class="logo">
				<?php
                if (isset($_SESSION['userID'])) {
                    $role = $_SESSION['role']; // 0 = admin, 1 = customer

                    // Admin navigation
                    if ($role == 0) {
                        echo '<h1><a href="admin_dashboard.php">MYTECH</a></h1>';
                        echo '</div>
                            <ul class="nav-menu">
                                <li><a href="admin_dashboard.php">Home</a></li>
								<li><a href="manage_products.php">Manage Inventory</a></li>
								<li><a href="view_orders.php">Monitor Orders</a></li>
								<li><a href="manage_staff.php">Manage Staff</a></li>
								<li><a href="logout.php"><img src="images/logout.png" alt="Log Out" class="icon"></a></li>
                            </ul>';
                    }

                    // Customer navigation
                    elseif ($role == 1) {
                        echo '<h1><a href="customer_home.php">MYTECH</a></h1>';
                        echo '</div>
                            <ul class="nav-menu">
                                <li><a href="customer_home.php">Home</a></li>
                                <li><a href="product_cat.php">Products</a></li>
								<li><a href="product_comparison.php">Compare</a></li>
                                <li><a href="cart.php"><img src="images/cart.png" alt="Cart" class="icon"></a></li>
								<li><a href="orders.php"><img src="images/orders.png" alt="Cart" class="icon"></a></li>
								</li>
								<li><a href="notification.php"><img src="images/notification.png" 
										alt="Notification" class="icon"></a></li>
								<li><a href="account.php"><img src="images/user.png" alt="User" class="icon"></a></li>
                                <li><a href="logout.php"><img src="images/logout.png" alt="Log Out" class="icon"></a></li>
                            </ul>';
                    }
                } else {
                    // Guest (not logged in)
                    echo '<h1><a href="index.php">MYTECH</a></h1>';
                    echo '</div>
                        <ul class="nav-menu">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="product_cat.php">Products</a></li>
							<li><a href="product_comparison.php">Compare</a></li>
							<li><a href="about.php">About Us</a></li>
							<li><a href="contact.php">Contact</a></li>
                            <li><a href="login.php"><img src="images/user.png" alt="User" class="icon"></a></li>
                        </ul>';
                }
                ?>
            </div>
        </nav>
    </header>
</body>
</html>