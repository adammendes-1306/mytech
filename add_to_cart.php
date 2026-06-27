<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['userID'])) {
    echo "<script>
        alert('Please login first!');
        window.location.href='login.php';
    </script>";
    exit();
}

$userID = $_SESSION['userID'];
$productID = $_POST['productID'];

// 1. GET THE PRODUCT FIRST
$sqlProduct = "SELECT * FROM product WHERE productID='$productID'";
$productResult = mysqli_query($conn, $sqlProduct);
$product = mysqli_fetch_assoc($productResult);

// If product not found
if (!$product) {
    echo "<script>alert('Product not found!'); history.back();</script>";
    exit();
}

// 2. CHECK STOCK
if ($product['stock'] <= 0) {
    echo "<script>alert('This item is OUT OF STOCK.'); history.back();</script>";
    exit();
}

// 3. CHECK IF PRODUCT ALREADY IN CART
$check = "SELECT * FROM cart WHERE userID='$userID' AND productID='$productID'";
$result = mysqli_query($conn, $check);

if (mysqli_num_rows($result) > 0) {

    // If in cart, increase quantity
    $update = "UPDATE cart SET quantity = quantity + 1 
               WHERE userID='$userID' AND productID='$productID'";
    mysqli_query($conn, $update);

} else {

    // Insert new item
    $insert = "INSERT INTO cart (userID, productID, quantity) 
               VALUES ('$userID', '$productID', 1)";
    mysqli_query($conn, $insert);
}

// 4. REDIRECT BACK
if (isset($_POST['return_url'])) {
    $url = $_POST['return_url'];
    echo "<script>
        alert('Product added to cart!');
        window.location.href = '$url';
    </script>";
    exit();
} else {
    echo "<script>
        alert('Product added to cart!');
        window.location.href = 'customer_home.php';
    </script>";
    exit();
}
?>
