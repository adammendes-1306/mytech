<?php
session_start();
include 'db_connect.php';

if (isset($_POST['cartID'])) {
    $cartID = $_POST['cartID'];
    mysqli_query($conn, "DELETE FROM cart WHERE cartID='$cartID'");
}

echo "<script>
    alert('Item removed from cart.');
    window.location.href='cart.php';
</script>";
?>
