<?php
session_start();
include 'db_connect.php';

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userid = $_POST['userid'];

    // Check if username exists
    $sql = "SELECT * FROM login WHERE userID = '$userid'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        // Username FOUND — redirect to reset password page
        echo "<script>
                alert('Username found. Proceeding to reset password...');
                window.location.href='reset_pwd.php?userID=$userid';
              </script>";
        exit();

    } else {

        // Username NOT FOUND
        echo "<script>
                alert('Username does not exist. Please try again.');
                window.location.href='find_userid.php';
              </script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Username</title>
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
				<form action="find_userid.php" method="POST">
                	<h2>Find Your Username</h2>
					
                    <div class="form-group">
                        <label for="userID">Username:</label>
                        <input type="text" id="userid" name="userid" required>
                    </div>
					
                    <button type="submit" class="auth-btn">Login</button>
                </form>
            </div>
        </div>

	<!-- Footer -->
	<?php require 'footer.php'; ?>
</body>
</html>