<?php
include 'db_connect.php';

$orderID = $_POST['orderID'];
$status  = $_POST['orderStatus'];

// First get customer ID for this order
$u = mysqli_query($conn, "SELECT userID FROM orders WHERE orderID='$orderID'");
$order = mysqli_fetch_assoc($u);
$userID = $order['userID'];

// Update order status
$sql = "UPDATE orders SET orderStatus='$status' WHERE orderID='$orderID'";

if (mysqli_query($conn, $sql)) {

    // Insert notification for customer
    $msg = "Your order #$orderID status has been updated to: $status.";
    mysqli_query($conn, "
        INSERT INTO notifications (userID, orderID, message)
        VALUES ('$userID', '$orderID', '$msg')
    ");

    echo "<script>
            alert('Order status updated!');
            window.location.href='view_orders.php';
          </script>";
    exit();

} else {
    echo "<script>
            alert('Update error!');
            window.location.href='view_orders.php';
          </script>";
    exit();
}
?>
