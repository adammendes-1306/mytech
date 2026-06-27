<?php
session_start();
include 'db_connect.php'; //

if (isset($_GET['id'])) {
    $productID = $_GET['id'];

    // Fetch product image first
    $sql = "SELECT image FROM product WHERE productID = '$productID' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $imagePath = "images/" . $row['image'];

        // Delete file if exists
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete product from DB
        $sqlDel = "DELETE FROM product WHERE productID = '$productID'";
        mysqli_query($conn, $sqlDel);
    }

    // Redirect back to manage_products page
	echo "<script>
            alert('Product has been deleted!');
            window.location.href = 'manage_products.php';
          </script>";
    exit();
} else {
    // No productID provided
	echo "<script>
            alert('No productID found!');
            window.location.href = 'manage_products.php';
          </script>";
    exit();
}
?>
