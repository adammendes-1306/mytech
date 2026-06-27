<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register New User</title>
    <style>
        .auth-container { display: flex; justify-content: center; align-items: center; min-height: 70vh; padding: 2rem 0; }
        .auth-form { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .auth-btn { width: 100%; background: #3498db; color: white; border: none; padding: 12px; border-radius: 5px; cursor: pointer; font-size: 1rem; }
        .auth-link { text-align: center; margin-top: 1rem; }
    </style>
</head>
<body>
	<!-- Navigation -->
	<?php require 'nav.php'; ?>

    <div class="container">
        <div class="auth-container">
            <div class="auth-form">
                <h2>Create Customer Account</h2>
                <form action="register_process.php" method="POST">
                    <div class="form-group">
                        <label for="userID">Username:</label>
                        <input type="text" id="userid" name="userid"
							   minlength="4" maxlength="10" required>
                        <small>Max 10 characters only.</small>
                    </div>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number:</label>
                        <input type="tel" id="phone" name="phone" pattern="[0-9]{10,11}" placeholder="e.g., 0123456789" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address"
							   placeholder="You can set your address later">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" 
							   minlength="6" maxlength="15" required>
                        <small>Password should consist of 6 to 15 characters only.</small>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_pwd" name="confirm_pwd" 
							   minlength="6" maxlength="15" required>
                    </div>
                    <button type="submit" class="auth-btn">Register</button>
                </form>
                <p class="auth-link">Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>

	<!-- Footer -->
	<?php require 'footer.php'; ?>
</body>
</html>