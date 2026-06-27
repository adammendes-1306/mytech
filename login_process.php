<?php
session_start();
include 'db_connect.php';

// Get role from login page, Admin = 0, Customer = 1
$role = $_GET['role'];	// Apply PHP logic

// Get data from login page
$userid = $_POST['userid'];
$pwd = md5($_POST['password']);		// Encryption

// Fetch user based on username (id)
$sql = "SELECT * FROM login WHERE userID = '$userid' AND password = '$pwd'";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

// If record EXISTS, execute
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
	
	$_SESSION['userID'] = $row['userID'];
	$_SESSION['role'] = $role;

    // Redirect based on role
    if ($role == 0) {
		echo "<script>
		alert('Log in as ADMIN. Welcome!');
		window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "<script>
		alert('Log in as CUSTOMER. Welcome!');
		window.location.href='customer_home.php';</script>";
    }
    exit();		// This won't execute any more codes below it
} else {
	if ($role == 0) {
		echo "<script>
		alert('Invalid username or password!');
		window.location.href='login_admin.php';</script>";
	} else {
    echo "<script>
		alert('Invalid username or password! Click Reset here to recover account.');
		window.location.href='login.php';</script>";
	}
}
mysqli_close($conn);
?>