<?php
include 'db_connect.php';
session_start();

// --- PART 1: FETCH PRODUCT DATA ---
if (!isset($_GET['id'])) {
    die("No product selected.");
}
$productID = $_GET['id'];

$sql = "SELECT p.*, b.brandName
		FROM product p
		LEFT JOIN brand b ON p.brandID = b.brandID
		WHERE productID = '$productID' LIMIT 1";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Product not found.");
}

// --- PART 2: UPDATE PRODUCT WHEN USER SUBMITS FORM ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $newName = $_POST['productName'];
    $newDesc = $_POST['description'];
    $newPrice = $_POST['price'];
    $newStock = $_POST['stock'];

// Keep old image first
$newImage = $product['image']; 

// Handle image upload
if (!empty($_FILES['new_image']['name'])) {

    $categoryID = $product['categoryID']; // Make sure already loaded this before
    $uploadDir = "images/$categoryID/";

    // Make sure folder exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = $_FILES['new_image']['name'];
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['new_image']['tmp_name'], $targetPath)) {
        $newImage = $categoryID . "/" . $fileName;  // Save with path (eg: "2/laptop.png")
    }
}

    // Update query
    $sqlUpdate = "UPDATE product 
                  SET productName = '$newName',
                      description = '$newDesc',
                      price = '$newPrice',
                      stock = '$newStock',
                      image = '$newImage'
                  WHERE productID = '$productID'";

    mysqli_query($conn, $sqlUpdate);

    // success popup
    echo "<script>
            alert('Product updated successfully!');
            window.location.href='manage_products.php';
          </script>";
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>

    <style>
        .edit-container {
            width: 700px;
            background: #fff;
            margin: 50px auto;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 15px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input, 
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-top: 5px;
        }
		.img-wrapper {
			display: flex;
    		text-align: center; /* Centers inline elements inside */
		}
        .product-img {
			max-width: 200px;
			max-height: 200px;
			width: auto;
    		border-radius: 6px;
   			margin-bottom: 10px;
			margin: 0 auto;
			display: block;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }
        .btn-cancel, .btn-save {
            padding: 10px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1rem;
        }
        .btn-cancel {
            background: #d9534f;
            color: white;
        }
        .btn-save {
            background: #27ae60;
            color: white;
        }
    </style>
</head>

<body>
<!-- Navigation -->
<?php require 'nav.php'; ?>
	
<div class="edit-container">
    <h2>Edit Product</h2>

    <form method="POST" enctype="multipart/form-data">
        
		<!-- Current Image -->
        <div class="form-group">
			<div class="img-wrapper">
            <img src="images/<?= $product['image'] ?>" class="product-img">
			</div>
        </div>
		
		<!-- Replace Image -->
        <div class="form-group">
            <label>Replace Image:</label>
            <input type="file" name="new_image">
        </div>
		
		<!-- Display productID but prevent editing -->
		<div class="form-group">
			<label>Product ID:</label>
			<input type="text" value="<?= htmlspecialchars($product['productID']) ?>" disabled>
        	<input type="hidden" name="productID" value="<?= $product['productID'] ?>">
		</div>
		
		<div class="form-group">
		<label>Brand:</label>
		<input type="text" value="<?= htmlspecialchars($product['brandName']) ?>" disabled>
		</div>
			
        <div class="form-group">
            <label>Product Name:</label>
            <input type="text" name="productName" value="<?= htmlspecialchars($product['productName']) ?>" required>
        </div>

        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" rows="4" required><?= htmlspecialchars($product['description']) ?></textarea>
        </div>

        <div class="form-group">
            <label>Price (RM):</label>
            <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>
        </div>

        <div class="form-group">
            <label>Stock Availability:</label>
            <input type="number" name="stock" value="<?= $product['stock'] ?>" required>
        </div>

        <div class="button-group">
            <a href="manage_products.php" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn-save">Save Changes</button>
        </div>

    </form>
</div>
	
<!-- Footer -->
<?php require 'footer.php'; ?>
</body>
</html>
