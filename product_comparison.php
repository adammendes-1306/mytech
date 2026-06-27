<?php
session_start();
include 'db_connect.php';

// Function to fetch product by ID including brand
function getProduct($conn, $id) {
    if (!$id) return null;
    $sql = "SELECT p.*, b.brandName 
            FROM product p
            LEFT JOIN brand b ON p.brandID = b.brandID
            WHERE p.productID = '$id'
            LIMIT 1";
    $res = mysqli_query($conn, $sql);
    if ($res && mysqli_num_rows($res) > 0) {
        return mysqli_fetch_assoc($res);
    }
    return null;
}

// Get selected products from GET (PHP v5)
$p1 = isset($_GET['p1']) ? $_GET['p1'] : null;
$p2 = isset($_GET['p2']) ? $_GET['p2'] : null;

$product1 = getProduct($conn, $p1);
$product2 = getProduct($conn, $p2);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Comparison</title>
    <style>
		.compare-container {
			max-width: 1200px;
            margin: 30px auto;
            background: #fff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            text-align: center;
		}
        .search-section {
            width: 80%;
            margin: 30px auto;
            display: flex;
            justify-content: space-between;
        }
        .search-box {
            width: 48%;
        }
        input[type=text] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .results {
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-top: 5px;
            display: none;
            background: #fff;
            position: absolute;
            width: 38%;
            z-index: 10;
        }
        .results div {
            padding: 10px;
            cursor: pointer;
        }
        .results div:hover {
            background: #f0f0f0;
        }
        table {
            width: 80%;
            margin: 40px auto;
            border-collapse: separate;
            text-align: center;
			font-size: 1rem;
			border-spacing: 0;
			border-radius: 12px;
			overflow: hidden;
			box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
			border-bottom: 1px solid #ddd;
        }
		tr:last-child td {
    		border-bottom: none; /* remove bottom border from last row */
		}
        th {
            background: #3498db;
            color: white;
        }
		td {
    		background: #fff;
		}
        img {
            width: 150px;
            border-radius: 8px;
        }
        .title {
            text-align: center;
            font-size: 26px;
            margin-top: 20px;
            font-weight: bold;
        }
        .compare-btn {
            margin: 20px auto;
            display: flex;
            justify-content: center;
        }
        button {
            padding: 10px 20px;
            background: #2ecc71;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #27ae60;
        }
    </style>
</head>
<body>
<!-- Navigation -->
<?php require 'nav.php'; ?>
<div class="compare-container">
<h2 class="title">Compare Products</h2>

<!-- SEARCH -->
<form method="GET" action="product_comparison.php">
    <div class="search-section">

        <!-- Product 1 Search -->
        <div class="search-box">
            <label><b>Product 1</b></label>
            <input type="text" id="search1" onkeyup="searchProduct('search1','results1','p1')" placeholder="Type product name..." 
				   value="<?= isset($_GET['search1']) ? htmlspecialchars($_GET['search1']) : '' ?>">
			<input type="hidden" id="p1" name="p1" value="<?= isset($p1) ? htmlspecialchars($p1) : '' ?>">

            <div id="results1" class="results"></div>
        </div>

        <!-- Product 2 Search -->
        <div class="search-box">
            <label><b>Product 2</b></label>
            <input type="text" id="search2" onkeyup="searchProduct('search2','results2','p2')" placeholder="Type product name..." 
				   value="<?= isset($_GET['search2']) ? htmlspecialchars($_GET['search2']) : '' ?>">
			<input type="hidden" id="p2" name="p2" value="<?= isset($p2) ? htmlspecialchars($p2) : '' ?>">
            <div id="results2" class="results"></div>
        </div>

    </div>

    <div class="compare-btn">
        <button type="submit">Compare Now</button>
    </div>
</form>

<!-- COMPARISON TABLE -->
<?php if ($product1 || $product2) { ?>
<table>
    <tr>
        <th>Feature</th>
        <th>Product 1</th>
        <th>Product 2</th>
    </tr>
	<tr>
        <td style="font-weight: bold">Image</td>
        <td><?= $product1 ? "<img src='images/".$product1['image']."'>" : '-' ?></td>
        <td><?= $product2 ? "<img src='images/".$product2['image']."'>" : '-' ?></td>
    </tr>
 	<tr>
    	<td style="font-weight: bold">Name</td>
    	<td><?= isset($product1['productName']) ? htmlspecialchars($product1['productName']) : '-' ?></td>
    	<td><?= isset($product2['productName']) ? htmlspecialchars($product2['productName']) : '-' ?></td>
	</tr>
	<tr>
    	<td style="font-weight: bold">Brand</td>
    	<td><?= isset($product1['brandName']) ? htmlspecialchars($product1['brandName']) : '-' ?></td>
    	<td><?= isset($product2['brandName']) ? htmlspecialchars($product2['brandName']) : '-' ?></td>
	</tr>
	<tr>
    	<td style="font-weight: bold">Price</td>
    	<td>RM <?= isset($product1['price']) ? number_format($product1['price'], 2) : '0.00' ?></td>
    	<td>RM <?= isset($product2['price']) ? number_format($product2['price'], 2) : '0.00' ?></td>
	</tr>
	<tr>
    	<td style="font-weight: bold">Description</td>
    	<td><?= isset($product1['description']) ? htmlspecialchars($product1['description']) : '-' ?></td>
    	<td><?= isset($product2['description']) ? htmlspecialchars($product2['description']) : '-' ?></td>
	</tr>
</table>
<?php } ?>
</div>
<!-- Footer -->
<?php require 'footer.php'; ?>
	
<script>
function searchProduct(inputId, resultId, hiddenId) {
    const query = document.getElementById(inputId).value;
    if (query.length < 1) {
        document.getElementById(resultId).style.display = "none";
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("GET", `search_product.php?q=${encodeURIComponent(query)}&inputId=${inputId}&resultId=${resultId}&hiddenId=${hiddenId}`, true);
    xhr.onload = function() {
        document.getElementById(resultId).innerHTML = this.responseText;
        document.getElementById(resultId).style.display = "block";
    };
    xhr.send();
}

function selectProduct(name, id, inputId, resultId, hiddenId) {
    document.getElementById(inputId).value = name;
    document.getElementById(hiddenId).value = id;
    document.getElementById(resultId).style.display = "none";
}
</script>
</body>
</html>