<?php
session_start();
include 'db_connect.php'; //

if (isset($_GET['id'])) {
    $staffID = $_GET['id'];

    // Delete product from DB
    $sqlDel = "DELETE FROM staff WHERE staffID = '$staffID'";
    mysqli_query($conn, $sqlDel);

    // Redirect back to manage_staff page
	echo "<script>
            alert('Staff information has been deleted!');
            window.location.href = 'manage_staff.php';
          </script>";
    exit();
} else {
    // No staffID provided
	echo "<script>
            alert('No staffID found!');
            window.location.href = 'manage_staff.php';
          </script>";
    exit();
}
?>
