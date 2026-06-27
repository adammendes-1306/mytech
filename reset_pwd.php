<?php
session_start();
include 'db_connect.php';

$userID = $_POST['userID'] ?? $_GET['userID'] ?? null;

if (!$userID) {
    echo "<script>alert('No user specified.'); window.location.href='find_userid.php';</script>";
    exit();
}

// Fetch user info
$sql = "SELECT * FROM login WHERE userID='$userID'";
$result = mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>alert('User not found.'); 
		window.location.href='find_userid.php';
		</script>";
    exit();
}
$user = mysqli_fetch_assoc($result);

// Handle password reset submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = ($_POST['new_password']);
    $confirmPassword = ($_POST['confirm_password']);

    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // MD5 hash password
        $hashed = md5($newPassword);

        // Update database
        $sqlUpdate = "UPDATE login SET password='$hashed' WHERE userID='$userID'";
        if (mysqli_query($conn, $sqlUpdate)) {
            echo "<script>
                    alert('Password successfully reset! You can login now.');
                    window.location.href='login.php';
                  </script>";
            exit();
        } else {
            echo "<script>alert('Error updating password.');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        .auth-container { display: flex; justify-content: center; align-items: center; min-height: 70vh; padding: 2rem 0; }
        .auth-form { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .auth-btn { width: 100%; background: #3498db; color: white; border: none; padding: 12px; border-radius: 5px; cursor: pointer; font-size: 1rem; }
    </style>
</head>
<body>
	<!-- Navigation -->
	<?php require 'nav.php'; ?>
	
        <div class="auth-container">
          <div class="auth-form">
				<form action="reset_pwd.php" method="POST">
                	<h2>Reset Old Password</h2>
					
                    <div class="form-group">
                        <label for="userid">Username:</label>
                        <input type="text" value="<?= htmlspecialchars($user['userID']) ?>" disabled>
						<!-- Hidden field to send the userID securely -->
						<input type="hidden" name="userID" value="<?= htmlspecialchars($user['userID']) ?>">
                    </div>
					
                    <div class="form-group">
                        <label for="password">New Password:</label>
                        <input type="password" id="new_password" name="new_password" 
							   minlength="6" maxlength="15" required>
                    </div>
					
                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" 
							   minlength="6" maxlength="15" required>
                    </div>
                    <button type="submit" class="auth-btn">Reset Password</button>
            </div>
        </div>

	<!-- Footer -->
	<?php require 'footer.php'; ?>
</body>
</html>