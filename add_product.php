<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productID = $_POST['productID']; // Admin-defined
	$brandID = $_POST['brandID'];
    $productName = $_POST['productName'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $categoryID = $_POST['categoryID'];

    $imageFile = $_FILES['image']['name'];
    $imagePath = '';

    // Handle image upload
    if (!empty($imageFile)) {
        $uploadDir = "images/$categoryID/"; // Save into category folder
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $targetFile = $uploadDir . basename($imageFile);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = "$categoryID/$imageFile"; // store in DB as category/filename
        } else {
            echo "<p style='color:red;'>Failed to upload image.</p>";
        }
    }

    // Insert into DB including productID
    $sql = "INSERT INTO product (productID, categoryID, brandID, productName, description, price, stock, image)
            VALUES ('$productID', '$categoryID', '$brandID', '$productName', '$description', '$price', '$stock', '$imagePath')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Product added successfully!'); window.location.href='manage_products.php';</script>";
        exit();
    } else {
        echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <style>
        body {
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, textarea, select {
            display: block;
            margin-bottom: 15px;
            padding: 10px;
            width: 100%;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            color: white;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .btn-add { background: #27ae60; }
        .btn-add:hover { background: #1e8449; }

        .btn-cancel { background: #D83B3F; }
        .btn-cancel:hover { background: #BB191A; }

        .btn-group {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
<!-- Navigation -->
<?php require 'nav.php'; ?>
<div class="container">
    <h2>Add New Product</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Category:</label>
        <select name="categoryID" required>
            <option value="">-- Select Category --</option>
            <?php
            $sqlCat = "SELECT categoryID, categoryName FROM category";
            $resCat = mysqli_query($conn, $sqlCat);
            while ($cat = mysqli_fetch_assoc($resCat)) {
                echo "<option value='{$cat['categoryID']}'>{$cat['categoryName']}</option>";
            }
            ?>
        </select>
		<label>Brand:</label>
        <select name="brandID" required>
            <option value="">-- Select Brand --</option>
            <?php
            $sqlBrand = "SELECT brandID, brandName FROM brand";
            $resBrand = mysqli_query($conn, $sqlBrand);
            while ($brand = mysqli_fetch_assoc($resBrand)) {
                echo "<option value='{$brand['brandID']}'>{$brand['brandName']}</option>";
            }
            ?>
        </select>
		<label>Product ID:</label>
        <input type="text" name="productID" required
			   placeholder="Example: XX001" pattern="[A-Z]{2}[0-9]{3}" 
			   title="Format: Two uppercase letters followed by three digits, e.g., XX001">

        <label>Product Name:</label>
        <input type="text" name="productName" required>

        <label>Description:</label>
        <textarea name="description" rows="4" required></textarea>

        <label>Price (RM):</label>
        <input type="number" name="price" step="0.01" required>

        <label>Stock:</label>
        <input type="number" name="stock" required>

        <label>Image:</label>
        <input type="file" name="image" accept="image/*" required>

        <div class="btn-group">
            <a href="manage_products.php" class="btn btn-cancel">Cancel</a>
            <button type="submit" class="btn btn-add">Add Product</button>
        </div>
    </form>
</div>

<!-- Footer -->
<?php require 'footer.php'; ?>
</body>
</html>
