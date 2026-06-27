<?php
session_start();
include 'db_connect.php';

// Make sure user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

$userID = $_SESSION['userID'];

// Fetch current user info
$sql = "SELECT userID, name, email, phoneNum, address FROM customer WHERE userID = '$userID' LIMIT 1";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phoneNum'];
    $address = $_POST['address'];

    $sqlUpdate = "UPDATE customer SET 
                    name = '$name',
                    email = '$email',
                    phoneNum = '$phone',
                    address = '$address'
                  WHERE userID = '$userID'";
    mysqli_query($conn, $sqlUpdate);

    // Redirect back to account page
    echo "<script>
        alert('Successfully edited account information!');
        window.location.href='account.php';
      	</script>";
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Account</title>
<style>
	.container { max-width: 1000px; margin: auto; padding: 30px; display: flex; 
	justify-content: center; align-items: center; }
	.container h2 { max-width: 600px; margin: 20 auto; text-align: center; }
	.edit-container { background: white; padding: 2rem; border-radius: 10px; 
	box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 100%; max-width: 600px; }
	.account-box { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 8px rgba(0,0,0,0.1); }
	h2 { margin-bottom: 20px; }
	button, .save-btn, .cancel-btn { font-family: inherit; font-size: 1rem; line-height: normal;
    vertical-align: middle; display: inline-block; text-align: center; }
	.save-btn, .cancel-btn { padding: 10px 20px; color: white; border: none; border-radius: 6px;
	text-decoration: none; cursor: pointer; }
	button { background: #27ae60; margin-right: 10px; }
	button:hover { background: #1e8449; }
	.cancel-btn { background: #D83B3F; }
	.cancel-btn:hover { background: #BB191A; }
	.form-group { margin-bottom: 1rem; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
    .form-group input, .form-group textarea {  width: 100%; padding: 10px; margin-bottom: 15px;
	border-radius: 5px; border: 1px solid #ddd; font-size: 1rem; }
</style>
</head>
<body>
<!-- Navigation -->
<?php require 'nav.php'; ?>
<div class="container">
    <div class="edit-container">
        <h2>Edit Account Information</h2>
        <form method="POST">
				<div class="form-group">
  					<label for="userID">Username: </label>
         			<input type="text" value="<?= htmlspecialchars($user['userID']) ?>" disabled>
          		</div>
				<div class="form-group">
          			<label for="Name">Name: </label>
                    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                </div>
				<div class="form-group">
                    <label for="email">Email: </label>
                   	<input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
				<div class="form-group">
                    <label for="phone">Phone Number: </label>
                    <input type="text" name="phoneNum" pattern="[0-9]{10,11}" placeholder="e.g., 0123456789" 
						   value="<?= htmlspecialchars($user['phoneNum']) ?>" required>
                </div>
				<div class="form-group">
                    <label for="address">Address: </label>
                    <textarea name="address" rows="3" required><?= htmlspecialchars($user['address']) ?>
					</textarea>
                   </div>
                <div class="form-group"></div>
				<div class="form-group"></div>

            	<button type="submit" class="save-btn">Save Changes</button>
            	<a href="account.php" class="cancel-btn">Cancel</a>
        </form>
    </div>
</div>
<!-- Footer -->
<?php require 'footer.php'; ?>
</body>
</html>
