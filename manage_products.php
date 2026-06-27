<?php
session_start();
include 'db_connect.php';

// Base query
$sql = "SELECT p.*, b.brandName
        FROM product p
        LEFT JOIN brand b ON p.brandID = b.brandID
        WHERE 1";  // makes it easy to append conditions

// Add search filter if provided
if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $sql .= " AND p.productName LIKE '%$search%'";
}

// Execute query
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory Management</title>

    <style>
        .product-container {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 1200px;
            margin: 20px auto;
        }

        .product-container h2 {
            margin: 20px auto;
			text-align: center;
        }

        .top-button {
            margin-bottom: 15px;
        }

        .top-button a {
            text-decoration: none;
            transition: 0.2s;
        }

        .top-button a:hover {
            transform: ;
        }
		
		.top-button img {
			width: 40px; 
		}

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
			box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #3498db;
            color: white;
        }

        tr:hover {
            background: #f1f7ff;
        }

        img.product-img {
			max-width: 60px;
			max-height: 60px;
            width: auto;
            object-fit: cover;
            border-radius: 6px;
        }
		.btn-edit , .btn-delete {
			text-decoration: none;
		}
		.btn-edit img, .btn-delete img {
			width: 25px;
			transition: 0.2s;
		}
		.btn-edit img:hover {
			transform: translateX(-5px);
		}
		.btn-delete img:hover {
			transform: translateX(5px);
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
    		padding: 8px 13px;
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
    </style>
</head>
<body>
<!-- Navigation -->
<?php require 'nav.php'; ?>

<div class="product-container">

    <h2>Inventory Management</h2>
	
    <div class="top-button"  align="right">
        <a href="add_product.php"><img src="images/add.png"></a>
    </div>
	<!-- Search & Filter Section -->
		<div class="search-filter">
    		<form method="GET" action="manage_products.php">
        		<!-- Search by keyword -->
        		<input type="text" name="search" placeholder="Search products..." 
               				value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
				<button type="submit">Search</button>
			</form>
		</div>
    <table>
        <tr>
            <th></th>
            <th>Product ID</th>
			<th>Brand</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>Price (RM)</th>
			<th>Stock</th>
			<th>Action</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td>
                    <img src="images/<?= $row['image'] ?>" class="product-img">
                </td>
                <td><?= $row['productID'] ?></td>
				<td><?= $row['brandName'] ?></td>
                <td><?= $row['productName'] ?></td>
                <td><?= $row['description'] ?></td>
                <td><?= number_format($row['price'], 2) ?></td>
				<td><?= $row['stock'] ?></td>
				<td>
        			<a href="edit_product.php?id=<?= $row['productID'] ?>" class="btn-edit">
						<img src="images/edit.png">
					</a>
        			<a href="delete_product.php?id=<?= $row['productID'] ?>" class="btn-delete"
           					onclick="return confirm('Are you sure you want to delete product <?= $row['productID'] ?>?')">
           				<img src="images/delete.png">
        			</a>
    			</td>
            </tr>
        <?php } ?>

    </table>
	
	<div style="text-align: center; margin-top: 20px;">
    	<button class="print-btn" onclick="window.print()">
    	Print
    	</button>
	</div>
</div>
<!-- Footer -->
<?php require 'footer.php'; ?>
</body>
</html>
