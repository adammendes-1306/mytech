<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MYTECH</title>
    <style>
        .auth-container { display: flex; justify-content: center; align-items: center; min-height: 70vh; padding: 2rem 0; }
        .auth-form { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
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
				<form action="login_process.php?role=0" method="POST">
                	<h2>Login as ADMINISTRATOR</h2>
					
                    <div class="form-group">
                        <label for="userID">Username:</label>
                        <input type="text" id="userid" name="userid" required>
                    </div>
					
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" 
							   minlength="6" maxlength="15" required>
                    </div>
					
                    <div class="form-group">
                    </div>
                    <button type="submit" class="auth-btn">Login</button>
                </form>
            </div>
        </div>
    </div>

	<!-- Footer -->
	<?php require 'footer.php'; ?>
</body>
</html>