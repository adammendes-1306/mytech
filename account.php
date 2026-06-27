<?php
session_start();
include 'db_connect.php';

// Make sure user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

$userID = $_SESSION['userID'];

// Fetch user info from customer table
$sql = "SELECT userID, name, email, phoneNum, address FROM customer WHERE userID = '$userID' LIMIT 1";
$result = mysqli_query($conn, $sql);

$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Account</title>
<style>
	.account-container { margin: 20px auto; padding: 10px; max-width: 1000px; }
	.account-box { background: #fff; max-width: 600px; margin: 0 auto; padding: 30px; border-radius: 8px;
	 box-shadow: 0 0 8px rgba(0,0,0,0.1); }
	.account-box h2 { margin: 1.5rem; text-align: center; color: #2c3e50; }
	.account-info { margin-bottom: 10px; }
	.account-info h4 { display: inline-block; width: 130px; }
	.btn-edit { margin-top: 20px; text-align: right; }
	.btn-edit a { display:inline-block; padding:5px 20px; background:#3498db; 
	color:white; border-radius:6px; text-decoration:none; }
</style>
</head>
<body>
<!-- Navigation -->
<?php require 'nav.php'; ?>
<div class="account-container">
	<div class="account-box">
    <h2>Account Information</h2>
	
    <div class="account-info"><h4>Username: </h4><?= htmlspecialchars($user['userID']) ?></div>
    <div class="account-info"><h4>Name: </h4><?= htmlspecialchars($user['name']) ?></div>
    <div class="account-info"><h4>Email: </h4><?= htmlspecialchars($user['email']) ?></div>
    <div class="account-info"><h4>Phone Number: </h4><?= htmlspecialchars($user['phoneNum']) ?></div>
    <div class="account-info"><h4>Address: </h4><?= htmlspecialchars($user['address']) ?></div>
		<div class="btn-edit">
    		<a href="edit_account.php">
       		Edit
    		</a>
		</div>
	</div>
</div>
<!-- Footer -->
<?php require 'footer.php'; ?>

</body>
</html>
