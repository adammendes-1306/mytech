<?php
session_start();
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN Dashboard</title>
    <style>
		.container {
      		max-width: 1200px;
    		margin: 0 auto;
     		padding: 0 20px;
		}

        #tools {
            background: #f8f9fa;
            padding: 60px 0;
            text-align: center;
        }

        #tools h3 {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            color: #2c3e50;
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .custom-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            max-width: 650px;
            margin: 0 auto;
        }

        .option {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
			transition: 0.2s;
			cursor: pointer;
        }
		
		.option:hover {
			transform: translateY(-5px);
    		box-shadow: 0 4px 15px rgba(0,0,0,0.15);
		}

        .option h4 {
            color: #e74c3c;
            margin-bottom: 0.5rem;
            font-weight: 600;
			text-transform: uppercase;
        }

        .option p {
            color: #666;
            font-size: 0.9rem;
        }
		.option-link {
    		text-decoration: none;
    		color: inherit;        /* keeps text color normal */
    		display: block;        /* makes the full div clickable */
		}
		
        /* Responsive Design */
        @media (max-width: 768px) {
            .custom-options {
               grid-template-columns: repeat(2, 1fr);
            }
            .hero-content h2 {
                font-size: 2.5rem;
            }
        }
        @media (max-width: 480px) {
            .custom-options,{
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
	<!-- Navigation -->
	<?php require 'nav.php'; ?>

    <!-- Tools part -->
    <section id="tools">
        <div class="container">
            <h3>TOOLS</h3>
            <div class="custom-options">
				<a href="manage_products.php" class="option-link">
                <div class="option">
                    <h4>Manage Inventory</h4>
                    <p>Add | Edit | Delete</p>
					<p>products</p>
                </div>
				</a>
				
				<a href="view_orders.php" class="option-link">
                <div class="option">
                    <h4>Monitor Customer Orders</h4>
                    <p>View all orders</p>
                </div>
				</a>
				
				<a href="manage_staff.php" class="option-link">
                <div class="option">
                    <h4>Manage Staff</h4>
                    <p>Manage staff information</p>
				</div>
				</a>
            </div>
        </div>
    </section>
	
	<!-- Footer -->
	<?php require 'footer.php'; ?>
</body>
</html>